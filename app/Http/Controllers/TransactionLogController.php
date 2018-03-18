<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\TransactionLog;

class TransactionLogController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['logs'] = TransactionLog::orderBy('created_at', 'desc')->get();
        return view('tx_log.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param  TransactionLog  $log
     * @return \Illuminate\Http\Response
     */
    public function show(TransactionLog $log)
    {
        $data['log'] = $log;
        return view('tx_log.show', $data);
    }
}
