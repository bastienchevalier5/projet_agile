<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Database\Factories\UserFactory;
use Illuminate\Contracts\View\View;
class UserController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index()
    {
        $users = User::all();
        return view('user',compact('users'));
    }

    /**
     * Summary of create
     * @return View
     */
    public function create()
    {
        $user = new User;
        return view('user_form',compact('user'));
    }

    public function store(Request $request): void
    {
    }

    /**
     * Summary of show
     *
     * @return View
     */
    public function show(User $user)
    {
        return view('detail_user',compact('user'));
    }

    /**
     * Summary of edit
     * @return View
     */
    public function edit(User $user)
    {
        return view('user_form');
    }

    public function update(Request $request, User $user): void
    {
    }

    public function destroy(User $user): void
    {
    }
}
