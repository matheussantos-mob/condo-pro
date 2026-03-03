<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrativo') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-indigo-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Estoque Atual</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $estoqueAtual }}</h3>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg text-indigo-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Notificados</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $aguardandoRetirada }}</h3>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg text-blue-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Entradas Hoje</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $entradasHoje }}</h3>
                </div>
                <div class="p-3 bg-green-50 rounded-lg text-green-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border-b-4 border-red-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-500 font-medium uppercase tracking-wider italic">Esquecidos (+3d)</p>
                    <h3 class="text-3xl font-bold text-red-600">{{ $esquecidos }}</h3>
                </div>
                <div class="p-3 bg-red-50 rounded-lg text-red-500">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'sindico')
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                <h3 class="text-lg font-bold text-gray-700">Equipe da Portaria / Sistema</h3>
                <button onclick="document.getElementById('modalGestaoAcesso').classList.remove('hidden')"
                    class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-full shadow-lg shadow-indigo-200 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg>
                    Gerenciar Equipe
                </button>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 text-[10px] uppercase text-gray-400 font-bold">
                        <tr>
                            <th class="px-6 py-3">Nome / Email</th>
                            <th class="px-6 py-3">Função</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($usuarios as $usuario)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-900">{{ $usuario->name }}</div>
                                <div class="text-xs text-gray-500">{{ $usuario->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2 py-1 {{ $usuario->role === 'admin' ? 'bg-red-100 text-red-700' : ($usuario->role === 'sindico' ? 'bg-blue-100 text-blue-700' : 'bg-green-100 text-green-700') }} rounded text-[10px] font-bold uppercase">
                                    {{ $usuario->role }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col">
            <div class="p-6 border-b border-gray-100 bg-gray-50/30">
                <h3 class="text-lg font-bold text-gray-700">Resumo de Atividades (Últimos 30 dias)</h3>
            </div>
            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead class="bg-gray-50/50 text-[10px] uppercase text-gray-400 font-bold">
                        <tr>
                            <th class="px-6 py-3">Porteiro</th>
                            <th class="px-6 py-3 text-center">Cadastros</th>
                            <th class="px-6 py-3 text-center">Notific.</th>
                            <th class="px-6 py-3 text-center">Entregues</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($resumoAtividades as $atividade)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-bold text-gray-800">{{ $atividade['name'] }}</div>
                            </td>
                            <td class="px-6 py-4 text-center font-bold text-indigo-600 text-sm">{{ $atividade['cadastrados'] }}</td>
                            <td class="px-6 py-4 text-center font-bold text-blue-600 text-sm">{{ $atividade['notificados'] }}</td>
                            <td class="px-6 py-4 text-center font-bold text-green-600 text-sm">{{ $atividade['entregues'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center">
            <h3 class="text-lg font-bold text-gray-700 mb-4 self-start">Status das Encomendas</h3>
            <div class="w-full h-[250px] relative">
                <canvas id="encomendasChart"></canvas>
            </div>
        </div>

        <div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border border-gray-100">
            <h3 class="text-lg font-bold text-gray-700 mb-6">Infraestrutura do Condomínio</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-3 bg-white rounded-full shadow-sm text-indigo-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-tighter">Total de Unidades</p>
                        <h4 class="text-2xl font-black">{{ $totalUnidades }}</h4>
                    </div>
                </div>
                <div class="flex items-center p-4 bg-gray-50 rounded-lg">
                    <div class="p-3 bg-white rounded-full shadow-sm text-green-600 mr-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500 uppercase font-bold tracking-tighter">Moradores Ativos</p>
                        <h4 class="text-2xl font-black">{{ $totalMoradores }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('encomendasChart').getContext('2d');
            
            const pendentes = {{ $dataChart['pendentes'] ?? 0 }};
            const notificados = {{ $dataChart['notificados'] ?? 0 }};
            const entregues = {{ $dataChart['entregues'] ?? 0 }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pendentes', 'Notificados', 'Entregues'],
                    datasets: [{
                        data: [pendentes, notificados, entregues],
                        backgroundColor: ['#fbbf24', '#3b82f6', '#10b981'],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    cutout: '75%',
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                font: { size: 12, weight: 'bold' },
                                usePointStyle: true
                            }
                        }
                    }
                }
            });
        });
    </script>

    @include('dashboard.partials.modal-gestao')
</x-app-layout>