<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\PoliController;
use App\Http\Controllers\Admin\PoliController as AdminPoliController;
use App\Http\Controllers\Admin\DokterController;
use App\Http\Controllers\Admin\PasienController;
use App\Http\Controllers\Admin\ObatController;
use App\Http\Controllers\Dokter\JadwalPeriksaController;
use App\Http\Controllers\Dokter\PeriksaPasienController;
use App\Http\Controllers\Dokter\RiwayatPasienController;
use App\Http\Controllers\Pasien\PoliController as PasienPoliController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        $totalObat = \App\Models\Obat::count();
        $polis = \App\Models\Poli::withCount('dokters')->get();
        $dokters = \App\Models\User::where('role', 'dokter')->with('poli')->get();
        
        $riwayatPasien = \App\Models\DaftarPoli::with(['pasien', 'jadwalPeriksa.dokter', 'periksas'])
            ->latest()
            ->take(10) // Limit to latest 10 for dashboard
            ->get()
            ->map(function ($daftar) {
                $daftar->status = $daftar->periksas->count() > 0 ? 'Sudah Diperiksa' : 'Belum Diperiksa';
                return $daftar;
            });

        $visits = \App\Models\DaftarPoli::where('created_at', '>=', now()->subDays(6))
            ->get()
            ->groupBy(function($item) { return $item->created_at->format('Y-m-d'); })
            ->sortKeys();

        $chartData = [
            'labels' => $visits->keys()->map(function($d) { return \Carbon\Carbon::parse($d)->format('d M'); })->values()->toArray(),
            'data' => $visits->map->count()->values()->toArray()
        ];

        return view('admin.dashboard', compact('totalObat', 'polis', 'dokters', 'riwayatPasien', 'chartData'));
    })->name('admin.dashboard');
    Route::resource('polis', AdminPoliController::class);
    Route::resource('dokter', DokterController::class);
    Route::resource('pasien', PasienController::class);
    Route::resource('obat', ObatController::class);
});

Route::middleware(['auth', 'role:dokter'])->prefix('dokter')->group(function () {
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $jadwalAktif = \App\Models\JadwalPeriksa::where('id_dokter', $user->id)->count();
        $daftarPoli = \App\Models\DaftarPoli::whereHas('jadwalPeriksa', function($q) use ($user) {
            $q->where('id_dokter', $user->id);
        })->get();
        $totalPasien = $daftarPoli->count();
        $sudahDiperiksa = \App\Models\Periksa::whereIn('id_daftar_poli', $daftarPoli->pluck('id'))->count();
        $belumDiperiksa = $totalPasien - $sudahDiperiksa;
        return view('dokter.dashboard', compact('user', 'jadwalAktif', 'totalPasien', 'sudahDiperiksa', 'belumDiperiksa'));
    })->name('dokter.dashboard');
    Route::resource('jadwal-periksa', JadwalPeriksaController::class);

    Route::get('/periksa-pasien', [PeriksaPasienController::class, 'index'])->name('periksa-pasien.index');
    Route::post('/periksa-pasien', [PeriksaPasienController::class, 'store'])->name('periksa-pasien.store');
    Route::get('/periksa-pasien/{id}', [PeriksaPasienController::class, 'create'])->name('periksa-pasien.create');

    Route::get('/riwayat-pasien', [RiwayatPasienController::class, 'index'])->name('riwayat-pasien.index');
    Route::get('/riwayat-pasien/{id}', [RiwayatPasienController::class, 'show'])->name('riwayat-pasien.show');
});

Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', function () {
        return view('pasien.dashboard');
    })->name('pasien.dashboard');
    Route::get('/daftar', [PasienPoliController::class, 'get'])->name('pasien.daftar');
    Route::post('/daftar', [PasienPoliController::class, 'submit'])->name('pasien.daftar.submit');
});
