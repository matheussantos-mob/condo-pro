<x-guest-layout>
    <div class="w-full flex flex-col items-center px-4">
        
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600 transition-all duration-300">
            
            <div class="mb-10 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-indigo-50 rounded-2xl mb-4 shadow-inner">
                    <svg class="w-12 h-12 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-black text-gray-900 tracking-tighter">Portaria Pro</h2>
                <p class="text-sm text-gray-500 mt-2 font-medium">Gestão inteligente de encomendas</p>
            </div>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Acesso Corporativo</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </span>
                        <input id="email" class="block pl-10 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition duration-200 placeholder-gray-300 py-3" 
                               type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div>
                    <div class="flex justify-between items-center mb-2 ml-1">
                        <label for="password" class="block text-xs font-bold uppercase tracking-widest text-gray-400">Senha</label>
                        @if (Route::has('password.request'))
                            <a class="text-xs text-indigo-600 hover:text-indigo-900 font-bold" href="{{ route('password.request') }}">
                                Esqueceu?
                            </a>
                        @endif
                    </div>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </span>
                        <input id="password" class="block pl-10 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition duration-200 placeholder-gray-300 py-3"
                                    type="password" name="password" required placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 w-5 h-5 cursor-pointer" name="remember">
                    <span class="ms-3 text-sm text-gray-500 font-semibold cursor-pointer select-none">Manter conectado</span>
                </div>

                <div>
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-4 bg-indigo-600 border border-transparent rounded-xl font-black text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-4 focus:ring-indigo-500/30 transition-all duration-200 shadow-xl shadow-indigo-200">
                        Entrar no Sistema
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>