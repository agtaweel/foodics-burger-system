<?php

namespace App\Listeners;

use App\Events\OrderDispatched;
use App\Mail\SendLowStockMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class UpdateStock
{
    /**
     * Create the event listener.
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     * @param object $event
     * @return void
     */
    public function handle(OrderDispatched $event): void
    {
        $order = $event->order;
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
        if(isset($low_stock_ingredient))
            Mail::to(env('MERCHANT_MAIL'))->send(new SendLowStockMail($low_stock_ingredient));
    }
}
