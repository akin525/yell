<?php

namespace App\Http\Controllers\Api;

use App\Models\Messages;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\wallet;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;



class ResellerdetailsController
{
    public function details(Request $request)
    {
        $apikey = $request->header('apikey');
        $user = User::where('apikey',$apikey)->first();
        if ($user) {
            $me = Messages::where('status', 1)->first();
            $wallet = wallet::where('username', $user->username)->first();
            $deposite = deposit::where('username', $user->username)->get();
            $totaldeposite = 0;
            foreach ($deposite as $depo){
                $totaldeposite += $depo->amount;

            }
            $bil2 = bo::where('username', $user->username)->get();
            $bill = 0;
            foreach ($bil2 as $bill1){
                $bill += $bill1->amount;

            }
            return response()->json([
                'success' => 1,
                'message' => 'Data Fetch Successfully',
                'user' => $user, 'wallet' =>$wallet, 'totaldeposite' => $totaldeposite,
                'me' => $me, 'bil2' => $bil2, 'bill' => $bill
                ], 200);
        }
    }
}
