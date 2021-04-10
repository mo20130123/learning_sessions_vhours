@component('mail::message')


  Hello {{$Member->name}},
  We're sorry you're having trouble logging into your The Market account.
  We're happy to be of service, just click on the forget <br> my password button to reset your password.
  <br><br>

  عزيزي العميل {{$Member->name}},

نأسف لوجود عُطل في الدخول للحساب الخاص بك. يسعدنا أن نكون في خدمتك.
<br>
 اضغط على "نسيت كلمة المرور الخاصة بي" لإعادة تأسيس كلمة مرور جديدة.


@component('mail::button', ['url' => url('member/resite_password_form/'.$Member->forget_password)])
  click for reset password
@endcomponent

Thanks,<br>
The Market
@endcomponent
