<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class SendLowStockMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected Ingredient $ingredient)
    {
        //
    }

    public function build()
    {
        $this->boot();

        $mail = $this->subject("Low Stock Ingredient ({$this->ingredient->name})")
            ->html(
                (new MailMessage)
                    ->line("Hi, ")
                    ->line("Kindly note that the {$this->ingredient->name} are running out of stock as the percentage now is {$this->ingredient->percentage}%.")
                    ->line("Please take the necessary actions.")
                    ->render()->toHtml()
            );
        return $mail;
    }

    protected function boot(): void
    {
        $this->from(
            env('MERCHANT_FROM_EMAIL', 'no-reply@gmail.com'),
            env('MERCHANT__FROM_NAME', 'NO_REPLY')
        );
    }
}
