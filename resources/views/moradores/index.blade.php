<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cadastrar Moradores') }}
        </h2>
    </x-slot>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white p-6 rounded-lg shadow mb-6 border-l-2 border-gray-800">
                <h3 class="text-lg font-bold mb-4">Cadastrar Morador</h3>
                <form action="{{ route('moradores.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf
                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apartamento / Bloco</label>
                        <select id="select-apto-morador" name="apartamento_id" required>
                            <option value="">Buscar unidade...</option>
                            @foreach($apartamentos as $apto)
                            <option value="{{ $apto->id }}">Apto {{ $apto->numero }} - Bloco {{ $apto->bloco }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nome do Morador</label>
                        <input type="text" name="nome" placeholder="Nome completo" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                        <input type="text" id="whatsapp_mask" placeholder="(00) 00000-0000" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500" required>
                        <input type="hidden" name="whatsapp" id="whatsapp_raw">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Ações</label>
                        <div class="flex gap-2">
                            <button type="submit" class="w-1/2 bg-blue-600 text-white py-2 rounded-md hover:bg-blue-700 font-bold transition flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            <button type="button" onclick="alert('Funcionalidade de importação em breve!')" class="w-1/2 bg-green-600 text-white py-2 rounded-md hover:bg-green-700 font-bold transition flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            @if ($errors->any())
            <div id="error-message" class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded shadow">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (session('status'))
            <div id="success-message" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded shadow">
                {{ session('status') }}
            </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow border-l-2 border-gray-800">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Moradores Cadastrados</h3>
                <div class="overflow-x-auto">
                    <table id="tabela-moradores" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Unidade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">WhatsApp</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($moradores as $morador)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $morador->nome }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">Apto {{ $morador->apartamento->numero }} - Bloco {{ $morador->apartamento->bloco }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-blue-600 font-mono">{{ $morador->whatsapp }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('moradores.edit', $morador) }}"
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                            title="Editar Morador">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('moradores.destroy', $morador) }}" method="POST" class="form-excluir-morador inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-deletar-morador text-red-500 hover:text-red-700 transition-colors" title="Excluir Morador">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/imask"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#select-apto-morador", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Digite o número...",
                maxOptions: 50,
            });

            const element = document.getElementById('whatsapp_mask');
            const hiddenInput = document.getElementById('whatsapp_raw');
            if (element && hiddenInput) {
                const mask = IMask(element, {
                    mask: '(00) 00000-0000'
                });
                element.addEventListener('input', () => {
                    hiddenInput.value = mask.unmaskedValue.length > 0 ? '55' + mask.unmaskedValue : '';
                });
            }

            $('#tabela-moradores').DataTable({
                "pageLength": 30,
                "dom": 'frtip',
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
                },
                "columnDefs": [{
                    "orderable": false,
                    "targets": 3
                }]
            });

            $(document).on('click', '.btn-deletar-morador', function() {
                const form = this.closest('.form-excluir-morador');
                Swal.fire({
                    title: 'Remover Morador?',
                    text: "Este morador não terá mais acesso às notificações!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Sim, remover!',
                    cancelButtonText: 'Cancelar',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });

            const hideMessage = (id) => {
                const el = document.getElementById(id);
                if (el) {
                    setTimeout(() => {
                        el.style.transition = "opacity 0.5s ease";
                        el.style.opacity = '0';
                        setTimeout(() => el.remove(), 500);
                    }, 5000);
                }
            };
            hideMessage('error-message');
            hideMessage('success-message');

            // $('#tabela-moradores').DataTable({
            //     "pageLength": 30,
            //     "dom": 'frtip',
            //     "language": {
            //         "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            //     },
            //     "columnDefs": [{
            //             "orderable": false,
            //             "targets": 3
            //         } // O índice 3 é a coluna de Ações
            //     ]
            // });
        });
    </script>
</x-app-layout>