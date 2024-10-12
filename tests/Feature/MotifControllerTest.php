<?php

namespace Tests\Feature;

use App\Models\Motif;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MotifControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create();
        Bouncer::assign('admin')->to($this->admin);

        $this->user = User::factory()->create();
        Bouncer::assign('salarie')->to($this->user);

        $this->motif = Motif::factory()->create();

        Bouncer::allow('admin')->to([
            'create-motifs',
            'view-motifs',
            'edit-motifs',
            'delete-motifs',
        ]);
    }

    /** @test */
    public function test_admin_can_access_index()
    {
        $response = $this->actingAs($this->admin)->get(route('motif.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lists');
    }

    /** @test */
    public function test_non_admin_user_cannot_access_index()
    {
        $response = $this->actingAs($this->user)->get(route('motif.index'));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to access this page."));
    }

    /** @test */
    public function test_admin_can_create_motif()
    {
        $response = $this->actingAs($this->admin)->get(route('motif.create'));

        $response->assertStatus(200);
        $response->assertViewIs('motif_form');
    }

    /** @test */
    public function test_non_admin_user_cannot_create_motif()
    {
        $response = $this->actingAs($this->user)->get(route('motif.create'));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to add a reason."));
    }

    /** @test */
    public function test_admin_can_store_motif()
    {
        $motifData = [
            'Libelle' => 'Test Motif',
        ];

        $response = $this->actingAs($this->admin)->post(route('motif.store'), $motifData);

        $this->assertDatabaseHas('motifs', $motifData);
        $response->assertRedirect(route('motif.index'));
        $response->assertSessionHas('success', __('Reason created successfully.'));
    }

    /** @test */
    public function test_admin_can_show_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('motif.show', $motif));

        $response->assertStatus(200);
        $response->assertViewIs('detail_motif');
        $response->assertViewHas('motif', $motif);
    }

    /** @test */
    public function test_non_admin_user_cannot_show_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->user)->get(route('motif.show', $motif));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to access this page."));
    }

    /** @test */
    public function test_admin_can_edit_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->admin)->get(route('motif.edit', $motif));

        $response->assertStatus(200);
        $response->assertViewIs('motif_form');
        $response->assertViewHas('motif', $motif);
    }

    /** @test */
    public function test_non_admin_user_cannot_edit_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->user)->get(route('motif.edit', $motif));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to edit a reason."));
    }

    /** @test */
    public function test_admin_can_update_motif()
    {
        $motif = Motif::factory()->create(['Libelle' => 'Old Name']);

        $response = $this->actingAs($this->admin)->put(route('motif.update', $motif), ['Libelle' => 'New Name']);

        $this->assertDatabaseHas('motifs', ['Libelle' => 'New Name']);
        $response->assertRedirect(route('motif.index'));
        $response->assertSessionHas('success', __('Reason modified successfully.'));
    }

    /** @test */
    public function test_admin_can_delete_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('motif.destroy', $motif));
        $response->assertRedirect(route('motif.index'));
        $response->assertSessionHas('success', __('Reason deleted successfully.'));
    }

    /** @test */
    public function test_non_admin_user_cannot_delete_motif()
    {
        $motif = Motif::factory()->create();

        $response = $this->actingAs($this->user)->delete(route('motif.destroy', $motif));

        $response->assertRedirect(route('motif.index'));
        $response->assertSessionHas('error', __("You don't have the permission to delete this reason."));
    }
}
