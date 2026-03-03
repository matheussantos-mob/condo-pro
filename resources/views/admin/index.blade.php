<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Painel Master Admin - Gestão de Condomínios') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
            <div id="flash-message" class="mb-4 p-4 {{ str_contains(session('status'), 'Erro') ? 'bg-red-100 border-red-400 text-red-700' : 'bg-green-100 border-green-400 text-green-700' }} border rounded shadow transition-opacity duration-500">
                {{ session('status') }}
            </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <div class="lg:col-span-1">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-t-4 border-yellow-500">
                        <h3 class="text-lg font-bold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                            </svg>
                            Novo Condomínio
                        </h3>

                        <form action="{{ route('admin.store') }}" method="POST">
                            @csrf
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nome do Condomínio</label>
                                    <input type="text" name="nome_condominio" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Ex: Edifício Horizonte" required>
                                </div>

                                <hr class="my-4">
                                <p class="text-xs font-bold text-gray-400 uppercase">Dados do Síndico (Acesso Pai)</p>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Nome do Síndico</label>
                                    <input type="text" name="nome_sindico" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email de Acesso</label>
                                    <input type="email" name="email_sindico" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Senha Provisória</label>
                                    <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                </div>

                                <button type="submit" class="w-full bg-gray-900 text-white py-2 rounded-md font-bold hover:bg-black transition">
                                    Cadastrar Unidade
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="lg:col-span-2">
                    <div class="lg:col-span-2">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                            <h3 class="text-lg font-bold mb-4">Condomínios Gerenciados</h3>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Condomínio</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Síndico</th>
                                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($condominios as $condo)
                                        <tr>
                                            <td class="px-4 py-4 text-sm text-gray-500">#{{ $condo->id }}</td>
                                            <td class="px-4 py-4 font-bold text-gray-900">{{ $condo->nome }}</td>
                                            <td class="px-4 py-4 text-sm text-gray-600">
                                                @foreach($condo->users->where('role', 'sindico') as $sindico)
                                                <div class="text-xs font-bold">{{ $sindico->name }}</div>
                                                <div class="text-[10px] text-gray-400">{{ $sindico->email }}</div>
                                                @endforeach
                                            </td>
                                            <td class="px-4 py-4">
                                                <div class="flex items-center justify-center gap-3">
                                                    <a href="{{ route('admin.show', $condo->id) }}"
                                                        class="inline-flex items-center px-3 py-1.5 bg-indigo-600 text-white text-[10px] font-black uppercase tracking-widest rounded hover:bg-indigo-700 transition shadow-sm">
                                                        Gerenciar
                                                    </a>

                                                    <form action="{{ route('condominios.destroy', $condo->id) }}" method="POST" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="button"
                                                            onclick="if(confirm('ATENÇÃO: Deletar este condomínio apagará todos os moradores e encomendas vinculadas. Confirmar?')) { this.closest('form').submit(); }"
                                                            class="inline-flex items-center px-3 py-1.5 bg-red-50 text-red-600 text-[10px] font-black uppercase tracking-widest rounded border border-red-200 hover:bg-red-600 hover:text-white transition">
                                                            Excluir
                                                        </button>
                                                    </form>                                                    
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500 italic">Nenhum condomínio cadastrado no sistema.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

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