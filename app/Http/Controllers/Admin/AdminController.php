<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Condominio;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $condominios = Condominio::all();

        if (!session()->has('admin_condominio_id') && $condominios->isNotEmpty()) {
            session(['admin_condominio_id' => $condominios->first()->id]);
        }

        return view('admin.index', compact('condominios'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'nome_condominio' => 'required|string|max:255',
            'nome_sindico' => 'required|string|max:255',
            'email_sindico' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
        ]);

        $condominio = Condominio::create([
            'nome' => $request->nome_condominio,
            'unidades_por_andar' => 4,
            'total_blocos' => 1,
        ]);


        User::create([
            'name' => $request->nome_sindico,
            'email' => $request->email_sindico,
            'password' => bcrypt($request->password),
            'role' => 'sindico',
            'condominio_id' => $condominio->id,
        ]);

        if (auth()->user()->role === 'admin') {
            session(['admin_condominio_id' => $condominio->id]);
        }

        return redirect()->back()->with('status', 'Condomínio e Síndico cadastrados com sucesso!');
    }

    public function show(Condominio $condominio)
    {
        $condominio->load(['users', 'apartamentos']);

        return view('admin.show', compact('condominio'));
    }

    public function addUser(Request $request, Condominio $condominio)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:sindico,porteiro',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'condominio_id' => $condominio->id,
        ]);

        return redirect()->back()->with('status', 'Usuário adicionado com sucesso!');
    }

    public function editUser(User $user)
    {
        $condominio = $user->condominio;
        return view('admin.users.edit', compact('user', 'condominio'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:porteiro,sindico',
        ]);

        $user->update($request->only('name', 'email', 'role'));

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('admin.show', $user->condominio_id)
            ->with('status', 'Usuário atualizado com sucesso!');
    }

    public function alternarContexto(Request $request)
    {
        $request->validate([
            'condominio_id' => 'nullable|exists:condominios,id'
        ]);

        if ($request->filled('condominio_id')) {
            session(['admin_condominio_id' => $request->condominio_id]);
        } else {
            session()->forget('admin_condominio_id');
        }

        return redirect()->back()->with('status', 'Contexto alterado com sucesso!');
    }
}
