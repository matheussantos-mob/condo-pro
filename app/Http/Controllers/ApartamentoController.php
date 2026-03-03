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
            'bloco' => 'required',
            'numero' => [
                'required',
                Rule::unique('apartamentos')->where(function ($query) use ($request) {
                    return $query->where('bloco', $request->bloco)
                        ->where('numero', $request->numero);
                }),
            ],
        ], [
            'numero.unique' => 'Esta unidade já está cadastrada neste bloco.'
        ]);

        Apartamento::create($request->all());

        return redirect()->back()->with('status', 'Unidade cadastrada com sucesso!');
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
