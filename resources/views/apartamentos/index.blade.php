<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cadastrar Unidades</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded shadow">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded shadow">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div class="bg-white p-6 rounded-lg shadow mb-6 border-l-2 border-gray-800">
                <h3 class="text-lg font-bold mb-4">Cadastrar Unidade</h3>

                <form action="{{ route('apartamentos.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                    @csrf

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Bloco / Torre</label>
                        <input type="text" name="bloco" placeholder="Ex: A" class="w-full border-gray-300 rounded-md uppercase focus:ring-indigo-500" required>
                    </div>

                    <div class="md:col-span-3">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Número da Unidade</label>
                        <input type="text" name="numero" placeholder="Ex: 101" class="w-full border-gray-300 rounded-md focus:ring-indigo-500" required>
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1 italic text-gray-400">Ações</label>
                        <div class="flex gap-2">
                            <button type="submit" title="Salvar Unidade" class="flex-1 bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 font-bold transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <button type="button" onclick="alert('Funcionalidade de importação em massa em breve!')" title="Importar via Excel" class="flex-1 bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 font-bold transition flex items-center justify-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-2 border-gray-800">
                <h3 class="text-lg font-bold mb-4 text-gray-800">Unidades Cadastradas</h3>
                <div class="overflow-x-auto">
                    <table id="tabela-unidades" class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Bloco / Torre</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Número da Unidade</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($apartamentos as $apto)
                            <tr class="btn-ver-moradores cursor-pointer hover:bg-gray-50"
                                data-unidade="Unidade {{ $apto->numero }} - Bloco {{ $apto->bloco }}"
                                data-moradores="{{ $apto->moradores->toJson() }}">

                                <td class="px-6 py-4 font-bold">{{ $apto->bloco }}</td>
                                <td class="px-6 py-4">{{ $apto->numero }}</td>

                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <a href="{{ route('apartamentos.edit', $apto->id) }}"
                                            class="text-indigo-600 hover:text-indigo-900 transition-colors"
                                            title="Editar Unidade"
                                            onclick="event.stopPropagation();">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>

                                        <form action="{{ route('apartamentos.destroy', $apto->id) }}" method="POST" class="form-excluir inline" onclick="event.stopPropagation();">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-deletar text-red-500 hover:text-red-700 transition-colors" title="Excluir Unidade">
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const swalConfig = {
                confirmButtonColor: '#4f46e5',
                cancelButtonColor: '#ef4444',
                reverseButtons: true,
                cancelButtonText: 'Cancelar'
            };

            document.querySelectorAll('.btn-deletar').forEach(botao => {
                botao.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const form = this.closest('.form-excluir');

                    Swal.fire({
                        ...swalConfig,
                        title: 'Tem certeza?',
                        text: "Você não poderá reverter esta exclusão!",
                        icon: 'warning',
                        confirmButtonText: 'Sim, excluir!'
                    }).then((result) => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });

            document.querySelectorAll('.btn-ver-moradores').forEach(card => {
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.form-excluir')) return;

                    const unidade = this.getAttribute('data-unidade');
                    const moradores = JSON.parse(this.getAttribute('data-moradores'));

                    const htmlMoradores = moradores.length > 0 ?
                        buildMoradoresTable(moradores) :
                        '<p class="text-gray-500 italic">Nenhum morador cadastrado nesta unidade.</p>';

                    Swal.fire({
                        title: unidade,
                        html: htmlMoradores,
                        showCloseButton: true,
                        showConfirmButton: false,
                        width: '600px'
                    });
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
        });


        function buildMoradoresTable(moradores) {
            return `
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 uppercase text-xs">
                        <tr>
                            <th class="p-2">Nome</th>
                            <th class="p-2">WhatsApp</th>
                            <th class="p-2 text-center">Ação</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${moradores.map(m => `
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-2">${m.nome}</td>
                                <td class="p-2 text-blue-600 font-mono">${m.whatsapp}</td>
                                <td class="p-2 text-center">
                                    <button onclick="excluirMoradorDirect(${m.id})" class="text-red-500 font-bold hover:underline">Remover</button>
                                </td>
                            </tr>
                        `).join('')}
                    </tbody>
                </table>
            </div>`;
        }

        function excluirMoradorDirect(id) {
            Swal.fire({
                title: 'Excluir Morador?',
                text: "Esta ação removerá o morador do sistema.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                confirmButtonText: 'Sim, excluir!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/moradores/${id}`;
                    form.innerHTML = `
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="_method" value="DELETE">
                `;
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
        $('#tabela-unidades').DataTable({
            "pageLength": 30,
            "dom": 'frtip',
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json"
            },
            "columnDefs": [{
                    "orderable": false,
                    "targets": 2
                } // Coluna de Ações desativada para ordenação
            ]
        });
    </script>
</x-app-layout>