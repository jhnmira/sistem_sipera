<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaintenanceRecord;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $today = Carbon::today();

        $totalBarang = Item::count();

        $listPerluServis = Item::whereDate('tanggal_servis_selanjutnya', '>=', $today)
                ->whereDate('tanggal_servis_selanjutnya', '<=', $today->copy()->addDays(7))
                ->orderBy('tanggal_servis_selanjutnya', 'asc')
                ->get();

        $listServisTerlambat = Item::whereDate('tanggal_servis_selanjutnya', '<', $today)
            ->orderBy('tanggal_servis_selanjutnya', 'asc')
            ->get();

        $listServisTerlambat->transform(function ($item) use ($today) {
            $item->hari_terlambat = Carbon::parse($item->tanggal_servis_selanjutnya)
                ->diffInDays($today);
            return $item;
        });

        $perluServis = $listPerluServis->count();
        $barangRusak = Item::where('kondisi', '!=', 'Baik')->count();

        // data infografis
        $kondisiData = Item::select('kondisi')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('kondisi')
            ->pluck('total', 'kondisi');

        $asetByJenis = Item::select('nama')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('nama')
            ->pluck('total', 'nama');
        // servis bulanan
        $servisBulananRaw = Item::selectRaw('MONTH(tanggal_servis_selanjutnya) as bulan, COUNT(*) as total')
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $namaBulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        $servisBulanan = collect();

        foreach ($servisBulananRaw as $bulan => $total) {
            $servisBulanan->put($namaBulan[$bulan], $total);
        }

        $query = MaintenanceRecord::with('item')->orderBy('tanggal_perawatan', 'desc');

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->whereHas('item', function($q2) use ($search) {
                $q2->where('nama', 'like', "%$search%")
                ->orWhere('kode_barang', 'like', "%$search%")
                ->orWhere('nup', 'like', "%$search%");
            })
            ->orWhere('deskripsi', 'like', "%$search%")
            ->orWhere('teknisi', 'like', "%$search%")
            ->orWhere('masalah', 'like', "%$search%");
        });
    }

        $riwayatServis = $query->paginate(10);

        if ($request->ajax()) {
            return view('dashboard', compact(
                'totalBarang',
                'perluServis',
                'barangRusak',
                'listPerluServis',
                'listServisTerlambat',
                'kondisiData',
                'asetByJenis',
                'servisBulanan',
                'riwayatServis'
            ));
        }

        return view('dashboard', compact(
            'totalBarang',
            'perluServis',
            'barangRusak',
            'listPerluServis',
            'listServisTerlambat',
            'kondisiData',
            'asetByJenis',
            'servisBulanan',
            'riwayatServis'
        ));
    }

}
