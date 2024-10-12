<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\AbsenceFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $debut
 * @property string $fin
 * @property int $motif_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $statut
 *
 * @property-read \App\Models\Motif|null $motif
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\AbsenceFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence query()
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereDebut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereFin($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereMotifId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereStatut($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Absence whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Absence extends Model
{
    /**
     * @use HasFactory<AbsenceFactory>
     */
    use HasFactory;

    protected $fillable = ['debut', 'fin', 'motif_id', 'user_id'];

    /**
     * Summary of motif
     *
     * @return BelongsTo<Motif, Absence>
     */
    public function motif()
    {
        return $this->belongsTo(Motif::class);
    }

    /**
     * @return BelongsTo<User, Absence>
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
