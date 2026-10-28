@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">Form Absensi Harian</div>
            <div class="card-body">

                <!-- Pesan Error / Peringatan -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Pesan Sukses -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if($buka)
                    <!-- Form Absensi dengan dukungan Upload File & Kamera Langsung -->
                    <form action="{{ route('absensi.kirim') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nisn" class="form-label">Masukkan NISN Anda</label>
                            <input type="text" name="nisn" id="nisn" class="form-control" required placeholder="Ketik NISN...">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Kehadiran</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>

                        <!-- Input Bukti Foto dengan Fitur Kamera Langsung -->
                        <div class="mb-3">
                            <label for="foto" class="form-label">Bukti Foto Kehadiran / Izin / Sakit</label>
                            <input type="file" name="foto" id="foto" class="form-control" accept="image/*" capture="environment">
                            <small class="text-muted">Klik untuk memilih file atau langsung mengambil foto dari kamera perangkat.</small>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="2" placeholder="Keterangan tambahan..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Kirim Absensi</button>
                    </form>
                @else
                    <div class="alert alert-warning text-center">
                        <h4>Form Absensi Sedang Ditutup</h4>
                        <p>Admin belum membuka akses absensi untuk hari ini.</p>
                    </div>
                @endif

                <div class="mt-3 text-center">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">Kembali ke Dashboard</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
