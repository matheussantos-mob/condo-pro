<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Condominio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Imports\CondominioImport;
use Maatwebsite\Excel\Facades\Excel;


class CondominioController extends Controller
{
    /**
     * Mostra o formulário de edição do condomínio do usuário logado.
     */
    public function edit()
    {
        $user = auth()->user();
        $condominioId = null;

        if ($user->role === 'admin') {
            $condominioId = session('admin_condominio_id');
        } else {
            $condominioId = $user->condominio_id;
        }

        if (!$condominioId) {
            return redirect()->route('admin.index')->with('status', 'Por favor, selecione um condomínio para configurar.');
        }

        $condominio = \App\Models\Condominio::findOrFail($condominioId);

        return view('condominio.edit', compact('condominio'));
    }

    /**
     * Salva as alterações (ex: mudar o total de blocos).
     */
    public function update(Request $request)
    {
        $condoId = (auth()->user()->role === 'admin')
            ? session('admin_condominio_id')
            : auth()->user()->condominio_id;

        if (!$condoId) {
            return redirect()->back()->withErrors(['erro' => 'Selecione um condomínio antes de salvar.']);
        }

        $condominio = Condominio::findOrFail($condoId);

        $request->validate([
            'nome' => 'required|string|max:255',
            'total_blocos' => 'required|integer|min:1',
            'andares_por_bloco' => 'nullable|integer|min:1',
            'unidades_por_andar' => 'nullable|integer|min:1',
        ]);


        $condominio->update($request->all());

        return redirect()->back()->with('success', 'Configurações atualizadas com sucesso!');
    }

    public function downloadExemplo()
    {
        $condominio = auth()->user()->condominio;

        $filename = "exemplo_importacao_" . Str::slug($condominio->nome) . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Bloco', 'Apartamento', 'nome', 'whatsapp'];

        $callback = function () use ($condominio, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);


            for ($andar = 1; $andar <= $condominio->andares_por_bloco; $andar++) {
                for ($unidade = 1; $unidade <= $condominio->unidades_por_andar; $unidade++) {

                    $numeroApto = ($andar * 100) + $unidade;

                    fputcsv($file, [
                        '1',
                        $numeroApto,
                        '',
                        ''
                    ]);
                }
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportar()
    {
        $condominio = auth()->user()->condominio;
        $apartamentos = $condominio->apartamentos;

        $filename = "base_unidades_" . Str::slug($condominio->nome) . ".csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$filename",
        ];

        $callback = function () use ($apartamentos) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Bloco', 'Apartamento']);

            foreach ($apartamentos as $apto) {
                fputcsv($file, [$apto->bloco, $apto->numero]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function destroy($id)
    {
        try {
            $condominio = \App\Models\Condominio::withoutGlobalScopes()->findOrFail($id);

            if (session('admin_condominio_id') == $condominio->id) {
                return redirect()->back()->with('status', 'Erro: Alterne o contexto para "Geral" antes de excluir este condomínio.');
            }

            \App\Models\User::where('condominio_id', $condominio->id)
                ->where('role', 'admin')
                ->update(['condominio_id' => null]);

            $condominio->delete();

            return redirect()->back()->with('status', 'Condomínio removido com sucesso! Administradores globais foram preservados.');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Erro inesperado: ' . $e->getMessage());
        }
    }

    public function importar(Request $request)
    {
        // O nome aqui deve ser 'arquivo_excel' para bater com o seu HTML
        $request->validate([
            'arquivo_excel' => 'required|mimes:xlsx,xls,csv'
        ]);

        $condominioId = (auth()->user()->role === 'admin')
            ? session('admin_condominio_id')
            : auth()->user()->condominio_id;

        if (!$condominioId) {
            return redirect()->back()->withErrors(['arquivo_excel' => 'Selecione um condomínio primeiro.']);
        }

        try {
            // Note o uso do arquivo_excel aqui também
            \Maatwebsite\Excel\Facades\Excel::import(
                new \App\Imports\MoradoresImport($condominioId),
                $request->file('arquivo_excel')
            );

            return redirect()->back()->with('success', 'Importação concluída!');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['arquivo_excel' => 'Erro: ' . $e->getMessage()]);
        }
    }
}
