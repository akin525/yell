<?php

namespace app\Http\Controllers;

use App\Mail\Emailtrans;
use App\Models\bo;
use App\Models\data;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class EkectController
{
    public function listelect()
    {


        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://test.mcd.5starcompany.com.ng/api/reseller/list',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('service' => 'electricity'),
            CURLOPT_HTTPHEADER => array(
                'Authorization: MCDKEY_903sfjfi0ad833mk8537dhc03kbs120r0h9a'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
        $data = json_decode($response, true);
        $plan= $data["data"];
        foreach ($plan as $pla) {
            $name = $pla['name'];
            $code = $pla['code'];
//return $response;
            $bo = data::create([
                'plan_id' => 'electricity',
                'plan' => 'elect',
                'network' => $name,
                'amount' => '0',
                'tamount' => '0',
                'cat_id' => $code,
            ]);
        }
    }
    public function electric(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $tv = data::where('network', 'elect')->get();

            return  view('elect', compact('user', 'tv'));

        }
        return redirect("login")->withSuccess('You are not allowed to access');

    }
    public function verifyelect(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $tv = data::where('id', $request->id)->first();


            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://test.mcd.5starcompany.com.ng/api/reseller/validate',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('service' => 'electricity', 'coded' => $tv->plan_id, 'phone' => $request->number),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: MCDKEY_903sfjfi0ad833mk8537dhc03kbs120r0h9a'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
//            echo $response;
            $data = json_decode($response, true);
            $success= $data["success"];
            $name=$data["data"];
            if ($success = 1){
                $log=$name;
            }else{
                $log= "Unable to Identify meter Number";
            }
            return view('payelect', compact('log', 'request', 'name'));


        }
    }
    public function payelect(Request $request)
    {
        if (Auth::check()) {
            $user = User::find($request->user()->id);
            $tv = data::where('id', $request->id)->first();

            $wallet = wallet::where('username', $user->username)->first();


            if ($wallet->balance < $request->amount) {
                $mg = "You Cant Make Purchase Above" . "NGN" . $request->amount . " from your wallet. Your wallet balance is NGN $wallet->balance. Please Fund Wallet And Retry or Pay Online Using Our Alternative Payment Methods.";
                Alert::error('Error', $mg);
                return redirect('dashboard');
            }
            if ($request->amount < 0) {

                $mg = "error transaction";
                Alert::error('Error', $mg);
                return redirect('dashboard');
            }
            $bo = bo::where('refid', $request->refid)->first();
            if (isset($bo)) {
                $mg = "duplicate transaction";
                Alert::error('Error', $mg);
                return redirect('dashboard');
            } else {
                $gt = $wallet->balance - $request->amount;


                $wallet->balance = $gt;
                $wallet->save();
                $resellerURL = 'https://renomobilemoney.com/api/';


                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL => $resellerURL.'payelect',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('service' => 'electricity', 'coded' => $tv->plan_id, 'phone' => $request->number, 'amount' => $request->amount, 'refid'=>$request->refid),
                    CURLOPT_HTTPHEADER => array(
                        'apikey: RENO-62c60552bbe6a5.09230661'
                    ),
                ));

                $response = curl_exec($curl);

                curl_close($curl);
//                echo $response;

                $data = json_decode($response, true);
                $success = $data["success"];
                $tran1 = $data["discountAmount"];
                $tran2 = $data["token"];

//                        return $response;
                if ($success == 1) {

                    $bo = bo::create([
                        'username' => $user->username,
                        'plan' => $tv->network,
                        'amount' => $request->amount,
                        'server_res' => $response,
                        'result' => $success,
                        'phone' => $request->number,
                        'refid' => $request->refid,
                        'discountamoun' => $tran1,
                        'token' => $tran2,
                    ]);


                    $name = $tv->plan;
                    $am = $tv->network."was Successful to";
                    $ph = $request->number."| Token:".$tran2;

                    $receiver = $user->email;
                    $admin = 'admin@primedata.com.ng';
                    $admin1 = 'primedata18@gmail.com';

//                    Mail::to($receiver)->send(new Emailtrans($bo));
//                    Mail::to($admin)->send(new Emailtrans($bo));
//                    Mail::to($admin1)->send(new Emailtrans($bo));
                    Alert::success('Success', $am.' '.$ph);
                    return redirect('dashboard');

                }elseif ($success==0){
                    $zo=$user->balance+$tv->tamount;
                    $user->balance = $zo;
                    $user->save();

                    $name= $tv->network;
                    $am= "NGN $request->amount Was Refunded To Your Wallet";
                    $ph=", Transaction fail";

                    return view('bill', compact('user', 'name', 'am', 'ph', 'success'));

                }
            }
        }
    }

}
