<?php

namespace App\Observers;

use App\Mail\SendLowStockMail;
use App\Models\Ingredient;
use Illuminate\Support\Facades\Mail;

class IngredientObserver
{
    public $afterCommit = true;
    /**
     * Handle the Ingredient "created" event.
     */
    public function created(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "updated" event.
     */
    public function updated(Ingredient $ingredient): void
    {
        if($ingredient->percentage < 50 && !$ingredient->has_low_stock_email){
            $ingredient->sendLowStockMail();
        }
    }

    /**
     * Handle the Ingredient "deleted" event.
     */
    public function deleted(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "restored" event.
     */
    public function restored(Ingredient $ingredient): void
    {
        //
    }

    /**
     * Handle the Ingredient "force deleted" event.
     */
    public function forceDeleted(Ingredient $ingredient): void
    {
        //
    }
}
