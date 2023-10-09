<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwal extends Model
{
    use HasFactory;
    protected $table= 'jadwal';
    protected $fillable = [
        'shift',
        'jam_masuk',
        'jam_keluar'
    ];

    public function absensi(){
        return $this->belongsToMany(Absensi::class,'jadwal_id');
    }

}
