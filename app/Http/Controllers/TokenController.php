<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Token;
use App\TransactionLog;
use App\Jobs\ConfirmCreateTokenTx;

class TokenController extends Controller
{

    public function __construct() {
        $this->middleware(['auth']);
        $this->middleware('admin')->except(['transfer', 'transferPage']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['tokens'] = Token::all();
        return view('token.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['artists'] = User::where('role_id', 3)->get();
        return view('token.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'artist' => 'required|exists:users,id',
            'token_name' => 'required|string|unique:tokens,name',
            'token_symbol' => 'required|string|unique:tokens,symbol'
        ]);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 20.0
        ]);

        $artist = User::find($request->input('artist'));
        $hcrTradingAccount = User::find(35);
        $adminAccount = User::find(2);

/*
* Generate Secondary wallet for artist trading account
        if (empty($artist->wallet[1])) {
            $response = $client->request('GET', 'account/create', [
                'http_errors' => false,
                'headers' => [
                    "Authorization" => "API-KEY TESTKEY"
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents());
                if ($result->success) {
                    $artistTradingWallet = $artist->wallet()->create([
                        'address' => $result->address,
                        'private_key' => $result->privateKey
                    ]);
                    addToWhitelist($artistTradingWallet->address);
                }
            }
        } else {
            $artistTradingWallet = $artist->wallet[1];
        }
*/

        // reference another account for artist trading account, must be defined at `trading_accounts` table

        if (empty($artist->tradingAccount)) {
            return response()->json([
                'success' => false,
                'message' => "{$artist->first_name} {$artist->last_name} doesn't have trading account. Please contact administrator."
            ], 422);
        }

        $artistTradingWallet = $artist->tradingAccount->account->wallet[0];

        $tokenRequestParams = [
            "token_name" => $request->input('token_name'),
            "token_symbol" => $request->input('token_symbol'),
            "artist_account" => $artist->wallet[0]->address,
            "artist_trading_account" => $artistTradingWallet->address,
            "hcr_trading_account" => $hcrTradingAccount->wallet[0]->address,
            "admin_account" => $adminAccount->wallet[0]->address
        ];

