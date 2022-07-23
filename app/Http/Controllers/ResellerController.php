<?php

namespace App\Http\Controllers;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use App\Models\setting;
use App\Models\wallet;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class ResellerController
{
    public function sell(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $wallet = wallet::where('username', $user->username)->first();


//            $wallet->account_number = $number;-
//            $wallet->account_name = $account;
//            $wallet->save();
//            Alert::info('Upgrade', 'You can request for a website after you upgrade. You will have access to cheaper prices of products too!');
            return view('reseller', compact('user', 'wallet'));



        }
    }
    public function apiaccess(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $wallet = wallet::where('username', $user->username)->first();


//            $wallet->account_number = $number;-
//            $wallet->account_name = $account;
//            $wallet->save();

            return view('upgrade', compact('user'));



        }
    }
    public function reseller(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $wallet = wallet::where('username', $user->username)->first();



            if ($wallet->balance < $request->amount) {
                $mg = "You Cant Upgrade Your Account" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $wallet->balance. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
                Alert::info('Insufficient Balance', $mg);
                return back();

            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                Alert::error('error', $mg);
                return view('bill', compact('user', 'mg'));

            }else {
                $user = User::find($request->user()->id);
                $wallet = wallet::where('username', $user->username)->first();


                $gt = $wallet->balance - $request->amount;


                $wallet->balance = $gt;
                $wallet->save();


                $token = uniqid('PRIME',true);

                $user->apikey = $token;
                $user->save();
                Alert::success('Success', 'You have successful upgrade your account! Thanks');


                return redirect("upgrade");
            }


        }
    }
}
