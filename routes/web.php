<?php

use App\Http\Controllers\AirtimeController;
use App\Http\Controllers\AlltvController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\EkectController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\listdata;
use App\Http\Controllers\RefersController;
use App\Http\Controllers\ResellerController;
use App\Http\Controllers\VertualController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//Route::middleware([
//    'auth:sanctum',
//    config('jetstream.auth_session'),
//    'verified'
//])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');
//});
Route::middleware(['auth'])->group(function () {
    Route::view('picktv', 'picktv');
    Route::post('passw', [AuthController::class, 'pass'])->name('passw');
    Route::post('pick', [AlltvController::class, 'tv'])->name('pick');
    Route::get('select', [AuthController::class, 'select'])->name('select');
    Route::get('select1', [AuthController::class, 'select1'])->name('select1');
    Route::post('tvp', [AlltvController::class, 'paytv'])->name('tvp');
    Route::get('paytv', [AlltvController::class, 'paytv'])->name('paytv');
    Route::post('verifytv', [AlltvController::class, 'verifytv'])->name('verifytv');
    Route::get('listdata', [listdata::class, 'list'])->name('listdata');
    Route::get('listtv', [AlltvController::class, 'listtv'])->name('listv');
    Route::get('listelect', [EkectController::class, 'listelect'])->name('listelect');
    Route::get('elect', [EkectController::class, 'electric'])->name('elect');
    Route::post('velect', [EkectController::class, 'verifyelect'])->name('velect');
    Route::post('payelect', [EkectController::class, 'payelect'])->name('payelect');
    Route::get('invoice', [AuthController::class, 'invoice'])->name('invoice');
    Route::get('charges', [AuthController::class, 'charges'])->name('charges');
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::get('referal', [AuthController::class, 'refer'])->name('referal');
    Route::post('mp', [ResellerController::class, 'reseller'])->name('mp');
    Route::get('reseller', [ResellerController::class, 'sell'])->name('reseller');
    Route::get('upgrade', [ResellerController::class, 'apiaccess'])->name('upgrade');
    Route::post('buyairtime', [AirtimeController::class, 'airtime'])->name('buyairtime');
    Route::post('buyairtime1', [AirtimeController::class, 'honor'])->name('buyairtime1');
//Route::get('airtime1', [AuthController::class, 'airtime'])->name('airtime1');
    Route::get('airtime', [AuthController::class, 'airtime'])->name('airtime');
    Route::post('buydata', [AuthController::class, 'buydata'])->name('buydata');
    Route::post('redata', [AuthController::class, 'redata'])->name('redata');
    Route::post('pre', [AuthController::class, 'pre'])->name('pre');
    Route::post('bill', [BillController::class, 'bill'])->name('bill');
    Route::get('referwith', [RefersController::class, 'index'])->name('referwith');
    Route::post('referwith1', [RefersController::class, 'with'])->name('referwith1');
    Route::get('fund', [FundController::class, 'fund'])->name('fund');
    Route::get('tran/{reference}', [FundController::class, 'tran'])->name('tran');
    Route::get('vertual', [VertualController::class, 'vertual'])->name('vertual');
});

Route::get('/logout', function(){
    Auth::logout();
    return Redirect::to('login');
});
