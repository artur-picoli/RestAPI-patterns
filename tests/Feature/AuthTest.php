<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_user()
    {
        $this->postJson('/api/registrar', [
            'name' => $name =  fake()->name(),
            'email' => $email = fake()->email(),
            'password' => 'Senha@123',
        ])->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'access_token',
                    'token_type',
                ],
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $name,
            'email' => $email,
        ]);
    }

    public function test_login_user()
    {
        $user = User::factory()->create(
            ['password' => 'Senha@123']
        );


        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'Senha@123',
        ])->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'access_token',
                    'token_type',
                ],
            ]);

        $this->assertCount(1, $user->tokens);

        $this->assertDatabaseHas('users', [
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function test_login_authentication_failure()
    {

        $user = User::factory()->create(
            ['password' => 'Senha@123']
        );


        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => '111111111',
        ])->assertStatus(401)
            ->assertJson([
                'message' => 'Usuário ou senha inválidos.'
            ]);

        $this->assertCount(0, $user->tokens);
    }

    public function test_logout_user()
    {
        $user = User::factory()->create(
            ['password' => 'Senha@123']
        );

        Sanctum::actingAs($user);

        $this->postJson('/api/logout')->assertNoContent();

        $this->assertCount(0, $user->tokens);
    }
}
