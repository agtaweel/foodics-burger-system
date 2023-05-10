<?php

namespace App\Traits;

use App\Models\Product;

trait OrderOperations
{
    public function updateStock(){
        foreach ($this->products as $product){
            foreach ($product->ingredients as $ingredient){
                $original_stock = ($ingredient->stock*100)/$ingredient->percentage;
                $available_stock = $ingredient->stock-($product->pivot->quantity*$ingredient->pivot->weight);
                $percentage = $available_stock*100/$original_stock;
                $ingredient->update(['stock'=>$available_stock,'percentage'=>$percentage]);
            }
        }
    }

    public function attachProduct($item){
        $product = Product::query()->find($item['product_id']);
        $this->products()->attach($product,['price'=>$product->price,'quantity'=>$item['quantity']]);
    }
}
