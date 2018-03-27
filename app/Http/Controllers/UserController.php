<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use App\User;
use App\UserRole;
use App\Token;
use App\TransactionLog;
use App\Wallet;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
        $this->middleware('admin')->only(['create', 'store', 'destroy']);
    }

    /**
     * Show the User dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $data['user'] = Auth::user();
        $data['tokens'] = Token::has('stages')->get();
        $data['transactions'] = Auth::user()->wallet[0]->transactions()->orderBy('created_at', 'desc')->get();
        return view('user.dashboard', $data);
    }

    /**
     * Show Buy Coin Form
     *
     * @param  Token  $token
     * @return \Illuminate\Http\Response
     */
    public function buyToken(Token $token)
    {
        $data['user'] = Auth::user();
        $data['token'] = $token;
        return view('user.buy', $data);
    }

    /**
     * Send Ether
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendEther(Request $request)
    {
        $this->validate($request, [
            'token' => 'required|exists:tokens,id',
            'eth_value' => 'required|numeric',
            'usd_value' => 'required|numeric',
            'token_value' => 'required|numeric'
        ]);

        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);

        $token = Token::find($request->input('token'));
        $user = Auth::user();

        $tokenRequestParams = [
            'address' => $token->crowdsale_address,
            'private_key' => $user->wallet[0]->private_key,
            'value' => $request->input('eth_value')
        ];
        try {
            $response = $client->request('POST', 'account/sendTransaction', [
                'json' => $tokenRequestParams,
                'headers' => [
                    'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $result = json_decode($response->getBody()->getContents());
                if ($result->success) {

                    TransactionLog::create([
                        'from' => $user->wallet[0]->address,
                        'to' => $token->crowdsale_address,
                        'eth_value' => $request->input('eth_value'),
                        'usd_value' => $request->input('usd_value') * 100,
                        'token_value' => $request->input('token_value'),
                        'token_id' => $token->id,
                        'transaction_type_id' => 1,
                        'tx_hash' => $result->tx_hash
                    ]);

                    return response()->json([
                        'success' => true,
                        'tx_hash' => $result->tx_hash
                    ]);
                }
            }
        } catch(\GuzzleHttp\Exception\ClientException $ex) {
            $message = "Transaction failed, insufficient funds for gas * price + value";
            if ($ex->hasResponse()) {
                $response = json_decode($ex->getResponse()->getBody()->getContents());
                //$message = $response->message;
            }
            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        } catch(\GuzzleHttp\Exception\ConnectException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to Ethereum Node'
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['users'] = User::orderBy('created_at')->get();
        return view('user.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['action'] = route('users.store');
        $data['user'] = new User;
        $data['user']->role_id = 3; // create artist
        $data['roles'] = UserRole::all();
        return view('user.edit', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->middleware('admin');
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'phone' => 'required|string|max:25|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|integer|exists:user_roles,id'
        ]);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'password' => bcrypt($request->input('password')),
            'role_id' =>$request->input('role')
        ]);

        if ($user->role->name == 'Artist' && $request->has('whitepaper')) {
            $user->whitepaper = $request->input('whitepaper');
            $user->save();
        }

        if($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $user->profile_picture = $request->file('profile_picture')->store('profile', 'public');

            if($request->has('profile_thumb')) {
                $user->profile_thumb = $request->input('profile_thumb');
                list($meta, $data) = explode(',', $request->input('profile_thumb'));
                $data = base64_decode($data);
                $path = 'profile_thumb/thumb_' . $user->id . '.png';
                Storage::put($path, $data, 'public');
                $user->profile_thumb = $path;
            }
            
            $user->save();
        }

        // create new wallet for the user.
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);

        $response = $client->request('GET', 'account/create', [
            'http_errors' => false,
            'headers' => [
                "Authorization" => "API-KEY TESTKEY"
            ]
        ]);

        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {
                $user->wallet()->create([
                    'address' => $result->address,
                    'private_key' => $result->privateKey
                ]);
                addToWhitelist($result->address);
            }
        }

        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $data['action'] = route('users.update', [$user]);
        $data['method'] = method_field('PUT');
        $data['user'] = $user;
        $data['roles'] = UserRole::all();
        $data['transactions'] = $user->wallet[0]->transactions()->orderBy('created_at', 'desc')->get();
        return view('user.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        if ($request->has('role') && Auth::user()->role->name == 'Administrator') {
            $user->role_id = $request->input('role');
        }
        $user->phone = $request->input('phone');
        if ($request->has('password') && !empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        if ($user->role->name == 'Artist') {
            $user->whitepaper = $request->input('whitepaper');
        }

        if($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $user->profile_picture = $request->file('profile_picture')->store('profile', 'public');

            if($request->has('profile_thumb')) {
                $user->profile_thumb = $request->input('profile_thumb');
                list($meta, $data) = explode(',', $request->input('profile_thumb'));
                $data = base64_decode($data);
                $path = 'profile_thumb/thumb_' . $user->id . '.png';
                Storage::put($path, $data, 'public');
                $user->profile_thumb = $path;
            }
        }

        $user->save();

        return redirect()->route('users.edit', $user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try{
            if (count($user->wallet) > 0) {
                $user->wallet[0]->delete();
            }
            $user->delete();
        } catch ( \Illuminate\Database\QueryException $ex ) {
            return response()->json([
                'success' => false,
                'msg' => $ex->getMessage()
            ], 500);
        }
        
        return response()->json([
            'success' => true
        ]);
    }
}
