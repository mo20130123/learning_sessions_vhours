@component('mail::message')

  {{-- <img width="100" class="logo" class="" src="{{$url_img}}" src="data:image/png;base64,{{base64_encode(file_get_contents(resource_path('site_assets/images/mido_logo_main.png')))}}" /> --}}

{{-- [logo]: {{asset('/site_assets/images/mido_logo_main.png')}} "Logo" --}}
  {{-- ------------------------------------------------------------- --}}
  <p> Dear ({{ $member->name }}) </p>

  <p> In response to recent global developments related to the COVID-19, we offer no-contact delivery for online paid orders. If you would like to use this service, you just need to select the online payment method. The courier will ring the doorbell and leave your order at the door </p>

<p>We are looking forward to providing you with a seamless food delivery experience.</p>

<p>Kind Regards,</p>

@component('mail::button', ['url' => url('https://mol-shop.com') ])
    The Market 
@endcomponent


@endcomponent
