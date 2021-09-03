<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_get_products()
    {
        $user = User::create([
            'name'     => $this->faker->name, 'email' => $this->faker->email,
            'password' => Hash::make('password')
        ]);
        $this->be($user);

        $response = $this->get('/api/products');

        $response->assertStatus(200);
    }

    public function test_store_product()
    {
        $user = User::create([
            'name'     => $this->faker->name, 'email' => $this->faker->email,
            'password' => Hash::make('password')
        ]);
        $this->be($user);

        $response = $this->postJson('/api/products', [
            'name'         => $this->faker->name,
            'manufactured' => $this->faker->year,
            'photo'        => new \Illuminate\Http\UploadedFile(resource_path('test/test.png'), 'large-avatar.jpg',
                null, null, true)
        ]);

        $response->assertStatus(201)->assertJson(['message' => 'created']);
    }

    public function test_update_product()
    {
        $user = User::create([
            'name'     => $this->faker->name, 'email' => $this->faker->email,
            'password' => Hash::make('password')
        ]);
        $product = Product::create([
            'user_id'      => $user->id,
            'name'         => $this->faker->name,
            'manufactured' => 2010,
            'photo'        => ''
        ]);

        $this->be($user);

        $response = $this->postJson('/api/products/'.$product->id, [
            'name' => $this->faker->name,
        ]);

        $response->assertStatus(200)->assertJson(['message' => 'updated']);
    }

    public function test_delete_product()
    {
        $user = User::create([
            'name'     => $this->faker->name, 'email' => $this->faker->email,
            'password' => Hash::make('password')
        ]);

        $product = Product::create([
            'user_id'      => $user->id,
            'name'         => $this->faker->name,
            'manufactured' => 2010,
            'photo'        => ''
        ]);

        $this->be($user);

        $response = $this->deleteJson('/api/products/'.$product->id);

        $response->assertStatus(200)->assertJson(['message' => 'deleted']);
    }
}
