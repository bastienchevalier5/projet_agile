<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Repositories\MotifRepository;
use App\Http\Requests\MotifRequest;
use App\Models\Motif;
use Auth;
use Cache;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MotifController extends Controller
{
    /**
     * Summary of repository
     *
     * @var MotifRepository
     */
    private $repository;

    public function __construct(MotifRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Summary of index
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            $motifs = Cache::remember('motifs', 3600, function () {
                return Motif::all();
            });

            return view('lists', compact('motifs'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to access this page."));
    }

    /**
     * Summary of create
     *
     * @return View|RedirectResponse
     */
    public function create()
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            $motif = new Motif();

            return view('motif_form', compact('motif'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to add a reason."));
    }

    /**
     * Summary of store
     *
     * @return RedirectResponse
     */
    public function store(MotifRequest $request)
    {
        $motif = $this->repository->store($request->all());

        return redirect()->route('motif.index')->with('success', __('Reason created successfully.'));
    }

    /**
     * Summary of show
     *
     * @return View | RedirectResponse
     */
    public function show(Motif $motif)
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            return view('detail_motif', compact('motif'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to access this page."));
    }

    /**
     * Summary of edit
     *
     * @return View | RedirectResponse
     */
    public function edit(Motif $motif)
    {
        $user = Auth::user();

        if ($user && $user->can('edit-motifs')) {
            return view('motif_form', compact('motif'));
        }

        return redirect()->route('accueil')->with('error', __("You don't have the permission to edit a reason."));
    }

    /**
     * Summary of update
     *
     * @return mixed|RedirectResponse
     */
    public function update(MotifRequest $request, Motif $motif)
    {
        $this->repository->update($motif, $request->all());

        return redirect()->route('motif.index')->with('success', __('Reason modified successfully.'));
    }

    /**
     * Summary of destroy
     *
     * @return mixed|RedirectResponse
     */
    public function destroy(Motif $motif)
    {
        $user = Auth::user();

        if ($user && $user->isAn('rh')) {
            Cache::forget('motifs');
            $motif->delete();

            return redirect()->route('motif.index')->with('success', __('Reason deleted successfully.'));
        }

        return redirect()->route('motif.index')->with('error', __("You don't have the permission to delete this reason."));
    }
}
