<?php

namespace App\Mail;

use App\Classes\Basket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;
    protected $name;
    protected $basket;

    /**
     * OrderCreated constructor.
     * @param $name
     * @param $basket
     */
    public function __construct($name, Basket $basket)
    {
        $this->name = $name;
        $this->basket = $basket;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fullSum = $this->basket->getOrder()->calculateFullSum();

        return $this->view('mail.order_created', ['name' => $this->name, 'fullSum' => $fullSum, 'order' => $this->basket->getOrder()]);
    }
}
