<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionLog extends Model
{
    protected $guarded = [];

    public function token() {
        return $this->belongsTo('App\Token');
    }
}
