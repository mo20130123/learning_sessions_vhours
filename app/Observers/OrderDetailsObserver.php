<?php

namespace App\Observers;

use App\Models\OrderDetails;
use App\Models\OrderDetailsAdminInfo;

class OrderDetailsObserver
{
    /**
     * Handle the OrderDetails "created" event.
     *
     * @param  \App\Models\OrderDetails  $orderDetails
     * @return void
     */
    public function created(OrderDetails $orderDetails)
    {
        OrderDetailsAdminInfo::create([ 'order_details_id' => $orderDetails->id ]);
    }


}