        $response = $client->request('POST', 'ico/create', [
            'http_errors' => false,
            'json' => $tokenRequestParams,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {
                $token = Token::create([
                    'user_id' => $request->input('artist'),
                    'tx_hash' => $result->tx_hash,
                    'name' => $request->input('token_name'),
                    'symbol' => $request->input('token_symbol')
                ]);

                ConfirmCreateTokenTx::dispatch($token);
                //ConfirmCreateTokenTx::dispatch($token)->delay(now()->addMinutes(1));

                return response()->json([
                    'success' => true,
                    'tx_hash' => $result->tx_hash
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Token API returns fail'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'cannot reach token API server'
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  App\Token $token
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        $data['token'] = $token;
        return view('token.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Create new ICO stage
     * @param  \Illuminate\Http\Request  $request
     * @param  Token  $token
     * @return \Illuminate\Http\Response
     */
    public function createStage(Request $request, Token $token) {
        $this->validate($request, [
            'supplier' => 'required|numeric',
            'price' => 'required|numeric',
            'supply' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $startDate = new Carbon($request->input('start_date'));
        $endtDate = new Carbon($request->input('end_date'));
        $price = $request->input('price') * 100;

        if ($request->input('supplier') == 0) {
            $private_key = User::find(2)->wallet[0]->private_key;
        } else {
            $private_key = $token->user->tradingAccount->account->wallet[0]->private_key;
        }

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 20.0
        ]);
        $requestParams = [
            "crowdsale_address" => $token->crowdsale_address,
            "token_address" => $token->token_address,
            "private_key" => $private_key,
            "start_date" => $startDate->timestamp,
            "end_date" => $endtDate->timestamp,
            "price" => $price,
            "supply" => $request->input('supply')
        ];

        $response = $client->request('POST', 'ico/stage/create', [
            'http_errors' => false,
            'json' => $requestParams,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {

                $token->stages()->create([
                    'start_at' => $startDate,
                    'end_at' => $endtDate,
                    'supply' => $request->input('supply'),
                    'price' => $price,
                    'tx_hash' => $result->tx_hash
                ]);
            }
        }
        
        return redirect()->route('tokens.show', [$token]);
    }

    /**
     * Update latest ICO stage
     * @param  \Illuminate\Http\Request  $request
     * @param  Token  $token
     * @return \Illuminate\Http\Response
     */
    public function updateStage(Request $request, Token $token) {
        $this->validate($request, [
            'start_date' => 'required|date',
            'end_date' => 'required|date'
        ]);

        $startDate = new Carbon($request->input('start_date'));
        $endtDate = new Carbon($request->input('end_date'));
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);
        $tokenRequestParams = [
            "crowdsale_address" => $token->crowdsale_address,
            "start_date" => $startDate->timestamp,
            "end_date" => $endtDate->timestamp
        ];
        $response = $client->request('POST', 'ico/stage/update', [
            'http_errors' => false,
            'json' => $tokenRequestParams,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {

                $currentStage = $token->currentStage();
                $currentStage->start_at = $startDate;
                $currentStage->end_at = $endtDate;
                $currentStage->tx_hash = $result->tx_hash;

                $currentStage->save();
            }
        }
        
        return redirect()->route('tokens.show', [$token]);
    }

    /**
     * show the form for allocating Tokens to user
     * @return \Illuminate\Http\Response
     */
    public function allocatePage() {
        $data['tokens'] = Token::has('stages')->get();
        $data['users'] = User::all();
        $data['administrators'] = User::where('role_id', 1)->get();
        return view('token.allocate', $data);
    }

    /**
     * allocate tokens
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function allocate(Request $request) {

        $this->validate($request, [
            'from' => 'required|integer|exists:users,id',
            'to' => 'required|integer|exists:users,id',
            'token' => 'required|integer|exists:tokens,id',
            'amount' => 'required|numeric'
        ]);

        $from = User::find($request->input('from'));
        $to = User::find($request->input('to'));
        $token = Token::find($request->input('token'));

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 20.0
        ]);
        $requestParams = [
            'token' => $token->token_address,
            'private_key' => $from->wallet[0]->private_key,
            'to' => $to->wallet[0]->address,
            'value' => $request->input('amount')
        ];
        $response = $client->request('POST', 'account/transferToken', [
            'http_errors' => false,
            'json' => $requestParams,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {

                TransactionLog::create([
                    'from' => $from->wallet[0]->address,
                    'to' => $to->wallet[0]->address,
                    'usd_value' => $token->currentStage()->price * $result->value,
                    'token_value' => $result->value,
                    'token_id' => $token->id,
                    'transaction_type_id' => 4,
                    'tx_hash' => $result->tx_hash
                ]);

                return response()->json([
                    'success' => true,
                    'tx_hash' => $result->tx_hash
                ]);
            }
        }

        return response()->json([
            'message' => false
        ], 500);
    }

    /**
     * show the form for transferring Tokens to user
     * @return \Illuminate\Http\Response
     */
    public function transferPage() {
        $data['tokens'] = Token::has('stages')->get();
        return view('token.transfer', $data);
    }

    /**
     * transfer tokens
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function transfer(Request $request) {

        $this->validate($request, [
            'email' => 'required|email|exists:users,email',
            'token' => 'required|integer|exists:tokens,id',
            'amount' => 'required|numeric'
        ]);

        $from = Auth::user();
        $to = User::where('email', $request->input('email'))->first();
        $token = Token::find($request->input('token'));

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 20.0
        ]);
        $requestParams = [
            'token' => $token->token_address,
            'private_key' => $from->wallet[0]->private_key,
            'to' => $to->wallet[0]->address,
            'value' => $request->input('amount')
        ];
        $response = $client->request('POST', 'account/transferToken', [
            'http_errors' => false,
            'json' => $requestParams,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {

                TransactionLog::create([
                    'from' => $from->wallet[0]->address,
                    'to' => $to->wallet[0]->address,
                    'usd_value' => $token->currentStage()->price * $result->value,
                    'token_value' => $result->value,
                    'token_id' => $token->id,
                    'transaction_type_id' => 4,
                    'tx_hash' => $result->tx_hash
                ]);

                return response()->json([
                    'success' => true,
                    'tx_hash' => $result->tx_hash
                ]);
            }
        }

        return response()->json([
            'message' => false
        ], 500);
    }
}