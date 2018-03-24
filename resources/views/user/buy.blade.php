@extends('layouts.app') @section('content')
<h2 class="page-title">Buy
    <small>{{ $token->name }}</small>
</h2>
<div class="row">
    <div class="col-md-8 col-lg-6">
        <section class="widget">
            <!-- <header>
                <h4>
                    <i class="fa fa-cogs"></i> Buy {{ $token->name }}</h4>
            </header> -->
            <div class="body">
                <form id="form_buy" class="form-horizontal form-label-left" action="{{ route('users.sendEther') }}" method="post">
                    @csrf
                    <input name="token" type="hidden" value="{{ $token->id }}">
                    <fieldset>
                        <legend class="section"><strong>Your Wallet Status</strong></legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Your HCR Wallet Address</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ $user->wallet[0]->address }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Your Ether Balance</label>
                            <div class="col-sm-8">
                                <p id="eth_balance" class="form-control-static">{{ $user->wallet[0]->eth_balance }} ETH /
                                    USD {{ number_format(ethToUsd($user->wallet[0]->eth_balance), 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">{{ $token->name }} Coins Held</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">{{ number_format($user->wallet[0]->getTokenBalance($token)) }} {{ $token->symbol }}</p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section"><strong>Select Number of Coins to Purchase</strong></legend>
                        <div class="form-group">

                            <label for="amount" class="control-label col-sm-4">Number of Coins</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="amount" name="token_value" class="form-control input-transparent text-right" min="{{ round(1000 / $token->currentStage()->price) }}" max="{{ round(1000000 / $token->currentStage()->price) }}" value="{{ round(1000 / $token->currentStage()->price) }}" type="number" required>
                                    <input type="hidden" name="eth_value" id="eth_value">
                                    <input type="hidden" name="usd_value" id="usd_value">
                                    <span class="input-group-addon">{{ $token->symbol }}</span>
                                </div>
                                <div class="slider-inverse mt-sm ml-md">
                                    <input class="js-slider" id="slider-ex5" data-slider-id='ex5Slider' type="text" data-slider-min="{{ round(1000 / $token->currentStage()->price) }}" data-slider-max="{{ round(1000000 / $token->currentStage()->price) }}"
                                        data-slider-step="10" data-slider-value="{{ round(1000 / $token->currentStage()->price) }}" />
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Total Amount if buying with Ethereum</label>
                            <div class="col-sm-6">
                                <p id="eth_amount" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Total Amount if buying with Bank Transfer</label>
                            <div class="col-sm-6">
                                <p id="bank_amount" class="form-control-static"></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-6">Total Amount if buying with Credit Card</label>
                            <div class="col-sm-6">
                                <p id="credit_card_amount" class="form-control-static"></p>
                            </div>
                        </div>
                        <div id="wrapper_console" class="form-group" style="display:none">
                            <label class="control-label col-sm-3">Transaction Hash</label>
                            <div class="col-sm-8">
                                <p class="form-control-static text-truncate"><i class="fa fa fa-external-link"></i>&nbsp;<a target="_blank" id="link_tx_hash"></a></p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Transfer Fees</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">ETH Transfer Fee</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">ETH 0.0005</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Bank Transfer Fee</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">USD 30 / Transfer</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Credit Card Fee</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">5.5 %</p>
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
                                <button id="button_buy_card" type="button" class="btn btn-info hidden-xs" disabled>Credit Card (coming soon)</button>
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
                            <p><a href="{{ $token->user->whitepaper }}" target="_blank">Whitepaper</a></p>
                        </div>
                    </div>
                    <fieldset>
                        <legend class="section">ICO Information</legend>
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
                            <label class="control-label col-sm-4">Total Coins</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>200,000,000</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Crowdsale Address</label>
                            <div class="col-sm-8">
                                <p class="form-control-static">
                                    <a target="_blank" href="https://etherscan.io/address/{{ $token->crowdsale_address }}">{{ $token->crowdsale_address }}</a>
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Current ICO: 
                            <small>Stage {{ $token->currentStage()->id }}</small>
                        </legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    USD <strong>{{ $token->currentStage()->price / 100 }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Issued Amount</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ number_format($token->currentStage()->supply) }}</strong> {{ $token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Coins Purchased</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ number_format($token->token_sold_current_stage) }}</strong> {{ $token->symbol }}
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