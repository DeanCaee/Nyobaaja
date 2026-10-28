@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Header Halaman & Tombol Kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark">Data Riwayat Absensi</h2>
            <p class="text-muted mb-0">Pantau seluruh data kehadiran siswa secara real-time.</p>
        </div>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            &laquo; Kembali ke Dashboard
        </a>
    </div>

    <!-- Alert Notifikasi Sukses -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Card Tabel yang Lebih Luas dan Rapi -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white py-3">
            <h5 class="mb-0">Daftar Kehadiran Siswa</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center" style="width: 5%;">No</th>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th>Tanggal</th>
                            <th class="text-center">Status</th>
                            <th>Keterangan</th>
                            <th class="text-center">Bukti Foto</th> <!-- <-- TAMBAHAN KOLOM FOTO -->
                            <th class="text-center" style="width: 15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensis as $index => $item)
                        <tr>
                            <td class="text-center fw-bold">{{ $index + 1 }}</td>
                            <td>
                                <div class="fw-bold">{{ $item->user->name ?? 'Tidak Dikenal' }}</div>
                            </td>
                            <td><code>{{ $item->user->nisn ?? '-' }}</code></td>
                            <td>{{ $item->tanggal }}</td>
                            <td class="text-center">
                                @if($item->status == 'Hadir')
                                    <span class="badge bg-success px-3 py-2">Hadir</span>
                                @elseif($item->status == 'Izin')
                                    <span class="badge bg-warning text-dark px-3 py-2">Izin</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Sakit</span>
                                @endif
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>

                            <!-- <-- TAMBAHAN TAMPILAN TOMBOL FOTO -->
                            <td class="text-center">
                                @if($item->foto)
                                    <a href="{{ asset('storage/' . $item->foto) }}" target="_blank" class="btn btn-sm btn-info text-white">
                                        Lihat Foto
                                    </a>
                                @else
                                    <span class="text-muted fst-italic">Tidak ada</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <form action="{{ route('absensi.destroy', $item->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm px-3">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted"> <!-- <-- Ubah colspan jadi 8 karena kolom bertambah -->
                                Belum ada data absensi siswa yang tercatat.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
