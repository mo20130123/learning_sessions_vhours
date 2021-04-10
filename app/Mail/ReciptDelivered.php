<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReciptDelivered extends Mailable
{
    use Queueable, SerializesModels;

    public $Recipt;
    public $member;

    public function __construct($Recipt, $member)
    {
           $this->Recipt = $Recipt;
           $this->member = $member;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@mido.com.eg')
                    ->subject('The Market Order Delivered')
                    ->markdown('mail.mail_recipt_delivered');

        // return $this->from('sender@example.com')
        //            ->view('mails.demo')
        //            ->text('mails.demo_plain')
        //            ->with(
        //              [
        //                    'testVarOne' => '1',
        //                    'testVarTwo' => '2',
        //              ])
        //              ->attach(public_path('/images').'/demo.jpg', [
        //                      'as' => 'demo.jpg',
        //                      'mime' => 'image/jpeg',
        //              ]);
        //
    }
}
