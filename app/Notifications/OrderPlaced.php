<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlaced extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     *
     * @param  Order  $order
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New Order Received')
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('A new order has been placed in your store.')
            ->line('Order ID: #' . $this->order->id)
            ->line('Total Amount: $' . number_format($this->order->total_amount, 2))
            ->action('View Order Details', url('/orders/' . $this->order->id))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification (for database or other use).
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total_amount' => $this->order->total_amount,
        ];
    }
}
