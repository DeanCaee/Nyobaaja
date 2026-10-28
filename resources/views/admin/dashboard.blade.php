@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-primary">
            <h4>Dashboard Admin</h4>
            <p>Kelola akses absensi harian dan pantau riwayat kehadiran siswa.</p>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Kotak Kontrol Buka/Tutup Akses (Menggunakan Cache) -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Kontrol Akses Form Absensi Siswa</h5>

                @php
                    // Ambil status langsung dari Cache global
                    $statusBuka = \Illuminate\Support\Facades\Cache::get('form_absen_buka', false);
                @endphp

                <p class="card-text">Status Form Saat Ini:
                    <span class="badge bg-{{ $statusBuka ? 'success' : 'danger' }}">
                        {{ $statusBuka ? 'DIBUKA' : 'DITUTUP' }}
                    </span>
                </p>

                <form action="{{ route('admin.toggle.akses') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-{{ $statusBuka ? 'danger' : 'success' }}">
                        {{ $statusBuka ? 'Tutup Akses Absen' : 'Buka Akses Absen' }}
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ route('absensi.index') }}" class="btn btn-dark">Lihat Semua Riwayat Absensi Masuk</a>
    </div>
</div>
@endsection
