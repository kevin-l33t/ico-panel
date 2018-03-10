@extends('layouts.app') @section('content')
<h2 class="page-title">Buy
    <small>Artist Coin</small>
</h2>
<div class="row">
    <div class="col-md-8 col-lg-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-cogs"></i> Buy Artist Coin</h4>
            </header>
            <div class="body">
                <form id="form_buy" class="form-horizontal form-label-left" action="{{ route('users.sendEther') }}" method="post">
                    @csrf
                    <input name="token" type="hidden" value="{{ $token->id }}">
                    <fieldset>
                        <legend class="section">Your Wallet Status</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $user->wallet[0]->address }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Balance</label>
                            <div class="col-sm-8">
                                <p id="eth_balance" class="form-control-static">{{ $user->wallet[0]->eth_balance }} ETH /
                                    {{ ethToUsd($user->wallet[0]->eth_balance) }} <i class="fa fa-usd"></i></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{ $token->name }} Balance</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $user->wallet[0]->getTokenBalance($token) }} {{ $token->symbol }}</p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Buy Tokens with ETH</legend>
                        <div class="form-group">

                            <label for="amount" class="control-label col-sm-4">Amount to Buy</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="amount" name="token_value" class="form-control input-transparent text-right" min="10" max="50000" value="10" type="number" required>
                                    <input type="hidden" name="eth_value" id="eth_value">
                                    <input type="hidden" name="usd_value" id="usd_value">
                                    <span class="input-group-addon">{{ $token->symbol }}</span>
                                </div>
                                <div class="slider-inverse mt-sm">
                                    <input class="js-slider" id="slider-ex5" data-slider-id='ex5Slider' type="text" data-slider-min="10" data-slider-max="1000"
                                        data-slider-step="10" data-slider-value="10" />
                                </div>
                            </div>

                            <!--  -->
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Ethereum</label>
                            <div class="col-sm-4">
                                <p id="eth_amount" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">USD</label>
                            <div class="col-sm-4">
                                <p id="usd_amount" class="form-control-static"></p>
                            </div>
                        </div>
                        <div id="wrapper_console" class="form-group" style="display:none">
                            <label class="control-label col-sm-4">Latest Tx</label>
                            <div class="col-sm-8">
                                <p class="form-control-static text-truncate"><i class="fa fa fa-arrow-right"></i>&nbsp;<a target="_blank" id="link_tx_hash"></a></p>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-12 text-center">
                                <button id="button_buy" type="button" class="btn btn-danger">ETH</button>
                                &nbsp;
                                <button id="button_buy_bank" type="button" class="btn btn-primary" data-action="{{ route('receipts.create') }}">Bank Transfer</button>
                                &nbsp;
                                <button id="button_buy_card" type="button" class="btn btn-info" disabled>Credit Card(comming soon)</button>
                                &nbsp;
                                <a href="{{ route('users.dashboard') }}" class="btn btn-default">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="col-md-8 col-lg-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-user"></i> Artist
                    <small>information </small>
                </h4>
            </header>
            <div class="body">
                <form class="form-horizontal form-label-left">
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-align-center">
                                <img class="img-circle" src="{{ empty($token->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$token->user->profile_thumb) }}" alt="64x64" style="height: 112px;">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3 class="mt-sm mb-xs">{{ $token->user->name }}</h3>
                            <address>
                                <strong>Artist</strong> at
                                <strong>
                                    <a href="#">the Band</a>
                                </strong>
                                <br>
                            </address>
                        </div>
                    </div>
                    <fieldset>
                        <legend class="section">ICO Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Name</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $token->name }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Symbol</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Total Supply</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $token->total_supply }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tokens Sold out</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <strong>{{ round($token->token_sold, 3) }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Crwodsale Address</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <a target="_blank" href="https://ropsten.etherscan.io/address/{{ $token->crowdsale_address }}">{{ $token->crowdsale_address }}</a>
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Current Stage&nbsp;&nbsp;
                            <small>{{ Carbon\Carbon::parse($token->currentStage()->start_at)->diffInDays(Carbon\Carbon::parse($token->currentStage()->end_at))
                                }} Days
                            </small>
                        </legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $token->currentStage()->price / 100 }}</strong> $
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Issued Amount</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $token->currentStage()->supply }}</strong> {{ $token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Start At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $token->currentStage()->start_at }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">End At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $token->currentStage()->end_at }}
                                </p>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection @section('scripts')
<script>
    var tokenUsdPrice = {{ $token->currentStage()->price / 100 }};
    var ethusd = {{ getEtherUSDPrice() }};
    var tokenEthPrice = tokenUsdPrice / ethusd;
</script>
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('lib/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') }}"></script>

<!-- page specific scripts -->
<script src="{{ asset('js/pages/user-buy.js') }}"></script>
@endsection