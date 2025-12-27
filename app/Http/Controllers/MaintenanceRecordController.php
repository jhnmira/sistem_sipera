<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MaintenanceRecordController extends Controller
{
    public function index(Item $item)
    {
        $records = $item->maintenanceRecords()->paginate(10);
        return view('maintenance.index', compact('item', 'records'));
    }

    public function store(Request $request, Item $item)
    {
        $request->validate([
            'tanggal_perawatan' => 'required',
            'deskripsi' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'masalah' => 'required',
        ]);

        MaintenanceRecord::create([
            'item_id' => $item->id,
            'tanggal_perawatan' => $request->tanggal_perawatan,
            'deskripsi' => $request->deskripsi,
            'teknisi' => $request->teknisi,
            'masalah' => $request->masalah,
        ]);

        $nextService = Carbon::parse($request->tanggal_perawatan)
                        ->addMonths((int) $item->interval_servis);

        $item->update([
            'tanggal_servis_terakhir' => $request->tanggal_perawatan,
            'tanggal_servis_selanjutnya' => $nextService,
        ]);

        return redirect()->back()->with('success', 'Riwayat dicatat & Jadwal aset diperbarui!');
    }

    public function edit(MaintenanceRecord $record)
    {
        return view('maintenance.edit', compact('record'));
    }

    public function update(Request $request, MaintenanceRecord $record)
    {
        $request->validate([
            'deskripsi' => 'nullable|string',
            'teknisi' => 'nullable|string',
            'masalah' => 'required',
        ]);

        $record->update([
            'deskripsi' => $request->deskripsi,
            'teknisi' => $request->teknisi,
            'masalah' => $request->masalah,
        ]);

        return redirect()
            ->route('maintenance.index', $record->item_id)
            ->with('success', 'Penanganan diperbarui.');
    }
}
