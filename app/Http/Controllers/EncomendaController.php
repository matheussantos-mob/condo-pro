<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use App\Models\Apartamento;
use App\Models\Morador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EncomendaController extends Controller
{
    public function index(Request $request)
    {
        $apartamentos = Apartamento::orderBy('numero')->get();

        $query = Encomenda::with('apartamento');

        $encomendas = Encomenda::with('apartamento')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('encomendas.index', compact('apartamentos', 'encomendas'));
    }

    public function store(Request $request)
    {
        // 1. Validação corrigida (sem o lixo de texto no meio)
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'descricao' => 'required|string|max:255',
            'setor_estoque' => 'required',
        ], [
            'apartamento_id.required' => 'Você precisa selecionar um apartamento válido da lista.',
            'apartamento_id.exists' => 'O apartamento selecionado é inválido.'
        ]);

        $condominioId = (auth()->user()->role === 'admin')
            ? session('admin_condominio_id')
            : auth()->user()->condominio_id;

        if (!$condominioId) {
            return redirect()->back()->withErrors(['erro' => 'Por favor, selecione um condomínio no menu lateral.']);
        }

        $numeros = rand(100, 999);
        $letras = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 1);
        $codigo = $numeros . $letras;

        Encomenda::create([
            'user_id' => auth()->id(),
            'apartamento_id' => $request->apartamento_id,
            'descricao' => $request->descricao,
            'setor_estoque' => $request->setor_estoque,
            'codigo_retirada' => $codigo,
            'recebido_por' => auth()->user()->name,
            'status' => 'pendente',
            'condominio_id' => $condominioId,
            'cadastrado_por_id' => auth()->id(),
        ]);

        return redirect()->back()->with('status', 'Encomenda registrada!');
    }

    public function notificar(Encomenda $encomenda, Morador $morador)
    {
        if ($encomenda->status !== 'notificado') {
            $encomenda->update([
                'status' => 'notificado',
                'notificado_por_id' => auth()->id(),
                'notificado_em' => now(),
            ]);
        }

        $msg = "Olá *{$morador->nome}*, sua encomenda chegou! Código: *{$encomenda->codigo_retirada}*";
        $waUrl = "https://wa.me/{$morador->whatsapp}?text=" . urlencode($msg);

        if (request()->ajax()) {
            return response()->json(['url' => $waUrl]);
        }

        return redirect()->away($waUrl);
    }

    public function entregar(Request $request, Encomenda $encomenda)
    {
        if ($request->codigo_digitado === $encomenda->codigo_retirada) {
            $encomenda->update([
                'status' => 'entregue',
                'entregue_por_id' => auth()->id(),
                'retirado_por' => $request->quem_retirou,
                'entregue_em' => now(),
            ]);

            return redirect()->back()->with('status', 'Sucesso! Encomenda entregue ao morador.');
        }

        return redirect()->back()->withErrors(['codigo' => 'Código de retirada inválido!']);
    }

    protected static function booted()
    {
        static::addGlobalScope('condominio', function ($builder) {
            if (auth()->check()) {
                if (auth()->user()->role === 'admin' && session()->has('admin_condominio_id')) {
                    $builder->where('condominio_id', session('admin_condominio_id'));
                } elseif (auth()->user()->role !== 'admin') {
                    $builder->where('condominio_id', auth()->user()->condominio_id);
                }
            }
        });
    }
}
