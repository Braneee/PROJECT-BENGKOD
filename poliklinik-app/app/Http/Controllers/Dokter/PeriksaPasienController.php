<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\DaftarPoli;
use App\Models\DetailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeriksaPasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dokterId = Auth::id();
        $daftarPasien = DaftarPoli::with(['pasien', 'jadwalPeriksa', 'periksas'])
            ->whereHas('jadwalPeriksa', function ($query) use ($dokterId) {
                $query->where('id_dokter', $dokterId);
            })
            ->orderBy('no_antrian')
            ->get();

        return view('dokter.periksa-pasien.index', compact('daftarPasien'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $obats = Obat::all();
        return view('dokter.periksa-pasien.create', compact('obats', 'id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $obatIds = json_decode($request->obat_json, true);

        // 1. Validasi ketersediaan stok obat terlebih dahulu
        $obats = Obat::whereIn('id', $obatIds)->get();
        foreach ($obats as $obat) {
            if ($obat->stok < 1) {
                return back()->withErrors(['obat_json' => "Stok obat '{$obat->nama_obat}' tidak mencukupi! Silakan pilih obat lain."])->withInput();
            }
        }

        try {
            \Illuminate\Support\Facades\DB::transaction(function () use ($request, $obatIds, $obats) {
                // 2. Buat data periksa
                $periksa = Periksa::create([
                    'id_daftar_poli' => $request->id_daftar_poli,
                    'tgl_periksa' => now(),
                    'catatan' => $request->catatan,
                    'biaya_periksa' => $request->biaya_periksa + 150000,
                ]);

                // 3. Simpan detail periksa dan kurangi stok obat
                foreach ($obatIds as $idObat) {
                    DetailPeriksa::create([
                        'id_periksa' => $periksa->id,
                        'id_obat' => $idObat,
                    ]);

                    // Kurangi stok obat
                    $obatModel = $obats->firstWhere('id', $idObat);
                    if ($obatModel) {
                        $obatModel->decrement('stok');
                    }
                }
            });
        } catch (\Exception $e) {
            return back()->withErrors(['obat_json' => 'Terjadi kesalahan sistem saat memproses pemeriksaan dan resep obat.'])->withInput();
        }

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $periksa = Periksa::with(['daftarPoli', 'detailPeriksas.obat'])->findOrFail($id);

        return view('dokter.periksa-pasien.show', compact('periksa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $periksa = Periksa::with(['detailPeriksas'])->findOrFail($id);
        $obats = Obat::all();

        return view('dokter.periksa-pasien.edit', compact('periksa', 'obats'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'obat_json' => 'required',
            'catatan' => 'nullable|string',
            'biaya_periksa' => 'required|integer',
        ]);

        $periksa = Periksa::findOrFail($id);

        $obatIds = json_decode($request->obat_json, true);

        $periksa->update([
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa + 150000,
        ]);

        DetailPeriksa::where('id_periksa', $id)->delete();

        foreach ($obatIds as $idObat) {
            DetailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $idObat,
            ]);
        }

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $periksa = Periksa::findOrFail($id);

        DetailPeriksa::where('id_periksa', $id)->delete();
        $periksa->delete();

        return redirect()->route('periksa-pasien.index')->with('success', 'Data periksa berhasil dihapus.');
    }
}
