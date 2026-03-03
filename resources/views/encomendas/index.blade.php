<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <h2 class="text-xl font-bold text-slate-800 leading-tight flex items-center gap-3">
                <div class="p-2 bg-indigo-600 rounded-lg shadow-md">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <span>Gerenciamento de Encomendas</span>
            </h2>
            <div class="flex items-center gap-2">
                <span class="bg-slate-200 text-slate-700 px-3 py-1 rounded-md text-sm font-bold">
                    Estoque: {{ count($encomendas->where('status', '!=', 'entregue')) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-3 md:py-8 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
            <div id="success-message" class="mb-6 p-4 bg-white border-l-4 border-indigo-600 shadow-md rounded-md flex justify-between items-center">
                <div class="flex items-center gap-3 font-semibold text-slate-700">
                    <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-6 mb-4 -mt-4 relative z-10">
                <h3 class="text-base font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Registrar Nova Encomenda
                </h3>

                <form action="{{ route('encomendas.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-5">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-600 mb-2">Unidade / Bloco</label>
                            <select id="select-apto" name="apartamento_id" required>
                                <option value="">Selecione...</option>
                                @foreach($apartamentos as $apto)
                                <option value="{{ $apto->id }}">Apto {{ $apto->numero }} - Bloco {{ $apto->bloco }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-600 mb-2">Descrição</label>
                            <input type="text" name="descricao" placeholder="Ex: Pacote Amazon" class="w-full border-slate-300 rounded-lg py-2.5 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-bold text-slate-600 mb-2">Local / Setor</label>
                            <input type="text" name="setor_estoque" placeholder="Ex: Prateleira A" class="w-full border-slate-300 rounded-lg py-2.5 text-sm font-medium focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-all shadow-md">
                                Confirmar Entrada
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-slate-200">
                <div class="p-0 md:p-6">
                    <div class="overflow-x-auto mb-6">
                        <table id="tabela-encomendas" class="w-full text-left border-collapse min-w-[800px]">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-4 py-4 text-sm font-bold text-slate-700">Unidade</th>
                                    <th class="px-4 py-4 text-sm font-bold text-slate-700">Descrição</th>
                                    <th class="px-4 py-4 text-sm font-bold text-slate-700">Setor</th>
                                    <th class="px-4 py-4 text-sm font-bold text-slate-700">Avisar</th>
                                    <th class="px-4 py-4 text-sm font-bold text-slate-700">Status</th>
                                    <th class="px-4 py-4 text-center text-sm font-bold text-slate-700">Entrega</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($encomendas as $encomenda)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4">
                                        <span class="text-sm font-bold text-slate-900">Apto {{ $encomenda->apartamento?->numero }}</span>
                                        <div class="text-xs text-slate-500">Bloco {{ $encomenda->apartamento?->bloco }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-600 font-medium">{{ $encomenda->descricao }}</td>
                                    <td class="px-4 py-4">
                                        <span class="text-xs font-bold text-indigo-700 bg-indigo-50 px-2 py-1 rounded-md">{{ $encomenda->setor_estoque }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex gap-1">
                                            @foreach($encomenda->apartamento->moradores as $morador)
                                            <button type="button" onclick="notificarMorador(this, '{{ route('encomendas.notificar', [$encomenda->id, $morador->id]) }}')"
                                                class="p-2 {{ $encomenda->status === 'notificado' ? 'bg-indigo-600' : 'bg-slate-700' }} text-white rounded-md hover:opacity-80 transition shadow-sm">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                                </svg>
                                            </button>
                                            @endforeach
                                        </div>
                                    </td>
                                    <td class="px-4 py-4">
                                        <span id="status-badge-{{ $encomenda->id }}" class="text-[11px] font-bold uppercase px-2 py-0.5 rounded-full border {{ $encomenda->status === 'pendente' ? 'bg-amber-50 border-amber-200 text-amber-700' : ($encomenda->status === 'notificado' ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-emerald-50 border-emerald-200 text-emerald-700') }}">
                                            {{ $encomenda->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4 text-center">
                                        @if($encomenda->status !== 'entregue')
                                        @else
                                        <div class="text-[11px] text-emerald-600 font-bold uppercase italic">Retirado por: {{ $encomenda->retirado_por }}</div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        /* TomSelect Estilizado */
        .ts-control {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.65rem !important;
            font-weight: 500 !important;
            font-size: 0.875rem !important;
        }

        .ts-control:focus {
            border-color: #4f46e5 !important;
            ring: 2px solid #4f46e5 !important;
        }

        /* DataTables Estilizado */


        .dataTables_wrapper,
        .dataTables_scrollBody,
        .dataTables_scroll {
            overflow-y: visible !important;
            height: auto !important;
            max-height: none !important;
        }

        .overflow-x-auto {
            overflow-y: hidden !important;
        }

        .dataTables_filter {
            margin-bottom: 1.5rem;
            float: right;
        }

        .dataTables_filter input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem 1rem !important;
            margin-left: 0.5rem !important;
            font-size: 0.875rem !important;
            outline: none;
        }

        .dataTables_filter input:focus {
            border-color: #4f46e5 !important;
            box-shadow: 0 0 0 2px rgba(79, 70, 229, 0.1);
        }

        .dataTables_info {
            font-size: 0.875rem !important;
            color: #64748b !important;
            font-weight: 500 !important;
            padding-top: 1.5rem !important;
        }

        /* Paginação Customizada */
        .dataTables_paginate {
            margin-top: 20px !important;
            padding-bottom: 10px !important;
            display: flex !important;
            justify-content: flex-end !important;
            gap: 5px;
        }

        .paginate_button {
            padding: 0.4rem 0.8rem !important;
            margin: 0 0.2rem !important;
            border-radius: 0.4rem !important;
            border: 1px solid #e2e8f0 !important;
            background: white !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            cursor: pointer;
            color: #475569 !important;
        }

        .paginate_button:hover {
            background: #f1f5f9 !important;
            color: #1e293b !important;
        }

        .paginate_button.current {
            background: #4f46e5 !important;
            color: white !important;
            border-color: #4f46e5 !important;
        }

        .paginate_button.disabled {
            opacity: 0.5;
            cursor: default;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#select-apto", {
                placeholder: "Digite número ou bloco..."
            });

            $('#tabela-encomendas').DataTable({
                "pageLength": 10,
                "dom": '<"top"f>rt<"bottom"ip><"clear">',
                "scrollY": false,
                "scrollCollapse": false,
                "paging": true,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
                    "search": "BUSCAR:",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Próximo"
                    }
                },

                "order": [
                    [4, "asc"]
                ],
                "columnDefs": [{
                    "targets": 4,
                    "render": function(data, type, row) {
                        if (type === 'sort') {
                            var status = data.replace(/<[^>]*>?/gm, '').trim().toLowerCase();
                            if (status === 'pendente') return 1;
                            if (status === 'notificado') return 2;
                            if (status === 'entregue') return 3;
                            return 4;
                        }
                        return data;
                    }
                }]
            });
        });

        function notificarMorador(botao, url) {
            const originalHTML = botao.innerHTML;
            // Spinner para feedback visual de carregamento
            botao.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            botao.disabled = true;

            fetch(url, {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        window.open(data.url, 'janela_whatsapp').focus();

                        const parts = url.split('/');
                        const id = parts[parts.indexOf('encomendas') + 1];
                        const statusBadge = document.getElementById('status-badge-' + id);

                        if (statusBadge) {
                            // 1. Atualiza o texto mantendo a caixa alta
                            statusBadge.innerText = 'NOTIFICADO';

                            // 2. Remove as classes de "Pendente" (Amarelo)
                            statusBadge.classList.remove('bg-amber-50', 'border-amber-200', 'text-amber-700');

                            // 3. Adiciona as classes de "Notificado" (Azul) para manter o balão
                            statusBadge.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-700');

                            // 4. Muda a cor do botão que foi clicado para azul também
                            botao.classList.remove('bg-slate-700');
                            botao.classList.add('bg-indigo-600');
                        }
                    }
                    botao.innerHTML = originalHTML;
                    botao.disabled = false;
                })
                .catch(error => {
                    console.error('Erro:', error);
                    botao.innerHTML = originalHTML;
                    botao.disabled = false;
                });
        }
    </script>
</x-app-layout>