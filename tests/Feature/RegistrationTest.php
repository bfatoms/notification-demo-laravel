<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    // add application/json to header so that the tests will return json always even for errors
    public function setup () : void
    {
        parent::setup();

        $this->withHeader('Accept', 'application/json');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_register()
    {
        $user = User::factory()->unverified()->plainPass()->make()->toArray();

        $user['password'] = $user['confirm_password'];

        $response = $this->post(
            'api/auth/register',
            $user
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'email' => $user['email'],
        ]);

        $response->assertSee('accessToken');
    }

    public function test_empty_password_upon_register_should_error()
    {
        $user = User::factory()->unverified()->plainPass()->make()->toArray();

        $response = $this->post(
            'api/auth/register',
            $user
        );

        $response->assertStatus(422);

        $response->assertSee('The password field is required');
    }

    public function test_cannot_register_should_error()
    {
        $user = User::factory()->unverified()->plainPass()->make()->toArray();

        $user['password'] = $user['confirm_password'];

        $response = $this->post(
            'api/auth/register',
            $user
        );

        $response->assertStatus(500);

        $response->assertSee('Wooops! Something went wrong');
    }
}
