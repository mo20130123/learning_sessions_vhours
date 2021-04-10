@component('mail::message')

  <img width="100" class="logo" class="" src="{{asset('site_assets/images/market_logo.png')}}"/>


    Dear {{ $member->name }}

  -------------------------------------------------------------

  Thank you for your recent purchase with us. We hope you are happy with your purchase. We’d love to hear how satisfied you are with your order. Could you take a moment to leave a review?

Tell Us How Happy You Are With Your Order https://www.facebook.com/pg/themarketol/reviews/

We really do appreciate having you as a customer, and we would like to say thank you for choosing us.

If there is anything else we can do for you, please do not hesitate to call us on 01205455553 from Sundays to Thursdays (9 am – 5 pm).
@component('mail::button', ['url' => url('History/details/'.$Recipt->id) ])
    Click for order details
@endcomponent


@endcomponent
