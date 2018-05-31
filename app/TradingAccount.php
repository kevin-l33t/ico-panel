<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradingAccount extends Model
{
    public function account() {
        return $this->belongsTo('App\User', 'trading_account_id', 'id');
    }
}
