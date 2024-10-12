<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\Motif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotifTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_has_absences()
    {
        $motif = Motif::factory()->create();

        $absence1 = Absence::factory()->create(['motif_id' => $motif->id]);
        $absence2 = Absence::factory()->create(['motif_id' => $motif->id]);

        $this->assertCount(2, $motif->absences);
        $this->assertTrue($motif->absences->contains($absence1));
        $this->assertTrue($motif->absences->contains($absence2));
    }
}
