<div id="modalGestaoAcesso" class="fixed inset-0 z-50 hidden overflow-y-auto" role="dialog" aria-modal="true">
    <div class="flex items-center justify-center min-h-screen p-4 sm:p-6">

        <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"
            onclick="document.getElementById('modalGestaoAcesso').classList.add('hidden')"></div>

        <div class="relative bg-white rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden transition-all flex flex-col md:flex-row">

            <div class="w-full md:w-5/12 p-8 border-b md:border-b-0 md:border-r border-gray-100">
                <div class="mb-6">
                    <span class="text-indigo-600 text-[10px] font-black uppercase tracking-[0.2em]">Administração</span>
                    <h3 class="text-2xl font-black text-gray-900 leading-tight uppercase tracking-tighter">Novo Porteiro</h3>
                </div>
                @if($errors->any())
                <div class="mb-4 p-3 bg-red-50 border-l-4 border-red-500 text-red-700 text-xs">
                    <ul class="list-disc ml-4">
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form action="{{ route('usuarios.storePorteiro') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Nome Completo</label>
                        <input type="text" name="name" required placeholder="Ex: João Silva"
                            class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">E-mail de Acesso</label>
                        <input type="email" name="email" required placeholder="porteiro@exemplo.com"
                            class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3 transition-all">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Senha Provisória</label>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 text-sm py-3 transition-all">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-400 uppercase mb-1 ml-1">Confirmar Senha</label>
                        <input type="password" name="password_confirmation" required placeholder="••••••••"
                            class="w-full border-gray-200 rounded-xl focus:ring-indigo-500 text-sm py-3">
                    </div>

                    <button type="submit" class="w-full py-4 bg-indigo-600 text-white rounded-xl font-bold uppercase tracking-widest hover:bg-indigo-700 shadow-lg shadow-indigo-200 transition-all active:scale-95">
                        Confirmar Cadastro
                    </button>
                </form>
            </div>

            <div class="w-full md:w-7/12 p-8 bg-gray-50/50 flex flex-col">
                <div class="mb-6 flex justify-between items-end">
                    <div>
                        <span class="text-gray-400 text-[10px] font-black uppercase tracking-[0.2em]">Equipe Atual</span>
                        <h3 class="text-2xl font-black text-gray-900 leading-tight uppercase tracking-tighter">Ativos no Prédio</h3>
                    </div>
                    <span class="text-xs font-bold text-indigo-500 bg-indigo-50 px-2 py-1 rounded-lg">
                        {{ $usuarios->where('role', 'porteiro')->count() }} Porteiros
                    </span>
                </div>

                <div class="flex-1 space-y-3 overflow-y-auto pr-2 max-h-[400px] custom-scrollbar">
                    @forelse($usuarios->where('role', 'porteiro') as $porteiro)
                    <div class="flex items-center justify-between p-4 bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 font-bold text-sm">
                                {{ substr($porteiro->name, 0, 1) }}
                            </div>
                            <div class="overflow-hidden">
                                <p class="text-sm font-bold text-gray-800 truncate">{{ $porteiro->name }}</p>
                                <p class="text-[10px] text-gray-400 font-medium truncate">{{ $porteiro->email }}</p>
                            </div>
                        </div>

                        <form action="{{ route('usuarios.destroy', $porteiro->id) }}" method="POST"
                            onsubmit="return confirm('ATENÇÃO: Este porteiro perderá o acesso imediatamente. Confirmar?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 text-gray-300 hover:text-red-500 hover:bg-red-50 rounded-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <p class="text-gray-400 text-sm italic">Nenhum porteiro cadastrado.</p>
                    </div>
                    @endforelse
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    <button onclick="document.getElementById('modalGestaoAcesso').classList.add('hidden')"
                        class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors w-full text-center">
                        Fechar Painel de Gestão
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Script para reabrir modal se houver erro de validação --}}
@if($errors->any())
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('modalGestaoAcesso').classList.remove('hidden');
    });
</script>
@endif