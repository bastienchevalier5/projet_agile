<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class UserRequestTest extends TestCase
{
    /** @test */
    public function test_it_authorizes_the_request()
    {
        $request = new UserRequest;

        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function test_it_validates_required_name()
    {
        $inputs = ['email' => 'test@example.com'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ name est obligatoire.', $validator->errors()->first('name'));
    }

    /** @test */
    public function test_it_validates_name_is_a_string()
    {
        $inputs = ['name' => 12345, 'email' => 'test@example.com'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ name doit être une chaîne de caractères.', $validator->errors()->first('name'));
    }

    /** @test */
    public function test_it_validates_name_max_length()
    {
        $inputs = ['name' => str_repeat('a', 101), 'email' => 'test@example.com'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le texte de name ne peut pas contenir plus de 100 caractères.', $validator->errors()->first('name'));
    }

    /** @test */
    public function test_it_validates_required_email()
    {
        $inputs = ['name' => 'Test User'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ email est obligatoire.', $validator->errors()->first('email'));
    }

    /** @test */
    public function test_it_validates_email_format()
    {
        $inputs = ['name' => 'Test User', 'email' => 'invalid-email'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertEquals('Le champ email doit être une adresse e-mail valide.', $validator->errors()->first('email'));
    }

    /** @test */
    public function test_it_passes_validation_with_valid_inputs()
    {
        $inputs = ['name' => 'Test User', 'email' => 'test@example.com', 'is_admin' => 'yes'];

        $request = new UserRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function test_it_returns_custom_error_messages()
    {
        $request = new UserRequest;

        $this->assertIsArray($request->messages());
    }
}
