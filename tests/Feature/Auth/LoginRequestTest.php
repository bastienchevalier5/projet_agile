<?php

namespace Tests\Unit\Requests\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class LoginRequestTest extends TestCase
{
    /** @test */
    public function test_it_authorizes_the_request()
    {
        $request = new LoginRequest;
        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function test_it_validates_required_email_and_password()
    {
        $inputs = ['email' => '', 'password' => ''];
        $request = new LoginRequest;
        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ email est obligatoire.', $validator->errors()->first('email'));
        $this->assertEquals('Le champ password est obligatoire.', $validator->errors()->first('password'));
    }

    /** @test */
    public function test_it_validates_email_format()
    {
        $inputs = ['email' => 'invalid-email', 'password' => 'password123'];
        $request = new LoginRequest;
        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ email doit être une adresse e-mail valide.', $validator->errors()->first('email'));
    }

    /** @test */
    public function test_it_authenticates_valid_credentials()
    {
        Auth::shouldReceive('attempt')
            ->once()
            ->with(['email' => 'test@example.com', 'password' => 'password'], false)
            ->andReturn(true);

        RateLimiter::shouldReceive('clear')->once();
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(false);

        $request = LoginRequest::create('/login', 'POST', [
            'email' => 'test@example.com',
            'password' => 'password',
            'remember' => false,
        ]);

        $request->authenticate();
        $this->assertTrue(true);
    }

    /** @test */
    public function test_it_fails_authentication_with_invalid_credentials()
    {
        Auth::shouldReceive('attempt')->once()->andReturn(false);
        RateLimiter::shouldReceive('hit')->once();
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(false);

        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Ces identifiants ne correspondent pas à nos enregistrements.');

        $request = LoginRequest::create('/login', 'POST', [
            'email' => 'invalid@example.com',
            'password' => 'wrongpassword',
        ]);

        $request->authenticate();
    }

    /** @test */
    public function test_it_ensures_request_is_not_rate_limited()
    {
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(false);

        $request = new LoginRequest;
        $request->ensureIsNotRateLimited();

        $this->assertTrue(true);
    }

    /** @test */
    public function test_it_throttles_when_rate_limited()
    {
        Event::fake();
        RateLimiter::shouldReceive('tooManyAttempts')->once()->andReturn(true);
        RateLimiter::shouldReceive('availableIn')->once()->andReturn(60);
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Tentatives de connexion trop nombreuses. Veuillez essayer de nouveau dans 60 secondes.');

        $request = new LoginRequest;
        $request->ensureIsNotRateLimited();

        Event::assertDispatched(Lockout::class);
    }

    /** @test */
    public function test_it_generates_the_correct_throttle_key()
    {
        $request = LoginRequest::create('/login', 'POST', ['email' => 'test@example.com']);
        $request->setLaravelSession(app('session')->driver());
        $request->server->set('REMOTE_ADDR', '127.0.0.1');

        $this->assertEquals('test@example.com|127.0.0.1', $request->throttleKey());
    }
}
