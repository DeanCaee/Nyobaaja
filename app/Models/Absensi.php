<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    use HasFactory;

    // Tambahkan baris ini agar kolom-kolom di bawah bisa diisi secara massal
    protected $fillable = [
        'user_id',
        'nisn',
        'tanggal',
        'status',
        'keterangan',
    ];

    // Relasi ke tabel users
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
