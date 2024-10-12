<?php

namespace Tests\Unit;

use App\Http\Repositories\AbsenceRepository;
use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use InvalidArgumentException;
use Tests\TestCase;

class AbsenceRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $absenceRepository;

    protected $user;

    protected $adminUser;

    protected $motif;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
        $this->adminUser = User::factory()->create();
        $this->adminUser->assign('admin');

        $this->motif = Motif::factory()->create();

        $this->absenceRepository = new AbsenceRepository(new Absence);
    }

    /** @test */
    public function test_it_can_update_an_absence()
    {
        Mail::fake();

        $absence = Absence::factory()->create([
            'user_id' => $this->user->id,
            'motif_id' => $this->motif->id,
        ]);

        $data = [
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => $absence->motif_id,
            'user_id' => $this->user->id,
        ];

        $updatedAbsence = $this->absenceRepository->update($absence, $data, $this->user);

        $this->assertEquals('2024-07-01', $updatedAbsence->debut);
        $this->assertEquals('2024-07-05', $updatedAbsence->fin);

        $this->assertDatabaseHas('absences', [
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => $absence->motif_id,
        ]);
    }

    /** @test */
    public function test_it_throws_exception_when_storing_invalid_data()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Debut and Fin fields are required.');

        $data = [];
        $this->absenceRepository->store($data, $this->user);
    }

    /** @test */
    public function test_it_throws_exception_when_user_id_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('User ID must be a valid integer.');

        $data = [
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => $this->motif->id,
        ];

        $this->absenceRepository->store($data, $this->user);
    }

    /** @test */
    public function test_it_throws_exception_when_debut_and_fin_are_not_strings()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Debut and Fin must be strings.');

        $data = [
            'debut' => 123,
            'fin' => 456,
            'motif_id' => $this->motif->id,
            'user_id' => $this->user->id,
        ];

        $this->absenceRepository->store($data, $this->user);
    }

    /** @test */
    public function test_it_throws_exception_when_motif_id_is_not_valid_integer()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Motif ID must be a valid integer.');

        $data = [
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => 'not_an_integer',
            'user_id' => $this->user->id,
        ];

        $this->absenceRepository->store($data, $this->user);
    }

    /** @test */
    public function test_it_can_notify_admins_of_new_absence()
    {
        Mail::fake();

        $absence = Absence::factory()->create([
            'user_id' => $this->user->id,
            'motif_id' => $this->motif->id,
        ]);

        $this->absenceRepository->notifyAdmins($absence);

        Mail::assertSent(MailDemandeAbsence::class, function ($mail) use ($absence) {
            return $mail->absence->is($absence) &&
                   $mail->user->is($absence->user) &&
                   $mail->motif->is($absence->motif);
        });
    }

    /** @test */
    public function test_it_clears_cache_on_store_and_update()
    {
        Cache::put('absences', 'some_value');

        $data = [
            'debut' => '2024-06-10',
            'fin' => '2024-06-15',
            'motif_id' => $this->motif->id,
            'user_id' => $this->user->id,
        ];

        $this->absenceRepository->store($data, $this->user);
        $this->assertNull(Cache::get('absences'));

        $absence = Absence::factory()->create([
            'user_id' => $this->user->id,
            'motif_id' => $this->motif->id,
        ]);

        $this->absenceRepository->update($absence, $data, $this->user);
        $this->assertNull(Cache::get('absences'));
    }
}
