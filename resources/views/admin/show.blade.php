<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Gerenciando: {{ $condominio->nome }}
            </h2>
            <a href="{{ route('admin.index') }}" class="text-sm text-gray-500 hover:underline">← Voltar</a>
        </div>
    </x-slot>
    @if (session('status'))
    <div id="flash-message" class="mb-4 p-4 {{ str_contains(session('status'), 'Erro') ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700' }} border rounded shadow transition-opacity duration-500">
        {{ session('status') }}
    </div>
    @endif

    @if ($errors->any())
    <div class="mb-4 p-4 bg-red-100 border-l-4 border-red-500 text-red-700 shadow-sm">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-blue-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Total de Unidades</p>
                    <p class="text-2xl font-bold">{{ $condominio->apartamentos->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow border-l-4 border-purple-500">
                    <p class="text-sm text-gray-500 uppercase font-bold">Equipe (Porteiros/Síndicos)</p>
                    <p class="text-2xl font-bold">{{ $condominio->users->count() }}</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6 border-t-4 border-green-500">
                <h3 class="text-lg font-bold mb-4 text-gray-700">Adicionar Funcionário (Porteiro/Síndico)</h3>

                <form action="{{ route('admin.user.store', $condominio->id) }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nome Completo</label>
                            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Senha</label>
                            <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Função</label>
                            <select name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-green-500 focus:border-green-500">
                                <option value="porteiro">Porteiro</option>
                                <option value="sindico">Síndico</option>
                            </select>
                        </div>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-md font-bold hover:bg-green-700 shadow-md transition duration-200">
                            Cadastrar e Vincular
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4">Usuários Vinculados ao Condomínio</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($condominio->users as $user)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 text-sm font-medium text-gray-900">{{ $user->name }}</td>
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $user->role === 'sindico' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">{{ $user->email }}</td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-2">
                                        {{-- Botão Editar --}}
                                        <button type="button"
                                            onclick='openEditModal({!! json_encode($user) !!})'
                                            class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 p-2 rounded-lg transition"
                                            title="Editar Usuário">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        {{-- Botão Excluir --}}
                                        <form action="{{ route('usuarios.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Atenção: Esta ação removerá o acesso de {{ $user->name }} permanentemente. Confirmar?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition" title="Excluir Usuário">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('admin.partials.modal-edit-user')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const message = document.getElementById('flash-message');
            if (message) {
                setTimeout(() => {
                    message.style.opacity = '0';

                    setTimeout(() => {
                        message.remove();
                    }, 500);

                }, 5000);
            }
        });
    </script>
</x-app-layout>