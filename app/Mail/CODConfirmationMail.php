<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CODConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('COD Order Confirmation - Order #' . $this->order->id)
            ->view('emails.cod-confirmation')
            ->with([
                'order' => $this->order,
                'user' => $this->user,
            ]);
    }
}
