<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;
    protected $fillable = [
        'guru_name',
        'guru_nip',
        'photo',
        'quote',
        'user_id',
        'guru_slug',
        'guru_status'
    ];

    public function kelas()
    {
        return $this->belongsToMany(Kelas::class);
    }

    public function getImageAttribute($value)
    {
        return asset('guru_image/'.$value);
    }

    public function mapelmaster(){
        return $this->hasMany(Mapelmaster::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
}
