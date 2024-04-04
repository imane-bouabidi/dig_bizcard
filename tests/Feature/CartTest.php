<?php

namespace Tests\Feature;

use App\Models\CarteVisite;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CartTest extends TestCase
{
    public function testIndex()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->get('/api/index');
        
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $carteData = [
            'nom' => 'John Doe',
            'tel' => '123-456-7890',
            'entreprise' => 'XYZ Company',
            'titre' => 'CEO',
            'coordonnees' => '123 Main Street, City, Country',
            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'
        ];

        $response = $this->post('/api/cartes_visites', $carteData);
        $response->assertStatus(201);
    }

    public function testDestroy()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $carte = CarteVisite::factory()->create(['user_id' => $user->id]);

        $response = $this->delete('/api/cartes-visites/'.$carte->id);
        $response->assertStatus(204);
    }

    public function testUpdate()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $carte = CarteVisite::factory()->create(['user_id' => $user->id]);

        $newCarteData = [
            'nom' => 'Jane Doe',
            'tel' => '987-654-3210',
            'entreprise' => 'ABC Company',
            'titre' => 'CTO',
            'coordonnees' => '456 Oak Street, City, Country',
            'description' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium.'
        ];

        $response = $this->post('/api/cartes-visites/'.$carte->id, $newCarteData);
        $response->assertStatus(200);
    }

   
}
