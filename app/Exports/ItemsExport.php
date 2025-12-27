<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class ItemsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected array $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        return Item::filter($this->filters)
                   ->orderBy('id', 'asc'); // urut sesuai ID Excel
    }

    public function map($item): array
    {
        return [
            $item->nama,
            $item->kode_barang,
            $item->nup,
            $item->merek,
            $item->nomor_seri,
            $item->lokasi,
            $item->kondisi,
            $item->tanggal_servis_terakhir?->format('d-m-Y'),
            $item->tanggal_servis_selanjutnya?->format('d-m-Y'),
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Aset',
            'Kode Aset',
            'NUP',
            'Merek',
            'Nomor Seri',
            'Lokasi',
            'Kondisi',
            'Tgl Servis Terakhir',
            'Next Servis',
        ];
    }
}
