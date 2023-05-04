<?php

namespace App\Rules;

use App\Models\Ingredient;
use App\Models\Product;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class AvailableQuantity implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $products = request()->get('products');
        for ($i=0;$i<sizeof($products) ;$i++){
            if(!isset($products[$i]['product_id']) || !isset($products[$i]['quantity'])){
                return;
            }
            $product = Product::query()->where('id','=',$products[$i]['product_id'])->first();
            if(!$product)
                return;
            foreach ($product->ingredients as $ingredient){
                if($products[$i]['quantity']*$ingredient->pivot->weight > $ingredient->stock){
                    $fail("The selected {$attribute}.{$i}.quantity is invalid.")->toString();
                }
            }
        }
    }
}
