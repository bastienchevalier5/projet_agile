<?php

namespace Tests\Unit;

use App\Http\Middleware\SetLocale;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Tests\TestCase;

class SetLocaleTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_sets_the_locale_to_default_when_no_language_in_session()
    {
        $request = Request::create('/some-url');

        $defaultLocale = App::getLocale();

        $middleware = new SetLocale;

        $response = $middleware->handle($request, function ($request) {
            return 'next';
        });

        $this->assertEquals($defaultLocale, App::getLocale());

        $this->assertEquals('next', $response);
    }

    /** @test */
    public function test_it_sets_the_locale_based_on_session_value()
    {
        Session::put('langue', 'fr');

        $request = Request::create('/some-url');

        $middleware = new SetLocale;

        $response = $middleware->handle($request, function ($request) {
            return 'next';
        });

        $this->assertEquals('fr', App::getLocale());

        $this->assertEquals('next', $response);
    }

    /** @test */
    public function test_it_sets_the_locale_to_default_for_invalid_session_value()
    {
        Session::put('langue', 'invalid_locale');

        $request = Request::create('/some-url');

        $defaultLocale = App::getLocale();

        $middleware = new SetLocale;

        $response = $middleware->handle($request, function ($request) {
            return 'next';
        });

        $this->assertEquals($defaultLocale, App::getLocale());

        $this->assertEquals('next', $response);
    }
}
