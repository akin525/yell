<?php

namespace App\Http\Controllers;

use App\Mail\login;
use App\Models\airtimecon;
use App\Models\big;
use App\Models\charp;
use App\Mail\Emailpass;
use App\Models\Messages;
use App\Models\refer;
use App\Models\server;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\wallet;
use App\Models\bo;
use App\Models\data;
use App\Models\deposit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;


class AuthController
{
public function pass(Request $request)
{
    $request->validate([
        'email' => 'required',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!isset($user)){

        return redirect(route('password.request'))
            ->with('error', "Email not found in our system");

    }elseif ($user->email == $request->email){
        $new= uniqid('Pass',true);

        $user->password=$new;
        $user->save();

        $admin= 'admin@primedata.com.ng';
        $admin1= 'primedata18@gmail.com';

        $receiver= $user->email;
//        Mail::to($receiver)->send(new Emailpass($new));
//        Mail::to($admin)->send(new Emailpass($new ));
//        Mail::to($admin1)->send(new Emailpass($new ));

        return redirect(route('password.request'))
            ->with('success', "New Password has been sent to your email");
    }
}
    public function cus(Request $request)
    {
        if (Auth()->user()) {
            return redirect(route('dashboard'))
                ->withSuccess('Signed in');

        }else{
            return redirect(route('log'));
        }
    }
    public function customLogin(Request $request)
    {
        if (Auth()->user()){
            return redirect(route('dashboard'))
                ->withSuccess('Signed in');

        }

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->where('password', $request->password)
            ->first();

        if(!isset($user)){

            Alert::error('Credentials does not match', 'Kindly Provide correct email & password');

            return back();
        }

        Auth::login($user);
        $admin= 'admin@primedata.com.ng';
        $admin1= 'primedata18@gmail.com';

        $user=User::where('email', $request->email)->first();
$login=$user->name;
        $receiver= $request->email;
        Mail::to($receiver)->send(new login($login));
        Mail::to($admin)->send(new login($login ));
        Mail::to($admin1)->send(new login($login ));

        Alert::success('Dashboard', 'Login Successfully');
        return redirect()->intended('dashboard')
            ->withSuccess('Signed in');


    }
    public function dashboard(Request $request)
    {

            $user = User::find($request->user()->id);
            $me = Messages::where('status', 1)->first();
            $refer = refer::where('username', $request->user()->username)->get();
            $totalrefer = 0;
            foreach ($refer as $de){
                $totalrefer += $de->amount;

            }
            $count = refer::where('username',$request->user()->username)->count();

//            $wallet = wallet::where('username', $user->username)->get();
            $deposite = deposit::where('username', $request->user()->username)->get();
            $totaldeposite = 0;
            foreach ($deposite as $depo){
                $totaldeposite += $depo->amount;

            }
            $bil2 = bo::where('username', $request->user()->username)->get();
            $bill = 0;
            foreach ($bil2 as $bill1){
                $bill += $bill1->amount;

            }
            $charge=charp::where('username',$user->username )->sum('amount');

            return  view('dashboard', compact('user', 'charge',  'totaldeposite', 'me', 'deposite',  'bil2', 'bill', 'totalrefer', 'count'));

    }
    public function refer(Request $request)
    {

            $user = User::find($request->user()->id);
            $refer = refer::where('username', $user->username)->first();

            $refers = refer::where('username', $request->user()->username)->get();
            $totalrefer = 0;
            foreach ($refers as $depo){
                $totalrefer+= $depo->amount;

            }

            return  view('referal', compact('user', 'refers', 'refer', 'totalrefer'));

    }
    public function select(Request  $request)
    {
        $serve = server::where('status', '1')->first();

            $user = User::find($request->user()->id);


            return view('select', compact('user', 'serve'));
       }
    public function select1(Request  $request)
    {
        $serve = server::where('status', '1')->first();

            $user = User::find($request->user()->id);


            return view('select1', compact('user', 'serve'));
         }
    public function buydata(Request  $request)
    {
        $request->validate([
            'id' => 'required',
        ]);
        $serve = server::where('status', '1')->first();

        if ($serve->name == 'mcd') {
            $user = User::find($request->user()->id);
            $data = data::where(['status' => 1])->where('network', $request->id)->get();


            return view('buydata', compact('user', 'data'));
        } elseif ($serve->name == 'honorworld') {
            $user = User::find($request->user()->id);
            $data= big::where('status', '1')->where('network', $request->id)->get();
//return $data;
            return view('buydata', compact('user', 'data'));

        }
       }
    public function redata(Request  $request)
    {

        $request->validate([
            'id' => 'required',
        ]);
        $daterserver = new DataserverController();
        $serve = server::where('status', '1')->first();
//return $request->id;
        if ($serve->name == 'mcd') {
            $user = User::find($request->user()->id);
            $data = data::where(['status' => 1])->where('network', $request->id)->get();

//return $data;
            return view('redata', compact('user', 'data'));
        } elseif ($serve->name == 'honorworld') {
            $user = User::find($request->user()->id);
            $data= big::where('status', '1')->where('network', $request->id)->get();
//return $data;
            return view('redata', compact('user', 'data'));

        }
       }
    public function pre(Request $request)


    {
        $request->validate([
            'id' => 'required',
        ]);
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $data = data::where('id',$request->id )->get();

            return view('pre', compact('user', 'data'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function airtime(Request  $request)
    {
        $con=DB::table('airtimecons')->where('status', '=', '1')->first();
        $se=$con->server;
        if ($se == 'MCD') {
            $user = User::find($request->user()->id);
            $data = data::where('plan_id', "airtime")->get();
//            $wallet = wallet::where('username', $user->username)->first();

            return view('airtime', compact('user', 'data'));
        } elseif ($se == 'Honor'){
            return view('airtime1');

        }
    }

    public function invoice(Request  $request)
    {
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $bill = bo::where('username', $request->user()->username)->get();


            return view('invoice', compact('user', 'bill'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
    public function charges(Request  $request)
    {
        if(Auth::check()){
            $user = User::find($request->user()->id);
            $bill = charp::where('username', $request->user()->username)->get();


            return view('charges', compact('user', 'bill'));
        }

        return redirect("login")->withSuccess('You are not allowed to access');
    }
}
