<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $table ='profile';
    protected $fillable =[
        'kode_karyawan',
        'gender',
        'address',
        'phone_number',
        'foto_profil',
        'users_id',
        'gajiharian_id'
        ];

    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
    public function gajiharian(){
        return $this->belongsTo(GajiHarian::class,'gajiharian_id');
    }
}
