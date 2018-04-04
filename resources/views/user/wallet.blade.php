@extends('layouts.app')
@section('content')
<h2 class="page-title">Wallet Management
</h2>
<div class="row">
    <div class="col-md-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-mail-forward"></i> Withdraw Ethereum
                </h4>
            </header>
            <div class="body">
                <form id="form_withdraw" class="form-horizontal form-label-left" method="post" action="{{ route('users.withdraw') }}"
                    data-parsley-validate>
                    @csrf
                    @include('layouts.partials.formErrors')
                    <fieldset>
                        <legend class="section">Please specify withdraw address and amount</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Your Ether Balance</label>
                            <div class="col-sm-8">
                                <p id="eth_balance" class="form-control-static">{{ $user->wallet[0]->eth_balance }} ETH /
                                    USD {{ number_format(ethToUsd($user->wallet[0]->eth_balance), 2) }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="address">Withdraw to</label>
                            <div class="col-sm-8">
                                <input type="text" id="address" name="address" required="required" class="form-control input-transparent" pattern="^0x[a-fA-F0-9]{40}$" placeholder="i.e, 0x370B5afb7Be5b6fAFfD320Fd7025d8956667Fa5e">
                            </div>
                        </div>
                        <div class="form-group">

                            <label for="amount" class="control-label col-sm-4">Ethereum Amount</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="amount" name="amount" class="form-control input-transparent text-right" min="0.1" max="{{ $user->wallet[0]->eth_balance }}" step="0.01" type="number" value="0.1" required>
                                    <span class="input-group-addon">ETH</span>
                                </div>
                                <div class="slider-inverse mt-sm ml-md">
                                    <input class="js-slider" id="slider-ex5" data-slider-id='ex5Slider' type="text" data-slider-min="0.1" data-slider-max="{{ $user->wallet[0]->eth_balance }}"
                                        data-slider-step="0.01" data-slider-value="0.1" />
                                </div>
                            </div>
                        </div>
                        <div id="wrapper_console" class="form-group" style="display:none">
                            <label class="control-label col-sm-3">Transaction Hash</label>
                            <div class="col-sm-8">
                                <p class="form-control-static text-truncate"><i class="fa fa fa-external-link"></i>&nbsp;<a target="_blank" id="link_tx_hash"></a></p>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <button id="button_withdraw" type="button" class="btn btn-primary">Withdraw</button>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection @section('scripts')
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('lib/seiyria-bootstrap-slider/dist/bootstrap-slider.min.js') }}"></script>
<!-- page specific scripts -->
<script src="{{ asset('js/pages/user-wallet.js') }}"></script>
@endsection