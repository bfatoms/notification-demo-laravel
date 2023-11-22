<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
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

        $response->assertSee('token');
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

        // password is hidden in the App\Models\User::class so we need to add it manually
        $user['password'] = $user['confirm_password'];

        $user['force500'] = 1;

        $response = $this->post('api/auth/register', $user);

        $response->assertStatus(500);

        $response->assertSee('Wooops! Something went wrong');
    }

    public function test_user_can_login()
    {
        $user = User::factory()->create();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(200);

        $response->assertSee('token');
    }

    public function test_invalid_credential_on_login_should_error()
    {
        $user = User::factory()->create();

        $response = $this->post('api/auth/login', [
            'email' => $user->email,
        ]);

        $response->assertStatus(422);

        $response->assertSee('The password field is required.');
    }

    public function test_user_profile()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('api/auth/profile', [], ['Bearer' => $user->createToken('authToken')->plainTextToken]);

        $response->assertSee('User profile retrieved successfully');
    }


    public function test_can_index_user_settings()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        UserSetting::factory(5)->create(['user_id' => $user->id]);

        $response = $this->get('api/auth/settings', [], ['Bearer' => $user->createToken('authToken')->plainTextToken]);

        $response->assertStatus(200);

        $response->assertSee('Settings retrieved successfully');

        $response->assertSee('current_page');

        $response->assertJsonFragment(['total' => 5]);
    }

    public function test_can_update_user_settings()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $setting = UserSetting::factory()->create([
            'user_id' => $user->id,
            'name' => 'email_notifications',
            'value' => 'off',
        ]);

        $response = $this->put("api/auth/settings/{$setting->id}", [
                'name' => 'email_notifications',
                'value' => 'on',
            ],
            ['Bearer' => $user->createToken('authToken')->plainTextToken]
        );

        $response->assertStatus(200);

        $response->assertSee('Settings updated successfully');

        // $response->assertSee('current_page');
    }
}
