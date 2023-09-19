<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendDefaultMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $data = $this->data;

        $sender_email = $data['sender_email'] ?? 'perki.yogyakarta@gmail.com';
        $sender_name = $data['sender_name'] ?? 'Perki Jogja';
        $subject = $data['email_subject'] ?? 'Information';
        $view = $data['view'] ?? 'templates.email.default';
        $attach = $data['attach'] ?? null;
        $attach2 = $data['attach2'] ?? null;

        if ($attach2 != null) {
            $this->from($sender_email, $sender_name)
                ->subject($subject)
                ->attach($attach)
                ->attach($attach2)
                ->view($view, $data);
        } else if($attach != null){
            $this->from($sender_email, $sender_name)
                ->subject($subject)
                ->attach($attach)
                ->view($view, $data);
        } else{
            $this->from($sender_email, $sender_name)
                ->subject($subject)
                ->view($view, $data);
        }
    }
}
