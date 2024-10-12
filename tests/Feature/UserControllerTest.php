<?php

namespace Tests\Feature;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Bouncer;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $repository;

    private $adminUser;

    private $salarieUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = Mockery::mock(UserRepository::class);
        $this->app->instance(UserRepository::class, $this->repository);

        $this->adminUser = User::factory()->create();
        $this->salarieUser = User::factory()->create();
        Bouncer::assign('admin')->to($this->adminUser);
        Bouncer::assign('salarie')->to($this->salarieUser);
        Bouncer::allow('admin')->to([
            'create-users',
            'view-users',
            'edit-users',
            'delete-users',
        ]);
    }

    /** @test */
    public function test_it_displays_user_index_page_for_admin()
    {
        $users = User::factory()->count(5)->create();

        $response = $this->actingAs($this->adminUser)->get(route('user.index'));

        $response->assertStatus(200);
        $response->assertViewIs('lists');
        $response->assertViewHas('users');
    }

    /** @test */
    public function test_it_redirects_non_admin_users_from_index()
    {
        $response = $this->actingAs($this->salarieUser)->get(route('user.index'));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to access this page."));
    }

    /** @test */
    public function test_it_displays_create_user_page_for_admin()
    {
        $response = $this->actingAs($this->adminUser)->get(route('user.create'));

        $response->assertStatus(200);
        $response->assertViewIs('user_form');
    }

    /** @test */
    public function test_it_redirects_non_admin_users_from_create_page()
    {
        $response = $this->actingAs($this->salarieUser)->get(route('user.create'));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to add a user."));
    }

    /** @test */
    public function test_it_stores_a_new_user()
    {
        $this->repository->shouldReceive('store')->once()->andReturn(new User);

        $response = $this->actingAs($this->adminUser)->post(route('user.store'), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => 'password',
            'is_admin' => 'yes',
        ]);

        $response->assertRedirect(route('user.index'));
        $response->assertSessionHas('success', __('User created successfully.'));
    }

    /** @test */
    public function test_it_displays_user_details_for_admin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)->get(route('user.show', $user));

        $response->assertStatus(200);
        $response->assertViewIs('detail_user');
        $response->assertViewHas('user', $user);
    }

    /** @test */
    public function test_it_redirects_non_admin_users_from_user_details_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->salarieUser)->get(route('user.show', $user));

        $response->assertRedirect(route('accueil'));
        $response->assertSessionHas('error', __("You don't have the permission to access this page."));
    }

    /** @test */
    public function test_it_displays_edit_user_page_for_admin()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)->get(route('user.edit', $user));

        $response->assertStatus(200);
        $response->assertViewIs('user_form');
        $response->assertViewHas('user', $user);

        $response = $this->actingAs($this->salarieUser)->get(route('user.edit', $user));

        $response->assertRedirect();
        $response->assertSessionHas('error', __("You don't have the permission to edit a user."));
    }

    /** @test */
    public function test_it_updates_a_user()
    {
        $user = User::factory()->create();

        $this->repository
            ->shouldReceive('update')
            ->once()
            ->withArgs(function ($passedUser, $data) use ($user) {
                return $passedUser->id === $user->id
                    && $data['name'] === 'Updated Name'
                    && $data['email'] === 'updated@example.com';
            })
            ->andReturn($user);

        $response = $this->actingAs($this->adminUser)->put(route('user.update', $user), [
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'is_admin' => 'yes',
        ]);

        $response->assertRedirect(route('user.index'));

        $response->assertSessionHas('success', __('User modified successfully.'));
    }

    /** @test */
    public function test_it_deletes_a_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->adminUser)->delete(route('user.destroy', $user));

        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseMissing('users', ['id' => $user->id]);

        $response->assertSessionHas('success', __('User deleted successfully.'));
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
