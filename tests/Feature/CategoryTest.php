<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Category;

class CategoryTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_category()
    {
        $data = [
            'name' => 'ropa',
            'description' => 'Ropa de alta calidad',
        ];
        $response = $this->post('/api/categories', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('categories', [
            'name' => 'ropa',
            'description' => 'Ropa de alta calidad',
        ]);

    }

    public function test_user_can_show_category(){
        $category = Category::create([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
        $response = $this->get('/api/categories/'.$category->id);
        $response->assertStatus(200);
        $response->assertJson([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
    }

    public function test_user_can_update_category(){
        $category = Category::create([
            'name' => 'Tecnologia',
            'description' => 'Elementos tecnológicos de alta calidad'
        ]);
        $updateData = [
            'name' => 'Tecnologia',
            'description' => 'Tecnología de punta'
        ];
        $response = $this->put('/api/categories/'.$category->id, $updateData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('categories', [
            'name' => 'Tecnologia',
            'description' => 'Tecnología de punta'
        ]);
    }

    public function test_user_can_delete_category(){
        $category = Category::create([
            'name' => 'Ropa',
            'description' => 'Prendas totalmente originales'
        ]);
        $response = $this->delete('/api/categories/'.$category->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
            #'name' => 'Gafas'
        ]);
    }

}
