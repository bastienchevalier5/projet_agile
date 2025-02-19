<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;

    public function sensible() {
        $this->belongsTo(JoursSensibles::class);
    }

    protected $fillable = ['nom'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
