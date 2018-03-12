<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $guarded = [];

    public function token() {
        return $this->belongsTo('App\Token');
    }

    public function type() {
        return $this->belongsTo('App\TransactionType', 'transaction_type_id', 'id');
    }
}
