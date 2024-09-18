<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absence extends Model
{
    use HasFactory;

    protected $fillable = ['debut','fin','motif_id','user_id'];
    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
