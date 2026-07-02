<?php

namespace Tests\Feature;

use App\Models\Contacts;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class ContactsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();

        $user = User::factory()->create();
        $this->actingAs($user, 'sanctum');
    }

    public function test_crear_contactos(): void
    {
        $this->postJson('api/contacts', [
            'name' => fake()->firstName(),
            'email' => 'hernandez@example.com',
        ]);

        $this->assertDatabaseHas('contacts', [
            'name' => 'Breiner',
        ]);
    }

    public function test_listar_contactos(): void
    {
        Contacts::factory()->create(5);
        $response = $this->getjson('/api/contacts');
        $response->assertStatus(200);
    }
    public function test_actualizar_contactos(): void
    {
        $contactos = Contacts::factory()->create();
        $response = $this->putJson('/api/contacts'.$contactos->id,[
            'name' => 'carlos'
        ]);
        $response ->assertStatus(200);
        $this->assertDatabaseHas('contacts',[
            'id' => $contactos -> id,
            'name' => 'carlos'
        ]);
    }
    public function test_eliminar_contactos(): void
    {
        $contactos = Contacts::factory()->create();
        $response = $this->deleteJson('/api/contacts'.$contactos->id);
        $response->assertStatus(200);
    
    $this->assertDatabaseMissing('contacts',[
        'id'=>$contactos->id
    ]);
    }
}