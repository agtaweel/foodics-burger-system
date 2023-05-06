<?php

namespace App\Listeners;

use App\Events\LowStockIngredients;
use App\Mail\SendLowStockMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendLowStockWarning implements ShouldQueue
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
    public function handle(LowStockIngredients $event): void
    {
        $ingredients = $event->ingredients;
        Mail::to(env('MERCHANT_MAIL','ahmedtaweel96@gmail.com'),)->send(new SendLowStockMail($ingredients));
    }
}
