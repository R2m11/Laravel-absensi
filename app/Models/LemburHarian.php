<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LemburHarian extends Model
{
    use HasFactory;
    protected $table = 'lembur_harian';
    protected $fillable = [
        'desc_lemburan',
        'lemburan'
    ];
    public function lemburharian(){
        return $this->belongsToMany(Kehadiran::class,'lemburharian_id','id');
    }
}
