@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h4>Form Absensi Harian (Ketik NISN)</h4>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif

                @if($buka)
                    <form action="{{ route('absensi.kirim') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="nisn" class="form-label">Masukkan NISN</label>
                            <input type="text" class="form-control" id="nisn" name="nisn" required placeholder="Contoh: 12345678">
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status Kehadiran</label>
                            <select name="status" id="status" class="form-control" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan (Opsional)</label>
                            <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Alasan jika izin/sakit..."></textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100">Kirim Kehadiran</button>
                    </form>
                @else
                    <div class="alert alert-warning text-center">
                        <h5>Form Absensi Sedang Ditutup</h5>
                        <p class="mb-0">Admin belum membuka akses absensi untuk hari ini. Silakan kembali lagi nanti.</p>
                    </div>
                @endif

                <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100 mt-3">Kembali ke Dashboard</a>
            </div>
        </div>
    </div>
</div>
@endsection
