<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\MotifRequest;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class MotifRequestTest extends TestCase
{
    /** @test */
    public function test_it_authorizes_the_request()
    {
        $request = new MotifRequest;

        $this->assertTrue($request->authorize());
    }

    /** @test */
    public function test_it_validates_required_libelle()
    {
        $inputs = [];

        $request = new MotifRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());

        $this->assertEquals('Le champ libelle est obligatoire.', $validator->errors()->first('Libelle'));
    }

    /** @test */
    public function test_it_validates_libelle_is_a_string()
    {
        $inputs = ['Libelle' => 12345];

        $request = new MotifRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());

        $this->assertEquals('Le champ libelle doit être une chaîne de caractères.', $validator->errors()->first('Libelle'));
    }

    /** @test */
    public function test_it_validates_libelle_max_length()
    {
        $inputs = ['Libelle' => str_repeat('a', 11)];

        $request = new MotifRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertTrue($validator->fails());

        $this->assertEquals('Le texte de libelle ne peut pas contenir plus de 10 caractères.', $validator->errors()->first('Libelle'));
    }

    /** @test */
    public function test_it_passes_validation_with_valid_inputs()
    {
        $inputs = ['Libelle' => 'ValidLib'];

        $request = new MotifRequest;

        $validator = Validator::make($inputs, $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function test_it_returns_custom_error_messages()
    {
        $request = new MotifRequest;

        $this->assertIsArray($request->messages());
    }
}
