<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'position_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function profile(){
        return $this->hasOne(Profile::class,'users_id');
    }
    public function kasbon(){
        return $this->hasMany(Kasbon::class,'users_id');
    }

    public function position(){
        return $this->belongsTo(Position::class,'position_id');
    }

    public function absensi_karyawan(){
        return $this->belongsToMany(Absensi::class,'absensi_karyawan','users_id','absensi_id');
    }

    public function kehadiran(){
        return $this->belongsToMany(Kehadiran::class,'users_id');
    }
    public function xkehadiran(){
        return $this->belongsToMany(Xkehadiran::class,'users_id');
    }

}
