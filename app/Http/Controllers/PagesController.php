<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function pages($a): string{
            return 'Je suis à la page '.$a;
    }
}
