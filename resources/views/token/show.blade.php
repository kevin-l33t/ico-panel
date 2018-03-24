@extends('layouts.app')

@section('content')
<h2 class="page-title">ICO Information <small>Crowdfunding for the artist</small></h2>
<div class="row">
    <div class="col-md-7">
        <section class="widget">
            <header>
                <h4><i class="fa fa-user"></i> Artist <small>information </small></h4>
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
                            <p>
                                <a href="{{ $token->user->whitepaper }}" target="_blank">Whitepaper</a><br>
                                E-Mail: <a href="mailto:#">{{ $token->user->email }}</a><br>
                                Wallet: {{ $token->user->wallet[0]->address }}
                            </p>
                        </div>
                    </div>
                    <fieldset class="mt-sm">
                        <legend>Initial Coin Offering <small>ICO consists of token and crowdsale</small></legend>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Token Info</legend>
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
                                <p class="form-control-static"><strong>{{ number_format($token->total_supply) }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://etherscan.io/address/{{ $token->token_address }}">{{ $token->token_address }}</a></p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Crowdsale Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://etherscan.io/address/{{ $token->crowdsale_address }}">{{ $token->crowdsale_address }}</a></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tokens Sold out</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ number_format($token->token_sold) }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Ether Raised</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">ETH <strong>{{ number_format($token->ether_raised, 3) }}</strong></p>
                            </div>
                        </div>
                    </fieldset>
                    @if(null !== $token->currentStage())
                    <fieldset>
                        <legend class="section">Current Stage&nbsp;&nbsp;
                            <small>{{ Carbon\Carbon::parse($token->currentStage()->start_at)->diffInDays(Carbon\Carbon::parse($token->currentStage()->end_at)) }} Days
                            </small>
                        </legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price per Coin</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    USD <strong>{{ $token->currentStage()->price / 100 }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Amount Issued</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    <strong>{{ number_format($token->currentStage()->supply) }}</strong> {{ $token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tokens Sold out</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    <strong>{{ number_format($token->token_sold_current_stage) }}</strong> {{ $token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Ether Rised</label>
                            <div class="col-sm-6">
                                <p class="form-control-static">
                                    ETH <strong>{{ number_format($token->ether_raised_current_stage, 3) }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Start at</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $token->currentStage()->start_at }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">End at</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $token->currentStage()->end_at }}
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    @endisset
                    <div class="form-actions text-center">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createStageModal" data-backdrop="static">Launch New Stage</button>
                        &nbsp;
                    @if (null !== $token->currentStage())
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#updateStageModal" data-backdrop="static">Update Current Stage</button>
                        &nbsp;
                    @endif
                        <a href="{{ route('tokens.index') }}" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="col-md-5">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-cubes"></i> Stage History</h4>
            </header>
            <div class="body">
                <form class="form-horizontal form-label-left">
                    <fieldset class="mt-sm">
                        <legend>ICO
                            <small>Stages</small>
                        </legend>
                    </fieldset>
                    @forelse($token->stages as $stage)
                    <fieldset>
                        <legend class="section">Stage {{ $loop->index + 1 }} &nbsp;&nbsp;
                            <small>{{ Carbon\Carbon::parse($stage->start_at)->diffInDays(Carbon\Carbon::parse($stage->end_at)) }} Days
                            </small>
                        </legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Price per Coin</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    USD <strong>{{ $stage->price / 100 }}</strong>
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Amount Issued</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ number_format($stage->supply) }}</strong> {{ $token->symbol }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Start At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $stage->start_at }}
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">End At</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    {{ $stage->end_at }}
                                </p>
                            </div>
                        </div>
                    </fieldset>
                    @empty
                        <h3>No Stages Released</h3>
                    @endforelse
                </form>
            </div>
        </section>
    </div>
</div>
<!-- create stage dialog -->
<div id="createStageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createStageModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form_stage" class="form-horizontal" action="{{ route('tokens.createStage', $token) }}" method="post" role="form">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="createStageModalLabel">Launch New ICO Stage</h4>
            </div>
            <div class="modal-body">
                <p>Please specify ICO stage duration and price.</p>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="price">Price per Coin</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="price" name="price" class="form-control" data-parsley-type="number" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark"><i class="fa fa-dollar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="supply">Amount to issue</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="supply" name="supply" class="form-control" type="number" min="1" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">{{ $token->symbol }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="start_date">Start Date</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="start_date" name="start_date" class="date-picker form-control" type="text" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="end_date">End Date</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="end_date" name="end_date" class="date-picker form-control" type="text" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Launch</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@if(null !== $token->currentStage())
<!-- update stage date time dialog -->
<div id="updateStageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="updateStageModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form_stage" class="form-horizontal" action="{{ route('tokens.updateStage', $token) }}" method="post" role="form">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="updateStageModalLabel">Update Latest ICO Stage</h4>
            </div>
            <div class="modal-body">
                <p>Please specify ICO stage duration.</p>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="start_date">Start Date</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="start_date_update" name="start_date" value="{{ $token->currentStage()->start_at }}" class="date-picker form-control" type="text" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="end_date">End Date</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="end_date_update" name="end_date" value="{{ $token->currentStage()->end_at }}" class="date-picker form-control" type="text" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </fieldset>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
@endif

@endsection
@section('scripts')
<!-- Page Lib -->
    <script src="{{ asset('lib/moment/moment.js') }}"></script>
    <script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>

    <!-- page specific scripts -->
    <script src="{{ asset('js/pages/token-show.js') }}"></script>
@endsection