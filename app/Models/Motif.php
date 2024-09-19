<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Database\Factories\MotifFactory;
/**
 * @property int $id
 * @property string $Libelle
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property bool $is_accessible_salarie
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @method static \Database\Factories\MotifFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif query()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereIsAccessibleSalarie($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereLibelle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Motif withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Motif withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Motif extends Model
{
    /**
     * @use HasFactory<MotifFactory>
     */
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_accessible_salarie' => 'boolean',
    ];

    protected $fillable = ['Libelle', 'is_accessible_salarie'];
}
