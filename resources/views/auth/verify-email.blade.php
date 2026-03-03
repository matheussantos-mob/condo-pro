<x-guest-layout>
    <div class="w-full flex flex-col items-center px-4">
        <div class="w-full sm:max-w-md mt-6 px-8 py-10 bg-white shadow-2xl sm:rounded-2xl border-t-4 border-indigo-600 text-center">
            
            <div class="mb-6">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 rounded-2xl mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <h2 class="text-2xl font-black text-gray-900 tracking-tighter uppercase">Verifique seu E-mail</h2>
                <p class="text-sm text-gray-500 mt-4 leading-relaxed">
                    Obrigado por se cadastrar! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você?
                </p>
            </div>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-bold text-xs text-green-600 bg-green-50 p-3 rounded-lg border border-green-100">
                    Um novo link de verificação foi enviado para o e-mail cadastrado.
                </div>
            @endif

            <div class="mt-8 space-y-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex justify-center items-center px-4 py-4 bg-indigo-600 text-white rounded-xl font-black uppercase tracking-widest hover:bg-indigo-700 transition">
                        Reenviar Link
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs text-gray-400 hover:text-red-600 font-bold uppercase tracking-widest transition">
                        Sair do Sistema
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>