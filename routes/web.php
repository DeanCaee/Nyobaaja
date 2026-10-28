<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\AbsensiController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Halaman Utama (Welcome)
Route::get('/', function () {
    return view('welcome');
});

// Halaman Login & Proses Login
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $request->validate([
        'identity' => ['required'], // Bisa berupa NISN, NIP, atau ID Admin
        'password' => ['required'],
    ]);

    // Cari user berdasarkan nisn, nip, atau id
    $user = User::where('nisn', $request->identity)
                ->orWhere('nip', $request->identity)
                ->orWhere('id', $request->identity)
                ->first();

    // Verifikasi password dan lakukan login manual
    if ($user && Hash::check($request->password, $user->password)) {
        Auth::login($user);
        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    return back()->withErrors([
        'identity' => 'NISN, NIP, atau ID dan password salah.',
    ])->withInput();
});

// Proses Logout
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/login');
})->name('logout');


// --- ROUTE YANG MEMBUTUHKAN AUTENTIKASI ---
Route::middleware(['auth'])->group(function () {

    // Redirect otomatis ke dashboard sesuai role user yang login
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;

        if ($role === 'admin') {
            return view('admin.dashboard');
        }

        if ($role === 'guru') {
            return view('guru.dashboard');
        }

        // Khusus Siswa: Ambil data absensi miliknya dan kirim ke view dashboard
        $absensis = \App\Models\Absensi::where('user_id', Auth::id())->latest()->get();
        return view('siswa.dashboard', compact('absensis'));

    })->name('dashboard');

    // KHUSUS ADMIN (Melihat riwayat absensi, hapus, dan tombol buka/tutup akses)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi.index');
        Route::delete('/absensi/{absensi}', [AbsensiController::class, 'destroy'])->name('absensi.destroy');
        Route::post('/admin/toggle-akses', [AbsensiController::class, 'toggleAkses'])->name('admin.toggle.akses');
    });

    // KHUSUS SISWA (Mengisi form absensi dengan NISN dan mengirimkannya)
    Route::get('/absensi/isi', [AbsensiController::class, 'formSiswa'])->name('absensi.isi');
    Route::post('/absensi/kirim', [AbsensiController::class, 'simpanSiswa'])->name('absensi.kirim');

});
