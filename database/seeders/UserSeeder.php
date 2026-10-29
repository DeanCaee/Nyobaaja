<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id' => '1000',
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Buat Akun Guru
        User::create([
            'name' => 'Bapak Guru',
            'email' => 'guru@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'guru',
            'nip'=> '101',
        ]);

        $banyakSiswa = [
            [
                'name' => 'Azhar Syukron',
                'email'=>'azhar@gmail.com',
                'nisn' => '252610010',
                'password' => Hash::make('010101'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Siti Hanifah',
                'email'=>'siti@gmail.com',
                'nisn' => '252610054',
                'password' => Hash::make('261208'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Ardistya Anindya',
                'email'=>'dista@gmail.com',
                'nisn' => '252610011',
                'password' => Hash::make('030210'),
                'role' => 'siswa',
            ],
            [
                'name' => 'Dean Caesar Abdul Rahman',
                'nisn' => '252610023',
                'email'=> 'dean@gmail.com',
                'password'=>Hash::make('131209'),
                'role' => 'siswa',
            ],
            // Kamu bisa teruskan menambah ke bawah sebanyak yang dibutuhkan...
        ];

        // Masukkan data siswa ke database secara otomatis
        foreach ($banyakSiswa as $siswa) {
            User::updateOrCreate(
                ['nisn' => $siswa['nisn']], // Kunci pengecekan agar tidak duplikat
                $siswa
            );
    }
    }
}
