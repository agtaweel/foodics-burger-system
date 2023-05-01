<?php

namespace App\Http\Controllers;

use App\Events\LowStockIngredients;
use App\Http\Resources\OrderResource;
use App\Models\Order;
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
            $order->products()->attach($request->get('products'));
            $low_stock_ingredient = $this->updateIngredentStock($order);
        }
        catch (\Throwable $e){
            throw new \Exception($e->getMessage(),500,$e);
        }

        if(!empty($low_stock_ingredient)){
            try{
                LowStockIngredients::dispatch($low_stock_ingredient);
        }
            catch (\Throwable $e){
                error_log($e->getMessage());
            }
        }
        return response()->json(new OrderResource($order));
    }

    private function updateIngredentStock(Order $order):array{

        foreach ($order->products as $product){
            foreach ($product->ingredients as $ingredient){
                $original_stock = ($ingredient->stock*100)/$ingredient->percentage;
                $available_stock = $ingredient->stock-($product->pivot->quantity*$ingredient->pivot->weight);
                $percentage = $available_stock*100/$original_stock;
                $ingredient->update(['stock'=>$available_stock,'percentage'=>$percentage]);
                if($percentage<50){
                    $low_stock_ingredient []= $ingredient;
                }
            }
        }
        return $low_stock_ingredient??[];
    }
}
