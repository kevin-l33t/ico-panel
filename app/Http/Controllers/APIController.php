<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Token;

class APIController extends Controller
{
    public function icoInfo()
    {
        $tokens = Token::has('stages')->get();
        foreach($tokens as $item) {
            $result [] = [
                'artist_name' => $item->user->name,
                'artist_avatar' => Storage::url($item->user->profile_picture),
                'name' => $item->name,
                'symbol' => $item->symbol,
                'supply' => $item->currentStage()->supply,
                'tokens_sold' => $item->token_sold_current_stage,
                'ether_raised' => $item->ether_raised_current_stage,
                'start_at' => $item->currentStage()->start_at,
                'end_at' => $item->currentStage()->end_at
            ];
        }

        return response()->json([
            'success' => true,
            'result' => $result
        ]);
    }
}
