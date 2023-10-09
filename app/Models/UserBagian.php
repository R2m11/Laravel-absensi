<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBagian extends Model
{
    use HasFactory;
    protected $table = 'user_bagian';
    protected $fillable = [
        'nama_user_bagian',
        'bagian_id'
    ];
    public function bagian(){
        return $this->belongsTo(Bagian::class,'bagian_id');
    }
    public function absenkaryawan(){
        return $this->belongsToMany(AbsenKaryawan::class,'userbagian_id');
    }
}
