<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Angkatan extends Model
{
    use HasFactory;

    protected $fillable=[
        'angkatan_name',
        'angkatan_status',
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class);
    }
}
