@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-info">
            @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
            <h4>Selamat Datang, Siswa!</h4>
            <p>Berikut adalah informasi rekapitulasi kehadiran Anda.</p>
        </div>

        <div class="mb-4">
            <a href="{{ route('absensi.isi') }}" class="btn btn-primary btn-lg">
                Isi Absensi Hari Ini
            </a>
        </div>

        <!-- Tabel Riwayat Kehadiran -->
        <div class="card">
            <div class="card-header bg-dark text-white">Riwayat Kehadiran Saya</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensis ?? [] as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->tanggal }}</td>
                            <td>
                                <span class="badge bg-{{ $item->status == 'Hadir' ? 'success' : 'warning' }}">
                                    {{ $item->status }}
                                </span>
                            </td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Belum ada riwayat absensi yang tercatat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>
@endsection
