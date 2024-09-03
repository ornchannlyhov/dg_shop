<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Order;

class OrderPaidNotification extends Notification
{
    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Order Paid')
            ->line('Order #' . $this->order->id . ' has been paid.')
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('Thank you for using our application!');
    }
}
