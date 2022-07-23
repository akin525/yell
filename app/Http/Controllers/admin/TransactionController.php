<?php

namespace app\Http\Controllers\admin;

use App\Models\bo;
use App\Models\deposit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TransactionController
{
public function index()
{
    $all=deposit::paginate(50);

    return view('admin/finddeposite', compact('all'));
}
    public function finduser(Request $request)
    {
        $input = $request->all();
        $user_name = $input['user_name'];
        $phoneno = $input['phoneno'];
        $reference = $input['reference'];
        $amount = $input['amount'];
        $date = $input['date'];

        // Instantiates a Query object
        $query = deposit::Where('username', 'LIKE', "%$user_name%")
            ->orWhere('payment_ref', 'LIKE', "%$reference%")
            ->orWhere('date', 'LIKE', "%$date%")
            ->OrderBy('id', 'desc')
            ->limit(1000)
            ->get();
        if(!$query){
            return redirect('admin/finddeposite')->with("error", "details does not exist");
        }
        $cquery = deposit::Where('username','LIKE',  "%$user_name%")
            ->orWhere('payment_ref', 'LIKE', "%$reference%")
            ->orWhere('date', 'LIKE', "%$date%")
            ->count();

        return view('admin/finddeposite', ['datas' => $query, 'count' => $cquery, 'result' => true]);
    }
    public function in(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');


        $data =deposit::orderBy('id', 'desc')->paginate(25);
        $tt = deposit::count();
        $ft = deposit::where([['date', 'like', Carbon::now()->format('Y-m-d') . '%']])->count();
        $st = deposit::where([['date', 'like', Carbon::now()->subDay()->format('Y-m-d') . '%']])->count();
        $rt = deposit::where([['date', 'like', Carbon::now()->subDays(2)->format('Y-m-d') . '%']])->count();
        $amount=deposit::sum('amount');
        $am=deposit::where([['date', 'LIKE', '%' . $today . '%']])->sum('amount');
        $am1=deposit::where([['date', 'like', '%'. Carbon::now()->subDay()->format('y-m-d'). '%']])->sum('amount');
        $am2=deposit::where([['date', 'like', '%'. Carbon::now()->subDays(2)->format('y-m-d'). '%']])->sum('amount');


        return view('admin/deposits', ['data' => $data,'amount'=>$amount, 'am'=>$am, 'am1'=>$am1, 'am2'=>$am2,  'tt' => $tt, 'ft' => $ft, 'st' => $st, 'rt' => $rt]);

    }
    public function bill()
    {
        $today = Carbon::now()->format('Y-m-d');


        $data =bo::orderBy('id', 'desc')->paginate(25);
        $tt = bo::count();
        $ft = bo::where([['date', 'like', Carbon::now()->format('Y-m-d') . '%']])->count();
        $st = bo::where([['date', 'like', Carbon::now()->subDay()->format('Y-m-d') . '%']])->count();
        $rt = bo::where([['date', 'like', Carbon::now()->subDays(2)->format('Y-m-d') . '%']])->count();
        $amount=bo::sum('amount');
        $am=bo::where([['date', 'LIKE', '%' . $today . '%']])->sum('amount');
        $am1=bo::where([['date', 'like', '%'. Carbon::now()->subDay()->format('y-m-d'). '%']])->sum('amount');
        $am2=bo::where([['date', 'like', '%'. Carbon::now()->subDays(2)->format('y-m-d'). '%']])->sum('amount');

        return view('admin/bills', ['data' => $data,'amount'=>$amount, 'am'=>$am, 'am1'=>$am1, 'am2'=>$am2,  'tt' => $tt, 'ft' => $ft, 'st' => $st, 'rt' => $rt]);

    }


}
