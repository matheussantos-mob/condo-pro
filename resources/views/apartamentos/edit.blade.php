<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Unidade') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-2 border-gray-800">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Alterar informações da Unidade</h3>
                    <p class="text-sm text-gray-600">Modifique os campos abaixo para atualizar o Bloco ou Número.</p>
                </div>

                <form action="{{ route('apartamentos.update', $apartamento->id) }}" method="POST">
                    @csrf
                    @method('PUT') <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Bloco / Torre</label>
                            <input type="text" name="bloco" value="{{ old('bloco', $apartamento->bloco) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 uppercase" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Número da Unidade</label>
                            <input type="text" name="numero" value="{{ old('numero', $apartamento->numero) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500" required>
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md font-bold hover:bg-indigo-700 transition">
                            Salvar Alterações
                        </button>
                        
                        <a href="{{ route('apartamentos.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md font-bold hover:bg-gray-300 transition text-center">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>