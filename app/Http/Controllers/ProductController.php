<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        return ProductResource::collection(Product::active()->filter($request->only(
            ['name','id','price_from','price_to','in_ingredients']
        ))->with('orders')->paginate($request->get('perPage')??20));
    }
}
