<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_has_absences()
    {
        $user = User::factory()->create();

        $absence1 = Absence::factory()->create(['user_id' => $user->id]);
        $absence2 = Absence::factory()->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->absences);
        $this->assertTrue($user->absences->contains($absence1));
        $this->assertTrue($user->absences->contains($absence2));
    }
}
