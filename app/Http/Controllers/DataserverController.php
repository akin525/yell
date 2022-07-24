<?php
namespace App\Http\Controllers;
use App\Mail\Emailfund;
use App\Mail\Emailtrans;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use App\Models\profit;
use App\Models\server;
use App\Models\setting;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
class DataserverController extends Controller
{

    public function honourwordbill($request)
    {

//return $request;
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.honourworld.com.ng/api/v1/purchase/data',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
  "network" : "'.$request->network.'",
   "planId" : "'.$request->plan_id.'",
  "phone" : "'.$request->number.'"
}',
            CURLOPT_HTTPHEADER => array(
//                'Authorization: Bearer sk_live_9a55cd84-8ad7-46d9-9136-c5962858f753',
                'Accept: application/json',
                'Content-Type: application/json'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
//        echo $response;

                    return $response;

            }

    public function mcdbill( $request)
    {

        $resellerURL = 'https://renomobilemoney.com/api/';
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$resellerURL.'data',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('code' =>$request->plan_id, 'number' => $request->number, 'amount'=>$request->ramount, 'refid'=>$request->id),

                         CURLOPT_HTTPHEADER => array(
                             'apikey: RENO-62ddc85d549f76.59606188'
                         )));


        $response = curl_exec($curl);

                curl_close($curl);
//                echo $response;


                return $response;

            }
}



