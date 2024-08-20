<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Ad;

class AdControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_an_ad()
    {
        $response = $this->postJson('/api/ads', [
            'title' => 'Тестовое объявление',
            'description' => 'Описание тестового объявления',
            'photos' => ['http://example.com/photo1.jpg', 'http://example.com/photo2.jpg'],
            'price' => 100.00,
        ]);

        $response->assertStatus(201)
                 ->assertJsonStructure(['id', 'status']);

        $this->assertDatabaseHas('ads', [
            'title' => 'Тестовое объявление',
            'price' => 100.00,
        ]);
    }

    /** @test */
    public function it_can_get_list_of_ads()
    {
        Ad::factory()->count(3)->create();

        $response = $this->getJson('/api/ads');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['title', 'main_photo', 'price']
                     ]
                 ]);
    }

    /** @test */
    public function it_can_get_a_single_ad()
    {
        $ad = Ad::factory()->create([
            'title' => 'Тестовое объявление',
            'price' => 100.00,
            'photos' => ['http://example.com/photo1.jpg']
        ]);

        $response = $this->getJson('/api/ads/'.$ad->id);

        $response->assertStatus(200)
                 ->assertJson([
                     'title' => 'Тестовое объявление',
                     'price' => 100.00,
                     'main_photo' => 'http://example.com/photo1.jpg',
                 ]);
    }
}
