<?php

namespace Database\Seeders;

use App\Models\Ingredient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('ingredients')->delete();
        DB::table('products')->delete();
        DB::table('orders')->delete();
        DB::table('order_product')->delete();
        DB::table('ingredient_product')->delete();

        Ingredient::query()->create([
            'name'=>'beef',
            'stock'=>20000,
            'unit'=>'g',
            'percentage'=>100,
        ]);
        Ingredient::query()->create([
            'name'=>'cheese',
            'stock'=>5000,
            'unit'=>'g',
            'percentage'=>100,
        ]);
        Ingredient::query()->create([
            'name'=>'onion',
            'stock'=>1000,
            'unit'=>'g',
            'percentage'=>100,
        ]);

    }
}
