<?php

namespace App\Http\Controllers;

use App\Mail\Emailtrans;
use App\Models\bo;
use App\Models\data;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class AirtimeController
{
    public function airtime(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

            $user = User::find($request->user()->id);
//            $wallet = wallet::where('username', $user->username)->first();


            if ($user->wallet < $request->amount) {
                $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $user->wallet. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
                Alert::error('Insufficient Fund', $mg);
                return back();

            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                Alert::warning('Warning', $mg);
                return back();

            }
            $bo = bo::where('refid', $request->refid)->first();
            if (isset($bo)) {
                $mg = "duplicate transaction";
                Alert::error($mg);
                return back();

            } else {
                $user = User::find($request->user()->id);
                $bt = data::where("id", $request->id)->first();
//                $wallet = wallet::where('username', $user->username)->first();


                $gt = $user->wallet - $request->amount;


                $user->wallet = $gt;
                $user->save();

                $bo = bo::create([
                    'username' => $user->username,
                    'plan' => 'Airtime',
                    'amount' => $request->amount,
                    'server_res' => 'pam',
                    'result' => 1,
                    'phone' => $request->number,
                    'refid' => $request->refid,
                    'discountamoun' => 0,
                ]);
//return $request;
                $resellerURL = 'https://renomobilemoney.com/api/';
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $resellerURL.'airtime',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array( 'name' => $request->name, 'number' => $request->number, 'amount' => $request->amount, 'refid' => $request->refid),

                    CURLOPT_HTTPHEADER => array(
                        'apikey: RENO-62ddc85d549f76.59606188'
                    )));

                $response = curl_exec($curl);

                curl_close($curl);

//                    return $response;
//    return;
                $data = json_decode($response, true);
                $success = $data["success"];
//                $tran1 = $data["discountAmount"];

//                        return $response;
                if ($success == 1) {




//                    $name = $bt->plan;
                    $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                    $ph = $request->number;

                    $receiver = $user->email;
                    $admin = 'admin@primedata.com.ng';
                    $admin2= 'primedata18@gmail.com';

//                    Mail::to($receiver)->send(new Emailtrans($bo));
//                    Mail::to($admin)->send(new Emailtrans($bo));
//                    Mail::to($admin2)->send(new Emailtrans($bo));

                    Alert::success('Success', $am.''.$ph);
                    return back();

                } elseif ($success == 0) {
                    $zo = $user->wallet + $request->amount;
                    $user->wallet = $zo;
                    $user->save();

//                    $name = $bt->plan;
                    $am = "NGN $request->amount Was Refunded To Your Wallet";
                    $ph = ", Transaction fail";
                    Alert::error('error', $am.''.$ph);
                    return redirect('dashboard');

                }
        }
    }
    public function honor(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user = User::find($request->user()->id);
        $wallet = wallet::where('username', $user->username)->first();


        if ($wallet->balance < $request->amount) {
            $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $wallet->balance. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
Alert::error('Insufficient Balance', $mg);
            return back();

        }
        if ($request->amount < 0) {

            $mg = "error transaction";
            Alert::warning('Warning', $mg);
            return back();

        }
        $bo = bo::where('refid', $request->refid)->first();
        if (isset($bo)) {
            $mg = "duplicate transaction";
            Alert::error('Error', $mg);
            return back();

        } else {
            $user = User::find($request->user()->id);
            $bt = data::where("id", $request->id)->first();
            $wallet = wallet::where('username', $user->username)->first();


            $gt = $wallet->balance - $request->amount;


            $wallet->balance = $gt;
            $wallet->save();


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.honourworld.com.ng/api/v1/purchase/airtime',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => '{
  "network" : "'.$request->id.'",
  "phone" : "'.$request->number.'",
  "amount" : "'.$request->amount.'"
}',
                CURLOPT_HTTPHEADER => array(
//                    'Authorization: Bearer sk_live_9a55cd84-8ad7-46d9-9136-c5962858f753',
                    'Accept: application/json',
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
//            echo $response;

            $data = json_decode($response, true);
//            $success = $data["message"];
//            $tran1 = $data["discountAmount"];

//                        return $response;
            if ($data['message']== 'SUCCESSFUL') {

                $bo = bo::create([
                    'username' => $user->username,
                    'plan' => 'airtime',
                    'amount' => $request->amount,
                    'server_res' => $response,
                    'result' => 1,
                    'phone' => $request->number,
                    'refid' => $request->refid,
                    'discountamoun' => '0',
                ]);

                $success=1;
                $name = "Airtime";
                $am = "NGN $request->amount  Airtime Purchase Was Successful To";
                $ph = $request->number;

                $receiver = $user->email;
                $admin = 'admin@primedata.com.ng';
                $admin2= 'primedata18@gmail.com';

//                Mail::to($receiver)->send(new Emailtrans($bo));
//                Mail::to($admin)->send(new Emailtrans($bo));
//                Mail::to($admin2)->send(new Emailtrans($bo));
//
                Alert::success('Success', $am.' '.$ph);
                return back();

            } elseif ($data['message']== 'Possible duplicate transaction, Please retry after 2 minutes') {
                $zo = $user->balance + $request->amount;
                $user->balance = $zo;
                $user->save();
$success=0;
                $name = 'Airtime';
                $am = "NGN $request->amount Was Refunded To Your Wallet";
                $ph = ", Possible duplicate transaction, Please retry after 2 minutesl";

                Alert::error('Error', $am.' '.$ph);
                return back();

            } elseif ($data['message']== 'Failed') {
                $zo = $user->balance + $request->amount;
                $wallet->balance = $zo;
                $wallet->save();
                $success=0;
                $name = 'Airtime';
                $am = "NGN $request->amount Was Refunded To Your Wallet";
                $ph = ", Transaction fail";
                Alert::error('Error', $am.' '.$ph);
                return back();

            }
        }

        }
}
