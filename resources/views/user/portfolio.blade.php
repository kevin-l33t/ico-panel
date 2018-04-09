@extends('layouts.app')

@section('content')
<h2 class="page-title">Portfolio Details <small>Crowdfunding for the artist</small></h2>
<div class="row">
    <div class="col-md-6">
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
                                <a href="{{ $token->user->whitepaper }}" target="_blank">Whitepaper</a>
                            </p>
                        </div>
                    </div>
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
                            <label class="control-label col-sm-4">Address</label>
                            <div class="col-sm-4">
                                <p class="form-control-static"><a target="_blank" href="https://etherscan.io/address/{{ $token->token_address }}">{{ $token->token_address }}</a></p>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Purchasing Info</legend>
                        @foreach ($portfolios as $item)
                        <div class="form-group">
                            <label class="control-label col-sm-4">Stage {{ $loop->index + 1 }}</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">{{ number_format($item['amount']) }} {{ $token->symbol }} / USD {{ number_format($item['usd_value'] / 100, 2) }}</p>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group">
                            <label class="control-label col-sm-4">Current Value</label>
                            <div class="col-sm-4">
                                <p class="form-control-static">USD {{ number_format($user->wallet[0]->getTokenBalance($token) * $token->currentStage()->price / 100, 2) }}</p>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <a href="{{ route('users.dashboard') }}" class="btn btn-default">Back</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>

@endsection
@section('scripts')
<!-- Page Lib -->
@endsection