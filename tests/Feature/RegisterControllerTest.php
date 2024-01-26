<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterControllerTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**@test */
    public function it_return_all_registers()
    {
        $user = User::factory()->create();
        $response = $this->getJson('/api/register');

        $response->assertStatus(200)
                 ->assertJson([
                    'status' => 200,
                    'registers' => [
                        [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ]
                    ]
                ]);
    }

    /**@test */
    public function it_validates_required_fields()
    {
        $response = $this->postJson('/api/register');
        $response->assertStatus(422)
                 ->assertJsonValidationErrorFor(['name', 'email', 'password']);
    }
}
