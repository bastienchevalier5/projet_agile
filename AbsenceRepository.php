<?php

namespace App\Http\Repositories;

use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;

class AbsenceRepository
{
    /**
     * @var Absence
     */
    protected $absence;

    public function __construct(Absence $absence)
    {
        $this->absence = $absence;
    }

    /**
     * Save a new Absence instance or update an existing one.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function save(?Absence $absence, array $inputs, User $user): Absence
    {
        Cache::forget('absences');

        // Validation des entrées
        if (! isset($inputs['debut']) || ! isset($inputs['fin'])) {
            throw new InvalidArgumentException('Debut and Fin fields are required.');
        }

        // Vérifier que 'user_id' est bien un entier si on ne doit pas utiliser l'utilisateur actuel
        if ($user->isAn('salarie')) {
            $userId = $user->id;
        } else {
            if (! isset($inputs['user_id']) || ! is_numeric($inputs['user_id'])) {
                throw new InvalidArgumentException('User ID must be a valid integer.');
            }
            $userId = (int) $inputs['user_id'];
        }

        // Création ou mise à jour de l'absence
        if (is_null($absence)) {
            $absence = new Absence();
            $absence->user_id = $userId;
        }

        // Assurer que les entrées sont valides
        if (! is_string($inputs['debut']) || ! is_string($inputs['fin'])) {
            throw new InvalidArgumentException('Debut and Fin must be strings.');
        }
        if (! is_numeric($inputs['motif_id'])) {
            throw new InvalidArgumentException('Motif ID must be a valid integer.');
        }

        // Assignation des valeurs
        $absence->debut = $inputs['debut'];
        $absence->fin = $inputs['fin'];
        $absence->motif_id = (int) $inputs['motif_id'];
        $absence->save();

        return $absence;
    }

    /**
     * Create a new Absence instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function store(array $inputs, User $user): Absence
    {
        return $this->save(null, $inputs, $user);
    }

    /**
     * Update an existing Absence instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function update(Absence $absence, array $inputs, User $user): Absence
    {
        return $this->save($absence, $inputs, $user);
    }

    /**
     * Notify admins of the new absence.
     */
    public function notifyAdmins(Absence $absence): void
    {
        $admins = User::whereIs('admin')->get();
        $absenceUser = $absence->user;
        $absenceMotif = $absence->motif;

        foreach ($admins as $admin) {
            if ($absenceUser && $absenceMotif) {
                Mail::to($admin->email)->send(new MailDemandeAbsence($absence, $absenceUser, $absenceMotif));
            }
        }
    }
}
