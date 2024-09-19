<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use Illuminate\Contracts\View\View;

class AcceuilController extends Controller
{
    /**
     * Summary of index
     * @return View
     */
    public function index()
    {
        return view('index');
    }
}
