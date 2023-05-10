<?php

namespace App\Http\Controllers;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Rules\AvailableQuantity;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        }
        catch (\Throwable $e){
            DB::rollBack();
            throw new \Exception($e->getMessage(),500,$e);
        }
        return response()->json(new OrderResource($order));
    }
}
