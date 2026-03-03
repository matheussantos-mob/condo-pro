<x-guest-layout>
    <div class="w-full flex flex-col items-center px-4">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white/95 backdrop-blur-sm shadow-2xl overflow-hidden sm:rounded-2xl border-t-4 border-indigo-600">
            
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-indigo-50 rounded-2xl mb-4 shadow-inner">
                    <svg class="w-10 h-10 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Recuperar Senha</h2>
                <p class="text-xs text-gray-500 mt-2 font-medium px-4">Informe seu e-mail para receber o link de redefinição.</p>
            </div>

            <x-auth-session-status class="mb-4 text-center font-bold text-green-600 text-xs bg-green-50 p-3 rounded-lg border border-green-100" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">E-mail de Cadastro</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg>
                        </span>
                        <input id="email" class="block pl-10 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl shadow-sm transition py-3" 
                               type="email" name="email" :value="old('email')" required autofocus placeholder="seu@email.com" />
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="space-y-4">
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-4 bg-indigo-600 border border-transparent rounded-xl font-black text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 transition-all duration-200 shadow-lg shadow-indigo-100">
                        Enviar Link
                    </button>
                    
                    <div class="text-center">
                        <a class="text-xs text-gray-400 hover:text-indigo-600 font-bold uppercase tracking-widest transition-colors" href="{{ route('login') }}">
                            Voltar para o Login
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>