<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = [
            'Akademik',
            'Fasilitas & Sarana',
            'Keuangan',
            'Kemahasiswaan',
            'Layanan Administrasi',
            'Lainnya',
        ];
        foreach ($kategori as $nama) {
            Category::firstOrCreate(['nama' => $nama]);
        }

        // Akun staff (satu-satunya cara membuat staff: lewat seeder/admin, bukan registrasi)
        User::updateOrCreate(['username' => 'staff_kemahasiswaan'], [
            'name' => 'Staff Kemahasiswaan',
            'email' => 'staff@unisnu.ac.id',
            'password' => Hash::make('staff12345'),
            'role' => 'staff',
        ]);

        User::updateOrCreate(['username' => 'mahasiswa_contoh'], [
            'name' => 'Mahasiswa Contoh',
            'email' => 'mahasiswa@unisnu.ac.id',
            'password' => Hash::make('mahasiswa12345'),
            'role' => 'mahasiswa',
        ]);
    }
}