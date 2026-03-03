<?php

namespace App\Http\Controllers;

use App\Models\Morador;
use App\Models\Apartamento;
use Illuminate\Http\Request;

class MoradorController extends Controller
{
    public function index()
    {
        $apartamentos = Apartamento::orderBy('numero')->get();
        $moradores = Morador::with('apartamento')
            ->orderBy('nome', 'asc')
            ->get();

        return view('moradores.index', compact('apartamentos', 'moradores'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'apartamento_id' => 'required|exists:apartamentos,id',
            'nome' => 'required|string|max:255',
            'whatsapp' => [
                'required',
                'numeric',
                'digits_between:12,13',
                'unique:moradors,whatsapp'
            ],
        ], [
            'whatsapp.unique' => 'Este número de WhatsApp já está cadastrado.',
            'whatsapp.digits_between' => 'O número digitado é inválido. Certifique-se de colocar DDD + Número.',
        ]);

        Morador::create($request->all());

        return redirect()->back()->with('status', 'Morador cadastrado com sucesso!');
    }

    public function destroy(Morador $morador)
    {
        $morador->delete();
        return redirect()->back()->with('status', 'Morador removido com sucesso!');
    }

    public function edit(Morador $morador)
    {
        $apartamentos = Apartamento::orderBy('numero')->get();
        return view('moradores.edit', compact('morador', 'apartamentos'));
    }

    public function update(Request $request, Morador $morador)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'whatsapp' => 'required|string|min:12',
            'apartamento_id' => 'required|exists:apartamentos,id',
        ]);

        $morador->update($request->all());

        return redirect()->route('moradores.index')->with('status', 'Dados do morador atualizados!');
    }
    protected static function booted()
    {
        static::addGlobalScope('condominio', function ($builder) {
            if (auth()->check() && auth()->user()->role !== 'admin') {
                $builder->where('condominio_id', auth()->user()->condominio_id);
            }
        });
    }
}
