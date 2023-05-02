<?php

namespace Tests\Feature;

use App\Mail\SendLowStockMail;
use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class OrderTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_create_order(): void
    {
        $product = Product::factory()->create();
        $ingredients = Ingredient::factory(2)->make();
        foreach ($ingredients as $ingredient){
            $product->ingredients()->attach($ingredient,['weight'=>rand(10,200)]);
        }
        $data_array = array(
            'products'=>array(
                array(
                    'product_id'=>$product->id,
                    'quantity'=>rand(1,5)
                )
            )
        );
        $response = $this->post('/api/orders',$data_array);
        $response->assertStatus(Response::HTTP_OK);
        $response->assertJsonStructure([
            'id',
            'created',
            'updated',
            'products'
        ]);
    }
    public function test_stock_is_updated_after_creating_order(): void
    {
        $product = Product::factory()->create();
        $ingredients = Ingredient::factory(2)->make();
        foreach ($ingredients as $ingredient){
            $product->ingredients()->attach($ingredient,['weight'=>rand(10,200)]);
        }
        $data_array = array(
            'products'=>array(
                array(
                    'product_id'=>$product->id,
                    'quantity'=>rand(1,5)
                )
            )
        );
        $response = $this->post('/api/orders',$data_array);
        $products = $response->json('products');
        foreach ($products as $product){
            foreach ($product['ingredients'] as $ingredient){
                $this->assertNotEquals($ingredient['percentage'],100);
                $stock_total = $ingredient['weight']*$product['quantity']+$ingredient['stock'];
                $this->assertNotEquals(round($ingredient['stock']/$stock_total,2),round($ingredient['percentage'],2));
            }
            $response->assertStatus(Response::HTTP_OK);
            $response->assertJsonStructure([
                'id',
                'created',
                'updated',
                'products'
            ]);
        }
    }
    public function test_create_order_fails_invalid_product_id(): void
    {
        $data_array = array(
            'products'=>array(
                array(
                    'product_id'=>rand(100,1000),
                    'quantity'=>rand(1,10)
                )
            )
        );
        $response = $this->post('/api/orders',$data_array);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            'products.0.product_id'=>[
                "The selected products.0.product_id is invalid."
            ]
        ]);
    }
    public function test_create_order_fails_invalid_quantity(): void
    {
        $product = Product::factory()->create();
        $ingredients = Ingredient::query()->get()->random(2);
        foreach ($ingredients as $ingredient){
            $product->ingredients()->attach($ingredient,['weight'=>rand(10,200)]);
        }
        $data_array = array(
            'products'=>array(
                array(
                    'product_id'=>$product->id,
                    'quantity'=>rand(2001,3000)
                )
            )
        );

        $response = $this->post('/api/orders',$data_array);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonFragment([
            'products'=>[
                "The selected products.0.quantity is invalid."
            ]
        ]);
    }

    public function test_email_is_sent_when_any_ingredient_has_less_than_50_percent_stock(): void
    {
        Mail::fake();
        $product = Product::factory()->create();
        $ingredient = Ingredient::query()->first()->update(['percentage'=>50]);
        $product->ingredients()->attach($ingredient,['weight'=>rand(10,100)]);
        $data_array = array(
            'products'=>array(
                array(
                    'product_id'=>$product->id,
                    'quantity'=>1
                )
            )
        );


        $response = $this->post('/api/orders',$data_array);

        $response->assertStatus(Response::HTTP_OK);

        Mail::assertSent(
            SendLowStockMail::class
        );
    }
}
