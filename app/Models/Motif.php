<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 *
 * @property int $id
 * @property string $Libelle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_accessible_salarie
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereIsAccessibleSalarie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereLibellé($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereLibelle($value)
 * @mixin \Eloquent
 */
class Motif extends Model
{
    use HasFactory;
    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_accessible_salarie' => 'boolean',
    ];

    protected $fillable = ['Libelle','is_accessible_salarie'];

}
