<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Sale;


class SaleTest extends TestCase
{
    use RefreshDatabase;
    
    public function test_user_can_create_sales()
    {
        $data = [
            'product_id' => 1,
            'name' => 'Venta cliente comun',
            'quantity' => 2000,
            'price' => 1000,
            'taxes' => 500,
            'total' => 50000
        ];
        $response = $this->post('/api/sales', $data);
        $response->assertStatus(201);
        $this->assertDatabaseHas('sales', [
            'product_id' => 1,
            'name' => 'Venta cliente comun',
            'quantity' => 2000,
            'price' => 1000,
            'taxes' => 500,
            'total' => 50000
        ]);

    }

    public function test_user_can_show_sales(){
        $sale = Sale::create([
            'product_id' => 2,
            'name' => 'Venta VIP',
            'quantity' => 2100,
            'price' => 5000,
            'taxes' => 200,
            'total' => 100000
        ]);
        $response = $this->get('/api/sales/'.$sale->id);
        $response->assertStatus(200);
        $response->assertJson([
            'data' => [
                'product_id' => 2,
                'name' => 'Venta VIP',
                'quantity' => 2100,
                'price' => 5000,
                'taxes' => 200,
                'total' => 100000
            ]
        ]);
    }

    public function test_user_can_update_sales(){
        $sale = Sale::create([
            'product_id' => 3,
            'name' => 'Ventota',
            'quantity' => 2,
            'price' => 130000,
            'taxes' => 5000,
            'total' => 135000
        ]);
        $updateData = [
            'product_id' => 3,
            'name' => 'Venta grande',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 11023211
        ];
        $response = $this->put('/api/sales/'.$sale->id, $updateData);
        $response->assertStatus(200);
        $this->assertDatabaseHas('sales', [
            'product_id' => 3,
            'name' => 'Venta grande',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 11023211
        ]);
    }

    public function test_user_can_delete_product(){
        $sale = Sale::create([
            'product_id' => 1,
            'name' => 'Venta minima',
            'quantity' => 5,
            'price' => 134000,
            'taxes' => 6000,
            'total' => 11023211
        ]);
        $response = $this->delete('/api/sales/'.$sale->id);
        $response->assertStatus(204);
        $this->assertDatabaseMissing('sales', [
            'id' => $sales->id
            #'name' => 'Gafas'
        ]);
    }
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
