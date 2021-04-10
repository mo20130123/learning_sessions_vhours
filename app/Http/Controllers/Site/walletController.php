<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\WalletPaymets;
use App\Models\Member;

class WalletController extends Controller
{
      public function index()
      {
          return view('Site.wallet' );
      }

      public function redirect_to_payment_page(Request $request)
      {
           $data = $request->validate([
              'wallet_amount' => 'required|numeric',
           ]);

           $walletPaymet_init = WalletPaymets::create([
              'member_id' => auth('Member')->id(),
              'amount' => $request->wallet_amount ,
              'is_paid' => 0
           ]);

            $PaymentAccapt = new \App\Http\Controllers\Site\PaymentAccapt\PaymentAccaptWalletController();
            try {
              return $PaymentAccapt->init_payment_form( $walletPaymet_init );
            } catch (\Exception $e) {
              \Log::info('Sorry,initialize wallet payment faild, Please Try again Now', ['Member_id' => auth('Member')->id()] );
              \Session::flash('flash_message','Sorry,initialize payment faild, Please Try again Now');
              return redirect('wallet');
            }
      }

      public static function continue_payment_after_creditcard( $get_order_id )
      {

        // \Log::info('continue_payment_after_creditcard',['$get_order_id'=>$get_order_id] );

             $walletPaymet = WalletPaymets::find($get_order_id);
             $walletPaymet->update([ 'is_paid' => 1 ]);

             $member = Member::find($walletPaymet->member_id);

             $member->update([
               'wallet' => $member->wallet + $walletPaymet->amount
             ]);

             //delete any old ones
             WalletPaymets::where('member_id',$member->id)->where('is_paid',0)->delete();

             \Session::flash('flash_message', __('page.wallet has updated') );
             return redirect('/wallet');
      }

}
