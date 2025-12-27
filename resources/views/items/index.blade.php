<x-app-layout>
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 flex-wrap">
        <div>
            <h3 class="text-3xl font-bold text-gray-800">Daftar Inventaris</h3>
            <p class="text-gray-500 mt-1">Kelola seluruh aset dan jadwal perawatan di sini.</p>
        </div>

        <div class="flex gap-2 mt-4 md:mt-0">
            <a href="{{ route('items.create') }}"
                class="mt-4 md:mt-0 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-1 px-2 rounded-xl shadow-lg shadow-indigo-190 transition transform hover:-translate-y-1">
                + Tambah Aset Baru
            </a>
            <a href="#" id="importButton"
                class="mt-4 md:mt-0 bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-2 rounded-xl shadow-lg shadow-green-190 transition transform hover:-translate-y-1">
                Import
            </a>
            <a href="{{ asset('template_import.xlsx') }}" download
                class="mt-4 md:mt-0 bg-red-600 hover:bg-orange-600 text-white font-semibold py-1 px-2 rounded-xl shadow-lg shadow-orange-200 transition transform hover:-translate-y-1">
                Download Template
            </a>


        </div>

        <form id="importForm" action="{{ route('items.import') }}" method="POST" enctype="multipart/form-data" style="display:none;">
            @csrf
            <input type="file" name="file" id="importFile" accept=".xlsx,.csv">
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r shadow-sm animate-fade-in-down">
            <p class="font-medium">Berhasil!</p>
            <p class="text-sm">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="flex items-center gap-2 text-gray-600 font-semibold flex-shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                <span class="font-semibold text-sm uppercase tracking-wider">Filter Data</span>
            </div>

            <input type="text" name="search" id="live-search" value="{{ request('search') }}"
                placeholder="Cari kode, NUP, nama, lokasi, kondisi..."
                class="flex-1 w-full px-4 py-2 text-sm border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400">

            <a id="export-link" href="{{ route('items.export', request()->query()) }}"
                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg text-green-700 bg-green-100 hover:bg-green-200">
                Export Excel
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full whitespace-nowrap">
                <thead class="bg-gray-50 text-gray-500 text-xs font-semibold uppercase tracking-wider text-left">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Aset Info</th>
                        <th class="px-6 py-4">Lokasi</th>
                        <th class="px-6 py-4 text-center">Kondisi</th>
                        <th class="px-6 py-4">Jadwal Servis</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody id="items-table-body" class="divide-y divide-gray-100">
                    @foreach($items as $item)
                        <tr class="hover:bg-gray-50 transition duration-150">
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $loop->iteration + ($items->currentPage() - 1) * $items->perPage() }}
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="h-10 w-10 flex-shrink-0 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-600 font-bold">
                                        {{ substr($item->nama, 0, 1) }}
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-bold text-gray-900">{{ $item->nama }}</div>
                                        <div class="text-xs text-gray-500">{{ $item->kode_barang }} <span class="mx-1">•</span> {{ $item->nup }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->lokasi }}</td>
                            <td class="px-6 py-4 text-center">
                                @php
                                    $badgeClass = match($item->kondisi) {
                                        'Baik' => 'bg-green-100 text-green-800 border-green-200',
                                        'Rusak Ringan' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                        'Rusak Berat' => 'bg-red-100 text-red-800 border-red-200',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border {{ $badgeClass }}">
                                    {{ $item->kondisi }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-900 font-medium">
                                    {{ \Carbon\Carbon::parse($item->tanggal_servis_selanjutnya)->format('d M Y') }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    Interval: {{ $item->interval_servis }} Bulan
                                </div>
                            </td>
                            <td class="px-6 py-4 text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <a href="{{ route('maintenance.index', $item->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition" title="Riwayat">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </a>
                                    <a href="{{ route('items.edit', $item->id) }}" class="p-2 bg-yellow-50 text-yellow-600 rounded-lg hover:bg-yellow-100 transition" title="Edit">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <form action="{{ route('items.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6" />
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

        <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
            {{ $items->links() }}
        </div>
    </div>

    <script>
        const searchInput = document.getElementById('live-search');
        const exportLink = document.getElementById('export-link');
        const importButton = document.getElementById('importButton');
        const importFile = document.getElementById('importFile');
        const importForm = document.getElementById('importForm');
        let timer = null;

        searchInput.addEventListener('keyup', function () {
            clearTimeout(timer);
            timer = setTimeout(() => {
                const query = encodeURIComponent(this.value);
                exportLink.href = "{{ route('items.export') }}?search=" + query;

                fetch("{{ route('items.index') }}?search=" + query, {
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(response => response.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newTbody = doc.getElementById('items-table-body');
                    const newPagination = doc.getElementById('pagination');
                    if(newTbody) document.getElementById('items-table-body').innerHTML = newTbody.innerHTML;
                    if(newPagination) document.getElementById('pagination').innerHTML = newPagination.innerHTML;
                });
            }, 300);
        });

        importButton.addEventListener('click', function(e) {
            e.preventDefault();
            importFile.click();
        });

        importFile.addEventListener('change', function() {
            importForm.submit();
        });
    </script>
</x-app-layout>
