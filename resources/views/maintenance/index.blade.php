<x-app-layout>
    <div class="mb-6">
        <a href="{{ route('items.index') }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Kembali ke Data Aset
        </a>
    </div>

<!-- Modal -->
<div id="problemModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
    <div class="bg-white rounded-2xl w-full max-w-lg p-6 relative">
        <button id="closeModalButton" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
            ✖
        </button>
        <h2 class="text-xl font-bold mb-4">Laporkan Alat Bermasalah</h2>

        <form action="{{ route('alat-bermasalah.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <label class="block mb-2 font-semibold">Tanggal Laporan</label>
            <input type="date" name="tanggal_laporan" class="w-full border border-gray-300 rounded-xl px-3 py-2 mb-4" required value="{{ date('Y-m-d') }}">

            <!-- Masalah / Deskripsi -->
            <label class="block mb-2 font-semibold">Masalah Alat</label>
            <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded-xl px-3 py-2 mb-4" placeholder="Jelaskan masalah alat"></textarea>

            <div class="flex justify-end gap-2">
                <button type="button" id="cancelModal" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-xl hover:bg-gray-300">Batal</button>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded-xl hover:bg-red-700">Laporkan</button>
            </div>
        </form>
    </div>
</div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-1 space-y-6">

            <div class="bg-white p-6 rounded shadow-md border-l-4 border-indigo-500">
                <h3 class="text-lg font-bold text-gray-700 mb-2">{{ $item->nama }}</h3>
                <p class="text-sm text-gray-500">Kode: <span class="font-mono text-gray-700">{{ $item->kode_barang }}</span></p>
                <p class="text-sm text-gray-500">NUP: <span class="font-mono text-gray-700">{{ $item->nup }}</span></p>

                <div class="mt-4 pt-4 border-t">
                    <p class="text-sm">Jadwal Servis Selanjutnya:</p>
                    <p class="text-xl font-bold {{ \Carbon\Carbon::parse($item->tanggal_servis_selanjutnya)->isPast() ? 'text-red-600' : 'text-green-600' }}">
                        {{ \Carbon\Carbon::parse($item->tanggal_servis_selanjutnya)->format('d M Y') }}
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow-md">
                <h4 class="text-lg font-bold text-gray-700 mb-4">Tambah Riwayat Perawatan</h4>

                @if(session('success'))
                    <div class="mb-4 bg-green-100 border text-green-700 px-4 py-2 rounded text-sm">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('maintenance.store', $item->id) }}" method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tanggal Perawatan</label>
                            <input type="date" name="tanggal_perawatan" class="mt-1 block w-full border rounded-md shadow-sm p-2" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Teknisi</label>
                            <input type="text" name="teknisi" class="mt-1 block w-full border rounded-md shadow-sm p-2" placeholder="Nama Teknisi">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Deskripsi Pengerjaan</label>
                            <textarea name="deskripsi" rows="3" class="mt-1 block w-full border rounded-md shadow-sm p-2" placeholder="Cth: Pembersihan filter, ganti freon..."></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Masalah</label>
                            <input type="text" name="masalah" class="mt-1 block w-full border rounded-md shadow-sm p-2" placeholder="Cth: Rusak, Bocor, Tidak dingin...">
                        </div>
                        <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-2 px-4 rounded hover:bg-indigo-700">
                            Simpan Riwayat
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white shadow-md rounded overflow-hidden">
                <div class="px-6 py-4 border-b">
                    <h3 class="font-bold text-gray-700">Riwayat Perawatan</h3>
                </div>
                <table class="min-w-full w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teknisi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Masalah</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($records as $record)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($record->tanggal_perawatan)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-700">
                                {{ $record->deskripsi }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $record->teknisi ?? '-' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                {{ $record->masalah ?? 'Baik' }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                Belum ada riwayat perawatan untuk alat ini.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>

    <script>
    const modal = document.getElementById('problemModal');
    const openButton = document.getElementById('openModalButton');
    const closeButton = document.getElementById('closeModalButton');
    const cancelButton = document.getElementById('cancelModal');

    openButton.addEventListener('click', () => modal.classList.remove('hidden'));
    closeButton.addEventListener('click', () => modal.classList.add('hidden'));
    cancelButton.addEventListener('click', () => modal.classList.add('hidden'));
</script>
</x-app-layout>
