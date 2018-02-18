@extends('layouts.app')

@section('content')
<h2 class="page-title">ICO Wizard <small>ICO</small></h2>
<div class="row">
    <div class="col-lg-7 col-lg-offset-1">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-windows"></i>
                    Wizard
                    <small>Issuing ICO</small>
                </h4>
                <p class="text-muted">Issue ICO for new artists.</p>
            </header>
            <div class="body">
                <div id="wizard" class="form-wizard">
                    <ul class="wizard-navigation nav-justified">
                        <li><a href="#tab1" data-toggle="tab"><small>1.</small><strong> Artist Info</strong></a></li>
                        <li><a href="#tab2" data-toggle="tab"><small>2.</small> <strong>ICO Details</strong></a></li>
                        <li><a href="#tab3" data-toggle="tab"><small>3.</small> <strong>Schedule</strong></a></li>
                        <li><a href="#tab4" data-toggle="tab"><small>4.</small> <strong>Thank you!</strong></a></li>
                    </ul>
                    <div id="bar" class="progress progress-small">
                        <div class="progress-bar progress-bar-inverse"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab1">
                            <form class="form-horizontal mt-sm" action='' method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <!-- Artist -->
                                        <label class="control-label col-md-3"  for="artist-select">Artist</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <select id="artist-select" name="artist" data-placeholder="Choose a artist..." class="select-block-level chzn-select" required>
                                                    <option value=""></option>
                                                    @foreach ($artists as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">Please choose a artist for ICO</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- Artist's wallet -->
                                        <label class="control-label col-md-3"  for="artist_wallet">Artist's Wallet Address</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="artist_wallet" name="artist_wallet"
                                                       placeholder="i.e., 0xe0014f07625ae3ef38050B28339b0203DDCdf045" class="form-control" pattern="^0x[a-fA-F0-9]{40}$" required>
                                                <span class="help-block">Please provide artist's ETH wallet address. 50 million tokens will be deposited there.</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <!-- Fund Wallet -->
                                        <label class="control-label col-md-3"  for="fund_wallet">Fund Wallet Address</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="fund_wallet" name="fund_wallet" placeholder="i.e., 0xe0014f07625ae3ef38050B28339b0203DDCdf045" class="form-control" pattern="^0x[a-fA-F0-9]{40}$" required>
                                                <span class="help-block">Please provide wallet address. Funds of ICO will be collected here.</span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form class="form-horizontal mt-sm" action='' method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="token_name" class="control-label col-md-3">Token Name</label>

                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="token_name" name="token_name" placeholder="i.e., Sarah Token" class="form-control" required>
                                                <span class="help-block pull-left">Please choose token name of the artist.</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="token_symbol" class="control-label col-md-3">Token Symbol</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="token_symbol" name="token_symbol" placeholder="i.e., SAH" class="form-control" required>
                                                <span class="help-block pull-left">Please choose Token Symbol</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="token_rate">Rate</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="number" id="token_rate" name="token_rate" placeholder="i.e., 40" class="form-control" required>
                                                <span class="help-block">How many token units a buyer gets per ETH</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3" for="total_supply">Total Supply</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="number" id="total_supply" name="total_supply" placeholder="i.e., 200000000" class="form-control" required>
                                                <span class="help-block">Total tokens to be supplied.</span></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <form class="form-horizontal mt-sm" action='' method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="start_date" class="control-label col-md-3">ICO Start Date</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10"><input type="text" id="start_date" name="start_date" class="form-control" required>
                                            <span class="help-block">Please choose ICO start date</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3"  for="bonus1">Stage 1 Bonus</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10"><input type="number" id="bonus1" name="bonus1" placeholder="" class="form-control" required>
                                            <span class="help-block">First stage bonus rate.</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3"  for="bonus2">Stage 2 Bonus</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10"><input type="number" id="bonus2" name="bonus2" placeholder="" class="form-control" required>
                                            <span class="help-block">Second stage bonus rate.</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3"  for="bonus3">Stage 3 Bonus</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10"><input type="number" id="bonus3" name="bonus3" placeholder="" class="form-control" required>
                                            <span class="help-block">Third stage bonus rate.</span>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3"  for="bonus4">Stage 4 Bonus</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10"><input type="number" id="bonus4" name="bonus4" placeholder="" class="form-control" required>
                                            <span class="help-block">Forth stage bonus rate.</span>
                                        </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <h2>Issue ICO</h2>
                            <p class="mb-lg">Please review again and submit.</p>
                            <br>
                        </div>
                        <div class="description ml mr mt-n-md">
                            <ul class="pager wizard">
                                <li class="previous">
                                    <button class="btn btn-primary pull-left"><i class="fa fa-caret-left"></i> Previous</button>
                                </li>
                                <li class="next">
                                    <button class="btn btn-primary pull-right" >Next <i class="fa fa-caret-right"></i></button>
                                </li>
                                <li class="finish" style="display: none">
                                    <button id="button_submit" class="btn btn-success pull-right" >Submit <i class="fa fa-check"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<!-- page libs -->
    <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('lib/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('lib/moment/moment.js') }}"></script>
    <script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('lib/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
<!-- page application js -->
    <script src="{{ asset('js/pages/ico-wizard.js') }}"></script>
@endsection
