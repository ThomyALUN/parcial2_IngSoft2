<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;
use App\Models\Category;
use App\Models\Product;


class SaleTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_sales()
    {
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
        $data = [
            'product_id' => $product->id,
            'name' => 'Venta cliente comun',
            'quantity' => 2000,
            'price' => 1000,
            'taxes' => 500,
            'total' => 50000
        ];
        $response = $this->post('/api/sales', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('sales', [
            'product_id' => $product->id,
            'name' => 'Venta cliente comun',
            'quantity' => 2000,
            'price' => 1000,
            'taxes' => 500,
            'total' => 50000
        ]);

    }

    public function test_user_can_show_sales(){
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
        $sale = Sale::create([
            'product_id' => $product->id,
            'name' => 'Venta VIP',
            'quantity' => 2100,
            'price' => 5000,
            'taxes' => 200,
            'total' => 100000
        ]);
        $response = $this->get('/api/sales/'.$sale->id);
        $response->assertStatus(200);
        $response->assertJson([
  
                'product_id' => $product->id,
                'name' => 'Venta VIP',
                'quantity' => 2100,
                'price' => 5000,
                'taxes' => 200,
                'total' => 100000
            
        ]);
    }

    public function test_user_can_update_sales(){
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
        $sale = Sale::create([
            'product_id' => $product->id,
            'name' => 'Ventota',
            'quantity' => 2,
            'price' => 130000,
            'taxes' => 5000,
            'total' => 135000
        ]);
        $updateData = [
            'product_id' => $product->id,
            'name' => 'Venta grande',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 1102
        ];
        $response = $this->put('/api/sales/'.$sale->id, $updateData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('sales', [
            'product_id' => $product->id,
            'name' => 'Venta grande',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 1102,
        ]);
    }

    public function test_user_can_delete_product(){
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
        $sale = Sale::create([
            'product_id' => $product->id,
            'name' => 'Venta minima',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 1102
        ]);
        $response = $this->delete('/api/sales/'.$sale->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('sales', [
            'id' => $sale->id
        ]);
    }
}
