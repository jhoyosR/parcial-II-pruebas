<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class IntegrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_connect_to_database()
    {
        $count = User::count();
        $this->assertIsInt($count);
    }


    public function test_users_persists_data()
    {
        $user = User::factory()->create();

        $this->postJson("/api/users", [
            'name' => $user->name,
            'email' => $user->email
        ])->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
        ]);
    }
}