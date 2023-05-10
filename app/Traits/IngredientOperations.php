<?php

namespace App\Traits;

use App\Mail\SendLowStockMail;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

trait IngredientOperations
{
    public function sendLowStockMail(){
        try{
            Mail::to(env('MERCHANT_MAIL','ahmedtaweel96@gmail.com'),)->send(new SendLowStockMail($this));
            $this->update(['has_low_stock_email'=>true]);
        }
        catch (\Throwable $throwable){
            error_log('ERROR_SENDING_LOW_STOCK_MAIL INGREDIENT_ID:'.$this->id);
        }
    }
}
