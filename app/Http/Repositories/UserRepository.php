<?php

namespace App\Http\Repositories;

use App\Models\User;
use Bouncer;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class UserRepository
{
    /**
     * Summary of user
     *
     * @var User
     */
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Save a user instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function save(User $user, array $inputs): User
    {
        Cache::forget('users');

        // Ensure the inputs are strings
        if (! is_string($inputs['name'])) {
            throw new InvalidArgumentException('Name must be a string.');
        }

        if (! is_string($inputs['email'])) {
            throw new InvalidArgumentException('Email must be a string.');
        }

        $user->name = $inputs['name'];
        $user->email = $inputs['email'];
        $user->age = $inputs['age'];
        $user->poste = $inputs['poste'];
        $user->service = $inputs['service'];
        $user->date_embauche = $inputs['date_embauche'];
        $user->duree_anciennete = $inputs['duree_anciennete'];

        $user->save();

        if ($inputs['is_admin'] === 'yes') {
            Bouncer::assign('admin')->to($user);
        } else {
            Bouncer::assign('salarie')->to($user);
        }

        return $user;
    }

    /**
     * Create a new user instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function store(array $inputs): User
    {
        $user = new User();

        return $this->save($user, $inputs);
    }

    /**
     * Update an existing user instance.
     *
     * @param  array<string, mixed>  $inputs
     *
     * @throws InvalidArgumentException
     */
    public function update(User $user, array $inputs): User
    {
        return $this->save($user, $inputs);
    }
}
