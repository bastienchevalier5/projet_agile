<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Repositories\UserRepository;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Auth;
use Bouncer;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Silber\Bouncer\Database\Role;

class UserController extends Controller
{
    /**
     * Summary of repository
     *
     * @var UserRepository
     */
    private $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Summary of index
     *
     * @return View | RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            $users = User::all();

            return view('lists', compact('users'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to access this page."));
    }

    /**
     * Summary of create
     *
     * @return View | RedirectResponse
     */
    public function create()
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            $user = new User();
            $roles = Role::all();
            $userRole = $user->roles->first()->id ?? null;
            return view('user_form', compact('user','roles', 'userRole'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to add a user."));
    }

    /**
     * Summary of store
     *
     * @return RedirectResponse
     */
    public function store(UserRequest $request)
    {
        $user = $this->repository->store($request->all());

        return redirect()->route('user.index')->with('success', __('User created successfully.'));
    }

    /**
     * Summary of show
     *
     * @return View | RedirectResponse
     */
    public function show(User $user)
    {
        $authUser = Auth::user();

        if ($authUser && $authUser->isAn('rh')) {
            return view('detail_user', compact('user'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to access this page."));
    }

    /**
     * Summary of edit
     *
     * @return View | RedirectResponse
     */
    public function edit(User $user)
    {
        $authUser = Auth::user();

        if ($authUser && $authUser->isAn('rh')) {
            $users = User::all();
            $roles = Role::all();
            $userRole = $user->roles->first()->id ?? null;
            return view('user_form', compact('user', 'roles', 'userRole'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to edit a user."));
    }

    /**
     * Summary of update
     *
     * @return mixed|RedirectResponse
     */
    public function update(UserRequest $request, User $user)
    {
        $this->repository->update($user, $request->all());

        return redirect()->route('user.index')->with('success', __('User modified successfully.'));
    }

    /**
     * Summary of destroy
     *
     * @return mixed|RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('user.index')->with('success', __('User deleted successfully.'));
    }
}
