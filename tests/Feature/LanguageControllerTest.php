<?php

namespace Tests\Unit;

use App\Http\Controllers\LanguageController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class LanguageControllerTest extends TestCase
{
    public function testSwitchLang()
    {
        $controller = new LanguageController;

        $response = $controller->switchLang('en');

        $this->assertEquals('en', Session::get('langue'));

        $this->assertInstanceOf(RedirectResponse::class, $response);
    }
}
