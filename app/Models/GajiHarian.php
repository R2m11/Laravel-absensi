<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GajiHarian extends Model
{
    use HasFactory;
    protected $table = 'gaji_harian';
    protected $fillable = [
        'desc_gaji',
        'gaji',
        'lembur_perjam'
    ];
    public function gajiharian(){
        return $this->belongsToMany(Kehadiran::class,'gajiharian_id','id');
    }
    public function profile(){
        return $this->belongsToMany(Profile::class,'gajiharian_id');
    }
}
