@extends('layouts.app')

@section('content')
<h2 class="page-title">ICO <small>Dashboard </small></h2>
<div class="row">
    <div class="col-md-3 col-sm-4 col-xs-6">
        <div class="box">
            <div class="big-text">
                {{ $user->wallet[0]->eth_balance }} ETH
            </div>
            <div class="description">
                <i class="fa fa-usd"></i>
                {{ ethToUsd($user->wallet[0]->eth_balance) }}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-10 col-xs-12">
        <div class="box">
            <div class="big-text">
                <h3>{{ $user->wallet[0]->address }}</h3>
            </div>
            <div class="description">
                <strong>Wallet</strong> Address
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <section class="widget">
            <header>
                <h5>ICO Investment <span class="fw-semi-bold">Opportunities</span></h5>
            </header>
            <div class="widget-body">
                <h3>Active <span class="fw-semi-bold">ICO</span> List</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="width-50"></th>
                        <th>Artist / Coin</th>
                        <th>Stage</th>
                        <th>Price</th>
                        <th class="width-200 text-center" >Progress</th>
                        <th class="text-center">Duration</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($tokens as $item)
                    <tr>
                        <td>
                            <img class="img-rounded" src="{{ empty($item->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$item->user->profile_thumb) }}" alt="" height="50">
                        </td>
                        <td>{{ $item->user->name }} / {{ $item->symbol }}</td>
                        <td>{{ count($item->stages) }}</td>
                        <td><i class="fa fa-usd"></i> {{ $item->currentStage()->price / 100 }}</td>
                        <td class="text-center">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">{{ intval($item->token_sold_current_stage) }}</span>
                                    <span class="text-muted">&nbsp;/&nbsp; {{ $item->currentStage()->supply }}</span>
                                </small>
                            </p>
                            <div class="progress progress-sm mt-xs js-progress-animate">
                                <div class="progress-bar progress-bar-success" data-width="{{ ceil($item->token_sold_current_stage * 100 / $item->currentStage()->supply) }} %" style="width: {{ ceil($item->token_sold_current_stage * 100 / $item->currentStage()->supply) }}%;"></div>
                            </div>
                        </td>
                        <td class="text-center">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Start:</span>
                                    <span class="text-muted">&nbsp; {{ substr($item->currentStage()->start_at, 0, 10) }}</span>
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">End:</span>
                                    <span class="text-muted">&nbsp; {{ substr($item->currentStage()->end_at, 0, 10) }}</span>
                                </small>
                            </p>
                        </td>
                        <td class="text-align-center width-100">
                            <a href="{{ route('users.buy', $item) }}" class="btn btn-info {{ (date('Y-m-d H:i:s') >= $item->currentStage()->start_at && date('Y-m-d H:i:s') < $item->currentStage()->end_at  ) ? '' : 'disabled' }} ">&nbsp;Buy&nbsp;</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
<div class="row">
    <div class="col-md-5">
        <section class="widget">
            <header>
                <h5>Coin <span class="fw-semi-bold">Balances</span></h5>
                <div class="widget-controls">
                    <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <h3>Your <span class="fw-semi-bold">Portfolio</span></h3>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>Artist</th>
                            <th>Coins you hold</th>
                            <th>USD Value</th>
                        </tr>
                        </thead>
                        <tbody>
                    @foreach($tokens as $item)
                        @if ($user->wallet[0]->getTokenBalance($item) > 0)
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ $user->wallet[0]->getTokenBalance($item) }} {{ $item->symbol }}</td>
                            <td>{{ round($user->wallet[0]->getTokenBalance($item) * $item->currentStage()->price / 100, 2) }} $</td>
                        </tr>
                        @endif
                    @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="col-md-7">
        <section class="widget">
            <header>
                <h5>Transaction <span class="fw-semi-bold">History</span></h5>
                <div class="widget-controls">
                    <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Action</th>
                            <th>To</th>
                            <th>Value</th>
                            <td>Date</th>
                        </tr>
                        </thead>
                        <tbody>
                    @forelse ($transactions as $item)
                        <tr>
                            <td>{{ $loop->index + 1}}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>{{ $item->token->name }} / {{ $item->token->symbol }}</td>
                            <td>{{ round($item->eth_value, 2) }} ETH / {{ $item->usd_value / 100 }} $</td>
                            <td>{{ $item->created_at }}</td>
                        </tr>
                    @empty
                        <p>No transactions</p>
                    @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<!-- Page Lib -->

<!-- page specific scripts -->
<script src="{{ asset('js/pages/user-dashboard.js') }}"></script>
@endsection
