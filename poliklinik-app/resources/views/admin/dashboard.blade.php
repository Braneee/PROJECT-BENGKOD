<x-layouts.app title="Admin Dashboard">
    <div class="space-y-6">
        {{-- Welcome Header --}}
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Dashboard Admin</h1>
            </div>
        </div>
        {{-- Statistics Row --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
            {{-- Obat --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-2xl">
                    <i class="fas fa-pills"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ $totalObat }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Obat Tersedia</p>
                </div>
            </div>
            
            {{-- Poli --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-emerald-50 text-emerald-500 flex items-center justify-center text-2xl">
                    <i class="fas fa-clinic-medical"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ count($polis) }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Total Poli</p>
                </div>
            </div>

            {{-- Dokter --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center text-2xl">
                    <i class="fas fa-user-md"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ count($dokters) }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Total Dokter</p>
                </div>
            </div>
            
             {{-- Pasien Diperiksa --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex items-center gap-4 hover:shadow-md transition">
                <div class="w-14 h-14 rounded-full bg-amber-50 text-amber-500 flex items-center justify-center text-2xl">
                    <i class="fas fa-users"></i>
                </div>
                <div>
                    <h3 class="text-3xl font-bold text-slate-800">{{ $riwayatPasien->where('status', 'Sudah Diperiksa')->count() }}</h3>
                    <p class="text-slate-500 font-medium text-sm">Pasien Diperiksa</p>
                </div>
            </div>
        </div>

        {{-- Chart and Poli Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Chart --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 lg:col-span-2">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Grafik Kunjungan (7 Hari Terakhir)</h3>
                <div class="relative h-[300px] w-full">
                    <canvas id="poliChart"></canvas>
                </div>
            </div>

            {{-- Poli List --}}
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h3 class="text-lg font-bold text-slate-800 mb-6">Daftar Poli</h3>
                <div class="space-y-4 max-h-[300px] overflow-y-auto pr-2">
                    @forelse($polis as $poli)
                    <div class="flex items-center justify-between p-3 bg-slate-50 rounded-xl border border-slate-100">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center">
                                <i class="fas fa-door-open"></i>
                            </div>
                            <div>
                                <p class="font-bold text-slate-700">{{ $poli->nama_poli }}</p>
                                <p class="text-xs text-slate-500 line-clamp-1">{{ $poli->keterangan }}</p>
                            </div>
                        </div>
                        <span class="px-3 py-1 bg-white border border-slate-200 text-slate-600 font-bold text-xs rounded-full">
                            {{ $poli->dokters_count }} Dokter
                        </span>
                    </div>
                    @empty
                    <div class="text-center text-slate-400 py-4">Belum ada data poli.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Tables Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Dokter List --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                <div class="p-6 border-b border-slate-100">
                    <h3 class="text-lg font-bold text-slate-800">List Dokter</h3>
                </div>
                <div class="overflow-x-auto max-h-[400px]">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-100 text-sm text-slate-500">
                                <th class="p-4 font-semibold">Nama Dokter</th>
                                <th class="p-4 font-semibold">Poli</th>
                                <th class="p-4 font-semibold">No. HP</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($dokters as $dokter)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4 font-medium text-slate-700">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center">
                                            <i class="fas fa-user-md text-xs"></i>
                                        </div>
                                        {{ $dokter->nama }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="px-2 py-1 bg-emerald-50 text-emerald-600 rounded-md text-xs font-semibold">
                                        {{ $dokter->poli->nama_poli ?? '-' }}
                                    </span>
                                </td>
                                <td class="p-4 text-slate-600">{{ $dokter->no_hp }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-slate-400">Belum ada dokter.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Riwayat Pasien List --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden flex flex-col">
                <div class="p-6 border-b border-slate-100 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-slate-800">Riwayat Antrian Pasien</h3>
                    <span class="text-xs text-slate-400">10 data terbaru</span>
                </div>
                <div class="overflow-x-auto max-h-[400px] overflow-y-auto">
                    <table class="w-full text-left border-collapse min-w-max">
                        <thead class="sticky top-0 bg-slate-50 z-10 shadow-sm">
                            <tr class="border-b border-slate-100 text-sm text-slate-500">
                                <th class="p-4 font-semibold">Pasien</th>
                                <th class="p-4 font-semibold">Poli & Dokter</th>
                                <th class="p-4 font-semibold">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @forelse($riwayatPasien as $riwayat)
                            <tr class="hover:bg-slate-50/50 transition">
                                <td class="p-4">
                                    <p class="font-bold text-slate-700">{{ $riwayat->pasien->nama ?? 'Unknown' }}</p>
                                    <p class="text-xs text-slate-500">No RM: {{ $riwayat->pasien->no_rm ?? '-' }}</p>
                                </td>
                                <td class="p-4">
                                    <p class="text-slate-700">{{ $riwayat->jadwalPeriksa->dokter->poli->nama_poli ?? '-' }}</p>
                                    <p class="text-xs text-slate-500">Dr. {{ $riwayat->jadwalPeriksa->dokter->nama ?? '-' }}</p>
                                </td>
                                <td class="p-4">
                                    @if($riwayat->status == 'Sudah Diperiksa')
                                        <span class="px-3 py-1 bg-emerald-50 text-emerald-600 border border-emerald-200 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> Sudah Diperiksa
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-rose-50 text-rose-600 border border-rose-200 rounded-full text-xs font-bold inline-flex items-center gap-1">
                                            <i class="fas fa-clock"></i> Belum Diperiksa
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="p-4 text-center text-slate-400">Belum ada riwayat pasien.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Script for Chart.js --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartData = @json($chartData);
            
            const ctx = document.getElementById('poliChart').getContext('2d');
            
            // Create gradient
            const gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(59, 130, 246, 0.5)'); // Blue-500
            gradient.addColorStop(1, 'rgba(59, 130, 246, 0.05)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartData.labels,
                    datasets: [{
                        label: 'Kunjungan',
                        data: chartData.data,
                        backgroundColor: gradient,
                        borderColor: '#3b82f6', // blue-500
                        borderWidth: 2,
                        borderRadius: 8,
                        hoverBackgroundColor: '#2563eb', // blue-600
                        barThickness: 40
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#1e293b',
                            padding: 12,
                            titleFont: { size: 14, family: "'Inter', sans-serif" },
                            bodyFont: { size: 14, family: "'Inter', sans-serif" },
                            callbacks: {
                                label: function(context) {
                                    return context.raw + ' Pasien';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1,
                                precision: 0,
                                font: { family: "'Inter', sans-serif" }
                            },
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: { family: "'Inter', sans-serif" }
                            }
                        }
                    }
                }
            });
        });
    </script>
    @endpush
</x-layouts.app>