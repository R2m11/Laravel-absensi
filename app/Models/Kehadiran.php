<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kehadiran extends Model
{
    use HasFactory;
    protected $table = 'kehadiran';
    protected $fillable = [
        'users_id',
        'absenkaryawan_id',
        'bagian_id',
        'tanggal',
        'status',
        'ket',
        'gajiharian_id',
        'lemburharian_id'
    ];
    protected $attributes = [
        'status' => 'Belum Diisi', // Ganti 'default_value' dengan nilai default yang sesuai
        'ket' => 'Hari Biasa', // Ganti 'default_value' dengan nilai default yang sesuai
        'lemburharian_id' => '1' // Ganti 'default_value' dengan nilai default yang sesuai
    ];

    public function absenkaryawan(){
        return $this->belongsTo(AbsenKaryawan::class,'absenkaryawan_id');
    }
    public function bagian(){
        return $this->belongsTo(Bagian::class,'bagian_id');
    }
    public function rekap(){
        return $this->belongsToMany(Rekap::class,'kehadiran_id');
    }
    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
    public function gajiharian(){
        return $this->belongsTo(GajiHarian::class,'gajiharian_id','id');
    }
    public function lemburharian(){
        return $this->belongsTo(LemburHarian::class,'lemburharian_id','id');
    }
}
