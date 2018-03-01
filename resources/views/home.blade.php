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
    <div class="col-md-10">
        <section class="widget">
            <header>
                <h5>ICO Investment <span class="fw-semi-bold">Opportunities</span></h5>
            </header>
            <div class="widget-body">
                <h3>Active <span class="fw-semi-bold">ICO</span> List</h3>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Artist / Coin</th>
                        <th>Stage</th>
                        <th>Price</th>
                        <th>Max Coins Available</th>
                        <th>Closing Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach($tokens as $item)
                    <tr>
                        <td>{{ $item->user->name }} / {{ $item->symbol }}</td>
                        <td>{{ count($item->stages) }}</td>
                        <td>{{ $item->currentStage()->price / 100 }}</td>
                        <td>{{ $item->currentStage()->supply }} <small>{{ $item->symbol }}</small></td>
                        <td>{{ $item->currentStage()->end_at }}</td>
                        <td class="text-align-center width-100">
                            <a href="http://localhost:8000/tokens/2" class="btn btn-info">&nbsp;Buy&nbsp;</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>
@endsection
