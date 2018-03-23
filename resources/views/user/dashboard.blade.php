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
                USD {{ number_format(ethToUsd($user->wallet[0]->eth_balance), 2) }}
            </div>
        </div>
    </div>
    <div class="col-md-9 col-sm-10 col-xs-12">
        <div class="box">
            <div class="big-text">
                <h3>{{ $user->wallet[0]->address }}</h3>
            </div>
            <div class="description">
                <strong>{{ $user->name }}</strong> Wallet Address
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
                        <th class="width-200">Artist / Coin</th>
                        <th class="text-center width-50">Stage</th>
                        <th class="text-center width-200">Price</th>
                        <th class="width-200 text-center" >Progress</th>
                        <th class="width-200 text-center">Duration</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($tokens as $item)
                    <tr>
                        <td>
                            <a href="{{ $item->user->whitepaper }}" target="_blank"><img class="img-rounded" src="{{ empty($item->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$item->user->profile_thumb) }}" alt="" height="50"></a>
                        </td>
                        <td><a href="{{ $item->user->whitepaper }}" target="_blank">{{ $item->user->name }} / {{ $item->symbol }}</a></td>
                        <td class="text-center">{{ count($item->stages) }}</td>
                        <td class="text-center">USD {{ $item->currentStage()->price / 100 }}</td>
                        <td class="text-center">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">{{ number_format($item->token_sold_current_stage) }}</span>
                                    <span class="text-muted">&nbsp;/&nbsp; {{ number_format($item->currentStage()->supply) }}</span>
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
                        <td class="text-center width-100">
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
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <h3>Your <span class="fw-semi-bold">Portfolio</span></h3>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="text-center">Artist</th>
                            <th class="text-center">Coins you hold</th>
                            <th class="text-center">USD Value</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                    @foreach ($tokens as $item)
                        @if ($user->wallet[0]->getTokenBalance($item) > 0)
                        @php
                            $hasPortfolio_count = true;
                        @endphp
                        <tr>
                            <td>{{ $item->user->name }}</td>
                            <td>{{ number_format($user->wallet[0]->getTokenBalance($item)) }} {{ $item->symbol }}</td>
                            <td>USD {{ number_format($user->wallet[0]->getTokenBalance($item) * $item->currentStage()->price / 100) }}</td>
                        </tr>
                        @endif
                    @endforeach
                    @if (empty($hasPortfolio_count))
                        <tr>
                            <td colspan="3" class="text-center">
                                No portfolios
                            </td>
                        </tr>
                    @endif
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
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Paid By</th>
                            <th class="text-center">To</th>
                            <th class="text-center">Value</th>
                            <th class="text-center">Date (GMT)</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">
                    @forelse ($transactions as $item)
                        <tr class="clickable-row" data-href="{{ route('tx.show', $item) }}">
                            <td>{{ $loop->index + 1}}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>{{ $item->token->name }} / {{ $item->token->symbol }}</td>
                            <td>
                            @if ($item->type->name == 'Ethereum')
                                ETH {{ round($item->eth_value, 2) }} / USD {{ number_format($item->usd_value / 100, 2) }}
                            @else
                                USD {{ number_format($item->usd_value / 100, 2) }}
                            @endif
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>
                            @switch($item->status)
                                @case(0)
                                    <span class="badge bg-gray-lighter text-gray"><i class="glyphicon glyphicon-time"></i> Pending</span>
                                    @break
                                @case(1)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Confirmed</span>
                                    @break
                                @default
                                <span class="badge badge-danger"><i class="fa fa-ban"></i> Failed</span>
                            @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No transactions
                            </td>
                        </tr>
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
