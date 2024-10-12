<?php

namespace App\Http\Repositories;

use App\Models\Motif;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class MotifRepository
{
    /**
     * Summary of motif
     *
     * @var Motif
     */
    protected $motif;

    public function __construct(Motif $motif)
    {
        $this->motif = $motif;
    }

    /**
     * Save a Motif instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function save(Motif $motif, array $inputs): Motif
    {
        Cache::forget('motifs');

        // Ensure the input is a string
        if (! is_string($inputs['Libelle'])) {
            throw new InvalidArgumentException('Libelle must be a string.');
        }

        $motif->Libelle = $inputs['Libelle'];
        $motif->save();

        return $motif;
    }

    /**
     * Create a new Motif instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function store(array $inputs): Motif
    {
        $motif = new Motif();

        return $this->save($motif, $inputs);
    }

    /**
     * Update an existing Motif instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function update(Motif $motif, array $inputs): Motif
    {
        return $this->save($motif, $inputs);
    }
}
