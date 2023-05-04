<?php

namespace App\Http\Controllers;

use App\Events\LowStockIngredients;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Rules\AvailableQuantity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "products"=>['required','array', new AvailableQuantity,],
            'products.*.product_id'=>['required','exists:products,id'],
            'products.*.quantity'=> ['required', 'integer',]
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toArray(),Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        try{
            $order = Order::create();
            foreach ($request->get('products') as $item){
                $product = Product::query()->find($item['product_id']);
                $order->products()->attach($product,['price'=>$product->price,'quantity'=>$item['quantity']]);
            }
            $low_stock_ingredients = $this->updateIngredientStock($order);
        }
        catch (\Throwable $e){
            throw new \Exception($e->getMessage(),500,$e);
        }

        if(!empty($low_stock_ingredients)){
            try{
                LowStockIngredients::dispatch($low_stock_ingredients);
                foreach ($low_stock_ingredients as $ingredient){
                    $ingredient->update(['has_low_stock_email'=>true]);
                }
        }
            catch (\Throwable $e){
                error_log($e->getMessage());
            }
        }
        return response()->json(new OrderResource($order));
    }

    private function updateIngredientStock(Order $order):array{

        foreach ($order->products as $product){
            foreach ($product->ingredients as $ingredient){
                $original_stock = ($ingredient->stock*100)/$ingredient->percentage;
                $available_stock = $ingredient->stock-($product->pivot->quantity*$ingredient->pivot->weight);
                $percentage = $available_stock*100/$original_stock;
                $ingredient->update(['stock'=>$available_stock,'percentage'=>$percentage]);
                if($percentage<50 && !$ingredient->has_low_stock_email){
                    $low_stock_ingredients []= $ingredient;
                }
            }
        }
        return $low_stock_ingredients??[];
    }
}
