<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class absensi extends Model
{
    use HasFactory;
    protected $table = 'absensi';
    protected $fillable = [
        'tanggal_absensi',
        'jadwal_id',
        'jam_masuk',
        'jam_keluar',
        'deskripsi'
    ];

    public function absenkaryawan(){
        return $this->belongsToMany(User::class,'absensi_id');
    }
    public function jadwal(){
        return $this->belongsTo(Jadwal::class,'jadwal_id','id');
    }
}
