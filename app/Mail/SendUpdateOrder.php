<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUpdateOrder extends Mailable
{
    use Queueable, SerializesModels;

    protected $order;
    protected $status;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $status)
    {
        $this->order = $order;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('TRẠNG THÁI ĐƠN HÀNG')->view('admin.orders.mail')->with(['order' => $this->order, 'status' => $this->status]);
    }
}
