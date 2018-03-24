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
                        <th class="text-center width-200">ICO Progress</th>
                        <th class="hidden-xs text-center">Token Info</th>
                        <th class="hidden-xs text-center">Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                @foreach ($tokens as $token)
                    <tr>
                        <td class="hidden-xs">{{ $loop->index + 1 }}</td>
                        <td>
                            <img class="img-rounded" src="{{ empty($token->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$token->user->profile_thumb) }}" alt="" height="50">
                        </td>
                        <td>
                            {{ $token->user->name }}
                        </td>
                        <td class="text-center">
                                @if ($token->status == 0)
                                <small>
                                    <span class="badge bg-gray-lighter text-gray fw-semi-bold">Pending</span>
                                    <br>
                                    <span class="text-muted"><a href="https://etherscan.io/tx/{{ $token->tx_hash }}" target="_blank">Check on Etherscan.io</a></span>
                                </small>
                                @elseif ($token->currentStage() == null)
                                <p>No Sale Stages</p>
                                @else
                                <p class="no-margin">
                                    <small>
                                        <span class="fw-semi-bold">{{ number_format($token->token_sold_current_stage) }}</span>
                                        <span class="text-muted">&nbsp;/&nbsp; {{ number_format($token->currentStage()->supply) }}</span>
                                    </small>
                                </p>
                                <div class="progress progress-sm mt-xs js-progress-animate">
                                    <div class="progress-bar" data-width="{{ ceil($token->token_sold_current_stage * 100 / $token->currentStage()->supply) }} %" style="width: {{ ceil($token->token_sold_current_stage * 100 / $token->currentStage()->supply) }}%;"></div>
                                </div>
                                @endif
                        </td>
                        <td class="hidden-xs text-center">
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
                        <td class="hidden-xs text-center">
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
                        <td class="text-center width-100">
                            <a href="{{ route('tokens.show', $token) }}" class="btn btn-info">&nbsp;Details&nbsp;</a>
                        </td>
                    </tr>
                @endforeach
                    </tbody>

                </table>
                <div class="clearfix">
                    <div class="pull-right">
                        
                    </div>
                    <p>You can check pending ICOs on <a href="https://etherscan.io" target="_blank">Etherscan.io</a></p>
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