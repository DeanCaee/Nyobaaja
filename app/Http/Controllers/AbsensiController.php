<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;
use App\Models\Absensi;
use App\Models\User;

class AbsensiController extends Controller
{
    /**
     * Admin melihat semua riwayat absensi masuk
     */
    public function index()
    {
        $absensis = Absensi::with('user')->latest()->get();
        return view('absensi.index', compact('absensis'));
    }

    /**
     * Admin membuka atau menutup akses form absensi (Menggunakan Cache global)
     */
    public function toggleAkses()
    {
        $statusAkses = Cache::get('form_absen_buka', false);

        // Simpan status baru ke Cache global selama 1 hari
        Cache::put('form_absen_buka', !$statusAkses, now()->addDay());

        return back()->with('success', 'Status akses form absensi berhasil diubah!');
    }

    /**
     * Halaman Siswa untuk mengecek status akses dan mengetik NISN
     */
    public function formSiswa()
    {
        // Ambil status dari Cache global agar sinkron dengan admin
        $buka = Cache::get('form_absen_buka', false);

        return view('siswa.isi_absensi', compact('buka'));
    }

    /**
     * Proses siswa mengirim absen menggunakan NISN
     */
    public function simpanSiswa(Request $request)
    {
        // Cek status buka/tutup dari Cache global
        if (!Cache::get('form_absen_buka', false)) {
            return back()->with('error', 'Maaf, form absensi sedang ditutup oleh Admin.');
        }

        $request->validate([
            'nisn' => 'required|exists:users,nisn',
            'status' => 'required|in:Hadir,Izin,Sakit',
            'keterangan' => 'nullable|string',
        ]);

        $siswa = User::where('nisn', $request->nisn)->where('role', 'siswa')->first();

        if (!$siswa) {
            return back()->with('error', 'NISN tidak ditemukan atau bukan akun siswa!');
        }

        // Cek apakah sudah absen hari ini
        $sudahAbsen = Absensi::where('user_id', $siswa->id)
                             ->where('tanggal', date('Y-m-d'))
                             ->first();

        if ($sudahAbsen) {
            return back()->with('error', 'Anda sudah melakukan absensi hari ini!');
        }

        Absensi::create([
            'user_id' => $siswa->id,
            'tanggal' => date('Y-m-d'),
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard')->with('success', 'Absensi dengan NISN ' . $request->nisn . ' berhasil tercatat!');
    }

    /**
     * Hapus data absensi (Admin)
     */
    public function destroy(Absensi $absensi)
    {
        $absensi->delete();
        return redirect()->route('absensi.index')->with('success', 'Data absensi berhasil dihapus.');
    }
}
