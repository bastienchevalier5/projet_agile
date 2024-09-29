<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{
    /**
     * Summary of index
     *
     * @return View | RedirectResponse
     */
    public function index()
    {
        if (Auth::user()->isAn('admin')) {
            $users = User::all();

            return view('user', compact('users'));
        } else {
            return redirect()->route('accueil')->with('error',__("You don't have the permission to access this page."));
        }

    }

    /**
     * Summary of create
     *
     * @return View | RedirectResponse
     */
    public function create()
    {
        if (Auth::user()->isAn('admin')) {
            $user = new User();

            return view('user_form', compact('user'));
        } else {
            return redirect()->route('accueil')->with('error',__("You don't have the permission to add a user."));
        }

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
     * @return View | RedirectResponse
     */
    public function show(User $user)
    {
        if (Auth::user()->isAn('admin')) {
            return view('detail_user', compact('user'));
        } else {
            return redirect()->route('accueil')->with('error',__("You don't have the permission to access this page."));
        }

    }

    /**
     * Summary of edit
     *
     * @return View | RedirectResponse
     */
    public function edit(User $user)
    {
        if (Auth::user()->isAn('admin')) {
            $users = User::all();

            return view('user_form', compact('user'));
        } else {
            return redirect()->route('accueil')->with('error',__("You don't have the permission to edit a user."));
        }

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
