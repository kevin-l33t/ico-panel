@extends('layouts.app')

@section('content')
<h2 class="page-title">Transaction Details <small>{{ $log->type->name }}</small></h2>
<div class="row">
    <div class="col-sm-9 col-lg-6">
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
                            <address>
                                <abbr title="Work email">e-mail: </abbr> <a href="mailto:#">{{ $log->wallet->user->email }}</a><br>
                                <abbr title="Work email">phone: </abbr> {{ $log->wallet->user->phone }}<br>
                                <abbr title="Wallet Address">wallet: </abbr> {{ $log->wallet->address }}
                            </address>
                        </div>
                    </div>
                    <fieldset>
                        <legend class="section">Transaction Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Paid by</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $log->type->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Token Amount</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($log->token_value) }} {{ $log->token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">USD Value</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($log->usd_value / 100, 2) }} $</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">ETH Value</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($log->eth_value, 3) }} ETH</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Current Value</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($log->token_value * $log->token->currentStage()->price / 100, 2) }} $</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Status</label>
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
                                    <span class="badge badge-success"><i class="fa fa-ban"></i> Failed</span>
                                @endswitch
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <a href="javascript:history.back()" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="col-sm-9 col-lg-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-cogs"></i> ICO Info</h4>
            </header>
            <div class="body">
                <form class="form-horizontal form-label-left">
                    <fieldset>
                        <legend class="section">Token Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $log->token->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Symbol</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $log->token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Total Supply</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ number_format($log->token->total_supply) }}</strong> {{ $log->token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://etherscan.io/address/{{ $log->token->token_address }}">{{ $log->token->token_address }}</a></p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Crowdsale Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://etherscan.io/address/{{ $log->token->crowdsale_address }}">{{ $log->token->crowdsale_address }}</a></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tokens Sold out</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ number_format($log->token->token_sold) }}</strong> {{ $log->token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">ETH Raised</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ number_format($log->token->ether_raised, 3) }}</strong> ETH</p>
                            </div>
                        </div>
                    </fieldset>
                    @if(null !== $log->token->currentStage())
                    <fieldset>
                        <legend class="section">Current Stage&nbsp;&nbsp;
                            <small>{{ Carbon\Carbon::parse($log->token->currentStage()->start_at)->diffInDays(Carbon\Carbon::parse($log->token->currentStage()->end_at)) }} Days
                            </small>
                        </legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $log->token->currentStage()->price / 100 }}</strong> $
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Issued Amount</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    <strong>{{ number_format($log->token->currentStage()->supply) }}</strong> {{ $log->token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Token Sold</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    <strong>{{ number_format($log->token->token_sold_current_stage) }}</strong> {{ $log->token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Ether Rised</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    <strong>{{ number_format($log->token->ether_raised_current_stage, 3) }}</strong> ETH
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Start At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $log->token->currentStage()->start_at }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">End At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $log->token->currentStage()->end_at }}
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    @endisset
                </form>
            </div>
        </section>
    </div>
</div>

@endsection
@section('scripts')

@endsection