<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankReceipt extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function token() {
        return $this->belongsTo('App\Token');
    }

    public function transactionLogs() {
        return $this->hasMany('App\TransactionLog', 'ref_id', 'id');
    }
}
