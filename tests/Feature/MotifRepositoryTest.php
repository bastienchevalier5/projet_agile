<?php

namespace Tests\Unit\Repositories;

use App\Http\Repositories\MotifRepository;
use App\Models\Motif;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class MotifRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $motifRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->motifRepository = new MotifRepository(new Motif);
    }

    /** @test */
    public function test_it_can_store_a_new_motif()
    {
        $inputs = [
            'Libelle' => 'Congé annuel',
        ];

        $motif = $this->motifRepository->store($inputs);

        $this->assertInstanceOf(Motif::class, $motif);
        $this->assertDatabaseHas('motifs', ['Libelle' => 'Congé annuel']);
    }

    /** @test */
    public function test_it_can_update_an_existing_motif()
    {
        $motif = Motif::factory()->create([
            'Libelle' => 'Congé annuel',
        ]);

        $inputs = [
            'Libelle' => 'Congé maladie',
        ];

        $updatedMotif = $this->motifRepository->update($motif, $inputs);

        $this->assertInstanceOf(Motif::class, $updatedMotif);
        $this->assertEquals('Congé maladie', $updatedMotif->Libelle);
        $this->assertDatabaseHas('motifs', ['Libelle' => 'Congé maladie']);
    }

    /** @test */
    public function test_it_throws_exception_when_saving_with_invalid_libelle()
    {
        $inputs = [
            'Libelle' => 12345,
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Libelle must be a string.');

        $this->motifRepository->store($inputs);
    }

    /** @test */
    public function test_it_throws_exception_when_updating_with_invalid_libelle()
    {
        $motif = Motif::factory()->create([
            'Libelle' => 'Congé annuel',
        ]);

        $inputs = [
            'Libelle' => null,
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Libelle must be a string.');

        $this->motifRepository->update($motif, $inputs);
    }
}
