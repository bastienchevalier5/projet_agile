<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Summary of index
     *
     * @return View
     */
    public function index()
    {
        $users = User::all();

        return view('user', compact('users'));
    }

    /**
     * Summary of create
     *
     * @return View
     */
    public function create()
    {
        $user = new User();

        return view('user_form', compact('user'));
    }

    /**
     * Summary of store
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.index')->with('success',__('User created successfully.'));
    }

    /**
     * Summary of show
     *
     * @return View
     */
    public function show(User $user)
    {
        return view('detail_user', compact('user'));
    }

    /**
     * Summary of edit
     *
     * @return View
     */
    public function edit(User $user)
    {
        $users = User::all();

        return view('user_form', compact('user'));
    }

    /**
     * Summary of update
     * @return mixed|RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->route('user.index')->with('success',__('User modified successfully.'));
    }

    /**
     * Summary of destroy
     * @return mixed|RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success',__('User deleted successfully.'));
    }
}
