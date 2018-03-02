<?php

use GuzzleHttp\Client;

/**
 * Get Ether balance of the address
 * @param $address Ethereum Address
 * @return EtherBalance
 */
function getEtherBalance($address) {
    $client = new Client([
        // Base URI is used with relative requests
        'base_uri' => env('ETHERSCAN_API_URL'),
        // You can set any number of default request options.
        'timeout'  => 10.0
    ]);
    $response = $client->request('GET', 'api', [
        'http_errors' => false,
        'query' => [
            'module' => 'account',
            'action' => 'balance',
            'address' => $address,
            'tag' => 'latest',
            'apikey' => env('ETHERSCAN_API_KEY')
        ]
    ]);
    if ($response->getStatusCode() == 200) {
        $result = json_decode($response->getBody()->getContents());
        if ($result->status == 1) {
            return round(fromWei($result->result, 'ether'), 3);
        }
    }
}

function fromWei($wei, $unit) {
    switch($unit) {
        case 'ether':
            return $wei / 1.0E18; 
        default:
            return $wei;
    }
}

function getEtherUSDPrice() {
    static $etherPriceUsd;
    if (empty($etherPriceUsd)) {
        $client = new Client([
            // Base URI is used with relative requests
            'base_uri' => env('ETHERSCAN_API_URL'),
            // You can set any number of default request options.
            'timeout'  => 10.0
        ]);
        $response = $client->request('GET', 'api', [
            'http_errors' => false,
            'query' => [
                'module' => 'stats',
                'action' => 'ethprice',
                'apikey' => env('ETHERSCAN_API_KEY')
            ]
        ]);
        if ($response->getStatusCode() == 200) {
            $result = json_decode($response->getBody()->getContents());
            if ($result->status == 1) {
                $etherPriceUsd = $result->result->ethusd;
            }
        }
    }

    return $etherPriceUsd;
}

function ethToUsd($ether) {

    return empty($ether) ? $ether :  round(getEtherUSDPrice() * $ether, 2);
}
