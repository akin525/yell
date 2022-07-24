<?php

namespace App\Http\Controllers\Api;
use App\Mail\Emailcharges;
use App\Mail\Emailfund;
use App\Models\bo;
use App\Models\charp;
use App\Models\web;
use App\Models\webook;
use App\Models\deposit;
use App\Models\setting;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class VertualController
{
    public function vertual(Request $request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        if ($user) {

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://app.mcd.5starcompany.com.ng/api/reseller/virtual-account',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_SSL_VERIFYHOST => 0,
                CURLOPT_SSL_VERIFYPEER => 0,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => array('account_name' => $user->username, 'business_short_name' => 'EVERDATA', 'uniqueid' => $user->name, 'email' => $user->email, 'phone' => '08146328645', 'webhook_url' => 'https://mobile.prinedata.com.ng/run.php',),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: MCDKEY_903sfjfi0ad833mk8537dhc03kbs120r0h9a'
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
//            echo $response;
//return $response;
//var_dump(array('account_name' => $name,'business_short_name' => 'RENO','uniqueid' => $username,'email' => $email,'phone' => '08146328645', 'webhook_url'=>'https://renomobilemoney.com/go/run.php'));
            $data = json_decode($response, true);
            $account = $data["data"]["account_name"];
            $number = $data["data"]["account_number"];
            $bank = $data["data"]["bank_name"];

            $user->account_no = $number;
            $user->account_name = $account;
            $user->save();

            return response()->json([
                'message' => 'You are not allowed to access',
            ], 200);


        }
    }

    public function run(Request $request)
    {
//        $web = web::create([
//            'webbook' => $request
//        ]);

        if ($json = json_decode(file_get_contents("php://input"), true)) {
            print_r($json['ref']);
//    print_r($json['accountDetails']['accountName']);
            $data = $json;

        }
// return  $data;
//   $data = json_decode($request, true);

//$paid=$data["paymentStatus"];
        $refid=$data["ref"];
        $amount=$data["amount"];
        $no=$data["account_number"];

        // return $request->all();
//  echo $amount;
// echo $bank;
//echo $acct;

        $wallet = User::where('account_number', $no)->first();
        $pt=$wallet['wallet'];

        if ($no == $wallet->account_number) {
            $depo = deposit::where('payment_ref', $refid)->first();
            $user = user::where('username', $wallet->username)->first();
            if (isset($depo)) {
                echo "payment refid the same";
            }else {

                $char = setting::first();
                $amount1 = $amount - $char->charges;


                $gt = $amount1 + $pt;
                $reference=$refid;

                $deposit = deposit::create([
                    'username' => $wallet->username,
                    'payment_ref' =>$refid,
                    'amount' => $amount,
                    'iwallet' => $pt,
                    'fwallet' => $gt,
                ]);
                $charp = charp::create([
                    'username' => $wallet->username,
                    'payment_ref' =>"Api". $reference,
                    'amount' => $char->charges,
                    'iwallet' => $pt,
                    'fwallet' => $gt,
                ]);
                $wallet->wallet = $gt;
                $wallet->save();
                $user = user::where('username', $wallet->username)->first();


                $admin= 'admin@primedata.com.ng';
                $admin2= 'primedata18@gmail.com';

                $receiver= $user->email;
//                Mail::to($receiver)->send(new Emailcharges($charp ));
//                Mail::to($admin)->send(new Emailcharges($charp ));
//                Mail::to($admin2)->send(new Emailcharges($charp ));


                $receiver = $user->email;
//                Mail::to($receiver)->send(new Emailfund($deposit));
//                Mail::to($admin)->send(new Emailfund($deposit));
//                Mail::to($admin2)->send(new Emailfund($deposit));


                $resellerURL = 'https://renomobilemoney.com/api/';
                $curl = curl_init();

                curl_setopt_array($curl, array(
                    CURLOPT_URL =>$resellerURL.'fund',
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => '',
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 0,
                    CURLOPT_FOLLOWLOCATION => true,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST => 'POST',
                    CURLOPT_POSTFIELDS => array('refid' =>$refid, 'amount' => $amount),

                    CURLOPT_HTTPHEADER => array(
                        'apikey: RENO-62c60552bbe6a5.09230661'
                    )));


                $response = curl_exec($curl);

                curl_close($curl);
//                echo $response;


                return $response;

            }


        }
    }

    public function honor(Request $request)
    {
//        dd($request->all());
//        $webook=webook::create([
//            'code'=>$request,
//            'message'=>$request,
//        ]);

       $json = json_decode(file_get_contents("php://input"), true) ;
//            print_r($json['ref']);
//    print_r($json['accountDetails']['accountName']);
//        return $request;
//        $data = json_decode($request, true);

        $data = $json;
//        return $data;



        $code=$data['code'];
        $message=$data['message'];

        $webook=webook::create([
            'code'=>$code,
            'message'=>$message,
        ]);
    }
}
