@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h2>Data Absensi</h2>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary mb-3">
        &laquo; Kembali ke Dashboard
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama User</th>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($absensis as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->name ?? 'Tidak Diketahui' }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>
                        <span class="badge bg-{{ $item->status == 'Hadir' ? 'success' : ($item->status == 'Izin' ? 'warning' : 'danger') }}">
                            {{ $item->status }}
                        </span>
                    </td>
                    <td>
                        <form action="{{ route('absensi.destroy', $item->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
