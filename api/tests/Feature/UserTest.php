<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_create_users () {
        // Arrange
        $user = [
            'name' => 'User test',
            'username' => 'usertest',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/users', $user);

        // Assert
        $response->assertUnauthorized();
    }
    
    /** @test */
    public function an_authenticated_user_can_create_a_user () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = [
            'name' => 'User test',
            'username' => 'usertest',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->actingAs($user_auth)->postJson('/api/users', $user);

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'name' => 'User test',
            'username' => 'usertest',
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_retrieve_single_user () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user_auth)->getJson("/api/users/{$user->id}");

        // Assert
        $response->assertOk();
        $response->assertJson([
            'user' =>  [
                'id' => $user->id,
                'name' => $user->name,
                'username' => $user->username
            ]
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_update_user () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = User::factory()->create();
        $newData = [
            'name' => 'New user',
            'username' => 'New username',
            'password' => ''
        ];

        // Act
        $response = $this->actingAs($user_auth)->putJson("/api/users/{$user->id}", $newData);

        // Assert
        $response->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => 'New user',
            'username' => 'New username',
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_delete_user () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user_auth)->deleteJson("/api/users/{$user->id}");

        // Assert
        $response->assertOk();
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    /** @test */
    public function an_user_requires_name_username_and_password () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = [
            'name' => '',
            'username' => '',
            'password' => '',
            'password_confirmation' => ''
        ];

        // Act
        $response = $this->actingAs($user_auth)->postJson('/api/users', $user);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'name',
                'username',
                'password',
            ]
        ]);
    }
    
    /** @test */
    public function an_user_username_and_password_requires_a_min_length () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = [
            'name' => 'User test',
            'username' => 'te',
            'password' => 'pass',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->actingAs($user_auth)->postJson('/api/users', $user);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username',
                'password',
            ]
        ]);
    }
    
    /** @test */
    public function a_new_user_username_must_be_unique () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = User::factory()->create([
            'username' => 'usertest',
        ]);
        $new_user = [
            'name' => 'User test',
            'username' => 'usertest',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->actingAs($user_auth)->postJson('/api/users', $new_user);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username',
            ]
        ]);
    }
    
    /** @test */
    public function update_user_username_must_be_unique () {
        // Arrange
        $user_auth = User::factory()->create();
        User::factory()->create([
            'username' => 'usertest',
        ]);
        $user = User::factory()->create([
            'username' => 'user_test',
        ]);
        $update_user = [
            'name' => 'User test',
            'username' => 'usertest',
        ];

        // Act
        $response = $this->actingAs($user_auth)->putJson("/api/users/{$user->id}", $update_user);
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username'
            ]
        ]);
    }
    
    /** @test */
    public function password_must_be_confirmed () {
        // Arrange
        $user_auth = User::factory()->create();
        $user = [
            'name' => 'User test',
            'username' => 'usertest',
            'password' => 'password',
            'password_confirmation' => 'pass'
        ];

        // Act
        $response = $this->actingAs($user_auth)->postJson('/api/users', $user);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'password'
            ]
        ]);
    }
}