@extends('layouts.app') 
@section('content')
<h2 class="page-title">ICO Transactions</h2>
<section class="widget">
    <header>
        <h4><span class="fw-semi-bold">Transaction</span> History</h4>
    </header>
    <div class="body">
        <div class="mt">
            <table id="datatable-table" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="no-sort width-50 text-center hidden-xs">#</th>
                    <th class="text-center">User</th>
                    <th class="text-center hidden-xs">Action</th>
                    <th class="text-center hidden-xs">ICO</th>
                    <th class="text-center no-sort">Token</th>
                    <th class="text-center hidden-xs">Value</th>
                    <th class="text-center width-200 hidden-xs">Date</th>
                    <th class="no-sort"></th>
                </tr>
                </thead>
                <tbody>
                @foreach($logs as $item)
                    <tr class="clickable-row" data-href="{{ route('tx.show', $item) }}">
                        <td class="text-center hidden-xs">{{ $item->id }}</td>
                        <td class="text-center">{{ $item->wallet->user->name }}</td>
                        <td class="text-center hidden-xs">{{ $item->type->name }}</td>
                        <td class="text-center hidden-xs">{{ $item->token->name }}</td>
                        <td class="text-center">{{ number_format($item->token_value) }} {{ $item->token->symbol }}</td>
                        <td class="text-center hidden-xs">
                            @if ($item->type->name == 'Ethereum')
                            ETH {{ round($item->eth_value, 3) }} / USD {{ number_format($item->usd_value / 100, 2) }}
                            @else
                                USD {{ number_format($item->usd_value / 100, 2) }}
                            @endif    
                       </td>
                        <td class="text-center text-muted hidden-xs">{{ $item->created_at }}</td>
                        <td>
                            @switch($item->status)
                                @case(0)
                                    <i class="glyphicon glyphicon-time"></i>
                                    @break
                                @case(1)
                                    <i class="fa fa-check"></i>
                                    @break
                                @default
                                    <i class="fa fa-ban"></i>
                            @endswitch
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>
@endsection
@section('scripts')
<!-- page specific scripts -->
    <!-- page specific libs -->
    <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('lib/datatables/media/js/jquery.dataTables.min.js') }}"></script>

    <!-- page application js -->
    <script src="{{ asset('js/pages/tx-index.js') }}"></script>
@endsection