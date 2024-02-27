<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;
use App\Models\User;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_can_register_user () {
        // Arrange
        $user = [
            'name' => 'User test',
            'username' => 'usertest',
            'password' => 'password',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/register', $user);

        // Assert
        $response->assertOk();

        $this->assertDatabaseHas('users', [
            'name' => 'User test',
            'username' => 'usertest',
        ]);

        $response->assertJsonStructure([
            'message',
            'access_token'
        ]);
    }
    
    /** @test */
    public function guest_can_login () {
        // Arrange
        $user_auth = User::factory()->create([
            'username' => 'user_auth',
            'password' => Hash::make('password')
        ]);
        $credentials = [
            'username' => 'user_auth',
            'password' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/login', $credentials);

        // Assert
        $response->assertOk();
        $response->assertJsonStructure([
            'access_token'
        ]);
    }

    /** @test */
    public function an_authenticated_user_can_check_auth () {
        // Arrange
        $user = User::factory()->create();

        // Act
        $response = $this->actingAs($user)->getJson('/api/check');

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
    public function an_authenticated_user_can_logout () {
        // Arrange
        $user = User::factory()->create([
            'username' => 'user_auth',
            'password' => Hash::make('password')
        ]);
        $credentials = [
            'username' => 'user_auth',
            'password' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/login', $credentials);
        $response = $this->actingAs($user)->postJson('/api/logout');

        // Assert
        $response->assertOk();
        $response->assertJsonStructure([
            'message'
        ]);
    }

    /** @test */
    public function register_requires_name_username_and_password () {
        // Arrange
        $user = [
            'name' => '',
            'username' => '',
            'password' => '',
            'password_confirmation' => ''
        ];

        // Act
        $response = $this->postJson('/api/register', $user);

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
    public function login_requires_username_and_password () {
        // Arrange
        $credentials = [
            'username' => '',
            'password' => ''
        ];

        // Act
        $response = $this->postJson('/api/login', $credentials);

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
    public function register_username_must_be_unique () {
        // Arrange
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
        $response = $this->postJson('/api/register', $new_user);

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
    public function login_username_must_exist () {
        // Arrange
        $user_auth = User::factory()->create([
            'username' => 'user_auth',
            'password' => Hash::make('password')
        ]);
        $credentials = [
            'username' => 'userauth',
            'password' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/login', $credentials);

        // Assert
        $response->assertUnprocessable();
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'username'
            ]
        ]);
    }

    /** @test */
    public function register_username_and_password_requires_a_min_length () {
        // Arrange
        $user = [
            'name' => 'User test',
            'username' => 'te',
            'password' => 'pass',
            'password_confirmation' => 'password'
        ];

        // Act
        $response = $this->postJson('/api/register', $user);

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
    public function login_username_and_password_requires_a_min_length () {
        // Arrange
        $user = [
            'username' => 'te',
            'password' => 'pass',
        ];

        // Act
        $response = $this->postJson('/api/login', $user);

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
    public function guest_can_not_check_auth () {
        // Arrange

        // Act
        $response = $this->getJson('/api/check');

        // Assert
        $response->assertUnauthorized();
    }
    
    /** @test */
    public function guest_can_not_logout () {
        // Arrange

        // Act
        $response = $this->postJson('/api/logout');

        // Assert
        $response->assertUnauthorized();
    }
}