@extends('layouts.app')

@section('content')
<h2 class="page-title">ICO - <span class="fw-semi-bold">List</span></h2>
<div class="row">
    <div class="col-md-12">
        <section class="widget">
            <header>
                <h4>
                    ICO <span class="fw-semi-bold">information</span>
                </h4>
            </header>
            <div class="body">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th class="hidden-xs">#</th>
                        <th>Avatar</th>
                        <th>Artist</th>
                        <th class="hidden-xs">Smart Contract Info</th>
                        <th class="hidden-xs">Token Info</th>
                        <th class="hidden-xs">Status</th>
                        <th class="text-align-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach ($tokens as $token)
                    <tr>
                        <td class="hidden-xs">{{ $loop->index + 1 }}</td>
                        <td>
                            <img class="img-rounded" src="img/1.png" alt="" height="50">
                        </td>
                        <td>
                            {{ $token->user->name }}
                        </td>
                        <td class="hidden-xs">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Crowdsale Address:</span>
                                @if ($token->status == 0)
                                    &nbsp;<span class="badge bg-gray-lighter text-gray fw-semi-bold">Pending</span>
                                    <span class="text-muted"><a href="https://ropsten.etherscan.io/tx/{{ $token->tx_hash }}" target="_blank">Check on Etherscan.io</a></span>
                                @else
                                    <span class="text-muted">&nbsp; <a href="https://ropsten.etherscan.io/address/{{ $token->crowdsale_address }}" target="_blank">{{ $token->crowdsale_address }}</a></span>
                                @endif
                                </small>
                            </p>
                        @if ($token->status == 1)
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Token Address:</span>
                                    <span class="text-muted">&nbsp; <a href="https://ropsten.etherscan.io/address/{{ $token->token_address }}" target="_blank">{{ $token->token_address }}</a></span>
                                </small>
                            </p>
                        @endif
                        </td>
                        <td class="hidden-xs">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Token Name:</span>
                                    <span class="text-muted">&nbsp; {{ $token->name }}</span>
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Token Symbol:</span>
                                    <span class="text-muted">&nbsp; {{ $token->symbol }}</span>
                                </small>
                            </p>
                        </td>
                        <td class="hidden-xs">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Start Date:</span>
                                    <span class="text-muted">{{ null == $token->currentStage() ? ' Not started' : substr($token->currentStage()->start_at, 0, 10) }}</span>
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Price:</span>
                                    <span class="text-muted">{{ null == $token->currentStage() ? ' Not determined' : '$' . $token->currentStage()->price / 100 }}</span>
                                </small>
                            </p>
                        </td>
                        <td class="text-align-center width-100">
                            <a href="{{ route('tokens.show', $token) }}" class="btn btn-info">&nbsp;Details&nbsp;</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>

                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        
                    </div>
                    <p>You can check pending ICOs on <a href="https://ropsten.etherscan.io" target="_blank">Etherscan.io</a></p>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<!-- page specific scripts -->
        <!-- page specific libs -->
        <script src="lib/jquery.sparkline/index.js"></script>

        <!-- page application js -->
        <script src="js/tables-static.js"></script>
@endsection