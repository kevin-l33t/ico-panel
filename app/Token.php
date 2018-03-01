<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;

class Token extends Model
{
    protected $guarded = [];

    private $isInfoLoaded = false;
    private $totalSupply, $ethRaised, $tokenSold;

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function stages() {
        return $this->hasMany('App\SaleStage');
    }

    public function currentStage() {
        return $this->stages()->latest()->first();
    }

    /**
     * Get TotalSupply
     *
     * @return string
     */
    public function getTotalSupplyAttribute()
    {
        $this->loadInfo();
        return $this->totalSupply;
    }

    /**
     * Get Token Sold
     *
     * @return string
     */
    public function getTokenSoldAttribute()
    {
        $this->loadInfo();
        return $this->tokenSold;
    }

    /**
     * Get Ether Raised
     *
     * @return string
     */
    public function getEtherRaisedAttribute()
    {
        $this->loadInfo();
        return $this->ethRaised;
    }

    private function loadInfo() {
        if ($this->isInfoLoaded) {
            return;
        }
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('TOKEN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);

        $response = $client->request('GET', 'ico/contract/'.$this->user->wallet[0]->address, [
            'http_errors' => false,
            'headers' => [
                'Authorization' => 'API-KEY ' . env('TOKEN_API_KEY')
            ]
        ]);
        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->success) {
                $this->tokenSold = $result->token_sold;
                $this->totalSupply = $result->total_supply;
                $this->ethRaised = $result->eth_raised;
                $this->isInfoLoaded = true;
            }
        }
    }
}
