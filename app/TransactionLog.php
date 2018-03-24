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

    public function wallet() {
        return $this->belongsTo('App\Wallet', 'from', 'address');
    }

    public function bankReceipt() {
        return $this->belongsTo('App\BankReceipt', 'ref_id', 'id');
    }

    public function getStageAttribute() {
        $stage = $this->token->stages()
                                ->whereRaw('"'.$this->created_at.'" between start_at and end_at')
                                ->first();
        return $stage;
    }
}
