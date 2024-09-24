<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Absence;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;
use Database\Factories\UserFactory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
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

    /**
     * Summary of store
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('user.index');
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
        $users = User::all();
        return view('user_form',compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }
}
