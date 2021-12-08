<?php

namespace Tests\Feature;

use App\Enums\ResponseMessage;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);
        DB::rollBack();
        return $response->assertJsonStructure([
            'access_token'
        ])->assertStatus(Response::HTTP_CREATED);
    }

    public function test_login_invalid_credentials()
    {
        DB::beginTransaction();
        $response = $this->postJson('/api/login', [
            'email' => 'sample@sample.com',
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'message'
        ])->assertStatus(Response::HTTP_UNAUTHORIZED);
        return $this->assertEquals($response['message'], ResponseMessage::error['login']);
    }

    public function test_login_no_email()
    {
        DB::beginTransaction();
        $response = $this->postJson('/api/login', [
            'email' => null,
            'password' => 'password'
        ]);
        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->assertEquals($response['errors']['email'][0], ResponseMessage::error['email_required']);
    }

    public function test_login_no_password()
    {
        DB::beginTransaction();
        $user = User::factory()->create();
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => null
        ]);
        $response->assertJsonStructure([
            'message',
            'errors'
        ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        return $this->assertEquals($response['errors']['password'][0], ResponseMessage::error['password_required']);
    }
}
