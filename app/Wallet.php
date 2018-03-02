<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use Token;

class Wallet extends Model
{
    protected $guarded = [];

     /**
     * Get Ether balance of the wallet
     *
     * @return string
     */
    public function getEthBalanceAttribute()
    {
        return getEtherBalance($this->address);
    }

    public function getTokenBalance($token) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);

        $response = $client->request('GET', "ico/balance/{$token->token_address}/{$this->address}" , [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);
        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {
                return round(fromWei($result->balance, 'ether'), 3);
            }
        }
    }
}
