<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlatBermasalah;
use Illuminate\Support\Facades\Auth;

class AlatBermasalahController extends Controller
{
    public function index()
    {
        $alatBermasalah = AlatBermasalah::with('maintenanceRecord')->get();

        return view('alat_bermasalah.index', compact('alatBermasalah'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_id' => 'required|exists:items,id',
            'tanggal_laporan' => 'required|date',
            'deskripsi' => 'required|string',
        ]);

        AlatBermasalah::create([
            'item_id' => $validated['item_id'],
            'user_id' => Auth::id(),
            'tanggal_laporan' => $validated['tanggal_laporan'],
            'deskripsi' => $validated['deskripsi'],
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Laporan berhasil ditambahkan!');
    }
}
