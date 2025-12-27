<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow-md mt-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Data Aset</h2>

        <form action="{{ route('items.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kode Barang</label>
                    <input type="text" name="kode_barang"
                           value="{{ old('kode_barang', $item->kode_barang) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @error('kode_barang')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">NUP</label>
                    <input type="text" name="nup"
                           value="{{ old('nup', $item->nup) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    @error('nup')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Nama Aset</label>
                    <input type="text" name="nama"
                           value="{{ old('nama', $item->nama) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Merek</label>
                    <input type="text" name="merek"
                           value="{{ old('merek', $item->merek) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-gray-700 font-medium mb-1">Nomor Seri</label>
                    <input type="text" name="nomor_seri"
                        value="{{ old('nomor_seri', $item->nomor_seri) }}"
                        class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        required>
                    @error('nomor_seri')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi"
                           value="{{ old('lokasi', $item->lokasi) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Kondisi</label>
                    <select name="kondisi" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="Baik" {{ old('kondisi', $item->kondisi) == 'Baik' ? 'selected' : '' }}>Baik</option>
                        <option value="Rusak Ringan" {{ old('kondisi', $item->kondisi) == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                        <option value="Rusak Berat" {{ old('kondisi', $item->kondisi) == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                    </select>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Tanggal Servis Terakhir</label>
                    <input type="date" name="tanggal_servis_terakhir"
                           value="{{ old
                           ('tanggal_servis_terakhir',
                           optional ($item->tanggal_servis_terakhir)->format('Y-m-d')
                        ) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                    <p class="text-xs text-gray-500 mt-1">*Mengubah ini akan menghitung ulang jadwal servis selanjutnya.</p>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Interval Servis (Bulan)</label>
                    <input type="number" name="interval_servis"
                           value="{{ old('interval_servis', $item->interval_servis) }}"
                           class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                </div>
            </div>

            <div class="mt-8 flex justify-end items-center gap-4">
                <a href="{{ route('items.index') }}" class="font-bold text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-600 transition duration-200">
                    Batal
                </a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded transition duration-150 shadow-lg">
                    Update Aset
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
