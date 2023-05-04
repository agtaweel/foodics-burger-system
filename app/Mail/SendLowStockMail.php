<?php

namespace App\Mail;

use App\Models\Ingredient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

class SendLowStockMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected array $ingredients)
    {
        //
    }

    public function build()
    {
        $this->boot();

        $mail = $this->subject("Low Stock Ingredients")
            ->html(
                (new MailMessage)
                    ->line("Hi, ")
                    ->line("Kindly note that the following ingredients are running out. Please take the necessary actions.")
                    ->line(new HtmlString($this->getIngredientsDetials()))
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

    protected function getIngredientsDetials(): string
    {
        $details = array_reduce($this->ingredients,function($carry, $ingredient){
            $carry .= sprintf("<tr><td>%s</td><td>%s</td><td>%s</td></tr>",
                $ingredient->name,$ingredient->stock,round($ingredient->percentage,2).'%');
            return $carry;
        }, "<tr><th>Name</th><th>Available Weight</th><th>Available Percentage</th></tr>");

        return "<table class=\"table table-bordered\" style=\"width: 100%;\"><tbody>$details</tbody></table>";
    }
}
