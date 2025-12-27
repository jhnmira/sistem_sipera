<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Item;
use App\Exports\ItemsExport;
use App\Imports\ItemsImport;
use Maatwebsite\Excel\Facades\Excel;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $items = Item::query();

        $items = Item::filter($request->all())
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('items.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang' => 'required|unique:master_asets,kode_barang',
            'nup' => 'required',
            'nama' => 'required',
            'merek' => 'required|string|max:100',
            'nomor_seri' => 'required|string',
            'lokasi' => 'required',
            'kondisi' => 'required',
            'tanggal_servis_terakhir' => 'required|date',
            'interval_servis' => 'required|integer|min:1',
        ]);

        $nextService = Carbon::parse($request->tanggal_servis_terakhir)
                        ->addMonths((int) $request->interval_servis);

        $item = Item::create([
            'kode_barang' => $request->kode_barang,
            'nup' => $request->nup,
            'nama' => $request->nama,
            'merek' => $request->merek,
            'nomor_seri' => $request->nomor_seri,
            'lokasi' => $request->lokasi,
            'kondisi' => $request->kondisi,
            'tanggal_servis_terakhir' => $request->tanggal_servis_terakhir,
            'interval_servis' => $request->interval_servis,
            'tanggal_servis_selanjutnya' => $nextService,
        ]);

        return redirect()->route('items.index')->with('success', 'Aset berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'kode_barang' => 'required',
            'nup' => 'required|unique:items,nup,' . $item->id,
            'nama' => 'required',
            'merek' => 'required|string|max:100',
            'nomor_seri' => 'required|string|unique:items,nomor_seri,' . $item->id,
            'lokasi' => 'required',
            'kondisi' => 'required',
            'tanggal_servis_terakhir' => 'required|date',
            'interval_servis' => 'required|integer|min:1',
        ]);

        $nextService = Carbon::parse($request->tanggal_servis_terakhir)
                        ->addMonths((int) $request->interval_servis);

        $item->update(array_merge(
            $request->all(),
            ['tanggal_servis_selanjutnya' => $nextService]
        ));

        return redirect()->route('items.index')->with('success', 'Data aset diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Aset dihapus.');
    }

    public function export(Request $request)
    {
        return Excel::download(
            new ItemsExport($request->all()),
            'data-inventaris-filtered.xlsx'
        );
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ], [
            'file.required' => 'Silakan pilih file terlebih dahulu.',
            'file.mimes' => 'Format file harus .xlsx atau .csv',
        ]);

        // Proses import
        Excel::import(new ItemsImport, $request->file('file'));

        // Redirect dengan notifikasi sukses
        return redirect()->back()->with('success', 'Data inventaris berhasil diimpor!');
    }
}
