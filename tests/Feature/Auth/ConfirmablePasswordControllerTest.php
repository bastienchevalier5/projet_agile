<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConfirmablePasswordControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_user_must_be_authenticated_to_confirm_password()
    {
        $response = $this->get(route('password.confirm'), [
            'password' => 'somepassword',
        ]);

        $response->assertRedirect(route('login'));
    }
}
