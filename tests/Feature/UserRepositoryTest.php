<?php

namespace Tests\Unit\Repositories;

use App\Http\Repositories\UserRepository;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use InvalidArgumentException;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected $userRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userRepository = new UserRepository(new User);
    }

    /** @test */
    public function test_it_can_store_a_new_user()
    {
        $inputs = [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'is_admin' => 'yes',
        ];

        $user = $this->userRepository->store($inputs);

        $this->assertInstanceOf(User::class, $user);
        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }

    /** @test */
    public function test_it_can_update_an_existing_user()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $inputs = [
            'name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'is_admin' => 'no',
        ];

        $updatedUser = $this->userRepository->update($user, $inputs);

        $this->assertInstanceOf(User::class, $updatedUser);
        $this->assertEquals('Jane Doe', $updatedUser->name);
        $this->assertEquals('jane.doe@example.com', $updatedUser->email);
        $this->assertDatabaseHas('users', ['email' => 'jane.doe@example.com']);
    }

    /** @test */
    public function test_it_throws_exception_when_saving_with_invalid_name()
    {
        $inputs = [
            'name' => 12345,
            'email' => 'john.doe@example.com',
            'is_admin' => 'yes',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Name must be a string.');

        $this->userRepository->store($inputs);
    }

    /** @test */
    public function test_it_throws_exception_when_saving_with_invalid_email()
    {
        $inputs = [
            'name' => 'John Doe',
            'email' => 12345,
            'is_admin' => 'yes',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email must be a string.');

        $this->userRepository->store($inputs);
    }

    /** @test */
    public function test_it_throws_exception_when_updating_with_invalid_email()
    {
        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
        ]);

        $inputs = [
            'name' => 'Jane Doe',
            'email' => 12345,
            'is_admin' => 'yes',
        ];

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Email must be a string.');

        $this->userRepository->update($user, $inputs);
    }
}
