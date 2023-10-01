<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $user = User::factory()->create();
        $token = JWTAuth::fromUser($user);
        
        $body = [
            "title" => "Product new update",
            "brand_id" => 1,
            "description"=> "test description",
            "images" => [
                1, 5, 3
            ],
            "price" => 10,
            "promo_price" => 7.5
        ];
        $response = $this->actingAs($user)->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->post('/api/product/create', $body);
        $response->assertStatus(200);
        $countProduct = Product::count();
        $this->assertEquals($countProduct, 1);
    }
}
