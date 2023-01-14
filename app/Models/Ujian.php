<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    public function materi()
    {
        return $this->belongsTo(Materi::class);
    }

    public function mapelmaster()
    {
        return $this->belongsTo(Mapelmaster::class);
    }
}
