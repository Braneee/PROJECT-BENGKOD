<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Obat;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Obat::query();

        if ($search) {
            $query->where('nama_obat', 'like', "%{$search}%")
                  ->orWhere('golongan_obat', 'like', "%{$search}%")
                  ->orWhere('distributor', 'like', "%{$search}%")
                  ->orWhere('produsen_obat', 'like', "%{$search}%");
        }

        $obats = $query->latest()->paginate(10);
        
        return view('admin.obat.index', compact('obats', 'search'));
    }

    public function create()
    {
        return view('admin.obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'required|string',
            'harga' => 'required|integer',
            'expired' => 'nullable|date',
            'golongan_obat' => 'nullable|string',
            'distributor' => 'nullable|string',
            'produsen_obat' => 'nullable|string',
            'stok' => 'required|integer|min:0',
        ]);

        Obat::create([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'expired' => $request->expired,
            'golongan_obat' => $request->golongan_obat,
            'distributor' => $request->distributor,
            'produsen_obat' => $request->produsen_obat,
            'stok' => $request->stok,
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat Berhasil dibuat')
            ->with('type', 'success');
    }

    public function edit(string $id)
    {
        $obat = Obat::findOrFail($id);
        return view('admin.obat.edit')->with([
            'obat' => $obat
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'nama_obat' => 'required|string',
            'kemasan' => 'nullable|string',
            'harga' => 'required|integer',
            'expired' => 'nullable|date',
            'golongan_obat' => 'nullable|string',
            'distributor' => 'nullable|string',
            'produsen_obat' => 'nullable|string',
            'stok' => 'required|integer|min:0',
        ]);

        $obat = Obat::findOrFail($id);
        $obat->update([
            'nama_obat' => $request->nama_obat,
            'kemasan' => $request->kemasan,
            'harga' => $request->harga,
            'expired' => $request->expired,
            'golongan_obat' => $request->golongan_obat,
            'distributor' => $request->distributor,
            'produsen_obat' => $request->produsen_obat,
            'stok' => $request->stok,
        ]);

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat berhasil di edit')
            ->with('type', 'success');
    }

    public function destroy(string $id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();

        return redirect()->route('obat.index')
            ->with('message', 'Data Obat Berhasil di Hapus')
            ->with('type', 'success');
    }
}
