<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Configurações do Condomínio') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Configurações Gerais</h2>
                    <p class="mt-1 text-sm text-gray-600">Defina os limites físicos do condomínio para validação.</p>
                </header>

                @if (session('success'))
                <div id="success-alert" class="mb-6 p-4 text-sm text-green-600 bg-green-50 rounded-lg">
                    {{ session('success') }}
                </div>
                @endif

                <form method="post" action="{{ route('condominio.update') }}" class="space-y-6">
                    @csrf
                    @method('put')

                    <div class="max-w-xl">
                        <x-input-label for="nome" :value="__('Nome do Condomínio')" />
                        <x-text-input id="nome" name="nome" type="text" class="mt-1 block w-full" :value="old('nome', $condominio->nome)" required />
                        <x-input-error class="mt-2" :messages="$errors->get('nome')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="total_blocos" :value="__('Total de Blocos')" />
                            <x-text-input name="total_blocos" type="number" class="mt-1 block w-full" :value="$condominio->total_blocos" />
                        </div>
                        <div>
                            <x-input-label for="andares_por_bloco" :value="__('Andares')" />
                            <x-text-input name="andares_por_bloco" type="number" class="mt-1 block w-full" :value="$condominio->andares_por_bloco" />
                        </div>
                        <div>
                            <x-input-label for="unidades_por_andar" :value="__('Aptos por Andar')" />
                            <x-text-input name="unidades_por_andar" type="number" class="mt-1 block w-full" :value="$condominio->unidades_por_andar" />
                        </div>
                    </div>

                    <div class="flex items-center gap-4 border-t pt-6">
                        <x-primary-button>{{ __('Salvar Alterações') }}</x-primary-button>
                    </div>
                </form>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <header class="mb-6">
                    <h2 class="text-lg font-medium text-gray-900">Gestão de Dados</h2>
                    <p class="mt-1 text-sm text-gray-600">Importe ou exporte as unidades do condomínio.</p>
                </header>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-4 border rounded-lg">
                        <p class="text-sm font-semibold mb-2">1. Baixar Modelo</p>
                        <p class="text-xs text-gray-500 mb-4">Baixe um CSV pronto com base na sua configuração de blocos e andares.</p>
                        <a href="{{ route('condominio.exemplo-excel') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50">
                            {{ __('Baixar Planilha Exemplo') }}
                        </a>
                    </div>

                    <div class="p-4 border rounded-lg">
                        <p class="text-sm font-semibold mb-2">2. Importar Unidades</p>
                        <form action="{{ route('condominio.importar') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            {{-- Mantenha o nome que preferir, mas deve ser igual no Controller --}}
                            <input type="file" name="arquivo_excel" class="block w-full text-sm text-gray-500 mb-4 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-gray-300 file:text-xs file:font-semibold" />

                            {{-- Adicione isso para ver o erro se a validação falhar --}}
                            <x-input-error class="mb-4" :messages="$errors->get('arquivo_excel')" />

                            <x-primary-button class="w-full justify-center">
                                {{ __('Iniciar Importação') }}
                            </x-primary-button>
                        </form>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <a href="{{ route('condominio.exportar') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">
                        Exportar base de dados atual
                    </a>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alert = document.getElementById('success-alert');
            if (alert) {
                setTimeout(() => {
                    alert.style.transition = "opacity 0.5s ease";
                    alert.style.opacity = "0";
                    setTimeout(() => alert.remove(), 500);
                }, 5000);
            }
        });
    </script>
</x-app-layout>