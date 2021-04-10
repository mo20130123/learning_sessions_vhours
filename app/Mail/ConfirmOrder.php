<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\OrderDetails;
use DB;

class ConfirmOrder extends Mailable
{
    use Queueable, SerializesModels;

    public $Recipt;
    public $member;

    public function __construct($Order,$member)
    {
      $this->member = $member;
        $this->Recipt = $Order;
        $lang = 'en';

        $this->Recipt->Products = OrderDetails::select(
                          'order_details.id',
                          'order_details.order_id',
                          'order_details.item_type',
                          'order_details.delivery_status',
                          'order_details.price',
                          'order_details.member_brief',
                          'order_details.package_type',
                          'order_details.marketing_brief_id',
                          "order_details.product_name_$lang as product_name",
                         "categories.name_$lang as category_name",
                         "product_images.image as image",
                         DB::raw("CONCAT('".asset('category')."/',categories.id,'-',REPLACE(categories.name_$lang,' ','-')) as category_link"),
                         DB::raw("IF(products.id,
                             CONCAT('".asset('product')."/',products.id,'-',REPLACE(products.name_$lang,' ','-')) ,
                             '#')
                           as product_link")  
                     )
                     ->leftJoin('products','products.id','order_details.product_id')
                     ->leftJoin('product_images','product_images.product_id','products.id')
                     ->leftJoin('categories','categories.id','products.category_id')
                     ->groupBy('order_details.id')
                     ->where('order_id',$Order->id)
                     ->get();
                     // dd($this->Recipt->Products);

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('support@deledeal.com.eg')
                    ->subject('deledeal Order Confirmation')
                    // ->markdown('mail.mail_recipt');
                    ->markdown('mail.mail_confirm_order');

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
