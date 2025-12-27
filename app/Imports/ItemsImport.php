<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ItemsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Ambil semua kombinasi nama + nup yang sudah ada di DB
        $existingItems = Item::select('nama', 'nup')
            ->get()
            ->map(fn($i) => trim($i->nama) . '||' . trim($i->nup))
            ->toArray();

        // Simpan kombinasi yang sudah diproses dalam file ini (hindari duplikasi di Excel)
        $alreadyImported = [];

        foreach ($rows as $row) {
            // Skip baris tanpa nama
            if (!isset($row['nama']) || trim($row['nama']) === '') {
                continue;
            }

            $nama = trim($row['nama']);
            $nup = $row['nup'] ?? '-';

            $key = $nama . '||' . $nup;

            // Skip jika sudah ada di DB atau sudah diimport dari file ini
            if (in_array($key, $existingItems) || in_array($key, $alreadyImported)) {
                continue;
            }

            $alreadyImported[] = $key;

            $merek = $row['merek'] ?? '-';
            $nomorSeri = $row['nomor_seri'] ?? '-';
            $kodeBarang = $row['kode_barang'] ?? '-';
            $lokasi = $row['lokasi'] ?? '-';
            $kondisi = $row['kondisi'] ?? '-';
            $interval = isset($row['interval_servis']) ? (int) $row['interval_servis'] : 1;

            // Tanggal servis terakhir
            if (!empty($row['tanggal_servis_terakhir'])) {
                if (is_numeric($row['tanggal_servis_terakhir'])) {
                    $tanggalTerakhir = Carbon::instance(
                        ExcelDate::excelToDateTimeObject($row['tanggal_servis_terakhir'])
                    );
                } else {
                    $tanggalTerakhir = Carbon::parse($row['tanggal_servis_terakhir']);
                }
            } else {
                $tanggalTerakhir = now();
            }

            $nextService = $tanggalTerakhir->copy()->addMonths($interval);

            // Tambahkan barang baru
            $item = Item::create([
                'nama' => $nama,
                'merek' => $merek,
                'nomor_seri' => $nomorSeri,
                'kode_barang' => $kodeBarang,
                'nup' => $nup,
                'lokasi' => $lokasi,
                'kondisi' => $kondisi,
                'interval_servis' => $interval,
                'tanggal_servis_terakhir' => $tanggalTerakhir,
                'tanggal_servis_selanjutnya' => $nextService,
            ]);

            $id = $item->id;
        }
    }
}
