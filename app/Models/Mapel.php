<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapel extends Model
{
    use HasFactory;

    protected $fillable = [
        'mapel_name',
        'mapel_slug',
        'image',
        'thumbnail',
    ];

    // public function getImageAttribute($value)
    // {
    //     return asset('mapel_image/'.$value);
    // }

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class);
    }

    public function mapelmaster(){
        return $this->hasMany(Mapelmaster::class);
    }

}
