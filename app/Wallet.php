<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
