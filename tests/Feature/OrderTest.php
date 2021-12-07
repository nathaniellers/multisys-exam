<?php

namespace Tests\Feature;

use App\Enums\ResponseMessage;
use Tests\TestCase;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\Response;

class OrderTest extends TestCase
{
    use WithoutMiddleware;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_order()
    {
        $this->withoutMiddleware();
        DB::beginTransaction();
        $product = Product::all()->random()->first();
        $response = $this->postJson('/api/order', [
            'product_id' => $product->id,
            'quantity' => 1
        ]);
        DB::rollBack();
        $response->assertJsonStructure([
            'message',
            'error',
            'code'
        ])->assertStatus(Response::HTTP_OK);
        return $this->assertEquals($response['message'], ResponseMessage::success['base']);
    }

    public function test_order_invalid()
    {
        $this->withoutMiddleware();
        DB::beginTransaction();
        $product = Product::all()->random()->first();
        $quantity = $product->available_stock + 1;
        $response = $this->postJson('/api/order', [
            'product_id' => $product->id,
            'quantity' => $quantity
        ]);
        DB::rollBack();
        $response->assertJsonStructure([
            'message',
            'error',
            'code'
        ])->assertStatus(Response::HTTP_BAD_REQUEST);
        return $this->assertEquals($response['message'], ResponseMessage::error['order']);
    }
}
