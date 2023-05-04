<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;
use App\Models\Ingredient;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ingredient_product', function (Blueprint $table) {
            $table->foreignIdFor(Product::class)->cascadeOnUpdate()->nullOnDelete();
            $table->foreignIdFor(Ingredient::class)->cascadeOnUpdate()->nullOnDelete();
            $table->double('weight');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_product');
    }
};
