@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="alert alert-success">
            <h4>Selamat Datang, Guru!</h4>
            <p>Silakan input dan pantau kehadiran siswa pada menu absensi.</p>
        </div>
        <a href="{{ route('absensi.index') }}" class="btn btn-primary">Kelola Data Absensi Siswa</a>
    </div>
</div>
@endsection
