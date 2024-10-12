<?php

namespace Tests\Feature;

use App\Mail\MailDemandeAbsence;
use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class AbsenceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $adminUser;

    protected $salarieUser;

    protected $motif;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::factory()->create();
        Bouncer::assign('admin')->to($this->adminUser);

        $this->salarieUser = User::factory()->create();
        Bouncer::assign('salarie')->to($this->salarieUser);

        $this->motif = Motif::factory()->create();

        Bouncer::allow('admin')->to([
            'create-absences',
            'view-absences',
            'edit-absences',
            'delete-absences',
            'validate-absences',
        ]);

        Bouncer::allow('salarie')->to([
            'create-absences',
            'view-absences',
            'edit-absences',
        ]);
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_accessing_index()
    {
        $response = $this->get(route('absence.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_admin_can_view_all_absences()
    {
        Absence::factory()->count(3)->create(['user_id' => $this->salarieUser->id, 'motif_id' => $this->motif->id]);

        $response = $this->actingAs($this->adminUser)->get(route('absence.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lists');
        $response->assertViewHas('absences');
        $this->assertCount(3, $response->viewData('absences'));
    }

    /** @test */
    public function test_salarie_can_view_only_their_own_absences()
    {
        Absence::factory()->count(2)->create(['user_id' => $this->salarieUser->id, 'motif_id' => $this->motif->id]);

        $otherUser = User::factory()->create();
        Absence::factory()->count(3)->create(['user_id' => $otherUser->id, 'motif_id' => $this->motif->id]);

        $response = $this->actingAs($this->salarieUser)->get(route('absence.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lists');
        $response->assertViewHas('absences');
        $this->assertCount(2, $response->viewData('absences'));
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_accessing_create_form()
    {
        $response = $this->get(route('absence.create'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_authorized_user_can_access_create_absence_form()
    {
        $response = $this->actingAs($this->adminUser)->get(route('absence.create'));

        $response->assertStatus(200);
        $response->assertViewIs('absence_form');
        $response->assertViewHas(['motifs', 'users', 'absence']);
    }

    /** @test */
    public function test_unauthorized_user_cannot_access_create_absence_form()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('absence.create'));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('error', __("You don't have the permission to add an absence."));
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_storing_absence()
    {
        $data = [
            'debut' => '2024-05-01',
            'fin' => '2024-05-05',
            'motif_id' => $this->motif->id,
        ];

        $response = $this->post(route('absence.store'), $data);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_salarie_can_store_absence()
    {
        Mail::fake();

        $data = [
            'debut' => '2024-05-01',
            'fin' => '2024-05-05',
            'motif_id' => $this->motif->id,
        ];

        $response = $this->actingAs($this->salarieUser)->post(route('absence.store'), $data);

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('An email has been sent to the administrators indicating your request'));

        $this->assertDatabaseHas('absences', [
            'debut' => '2024-05-01',
            'fin' => '2024-05-05',
            'motif_id' => $this->motif->id,
            'user_id' => $this->salarieUser->id,
        ]);

        Mail::assertSent(MailDemandeAbsence::class, function ($mail) use ($data) {
            return $mail->absence->debut === $data['debut'] &&
                   $mail->absence->fin === $data['fin'] &&
                   $mail->motif->id === $this->motif->id &&
                   $mail->user->id === $this->salarieUser->id;
        });
    }

    /** @test */
    public function test_admin_can_store_absence_for_any_user()
    {
        Mail::fake();

        $otherUser = User::factory()->create();
        Bouncer::assign('salarie')->to($otherUser);

        $data = [
            'debut' => '2024-06-10',
            'fin' => '2024-06-15',
            'motif_id' => $this->motif->id,
            'user_id' => $otherUser->id,
        ];

        $response = $this->actingAs($this->adminUser)->post(route('absence.store'), $data);

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence created successfully.'));

        $this->assertDatabaseHas('absences', [
            'debut' => '2024-06-10',
            'fin' => '2024-06-15',
            'motif_id' => $this->motif->id,
            'user_id' => $otherUser->id,
        ]);

        Mail::assertSent(MailDemandeAbsence::class, function ($mail) use ($data, $otherUser) {
            return $mail->absence->debut === $data['debut'] &&
                   $mail->absence->fin === $data['fin'] &&
                   $mail->motif->id === $this->motif->id &&
                   $mail->user->id === $otherUser->id;
        });
    }

    /** @test */
    public function test_store_absence_requires_valid_data()
    {
        $data = [
            'debut' => 'invalid-date',
            'fin' => 'invalid-date',
            'motif_id' => 999,
        ];

        $response = $this->actingAs($this->salarieUser)->post(route('absence.store'), $data);

        $response->assertSessionHasErrors(['debut', 'fin', 'motif_id']);
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_viewing_absence()
    {
        $absence = Absence::factory()->create();

        $response = $this->get(route('absence.show', $absence));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_admin_can_view_any_absence()
    {
        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('absence.show', $absence));

        $response->assertStatus(200);
        $response->assertViewIs('detail_absence');
        $response->assertViewHas('absence');
        $this->assertEquals($absence->id, $response->viewData('absence')->id);
    }

    /** @test */
    public function test_salarie_can_view_their_own_absence()
    {
        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->salarieUser)->get(route('absence.show', $absence));

        $response->assertStatus(200);
        $response->assertViewIs('detail_absence');
        $response->assertViewHas('absence');
        $this->assertEquals($absence->id, $response->viewData('absence')->id);
    }

    /** @test */
    public function test_salarie_cannot_view_others_absence()
    {
        $otherUser = User::factory()->create();
        $absence = Absence::factory()->create([
            'user_id' => $otherUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->salarieUser)->get(route('absence.show', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('error', __("You don't have the permission to access this absence."));
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_accessing_edit_form()
    {
        $absence = Absence::factory()->create();

        $response = $this->get(route('absence.edit', $absence));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_admin_can_access_edit_absence_form()
    {
        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('absence.edit', $absence));

        $response->assertStatus(200);
        $response->assertViewIs('absence_form');
        $response->assertViewHas(['motifs', 'users', 'absence']);
    }

    /** @test */
    public function test_salarie_can_access_edit_own_absence()
    {
        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->salarieUser)->get(route('absence.edit', $absence));

        $response->assertStatus(200);
        $response->assertViewIs('absence_form');
        $response->assertViewHas(['motifs', 'users', 'absence']);
    }

    /** @test */
    public function test_salarie_cannot_access_edit_others_absence()
    {
        $otherUser = User::factory()->create();
        $absence = Absence::factory()->create([
            'user_id' => $otherUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $response = $this->actingAs($this->salarieUser)->get(route('absence.edit', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('error', __("You don't have the permission to edit this absence."));
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_updating_absence()
    {
        $absence = Absence::factory()->create();

        $data = [
            'debut' => '2024-07-10',
            'fin' => '2024-07-15',
            'motif_id' => $absence->motif_id,
            'user_id' => $absence->user_id,
        ];

        $response = $this->put(route('absence.update', $absence), $data);

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_admin_can_update_absence()
    {
        Mail::fake();

        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $data = [
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => $this->motif->id,
            'user_id' => $this->salarieUser->id,
        ];

        $response = $this->actingAs($this->adminUser)->put(route('absence.update', $absence), $data);

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence modified successfully.'));

        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
            'debut' => '2024-07-01',
            'fin' => '2024-07-05',
            'motif_id' => $this->motif->id,
            'user_id' => $this->salarieUser->id,
        ]);
    }

    /** @test */
    public function test_salarie_can_update_own_absence()
    {
        Mail::fake();

        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
        ]);

        $data = [
            'debut' => '2024-07-10',
            'fin' => '2024-07-15',
            'motif_id' => $this->motif->id,
            'user_id' => $this->salarieUser->id,
        ];

        $response = $this->actingAs($this->salarieUser)->put(route('absence.update', $absence), $data);

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence modified successfully.'));

        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
            'debut' => '2024-07-10',
            'fin' => '2024-07-15',
            'motif_id' => $this->motif->id,
            'user_id' => $this->salarieUser->id,
        ]);
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_validating_absence()
    {
        $absence = Absence::factory()->create(['statut' => 0]);

        $response = $this->patch(route('absence.validate', $absence));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_salarie_cannot_validate_absence()
    {
        $absence = Absence::factory()->create(['statut' => 0]);

        $response = $this->actingAs($this->salarieUser)->patch(route('absence.validate', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('error', "You don't have the permission to validate this absence.");
    }

    /** @test */
    public function test_admin_can_validate_absence()
    {
        Mail::fake();

        $absence = Absence::factory()->create([
            'user_id' => $this->salarieUser->id,
            'motif_id' => $this->motif->id,
            'statut' => 0,
        ]);

        $response = $this->actingAs($this->adminUser)->patch(route('absence.validate', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence validated successfully.'));

        $absence->refresh();
        $this->assertEquals(1, $absence->statut);
    }

    /** @test */
    public function test_guest_is_redirected_to_login_when_deleting_absence()
    {
        $absence = Absence::factory()->create();

        $response = $this->delete(route('absence.destroy', $absence));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function test_admin_can_delete_absence()
    {
        $absence = Absence::factory()->create(['user_id' => $this->salarieUser->id]);

        $response = $this->actingAs($this->adminUser)->delete(route('absence.destroy', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence deleted successfully.'));

        $this->assertDatabaseMissing('absences', ['id' => $absence->id]);
    }

    /** @test */
    public function test_salarie_cannot_delete_others_absence()
    {
        $otherUser = User::factory()->create();
        $absence = Absence::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($this->salarieUser)->delete(route('absence.destroy', $absence));

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('error', __("You don't have the permission to delete this absence."));
    }

    /** @test */
    public function test_admin_can_invalidate_a_validated_absence()
    {
        $absence = Absence::factory()->create(['statut' => 1]);

        $response = $this->actingAs($this->adminUser)->patch(route('absence.validate', $absence));

        $absence->refresh();
        $this->assertEquals(0, $absence->statut);

        $response->assertRedirect(route('absence.index'));
        $response->assertSessionHas('success', __('Absence removed successfully.'));
    }
}
