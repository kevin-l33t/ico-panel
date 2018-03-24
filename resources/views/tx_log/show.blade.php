@extends('layouts.app')

@section('content')
<h2 class="page-title">Transaction Details <small>{{ $log->type->name }}</small></h2>
<div class="row">
    <div class="col-sm-9 col-lg-8">
        <section class="widget">
            <header>
                <h4><i class="fa fa-user"></i> Transaction <small>information </small></h4>
            </header>
            <div class="body">
                <form class="form-horizontal form-label-left">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-align-center">
                                <img class="img-circle" src="{{ empty($log->wallet->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$log->wallet->user->profile_thumb) }}" alt="Avatar" style="height: 112px;">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3 class="mt-sm mb-xs">{{ $log->wallet->user->name }}</h3>
                            <p>
                                e-mail: <a href="mailto:#">{{ $log->wallet->user->email }}</a><br>
                                phone: {{ $log->wallet->user->phone }}<br>
                                wallet: {{ $log->wallet->address }}
                            </p>
                        </div>
                    </div>
                    <fieldset>
                        <legend class="section">Transaction Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Purchase with:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->type->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Artist Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->token->user->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Coin Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">ICO Stage:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">Stage {{ $log->stage->id }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Date Purchased:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->created_at }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price per Coin:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">USD {{ $log->stage->price / 100 }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Coins Purchased:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($log->token_value) }} {{ $log->token->symbol }}</p>
                            </div>
                        </div>
            
                        @if ($log->type->name == 'Ethereum')
                        <div class="form-group">
                            <label class="control-label col-sm-4">Ether Paid:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">ETH {{ number_format($log->eth_value, 3) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Value in USD:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">USD {{ number_format($log->token_value * $log->token->currentStage()->price / 100, 2) }}</p>
                            </div>
                        </div>
                        @elseif ($log->type->name == 'Bank Transfer')
                        <div class="form-group">
                            <label class="control-label col-sm-4">USD Amount Transfered:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">USD {{ number_format($log->usd_value / 100, 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Bank Name:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->bankReceipt->bank_name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Bank Account Name / Number:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->bankReceipt->account_name }} / {{ $log->bankReceipt->account_number }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-sm-4">Status:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                @switch($log->status)
                                    @case(0)
                                        <span class="badge bg-gray-lighter text-gray"><i class="glyphicon glyphicon-time"></i> Pending</span>
                                        @break
                                    @case(1)
                                        <span class="badge badge-success"><i class="fa fa-check"></i> Confirmed</span>
                                        @break
                                    @default
                                    <span class="badge badge-danger"><i class="fa fa-ban"></i> Failed</span>
                                @endswitch
                                </p>
                            </div>
                        </div>
                        @if ($log->type->name == 'Bank Transfer' && $log->status == 1)
                        <div class="form-group">
                            <label class="control-label col-sm-4">Date Status Confirmed:</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->updated_at }}</p>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <label class="control-label col-sm-4">Transaction Hash:</label>
                            <div class="col-sm-7 text-truncate">
                                <i class="fa fa-external-link"></i>&nbsp;<a href="https://etherscan.io/tx/{{ $log->tx_hash }}" target="_blank">{{ $log->tx_hash }}</a>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <a href="javascript:history.back()" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

@endsection
@section('scripts')

@endsection