<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Summary of switchLang
     *
     * @param  mixed  $lang
     *
     * @return mixed|\Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        Session::put('langue', $lang);

        return redirect()->back();
    }
}
