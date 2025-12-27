<x-app-layout>
    <div class="max-w-4xl mx-auto bg-white p-8 rounded shadow-md">
        <h2 class="text-2xl font-bold mb-6">Tambah Aset Baru</h2>

        <form action="{{ route('items.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700">Kode Aset</label>
                    <input type="text" name="kode_barang" id="kode_barang" class="w-full border rounded px-3 py-2" placeholder="******" required>
                </div>
                <div>
                    <label class="block text-gray-700">NUP</label>
                    <input type="text" name="nup" class="w-full border rounded px-3 py-2" placeholder="**" required>
                </div>
                <div>
                    <label class="block text-gray-700">Nama Aset</label>
                    <input type="text" name="nama" id="nama_barang" class="w-full border rounded px-3 py-2" placeholder="Lap Top" required>
                </div>
                <div>
                    <label class="block text-gray-700">Merek</label>
                    <input type="text" name="merek" class="w-full border rounded px-3 py-2" placeholder="Dell / HP / Asus" required>
                </div>
                <div>
                    <label class="block text-gray-700">Nomor Seri</label>
                    <input type="text" name="nomor_seri" class="w-full border rounded px-3 py-2" placeholder="SN-XXXXX" required>
                </div>
                <div>
                    <label class="block text-gray-700">Lokasi</label>
                    <input type="text" name="lokasi" class="w-full border rounded px-3 py-2" placeholder="Ruang A" required>
                </div>
                <div>
                    <label class="block text-gray-700">Kondisi</label>
                    <select name="kondisi" class="w-full border rounded px-3 py-2">
                        <option value="Baik">Baik</option>
                        <option value="Rusak Ringan">Rusak Ringan</option>
                        <option value="Rusak Berat">Rusak Berat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-gray-700">Tanggal Servis Terakhir</label>
                    <input type="date" name="tanggal_servis_terakhir" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-gray-700">Interval Servis (Bulan)</label>
                    <input type="number" name="interval_servis" class="w-full border rounded px-3 py-2" placeholder="3" required>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <a href="{{ route('items.index') }}" class="text-gray-600 mr-4 py-2">Batal</a>
                <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Simpan Aset</button>
            </div>
        </form>
    </div>
    <script>
document.getElementById('kode_barang').addEventListener('input', function () {
    const kode = this.value.toUpperCase();
    const namaInput = document.getElementById('nama_barang');

    const mapping = {
        '3100101007': 'PC Workstation',
        '3100102001': 'P.C Unit',
        '3100102002': 'Lap Top',
        '3100102003': 'Note Book',
        '3100102008': 'Ultra Mobile P.C.',
        '3100202015': 'Auto Switch/Data Switch',
        '3100203003': 'Printer (Peralatan Personal Komputer)',
        '3100203004': 'Scanner (Peralatan Personal Komputer)',
        '3100203007': 'External',
        '3100203009': 'Keyboard (Peralatan Personal Komputer)',
        '3100204001': 'Server',
        '3100204002': 'Router',
        '3100204023': 'Wireless Access Point',
        '3100204024': 'Switch',
        '3100204030': 'Network Cable Tester',
        '3060101048': 'Uninterruptible Power Supply (UPS)',
        '3050206017': 'Unit Power Supply',
        '3060102128': 'Camera Digital',
        '3060201001': 'Telephone (PABX)'
    };
    let nama = '';

    for (const key in mapping) {
        if (kode.startsWith(key)) {
            nama = mapping[key];
            break;
        }
    }

    if (nama) {
        namaInput.value = nama;
        namaInput.readOnly = true; //(supaya konsisten)
    } else {
        namaInput.value = '';
        namaInput.readOnly = false;
    }
});
</script>
</x-app-layout>
