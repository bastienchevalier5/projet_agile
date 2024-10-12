<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AccueilControllerTest extends TestCase
{
    /**
     * Test that the index method returns the correct view.
     *
     * @return void
     */
    public function test_acceuil_page_is_accessible()
    {
        $user = User::factory()->create();

        $this->actingAs($user);
        $response = $this->actingAs($user)->get(route('accueil'));

        $response->assertStatus(status: 200);
        $response->assertViewIs('index');
    }
}
