<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class WebsiteControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test index method.
     *
     * @return void
     */
    /** @test */
    public function it_returns_all_websites_in_json_format()
    {
        // Arrange
        $websites = Website::factory()->count(3)->create();

        // Act
        $response = $this->getJson('/api/websites');

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'websites' => $websites->toArray()
            ]);
    }

    /** @test */
    public function it_returns_404_if_no_websites_are_found()
    {
        // Act
        $response = $this->getJson('/api/websites');

        // Assert
        $response->assertStatus(404)
            ->assertJson([
                'status' => 404,
                'message' => 'No record found'
            ]);
    }

    /**
     * Test store method.
     *
     * @return void
     */
    public function testStore()
    {
        $data = [
            'name' => 'Example Website',
            'url' => 'https://example.com'
        ];

        $response = $this->post('/api/websites', $data);

        $response->assertStatus(200)
            ->assertJson([
                'status' => 200,
                'message' => 'Website Added Successfully'
            ]);

        $this->assertDatabaseHas('websites', $data);
    }

    /**
     * Test show method.
     *
     * @return void
     */
    public function testShow()
    {
        $website = Website::factory()->create();

        $response = $this->get("/api/websites/{$website->id}");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'website'
            ]);
    }


}
