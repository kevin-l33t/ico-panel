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
                        <th>Artist Name</th>
                        <th class="hidden-xs">Info</th>
                        <th class="hidden-xs">Start Date</th>
                        <th class="hidden-xs">Status</th>
                        <th>Progress</th>
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
                                    <span class="fw-semi-bold">Address:</span>
                                @if ($token->status == 0)
                                    &nbsp;<span class="badge bg-gray-lighter text-gray fw-semi-bold">Pending</span>
                                    <span class="text-muted"><a href="https://ropsten.etherscan.io/tx/{{ $token->tx_hash }}" target="_blank">Check on Etherscan.io</a></span>
                                @else
                                    <span class="text-muted">&nbsp; <a href="https://ropsten.etherscan.io/address/{{ $token->address }}" target="_blank">{{ $token->address }}</a></span>
                                @endif
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Artist Wallet:</span>
                                    <span class="text-muted">&nbsp; {{ $token->artist_address }}</span>
                                </small>
                            </p>
                        </td>
                        <td class="hidden-xs">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Token Name:</span>
                                    <span class="text-muted">&nbsp; {{ $token->token_name }}</span>
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Token Symbol:</span>
                                    <span class="text-muted">&nbsp; {{ $token->token_symbol }}</span>
                                </small>
                            </p>
                        </td>
                        <td class="hidden-xs">
                            <p class="no-margin">
                                <small>
                                    <span class="fw-semi-bold">Start Date:</span>
                                    <span class="text-muted">&nbsp; Not Started yet</span>
                                </small>
                            </p>
                            <p>
                                <small>
                                    <span class="fw-semi-bold">Price:</span>
                                    <span class="text-muted">&nbsp; Not determined</span>
                                </small>
                            </p>
                        </td>
                        <td class="width-150">
                            <div class="progress progress-sm mt-xs js-progress-animate">
                                <div class="progress-bar progress-bar-success" data-width="{{ $loop->index * 20 + 10 }}%" style="width: 0;"></div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        
                    </div>
                    <p>You can check pending tokens on <a href="https://ropsten.etherscan.io" target="_blank">Etherscan.io</a></p>
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