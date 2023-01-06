<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mapelmaster extends Model
{
    use HasFactory;
    protected $fillable=[
        'guru_id','kelas_id','mapel_id'
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function mapel()
    {
        return $this->belongsTo(Mapel::class);
    }

    public function materi()
    {
        return $this->hasMany(Materi::class);
    }
}
