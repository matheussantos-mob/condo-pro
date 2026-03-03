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
            <div class="flex items-center">
                <span class="bg-indigo-600 text-white px-4 py-1.5 rounded-full text-xs font-bold shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 bg-white rounded-full animate-pulse"></span>
                    Estoque Atual: {{ count($encomendas->where('status', '!=', 'entregue')) }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-4 md:py-8 bg-slate-100 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session('status'))
            <div id="success-message" class="mb-6 p-4 bg-white border-l-4 border-emerald-500 shadow-md rounded-md flex justify-between items-center transition-opacity duration-500">
                <div class="flex items-center gap-3 font-semibold text-slate-700 text-sm">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    {{ session('status') }}
                </div>
            </div>
            @endif

            <div class="bg-white rounded-xl shadow-md border border-slate-200 p-5 md:p-6 mb-6">
                <h3 class="text-sm font-bold text-slate-800 mb-5 flex items-center gap-2 uppercase tracking-wider">
                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>
                    Nova Entrada
                </h3>

                <form action="{{ route('encomendas.store') }}" method="POST">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Unidade / Bloco</label>
                            <select id="select-apto" name="apartamento_id" required>
                                <option value="">Selecione...</option>
                                @foreach($apartamentos as $apto)
                                <option value="{{ $apto->id }}">Apto {{ $apto->numero }} - Bloco {{ $apto->bloco }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Descrição</label>
                            <input type="text" name="descricao" placeholder="Ex: Pacote Amazon" class="w-full border-slate-300 rounded-lg py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1 ml-1">Local / Setor</label>
                            <input type="text" name="setor_estoque" placeholder="Ex: Prateleira A" class="w-full border-slate-300 rounded-lg py-2 text-sm focus:ring-indigo-500 focus:border-indigo-500 shadow-sm" required>
                        </div>
                        <div class="flex items-end">
                            <button type="submit" class="w-full py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-lg transition-all shadow-md text-sm uppercase">
                                Registrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-md border border-slate-200 overflow-hidden">
                <div class="p-4 md:p-6">
                    <div class="overflow-x-auto">
                        <table id="tabela-encomendas" class="w-full text-left border-collapse" style="min-width: 900px;">
                            <thead>
                                <tr class="bg-slate-50 border-b border-slate-200">
                                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase">Unidade</th>
                                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase">Descrição</th>
                                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase">Setor</th>
                                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase">Notificar</th>
                                    <th class="px-4 py-4 text-xs font-bold text-slate-500 uppercase">Status</th>
                                    <th class="px-4 py-4 text-center text-xs font-bold text-slate-500 uppercase">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                @foreach($encomendas as $encomenda)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-4 py-4">
                                        <span class="text-sm font-bold text-slate-900">Apto {{ $encomenda->apartamento?->numero }}</span>
                                        <div class="text-[10px] text-slate-400 font-bold uppercase">Bl {{ $encomenda->apartamento?->bloco }}</div>
                                    </td>
                                    <td class="px-4 py-4 text-sm text-slate-600 font-medium">{{ $encomenda->descricao }}</td>
                                    <td class="px-4 py-4">
                                        <span class="text-[10px] font-black text-indigo-700 bg-indigo-50 px-2 py-1 rounded border border-indigo-100 uppercase">{{ $encomenda->setor_estoque }}</span>
                                    </td>
                                    <td class="px-4 py-4">
                                        <div class="flex flex-wrap gap-2">
                                            @if($encomenda->status !== 'entregue')
                                            @foreach($encomenda->apartamento->moradores as $morador)
                                            <button type="button"
                                                onclick="notificarMorador(this, '{{ route('encomendas.notificar', [$encomenda->id, $morador->id]) }}')"
                                                title="Enviar WhatsApp para {{ $morador->nome }}"
                                                class="btn-notificar px-3 py-1 rounded-full text-xs font-semibold transition-all border {{ $encomenda->status === 'notificado' ? 'bg-indigo-100 text-indigo-700 border-indigo-300' : 'bg-slate-100 text-slate-600 border-slate-300 hover:bg-slate-200' }}">
                                                {{ $morador->nome }}
                                            </button>
                                            @endforeach
                                            @else
                                            <span class="text-[10px] text-green-600 font-bold uppercase italic border border-green-200 bg-green-50 px-2 py-1 rounded">
                                                Entregue
                                            </span>
                                            @endif
                                        </div>
                                    </td>
                                   
                                    <td class="px-4 py-4">
                                        <span id="status-badge-{{ $encomenda->id }}" class="text-[10px] font-bold uppercase px-2 py-1 rounded border {{ $encomenda->status === 'pendente' ? 'bg-amber-50 border-amber-200 text-amber-700' : ($encomenda->status === 'notificado' ? 'bg-blue-50 border-blue-200 text-blue-700' : 'bg-emerald-50 border-emerald-200 text-emerald-700') }}">
                                            {{ $encomenda->status }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-4">
                                        @if($encomenda->status !== 'entregue')
                                        <form action="{{ route('encomendas.entregar', $encomenda->id) }}" method="POST" class="flex gap-2 items-center justify-end">
                                            @csrf
                                            <input type="text" name="codigo_digitado" maxlength="5" placeholder="CÓD"
                                                class="w-16 border-slate-300 rounded-md text-xs font-bold py-1.5 px-1 text-center focus:ring-indigo-500 uppercase">

                                            <input type="text" name="quem_retirou" placeholder="QUEM?"
                                                class="w-24 border-slate-300 rounded-md text-xs font-bold py-1.5 px-2 focus:ring-indigo-500 uppercase">

                                            <button type="submit" class="bg-indigo-600 text-white p-1.5 rounded-md hover:bg-black transition flex-shrink-0">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                </svg>
                                            </button>
                                        </form>
                                        @else
                                        <div class="text-[11px] text-right text-emerald-600 font-bold uppercase leading-tight">
                                            Retirado por:<br>{{ $encomenda->retirado_por }}
                                            <div class="text-[9px] text-slate-400 mt-1 lowercase">
                                                Entregue por: {{ $encomenda->entreguePor?->name ?? 'Sistema' }}
                                            </div>
                                        </div>
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

    {{-- Scripts e Styles --}}
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <style>
        .ts-control {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.5rem !important;
            font-size: 0.875rem !important;
        }

        .dataTables_filter {
            margin-bottom: 1.5rem;
            float: right;
        }

        .dataTables_filter input {
            border: 1px solid #cbd5e1 !important;
            border-radius: 0.5rem !important;
            padding: 0.4rem 0.8rem !important;
            font-size: 0.875rem !important;
            outline: none;
            margin-left: 10px;
        }

        .dataTables_paginate {
            display: flex !important;
            justify-content: flex-end !important;
            gap: 5px;
            padding: 1rem;
        }

        .paginate_button {
            padding: 0.3rem 0.6rem !important;
            border-radius: 0.3rem !important;
            border: 1px solid #e2e8f0 !important;
            font-size: 0.7rem !important;
            font-weight: 700 !important;
            cursor: pointer;
            color: #475569 !important;
            background: white !important;
        }

        .paginate_button.current {
            background: #4f46e5 !important;
            color: white !important;
        }

        .dataTables_info {
            font-size: 0.75rem;
            color: #64748b;
            padding-top: 1rem;
        }

        #tabela-encomendas td:last-child {
            min-width: 230px;
        }

        .overflow-x-auto {
            overflow-x: auto !important;
        }

        #tabela-encomendas {
            width: 100% !important;
            min-width: 1000px;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            new TomSelect("#select-apto", {
                placeholder: "Apto ou Bloco..."
            });

            $('#tabela-encomendas').DataTable({
                "pageLength": 10,
                "dom": '<"top"f>rt<"bottom"ip><"clear">',
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.6/i18n/pt-BR.json",
                    "search": "BUSCAR:"
                },
                "order": [
                    [4, "asc"]
                ],
                "responsive": false,
                "autoWidth": false
            });

            const successMsg = document.getElementById('success-message');
            if (successMsg) {
                setTimeout(() => {
                    successMsg.style.opacity = '0';
                    setTimeout(() => successMsg.remove(), 500);
                }, 4000);
            }
        });

        function notificarMorador(botao, url) {
            const originalHTML = botao.innerHTML;
            botao.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>';
            botao.disabled = true;

            fetch(url, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        window.open(data.url, 'janela_whatsapp').focus();
                        const id = url.split('/').slice(-2)[0];
                        const badge = document.getElementById('status-badge-' + id);
                        if (badge) {
                            badge.innerText = 'NOTIFICADO';
                            badge.classList.remove('bg-amber-50', 'border-amber-200', 'text-amber-700');
                            badge.classList.add('bg-blue-50', 'border-blue-200', 'text-blue-700');
                        }
                        botao.classList.replace('bg-slate-700', 'bg-indigo-600');
                    }
                    botao.innerHTML = originalHTML;
                    botao.disabled = false;
                })
                .catch(() => {
                    botao.innerHTML = originalHTML;
                    botao.disabled = false;
                });
        }
    </script>
</x-app-layout>