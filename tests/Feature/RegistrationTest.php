<?php

namespace Tests\Feature;

use App\Enums\ResponseMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use WithFaker;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration()
    {
     
        DB::beginTransaction();
        $response = $this->postJson('/api/register', [
            'email' => $this->faker->email(),
            'password' => 'password'
        ]);
        return $response->assertJsonStructure([
            'message'
        ])->assertStatus(Response::HTTP_CREATED);
    }

    public function test_registration_invalid_email()
    {
     
        DB::beginTransaction();
        $response = $this->postJson('/api/register', [
            'email' => $this->faker->name(),
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->assertEquals($response['errors']['email'][0], ResponseMessage::error['email_invalid']);
    }

    public function test_registration_no_email()
    {
     
        DB::beginTransaction();
        $response = $this->postJson('/api/register', [
            'email' => null,
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->assertEquals($response['errors']['email'][0], ResponseMessage::error['email_required']);
    }

    public function test_registration_no_password()
    {
     
        DB::beginTransaction();
        $response = $this->postJson('/api/register', [
            'email' => $this->faker->email(),
            'password' => null
        ]);
        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->assertEquals($response['errors']['password'][0], ResponseMessage::error['password_required']);
    }

    public function test_registration_existing_email()
    {
     
        DB::beginTransaction();
        $user = User::factory()->create([
            'email' => $this->faker->email(),
            'password' => 'password'
        ]);
        $response = $this->postJson('/api/register', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'message'
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
        return $this->assertEquals($response['message'], ResponseMessage::error['email_unique']);
    }
}
