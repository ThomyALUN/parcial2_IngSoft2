<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Product;
use App\Models\Category;

class ProductTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_product()
    {
        $category = Category::create([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
        $data = [
            'category_id' => $category->id,
            'name' => 'Laptop',
            'selling_price' => 2000,
            'buying_price' => 1000,
            'stock' => 4,
            'description' => 'Computadora con las 3b'
        ];
        $response = $this->post('/api/products', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'name' => 'Laptop',
            'selling_price' => 2000,
            'buying_price' => 1000,
            'stock' => 4,
            'description' => 'Computadora con las 3b'
        ]);

    }

    public function test_user_can_show_product(){
        $category = Category::create([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Camiseta',
            'selling_price' => 4000,
            'buying_price' => 2000,
            'stock' => 1,
            'description' => 'Camiseta Nike'
        ]);
        $response = $this->get('/api/products/'.$product->id);
        $response->assertStatus(200);
        $response->assertJson([
          
                'category_id' => $category->id,
                'name' => 'Camiseta',
                'selling_price' => 4000,
                'buying_price' => 2000,
                'stock' => 1,
                'description' => 'Camiseta Nike'
            
        ]);
    }

    public function test_user_can_update_product(){
        $category = Category::create([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Silla',
            'selling_price' => 10000,
            'buying_price' => 3000,
            'stock' => 20,
            'description' => 'Silla super cómoda'
        ]);
        $updateData = [
            'category_id' => $category->id,
            'name' => 'Silla Rimax',
            'selling_price' => 20000,
            'buying_price' => 4000,
            'stock' => 19,
            'description' => 'Silla super comodísima'
        ];
        $response = $this->put('/api/products/'.$product->id, $updateData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('products', [
            'category_id' => $category->id,
            'name' => 'Silla Rimax',
            'selling_price' => 20000,
            'buying_price' => 4000,
            'stock' => 19,
            'description' => 'Silla super comodísima'
        ]);
    }

    public function test_user_can_delete_product(){
        $category = Category::create([
            'name' => 'muebles',
            'description' => 'Muebles para tú casa',
        ]);
        $product = Product::create([
            'category_id' => $category->id,
            'name' => 'Pantalón',
            'selling_price' => 140000,
            'buying_price' => 100000,
            'stock' => 8,
            'description' => 'Pantalon super bueno'
        ]);
        $response = $this->delete('/api/products/'.$product->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('products', [
            'id' => $product->id
            #'name' => 'Gafas'
        ]);
    }

}
