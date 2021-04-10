<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Member;
use App\Models\ShoppingCart;
use App\Models\MemberMarketingBrief;
use Illuminate\Support\Str;

class AuthController extends Controller
{

        public function __construct()
        {
           $this->middleware('guest:Member')->except('logout','edit','update','add_new_address','changePassword_form','changePassword_action');
           $this->middleware('auth:Member')->only('edit','update','changePassword_form','changePassword_action');
        }


      public function registerForm()
      {
          $lang = \App::getLocale();

          $Cities = \App\City::select('id',"name_$lang as name")->where('status',1)->orderBy("name_$lang")->get();

          foreach ($Cities as $key => $City)
          {
              $City->Districts = District::select('id',"name_$lang as name")
                                         ->where('city_id',$City->id)->where('status',1)
                                         ->get();
          }
          $Member = new Member();
          return view('Site.Auth.register',compact('Cities','Member'));
      }

      public function loginForm()
      {
          return view('Site.Auth.login');
      }

      public function register(Request $request)
      {
            $data = $request->validate([
                'name' => 'required',
                'email' => 'required|unique:members',
                'password' => 'required',
                // 'gender' => 'required',
                'phone' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                // 'birthdate' => 'required|date',
                'address' => 'required',
                'street' => 'required',
                'building_no' => 'required',
                'apartment_no' => 'required',
                'Guest_Cart' => '',
            ]);
            // $Member = Member::create($data);
            $Member = Member::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' =>  md5('moi'.$request->password) ,
                'phone' => $request->phone,
                // 'gender' => $request->gender,
                // 'birthdate' => $request->birthdate,
            ]);
            MemberAddress::create([
                'member_id' => $Member->id ,
                'address' => self::remove_quotes($request->address) ,
                'street' => self::remove_quotes($request->street) ,
                'building_no' => self::remove_quotes($request->building_no) ,
                'apartment_no' => self::remove_quotes($request->apartment_no) ,
                'city_id' => $request->city_id ,
                'district_id' => $request->district_id ,
            ]);
            auth()->guard('Member')->loginUsingId($Member->id, true);

            $this->cut_Guest_Cart_to_Auth_cart(json_decode($request->Guest_Cart));

            return redirect('/');
      }

      //--api--
      public function login(Request $request)
      {
          $data = $request->validate([
              'email' => 'required',
              'password' => 'required',
              // 'Guest_Cart' => '',
          ]);

          // return $request->all();

          $Member = Member::where('email',$request->email)->where('password', md5('moi'.$request->password) )->first();

          if($Member)
          {
              if(!$Member->is_allowed)
              {
                  return response()->json([
                    'status' => 'not_allowed',
                    'flash_message' => 'you are not allowed to access yet'
                  ]);
              }

              auth()->guard('Member')->loginUsingId($Member->id, true);

              // $this->cut_Guest_Cart_to_Auth_cart(json_decode($request->Guest_Cart));

              return response()->json([
                'status' => 'success',
              ]);
          }
          else
          {
              return response()->json([
                'status' => 'faild',
                'flash_message' => 'your email or password is/are wrong'
              ]);
          }
      }

      public function logout()
      {
          if(auth()->guard('Member')->check())
              auth()->guard('Member')->logout();
          return redirect('');
          // return back();
      }

      public function edit()
      {
          $member = auth('Member')->user();
          // $address = MemberAddress::select('*',\DB::raw("CONCAT('cc_',id) as cc"))->where('member_id',$member->id)->get();

          $lang = \App::getLocale();
          $Countries = Country::select('id',"name_$lang as name")
                                   ->orderBy('position')->where('status',1)->get();
          $MarketingBriefs = MemberMarketingBrief::select('id','name')->where('member_id',$member->id)->get();

          return view('Site.Auth.profile',compact('member' ,'Countries','MarketingBriefs'));
      }

      public function update(Request $request)
      {
          $id = auth('Member')->id();
          $data = $request->validate([
            'email' => 'required|unique:members,email,'.$id,
            'name' => 'required',
            'company' => 'required',
            // 'password' => '',
            'title' => 'required',
            'company_size' => 'required',
            'phone' => 'required',
        ]);
        $member_data = [
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'company' => $request->company ,
            'title' => $request->title ,
            'company_size' => $request->company_size ,
        ];
        // if($data['password']){
        //   $member_data['password'] = md5('moi'.$request->password);
        // }
         auth('Member')->user()->update($member_data);

          \Session::flash('flash_message',__('page.profile has updated'));
          return redirect('/');
      }

      // page
      public function forgetPassword_Form()
      {
         return view('Site.Auth.forgetPassword_sendEmail');
      }

      //action
       public function send_forget_password_email(Request $request)
       {
             $data = $request->validate([
                 'email' => 'required',
             ]);
             $Member = Member::where('email',$request->email)->first();
             if($Member)
             {
                $Member->update(['forget_password' => Str::random(80) ]);
                \Mail::to($Member->email)->send(new \App\Mail\ForgetPassword($Member));
             }

             \Session::flash('flash_message',__('page.Forget password Email has send to your mail'));
             return redirect('');
       }

       // page
       public function resite_password_form($ForgetPassword)
       {
           $Member = Member::where('forget_password',$ForgetPassword)->first();
           if($Member)
           {
               return view('Site.Auth.resite_password',compact('Member'));
           }
           else {
             return 'expired';
           }
       }

       //action
       public function reset_password(Request $request)
       {
             $data = $request->validate([
                 'password' => 'required',
                 'member_id' => 'required',
                 'forget_password' => 'required',
                 'password_again' => '',
             ]);
             $Member = Member::where('forget_password',$request->forget_password)->findOrFail($request->member_id);
             $Member->update([
               'password' => md5('moi'.$request->password) ,
               'forget_password' => Str::random(80)
             ]);
             auth()->guard('Member')->loginUsingId($Member->id, true);
             return redirect('/');
       }

       public function changePassword_form()
       {
           return view('Site.Auth.changePassword');
       }

       public function changePassword_action(Request $request)
       {
           $data = $request->validate([
               'old_password' => 'required',
               'password' => 'required',
           ]);

           $old_password = md5('moi'.$request->old_password);
           $new_password = md5('moi'.$request->password);
           if( $old_password == auth()->guard('Member')->user()->password )
           {
               auth()->guard('Member')->user()->update([
                  'password' => $new_password
               ]);
               \Session::flash('flash_message',__('page.password has updated'));
                return redirect('/');
           }
           else
           {
               \Session::flash('flash_message',__('page.wrong old password'));
               return back();
           }
        }

        public function cut_Guest_Cart_to_Auth_cart($Guest_Cart)
        {
            if($Guest_Cart)
            {
                foreach ($Guest_Cart as $Guest_Cart_item)
                {
                   $find = ShoppingCart::where('member_id',auth()->guard('Member')->id() )->where('product_id', $Guest_Cart_item->id )
                                       ->first();
                    if($find)
                    {
                       $find->update([
                         'quantity' => $Guest_Cart_item->quantity ,
                         'cheese_type' => $Guest_Cart_item->cheese_type??null ,
                         'cheese_weight' => $Guest_Cart_item->cheese_weight??null ,
                       ]);
                    }
                    else
                    {
                        ShoppingCart::create([
                          'member_id' => auth()->guard('Member')->id(),
                          'product_id' => $Guest_Cart_item->id ,
                          'quantity' => $Guest_Cart_item->quantity ,
                          'cheese_type' => $Guest_Cart_item->cheese_type??null ,
                          'cheese_weight' => $Guest_Cart_item->cheese_weight??null ,
                        ]);
                    }
                }//End foreach
            }//End if($Guest_Cart)
        }

}
