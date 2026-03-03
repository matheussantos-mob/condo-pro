<x-guest-layout>
    <div class="w-full flex flex-col items-center px-4">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl sm:rounded-2xl border-t-4 border-indigo-600">
            
            <div class="mb-8 text-center">
                <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Nova Senha</h2>
                <p class="text-xs text-gray-500 mt-2 font-medium">Crie sua nova credencial de acesso.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <div>
                    <label class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">E-mail</label>
                    <input id="email" class="block w-full border-gray-100 bg-gray-50 text-gray-500 rounded-xl py-3" 
                           type="email" name="email" value="{{ old('email', $request->email) }}" required readonly />
                </div>

                <div>
                    <label for="password" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Nova Senha</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 00-2 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </span>
                        <input id="password" class="block pl-10 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3"
                               type="password" name="password" required placeholder="••••••••" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <label for="password_confirmation" class="block text-xs font-bold uppercase tracking-widest text-gray-400 mb-2 ml-1">Confirmar Senha</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-focus-within:text-indigo-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4" /></svg>
                        </span>
                        <input id="password_confirmation" class="block pl-10 w-full border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 rounded-xl py-3"
                               type="password" name="password_confirmation" required placeholder="••••••••" />
                    </div>
                </div>

                <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-4 bg-indigo-600 text-white rounded-xl font-black uppercase tracking-widest hover:bg-indigo-700 transition shadow-lg">
                    Redefinir Senha
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>