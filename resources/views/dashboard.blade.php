<x-app-layout>
    <div class="mb-8 flex flex-col md:flex-row justify-between items-end gap-4">
        <div>
            <h3 class="text-3xl font-bold text-gray-800">Dashboard Overview</h3>
            <p class="text-gray-500">
                Selamat datang kembali,
                <span class="font-semibold text-indigo-600">{{ Auth::user()->name }}</span>.
            </p>
        </div>
        <div class="text-sm text-gray-400">
            {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
        </div>
    </div>

    {{-- Card Notifikasi Perawatan --}}
    @if(isset($listPerluServis) && $listPerluServis->count() > 0)
        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-8 rounded-r-xl shadow-sm animate-pulse-slow">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002
                                 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159
                                 c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-lg font-bold text-yellow-800">
                        Peringatan Jadwal Perawatan ({{ $listPerluServis->count() }} Aset)
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        <p class="mb-2 font-medium">Aset berikut mendekati jadwal servis (Kurang dari 7 Hari):</p>
                        <ul class="list-disc list-inside space-y-1 bg-white/50 p-3 rounded-lg">
                            @foreach($listPerluServis->take(5) as $item)
                                <li>
                                    <span class="font-bold text-gray-800">{{ $item->nama }}</span>
                                    <span class="text-gray-500">({{ $item->lokasi }})</span> -
                                    <span class="text-red-600 font-semibold">
                                        Jadwal: {{ \Carbon\Carbon::parse($item->tanggal_servis_selanjutnya)->format('d M Y') }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                        @if($listPerluServis->count() > 5)
                            <p class="mt-2 text-xs font-semibold hover:underline cursor-pointer">
                                ...dan {{ $listPerluServis->count() - 5 }} aset lainnya.
                            </p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- Card Kolom --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Alat --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow duration-300">
            <div class="p-4 rounded-xl bg-indigo-50 text-indigo-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Total Alat</p>
                <h4 class="text-3xl font-bold text-gray-800">{{ $totalBarang }}</h4>
            </div>
        </div>

        {{-- Perlu Servis --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow duration-300">
            <div class="p-4 rounded-xl bg-orange-50 text-orange-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Perlu Servis (7 Hari)</p>
                <h4 class="text-3xl font-bold text-gray-800">{{ $perluServis }}</h4>
            </div>
        </div>

        {{-- Kondisi Rusak --}}
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center hover:shadow-md transition-shadow duration-300">
            <div class="p-4 rounded-xl bg-red-50 text-red-600 mr-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732
                             4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <p class="text-gray-500 text-sm font-medium">Kondisi Rusak</p>
                <h4 class="text-3xl font-bold text-gray-800">{{ $barangRusak }}</h4>
            </div>
        </div>
    </div>

    {{-- Infografis --}}
    <div class="bg-white rounded-2xl p-4 shadow-sm border mb-10">
        <!-- Tabs -->
        <div class="flex gap-6 border-b mb-4">
            <button class="tab-btn active-tab" onclick="showChart('kondisi', this)">Kondisi Aset</button>
            <button class="tab-btn" onclick="showChart('servis', this)">Servis Bulanan</button>
            <button class="tab-btn" onclick="showChart('jenis', this)">Aset per Jenis</button>
        </div>

        <!-- Charts -->
        <div id="chart-kondisi" class="chart-content">
            <div class="relative h-56">
                <canvas id="kondisiChart"></canvas>
            </div>
        </div>

        <div id="chart-servis" class="chart-content hidden">
            <div class="relative h-56">
                <canvas id="servisChart"></canvas>
            </div>
        </div>

        <div id="chart-jenis" class="chart-content hidden">
            <div class="relative h-56">
                <canvas id="jenisAsetChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat Perawatan --}}
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 mb-10">
        <div class="flex flex-col md:flex-row justify-between items-center mb-4 gap-4">
            <h3 class="text-2xl font-bold text-gray-800">Riwayat Perawatan</h3>
            <input type="text" id="live-search-history" placeholder="Cari kode, NUP, nama, solusi, masalah, nomor seri..." class="flex-1 md:flex-auto px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider text-left">
                    <tr>
                        <th class="px-6 py-3">Kode Aset</th>
                        <th class="px-6 py-3">NUP</th>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Nomor Seri</th>
                        <th class="px-6 py-3">Merek</th>
                        <th class="px-6 py-3">Solusi</th>
                        <th class="px-6 py-3">Teknisi</th>
                        <th class="px-6 py-3">Tanggal Servis</th>
                        <th class="px-6 py-3">Masalah</th>
                    </tr>
                </thead>
                <tbody id="history-table-body" class="divide-y divide-gray-100">
                    @foreach($riwayatServis as $riwayat)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">{{ $riwayat->item->kode_barang }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->item->nup }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->item->nama }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->item->nomor_seri }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->item->merek }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->deskripsi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->teknisi }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ \Carbon\Carbon::parse($riwayat->tanggal_perawatan)->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $riwayat->masalah }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4" id="pagination-links">
            {{ $riwayatServis->links() }}
        </div>
    </div>

    {{-- Styles --}}
    <style>
        .tab-btn {
            padding-bottom: .5rem;
            font-weight: 600;
            color: #6B7280;
            border-bottom: 3px solid transparent;
        }
        .active-tab {
            color: #4F46E5;
            border-bottom-color: #4F46E5;
        }
        .chart-content { animation: fadeIn .25s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(4px); } to { opacity: 1; transform: translateY(0); } }
    </style>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function showChart(type, btn) {
            document.querySelectorAll('.chart-content').forEach(c => c.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(t => t.classList.remove('active-tab'));
            document.getElementById('chart-' + type).classList.remove('hidden');
            btn.classList.add('active-tab');
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Kondisi Alat Chart
            const kondisiData = {!! json_encode($kondisiData) !!};
            const kondisiLabels = ['Baik', 'Rusak Ringan', 'Rusak Berat'];
            const kondisiValues = kondisiLabels.map(l => kondisiData[l] ?? 0);

            new Chart(document.getElementById('kondisiChart'), {
                type: 'doughnut',
                data: {
                    labels: kondisiLabels,
                    datasets: [{ data: kondisiValues, backgroundColor: ['#10B981','#FACC15','#EF4444'] }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });

            // Servis Bulanan Chart
            new Chart(document.getElementById('servisChart'), {
                type: 'bar',
                data: {
                    labels: {!! json_encode($servisBulanan->keys()) !!},
                    datasets: [{ label: 'Jumlah Servis', data: {!! json_encode($servisBulanan->values()) !!}, backgroundColor: '#D97706' }]
                },
                options: { responsive: true, maintainAspectRatio: false, scales: { y: { beginAtZero: true } } }
            });

            // Aset per Jenis Chart
            new Chart(document.getElementById('jenisAsetChart'), {
                type: 'pie',
                data: {
                    labels: {!! json_encode($asetByJenis->keys()) !!},
                    datasets: [{
                        data: {!! json_encode($asetByJenis->values()) !!},
                        backgroundColor: ['#EF4444','#F87171','#DC2626','#FBBF24','#FACC15','#D97706','#10B981','#34D399','#059669','#3B82F6','#60A5FA','#1D4ED8','#8B5CF6','#A78BFA','#6D28D9','#EC4899','#F472B6','#DB2777','#14B8A6','#22D3EE','#0EA5E9','#FCD34D','#F59E0B','#84CC16','#22C55E']
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('live-search-history');
    const tableBody = document.getElementById('history-table-body');
    const rows = Array.from(tableBody.getElementsByTagName('tr'));

    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
});
</script>
</x-app-layout>
