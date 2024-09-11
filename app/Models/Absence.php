<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
