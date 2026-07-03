<?php
namespace Tests\Feature;


use GuzzleHttp\Promise\Create;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Attributes\Validate;
use Tests\TestCase;
use App\Models\Contacts;
use App\Models\User;


class ContactoTest extends TestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }
    public function test_register()
    {
        $datos = [
            'name' => fake()->firstName(),
            'email' => fake()->safeEmail(),
            'password' => '12345678',
            'password_confirmation' => '12345678'
        ];
        $response = $this->postJson('/register', $datos);
        $response->assertStatus(201);
        $response->assertJson([
            'success' => true,
            'message' => 'Usuario registrado con exito',
        ]);
        $this->assertDatabaseHas('users', [
            'email' => $datos['email']
        ]);
    }

    public function test_example()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }
}
