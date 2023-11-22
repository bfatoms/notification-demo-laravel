<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Notification;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    // add application/json to header so that the tests will return json always even for errors
    public function setup () : void
    {
        parent::setup();

        $user = User::factory()->create();

        $this->actingAs($user);

        $this->withHeaders([
            'Accept' => 'application/json',
            'Bearer' => $user->createToken('authToken')->plainTextToken
        ]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_create_notification()
    {
        $notification = Notification::factory()->make([
            'user_id' => auth()->user()->id
        ])->toArray();

        $response = $this->post(
            'api/notifications',
            $notification
        );

        $response->assertStatus(200);

        $this->assertDatabaseHas('notifications', [
            'user_id' => auth()->user()->id,
        ]);

        $response->assertSee('Notification created successfully');
    }

    public function test_can_update_notification()
    {
        $notification = Notification::factory()->create([
            'user_id' => auth()->user()->id
        ]);

        $response = $this->put(
            "api/notifications/{$notification->id}",
            [ 'status' => 'read' ]
        );

        $response->assertStatus(200);

        $response->assertSee('Notification updated successfully');
    }

    public function test_can_delete_notification()
    {
        $notification = Notification::factory()->create([
            'user_id' => auth()->user()->id
        ]);

        $response = $this->delete("api/notifications/{$notification->id}");

        $response->assertStatus(200);

        $response->assertSee('Notification deleted successfully');
    }

    public function test_can_show_notification()
    {
        $notification = Notification::factory()->create(['user_id' => auth()->user()->id]);

        $response = $this->get("api/notifications/{$notification->id}");

        $response->assertStatus(200);

        $response->assertSee('Notification Found');
    }
}
