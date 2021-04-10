<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mails_to_everybody extends Mailable
{
    use Queueable, SerializesModels;

    public $member;
    // public $img_url;

    public function __construct($member )
    {
        $this->member = $member;
        $this->img_url = env('APP_URL')."/site_assets/images/mido_logo_main.png";
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@mido.com.eg')
                    ->subject('The Market Contactless delivery service' )
                    ->markdown('mail.Mails_to_everybody',[
                      'url_img' =>  asset("/site_assets/images/mido_logo_main.png")
                    ]);



    }
}
