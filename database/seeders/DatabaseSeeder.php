<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\GajiHarian;
use App\Models\jadwal;
use App\Models\LemburHarian;
use App\Models\Position;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        GajiHarian::create([
            'id' => '1',
            'desc_gaji'=>'admin',
            'gaji'=>'0',
            'lembur_perjam'=>'0',
        ]);
        Position::create([
            'position_name'=>'Administrator',
            'description'=>'Bagian Pengurusan Data',
        ]);
        Position::create([
            'position_name'=>'Karyawan',
            'description'=>'Tim Pekerja dilapangan',
        ]);
        Position::create([
            'position_name'=>'HR',
            'description'=>'no description',
        ]);
        User::create([
            'id'=>'1',
            'name'=> 'Admin',
            'email'=>'admin@admin.com',
            'password' => Hash::make('admin123'),
            'position_id'=>'1'
        ]);
        Profile::create([
            'kode_karyawan'=>'2113201037',
            'gender'=>'Laki-Laki',
            'address'=>'office',
            'phone_number'=>'0899999999',
            'users_id'=>'1',
            'gajiharian_id'=>'1',
        ]);
        User::create([
            'id'=>'2',
            'name'=> 'Bigboss',
            'email'=>'hr@gmail.com',
            'password' => Hash::make('admin123'),
            'position_id'=>'3'
        ]);
        Profile::create([
            'kode_karyawan'=>'11042003',
            'gender'=>'Laki-Laki',
            'address'=>'Karawang',
            'phone_number'=>'0899999999',
            'users_id'=>'2',
            'gajiharian_id'=>'1',
        ]);
        jadwal::create([
            'id' => '1',
            'shift'=>'non-shift',
            'jam_masuk'=>'08:00:00',
            'jam_keluar'=>'17:00:00'
        ]);
        jadwal::create([
            'id' => '2',
            'shift'=>'shift1',
            'jam_masuk'=>'07:00:00',
            'jam_keluar'=>'15:00:00'
        ]);
        jadwal::create([
            'id' => '3',
            'shift'=>'shift2',
            'jam_masuk'=>'15:00:00',
            'jam_keluar'=>'23:00:00'
        ]);
        jadwal::create([
            'id' => '4',
            'shift'=>'shift3',
            'jam_masuk'=>'23:00:00',
            'jam_keluar'=>'07:00:00'
        ]);
        LemburHarian::create([
            'id' => '1',
            'desc_lemburan'=>'Tidak Ada Lemburan',
            'lemburan'=>'0',
        ]);

    }
}
