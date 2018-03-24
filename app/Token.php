<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GuzzleHttp\Client;
use TransactionLog;

class Token extends Model
{
    protected $guarded = [];

    private $isInfoLoaded = false;
    private $totalSupply, $ethRaised, $tokenSold, $ethRaisedCurrentStage, $tokenSoldCurrentStage;

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
     * Get Token Sold
     *
     * @return string
     */
    public function getTokenSoldCurrentStageAttribute()
    {
        $this->loadInfo();
        return $this->tokenSoldCurrentStage;
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

    /**
     * Get Ether Raised
     *
     * @return string
     */
    public function getEtherRaisedCurrentStageAttribute()
    {
        $this->loadInfo();
        return $this->ethRaisedCurrentStage;
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
                $this->tokenSold = round($result->token_sold, 3);
                $this->totalSupply = $result->total_supply;
                $this->ethRaised = round($result->eth_raised, 3);
                $this->ethRaisedCurrentStage = round($result->eth_raised_current_stage, 3);
                $this->tokenSoldCurrentStage = round($result->token_sold_current_stage, 3);
                $this->isInfoLoaded = true;
            }
        }
    }
}
