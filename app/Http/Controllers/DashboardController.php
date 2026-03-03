<?php

namespace App\Http\Controllers;

use App\Models\Encomenda;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{

    public function index()
    {
        $estoqueAtual = Encomenda::where('status', '!=', 'entregue')->count();

        $aguardandoRetirada = Encomenda::where('status', 'notificado')->count();

        $entradasHoje = Encomenda::whereDate('created_at', today())->count();

        $esquecidos = Encomenda::where('status', 'notificado')
            ->where('notificado_em', '<=', now()->subDays(10))
            ->count();

        $totalUnidades = \App\Models\Apartamento::count();
        $totalMoradores = \App\Models\Morador::count();

        $dataChart = [
            'pendentes'   => Encomenda::where('status', 'pendente')->count(),
            'notificados' => Encomenda::where('status', 'notificado')->count(),
            'entregues'   => Encomenda::where('status', 'entregue')->count(),
        ];

        $entregasHoje = Encomenda::where('status', 'entregue')
            ->whereDate('entregue_em', now())
            ->count();

        $condominioIdBusca = (auth()->user()->role === 'admin' && session()->has('admin_condominio_id'))
            ? session('admin_condominio_id')
            : auth()->user()->condominio_id;

        $usuarios = collect();
        if (auth()->user()->role === 'admin' || auth()->user()->role === 'sindico') {
            $query = \App\Models\User::where('condominio_id', $condominioIdBusca);

            if (auth()->user()->role !== 'admin') {
                $query->where('role', '!=', 'admin');
            }

            $usuarios = $query->get();
        }

        $condominioIdAtivo = (auth()->user()->role === 'admin' && session()->has('admin_condominio_id'))
            ? session('admin_condominio_id')
            : auth()->user()->condominio_id;

        $dataLimite = now()->subDays(30);

        $resumoAtividades = User::where('role', 'porteiro')
            ->where('condominio_id', $condominioIdAtivo)
            ->get()
            ->map(function ($porteiro) use ($dataLimite) {
                return [
                    'name' => $porteiro->name,
                    'email' => $porteiro->email,

                    'cadastrados' => Encomenda::where('user_id', $porteiro->id)
                        ->where('created_at', '>=', $dataLimite)
                        ->count(),

                    'notificados' => Encomenda::where('notificado_por_id', $porteiro->id)
                        ->where('notificado_em', '>=', $dataLimite)
                        ->count(),

                    'entregues'   => Encomenda::where('entregue_por_id', $porteiro->id)
                        ->where('entregue_em', '>=', $dataLimite)
                        ->count(),
                ];
            });

        return view('dashboard', compact(
            'estoqueAtual',
            'aguardandoRetirada',
            'entradasHoje',
            'esquecidos',
            'totalUnidades',
            'totalMoradores',
            'dataChart',
            'usuarios',
            'entregasHoje',
            'resumoAtividades'
        ));
    }

    public function storePorteiro(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $condominioId = session('admin_condominio_id', auth()->user()->condominio_id);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'porteiro',
            'condominio_id' => $condominioId,
        ]);

        return redirect()->back()->with('status', 'Porteiro cadastrado com sucesso!');
    }

    public function destroy(User $user)
    {
        $authUser = auth()->user();

        if ($authUser->role === 'admin') {
            if ($authUser->id === $user->id) {
                return redirect()->back()->withErrors(['erro' => 'Você não pode excluir seu próprio usuário mestre!']);
            }

            $user->delete();
            return redirect()->back()->with('status', 'Usuário removido pelo Administrador Master.');
        }

        if (
            $authUser->role === 'sindico' &&
            $authUser->condominio_id === $user->condominio_id &&
            $user->role === 'porteiro'
        ) {

            $user->delete();
            return redirect()->back()->with('status', 'Acesso removido com sucesso.');
        }

        return redirect()->back()->withErrors(['erro' => 'Você não tem permissão para realizar esta ação.']);
    }
}
