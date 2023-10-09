<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kasbon extends Model
{
    use HasFactory;
    protected $table = 'kasbon';
    protected $fillable = [
        'tanggal',
        'users_id',
        'jumlah'
    ];
    public function user(){
        return $this->belongsTo(User::class,'users_id');
    }
}
