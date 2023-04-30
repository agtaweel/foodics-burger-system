<?php

namespace App\Http\Controllers;

use App\Events\OrderDispatched;
use App\Models\Order;
use App\Rules\AvailableQuantity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    //

    public function create(Request $request){
//        dd($request->all());
        $validator = Validator::make($request->all(),[
            "products"=>['required','array', new AvailableQuantity,],
            'products.*.product_id'=>['required','exists:products,id'],
            'products.*.quantity'=> ['required', 'integer',]
        ]);
        if ($validator->fails()){
            return response()->json($validator->errors()->toArray());
        }

        $order = Order::query()->create();
        $order->products()->attach($request->get('products'));

//        try{
            OrderDispatched::dispatch($order);
//        }
//        catch (\Throwable $throwable){
//            throw new \Exception($throwable->getMessage());
//        }
        return response()->json($order->toArray());
    }
}
