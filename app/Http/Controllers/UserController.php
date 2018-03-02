<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use GuzzleHttp\Client;
use App\User;
use App\Token;
use App\TransactionLog;

class UserController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Store a newly created resource in storage.
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
            'eth_value' => 'required|numeric'
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
                        'token_id' => $token->id,
                        'tx_hash' => $result->tx_hash
                    ]);

                    return response()->json([
                        'success' => true,
                        'tx_hash' => $result->tx_hash
                    ]);
                }
            }
        } catch(GuzzleHttp\Exception\ClientException $ex) {
            $message = "Transaction failed, insufficient funds for gas * price + value";
            if ($ex->hasResponse()) {
                $response = json_decode($ex->getResponse()->getBody()->getContents());
                //$message = $response->message;
            }
            return response()->json([
                'success' => false,
                'message' => $message
            ], 400);
        } catch(GuzzleHttp\Exception\ConnectException $ex) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot connect to Ethereum Node'
            ], 500);
        }
    }
}
