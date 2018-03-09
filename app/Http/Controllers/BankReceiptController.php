<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Token;
use App\BankReceipt;

class BankReceiptController extends Controller
{
    /**
     * Pay with bank transfer
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $this->validate($request, [
            'token' => 'required|exists:tokens,id',
            'token_amount' => 'required|numeric',
            'eth_value' => 'required|numeric',
            'usd_value' => 'required|numeric'
        ]);
        $data['token'] = Token::find($request->input('token'));
        $data['eth_value'] = $request->input('eth_value');
        $data['usd_value'] = $request->input('usd_value');
        $data['token_amount'] = $request->input('token_amount');
        $data['order_id'] = date('Ym') . substr(hexdec(uniqid()), 0, 8);

        return view('receipt.create', $data);
    }

    /**
     * Save Bank transfer Reciept
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $this->validate($request, [
            'token' => 'required|exists:tokens,id',
            'token_amount' => 'required|numeric',
            'usd_value' => 'required|numeric',
            'order_id' => 'required|string',
            'bank_name' => 'required|string',
            'account_name' => 'required|string',
            'account_number' => 'required|string',
            'receipt' => 'required|file'
        ]);

        if($request->file('receipt')->isValid()) {
            $receipt = $request->file('receipt')->store('receipt', 'public');
        }

        BankReceipt::create([
            'user_id' => Auth::user()->id,
            'order_id' => $request->input('order_id'),
            'bank_name' => $request->input('bank_name'),
            'account_name' => $request->input('account_name'),
            'account_number' => $request->input('account_number'),
            'usd_value' => $request->input('usd_value'),
            'token_value' => $request->input('token_amount'),
            'receipt' => $receipt
        ]);
        
        $data['heading'] = 'Thank you';
        $data['message'] = 'Successfully submitted receipt. We will review soon and deliver coins';
        $data['description'] = 'Please email me if you have any questions';
        $data['link_label'] = 'Go to Dashboard';
        $data['link'] = route('users.dashboard');

        return view('layouts.error', $data);
    }
}
