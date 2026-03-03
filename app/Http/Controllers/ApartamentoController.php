<?php

namespace App\Http\Controllers;

use App\Models\Apartamento;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;


class ApartamentoController extends Controller
{
    public function index()
    {
        $apartamentos = Apartamento::with('moradores')
            ->orderBy('bloco')
            ->orderBy('numero')
            ->get();

        return view('apartamentos.index', compact('apartamentos'));
    }

    public function store(Request $request)
    {
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
            return redirect()->back()->withErrors(['erro' => 'Selecione um condomínio no menu lateral antes de cadastrar.']);
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
            'recebido_por' => Auth::user()->name,
            'status' => 'pendente',
            'condominio_id' => $condominioId,
            'cadastrado_por_id' => Auth::id(),
        ]);

        return redirect()->back()->with('status', 'Encomenda registrada!');
    }

    public function destroy(Apartamento $apartamento)
    {
        if ($apartamento->moradores()->count() > 0) {
            return redirect()->back()->withErrors(['erro' => 'Não é possível excluir uma unidade que possui moradores cadastrados.']);
        }

        $apartamento->delete();
        return redirect()->back()->with('status', 'Unidade excluída com sucesso!');
    }

    public function edit(Apartamento $apartamento)
    {
        return view('apartamentos.edit', compact('apartamento'));
    }

    public function update(Request $request, Apartamento $apartamento)
    {
        $request->validate([
            'numero' => 'required|unique:apartamentos,numero,' . $apartamento->id . ',id,bloco,' . $request->bloco,
            'bloco' => 'required|string',
        ]);

        $apartamento->update($request->all());

        return redirect()->route('apartamentos.index')->with('status', 'Unidade atualizada com sucesso!');
    }
}
