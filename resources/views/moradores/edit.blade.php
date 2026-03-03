<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar Morador') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-2 border-gray-800">
                
                <div class="mb-6">
                    <h3 class="text-lg font-bold text-gray-800">Atualizar Dados do Morador</h3>
                    <p class="text-sm text-gray-600">Altere o nome, telefone ou a unidade vinculada.</p>
                </div>

                <form action="{{ route('moradores.update', $morador->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Apartamento / Bloco</label>
                            <select id="select-apto-edit" name="apartamento_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                                @foreach($apartamentos as $apto)
                                    <option value="{{ $apto->id }}" {{ $morador->apartamento_id == $apto->id ? 'selected' : '' }}>
                                        Apto {{ $apto->numero }} - Bloco {{ $apto->bloco }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nome Completo</label>
                            <input type="text" name="nome" value="{{ old('nome', $morador->nome) }}" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                        </div>

                        <div class="md:col-span-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                            <input type="text" id="whatsapp_mask_edit" placeholder="(00) 00000-0000" 
                                   class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                            <input type="hidden" name="whatsapp" id="whatsapp_raw_edit" value="{{ $morador->whatsapp }}">
                        </div>
                    </div>

                    <div class="mt-8 flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md font-bold hover:bg-blue-700 transition">
                            Atualizar Morador
                        </button>
                        <a href="{{ route('moradores.index') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-md font-bold hover:bg-gray-300 transition">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://unpkg.com/imask"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#select-apto-edit", {
                create: false,
                placeholder: "Selecione a unidade...",
            });

            const element = document.getElementById('whatsapp_mask_edit');
            const hiddenInput = document.getElementById('whatsapp_raw_edit');
            const mask = IMask(element, { mask: '(00) 00000-0000' });

            const valorBanco = hiddenInput.value.replace(/^55/, '');
            mask.value = valorBanco;

            element.addEventListener('input', () => {
                hiddenInput.value = mask.unmaskedValue.length > 0 ? '55' + mask.unmaskedValue : '';
            });
        });
    </script>
</x-app-layout>