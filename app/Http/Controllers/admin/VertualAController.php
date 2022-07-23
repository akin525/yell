<?php

namespace app\Http\Controllers\admin;

use App\Mail\Emailpass;
use App\Models\User;
use App\Models\wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VertualAController
{
public function list()
{
    $vertual=wallet::get();
    $alluser = User::count();


    return view('admin/vertual', compact('vertual', 'alluser' ));

}
public function users()
{
    $users=User::get();

    return view('admin/users', compact('users' ));

}
public function edituser(Request $request)
{
    $users=User::where('id', $request->id)->first();

    return view('admin/edituser', compact('users' ));

}
public function updateuser(Request $request)
{
    $request->validate([
        'email' => 'required',
        'number' => 'required',
        'name' => 'required',
        'username' => 'required',
        'role' => 'required',
    ]);
    $users=User::where('username', $request->username)->first();
    $users->name=$request->name;
    $users->phone_no=$request->number;
    $users->email=$request->email;
    $users->role=$request->role;
    $users->save();

    return redirect(url('admin/profile/'.$users->username))
        ->with('status', $users->username.' was updated successfully');

}
public function pass(Request $request)
{
    $request->validate([
        'username' => 'required',
    ]);
    $users=User::where('username', $request->username)->first();
    $new= uniqid('pass', true);

    $users->password=$new;
    $users->save();
    $admin= 'admin@primedata.com.ng';
    $admin1= 'primedata18@gmail.com';

    $receiver= $users->email;
    Mail::to($receiver)->send(new Emailpass($new));
    Mail::to($admin)->send(new Emailpass($new ));
    Mail::to($admin1)->send(new Emailpass($new ));
    return redirect(url('admin/profile/'.$request->username))
        ->with('status', $users->username.' password was change successfully');

}
public function apikey(Request $request)
{
    $request->validate([
        'username' => 'required',
    ]);
    $users=User::where('username', $request->username)->first();
    $api= uniqid("PRIME", true);
    $users->apikey=$api;
    $users->save();
    return redirect(url('admin/profile/'.$request->username))
        ->with('status', $users->username.' New Api was Generated Successfully');
}
}
