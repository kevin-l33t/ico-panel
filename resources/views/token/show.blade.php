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
                                <img class="img-circle" src="{{ asset('img/3.png') }}" alt="64x64" style="height: 112px;">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3 class="mt-sm mb-xs">{{ $token->user->name }}</h3>
                            <address>
                                <strong>Artist</strong> at <strong><a href="#">the Band</a></strong><br>
                                <abbr title="Work email">e-mail: </abbr> <a href="mailto:#">{{ $token->user->email }}</a><br>
                                <abbr title="Wallet Address">wallet: </abbr> {{ $token->artist_address }}
                            </address>
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
                                <p class="form-control-static"><strong>{{ $token->total_supply }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://ropsten.etherscan.io/address/{{ $token->token_address }}">{{ $token->token_address }}</a></p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Crowdsale Info</legend>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://ropsten.etherscan.io/address/{{ $token->token_address }}">{{ $token->crowdsale_address }}</a></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tokens Sold out</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ $token->token_sold }}</strong> {{ $token->symbol }}</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">ETH Raised</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><strong>{{ $token->ether_raised }}</strong> ETH</p>
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
                    @endisset
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createStageModal" data-backdrop="static">Launch New Stage</button>
                                &nbsp;
                                <a href="{{ route('tokens.index') }}" class="btn btn-default">Back</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <div class="col-md-5">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-cogs"></i> Stage History</h4>
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
                            <label class="control-label col-sm-4">Price</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $stage->price / 100 }}</strong> $
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Issued Amount</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">
                                    <strong>{{ $stage->supply }}</strong> {{ $token->symbol }}
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
<div id="createStageModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="createStageModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form_stage" class="form-horizontal" action="{{ route('tokens.createStage', $token) }}" method="post" role="form">
            @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="createStageModalLabel">Modal Heading</h4>
            </div>
            <div class="modal-body">
                <h4>Text in a modal</h4>
                <p>Duis mollis, est non commodo luctus, nisi erat porttitor ligula.</p>
                    <fieldset>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="price">Price</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="price" name="price" class="form-control" data-parsley-type="number" required>
                                    <span class="input-group-addon bg-gray-lighter text-gray-dark">$</span>
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
                                    <input id="start_date" name="end_date" class="date-picker form-control" type="text" required>
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
@endsection
@section('scripts')
<!-- Page Lib -->
    <script src="{{ asset('lib/moment/moment.js') }}"></script>
    <script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>

    <!-- page specific scripts -->
    <script src="{{ asset('js/pages/token-show.js') }}"></script>
@endsection