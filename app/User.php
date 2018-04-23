<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password', 'role_id', 'phone', 'whitepaper', 'dob', 'country'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role() {
        return $this->belongsTo('App\UserRole');
    }

    public function wallet() {
        return $this->hasMany('App\Wallet');
    }

    public function emailVerification()
    {
        return $this->hasMany('App\EmailVerification');
    }

    public function getTotalAssetAttribute() {
        $tokens = Token::has('stages')->get();
        $total = 0;
        foreach($tokens as $token) {
            $total += $this->wallet[0]->getTokenBalance($token) * $token->currentStage()->price;
        }

        return $total;
    }

    public function getNameAttribute() {
        return $this->first_name.' '.$this->last_name;
    }
}
