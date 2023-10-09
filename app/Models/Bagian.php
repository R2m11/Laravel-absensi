<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    use HasFactory;
    protected $table = 'bagian';
    protected $fillable = [
        'nama_bagian',
        'kode_bagian',
        'perusahaan_id',
        'tagihan_harian',
        'tagihan_harian_perjam',
    ];

    public function perusahaan(){
        return $this->belongsTo(Perusahaan::class,'perusahaan_id');
    }
    public function user_bagian(){
        return $this->hasMany(UserBagian::class,'bagian_id');
    }
    public function absenkaryawan(){
        return $this->belongsToMany(AbsenKaryawan::class,'bagian_id');
    }
    public function rekap(){
        return $this->belongsToMany(Rekap::class,'bagian_id');
    }
    public function kehadiran(){
        return $this->belongsToMany(Kehadiran::class,'bagian_id');
    }
    public function xkehadiran(){
        return $this->belongsToMany(Xkehadiran::class,'bagian_id');
    }
}
