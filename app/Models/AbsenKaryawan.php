<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AbsenKaryawan extends Model
{
    use HasFactory;
    protected $table = 'absen_karyawan';
    protected $fillable = [
        'users_id',
        'absensi_id',
        'bagian_id',
        'userbagian_id',
        'absen_masuk',
        'absen_keluar',
        'foto_absen'
    ];

    public function user(){
        return $this->belongsTo(User::class,'users_id','id');
    }
    public function absensi(){
        return $this->belongsTo(absensi::class,'absensi_id');
    }
    public function kehadiran(){
        return $this->belongsToMany(Kehadiran::class,'absenkaryawan_id','id');
    }
    public function bagian(){
        return $this->belongsTo(Bagian::class,'bagian_id','id');
    }
    public function userbagian(){
        return $this->belongsTo(UserBagian::class,'userbagian_id','id');
    }
}
