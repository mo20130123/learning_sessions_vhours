@component('mail::message')

  <img width="100" class="logo" class="" src="{{asset('site_assets/images/market_logo.png')}}"/>


    Dear {{ $member->name }}

  -------------------------------------------------------------

    Here's your order status.
    Order Number:  {{ $Recipt->id }}
    Status:Processing

    Regards,
    The Market 

@component('mail::button', ['url' => url('History') ])
    Click for order details
@endcomponent


@endcomponent
