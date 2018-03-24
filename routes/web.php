<?php

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
    return redirect()->route('users.dashboard');
});

Auth::routes();

Route::resource('tokens', 'TokenController');
Route::post('tokens/stage/create/{token}', 'TokenController@createStage')->name('tokens.createStage');
Route::post('tokens/stage/update/{token}', 'TokenController@updateStage')->name('tokens.updateStage');
Route::get('allocate_coin', 'TokenController@allocatePage')->name('tokens.allocatePage');
Route::post('allocate_coin', 'TokenController@allocate')->name('tokens.allocate');

Route::resource('users', 'UserController');
Route::get('users/buy/{token}', 'UserController@buyToken')->name('users.buy');
Route::post('users/send/ether', 'UserController@sendEther')->name('users.sendEther');
Route::get('dashboard', 'UserController@dashboard')->name('users.dashboard');

Route::get('receipts', 'BankReceiptController@index')->name('receipts.index')->middleware('admin');
Route::post('receipts/create', 'BankReceiptController@create')->name('receipts.create');
Route::post('receipts', 'BankReceiptController@store')->name('receipts.store');
Route::get('receipts/approve/{receipt}', 'BankReceiptController@approve')->name('receipts.approve')->middleware('admin');
Route::get('receipts/dismiss/{receipt}', 'BankReceiptController@dismiss')->name('receipts.dismiss')->middleware('admin');

Route::get('tx', 'TransactionLogController@index')->name('tx.index')->middleware('admin');
Route::get('tx/{log}', 'TransactionLogController@show')->name('tx.show');

Route::get('/mailable', function() {
    $receipt = App\BankReceipt::find(1);
    $log = App\TransactionLog::where('transaction_type_id', 1)->first();

    Mail::to('yoshiro.sakanishi@hotmail.com')
            ->queue(new App\Mail\BankReceiptApproved($receipt));

    // return new App\Mail\BankReceiptSubmitted($receipt);
    return new App\Mail\BankReceiptApproved($receipt);
    //return new App\Mail\EtherTxApproved($log);
});