<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IngredientProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ingredients = Ingredient::all();
        for ($i=0;$i<10;$i++){
            $product = Product::factory()->create();
            $product->ingredients()->attach($ingredients->random(rand(1,3)),['weight'=>rand(10,100)]);
        }
    }
}
