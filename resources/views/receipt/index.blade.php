@extends('layouts.app') 
@section('content')
<h2 class="page-title">Bank Receipt</h2>
<section class="widget">
    <div class="body">
        <div class="mt">
            <table id="datatable-table" class="table table-striped table-hover">
                <thead>
                <tr>
                    <th class="no-sort width-200">User Info</th>
                    <th class="no-sort">Receipt</th>
                    <th class="no-sort">Bank Info</th>
                    <th class="no-sort">Amount</th>
                    <th class="no-sort">Token Info</th>
                    <th class="text-center width-200">Date</th>
                    <th class="no-sort text-center">Action</th>
                </tr>
                </thead>
                <tbody>
                @foreach($receipts as $item)
                    <tr>
                        <td>
                            <small>
                                <span class="fw-semi-bold">Name:</span>
                                &nbsp; {{ $item->user->name }}
                            </small>
                            <br>
                            <small>
                                <span class="fw-semi-bold">Email:</span>
                                &nbsp; {{ $item->user->email }}
                            </small>
                        </td>
                        <td>
                            <small>
                                <span class="fw-semi-bold">Order ID:</span>
                                &nbsp; {{ $item->order_id }}
                            </small>
                            <br>
                            <a href="{{ asset('storage/'.$item->receipt) }}" target="_blank">View Receipt</a>
                        </td>
                        <td>
                            <small>
                                <span class="fw-semi-bold">Bank:</span>
                                &nbsp; {{ $item->bank_name }}
                            </small>
                            <br>
                            <small>
                                <span class="fw-semi-bold">Account Name:</span>
                                &nbsp; {{ $item->account_name }}
                            </small>
                            <br>
                            <small>
                                <span class="fw-semi-bold">Account Number:</span>
                                &nbsp; {{ $item->account_number }}
                            </small>
                        </td>
                        <td><i class="fa fa-usd"></i> {{ number_format($item->usd_value / 100, 2) }}</td>
                        <td>
                            <small>
                                <span class="fw-semi-bold">Name:</span>
                                &nbsp; {{ $item->token->name }}
                            </small>
                            <br>
                            <small>
                                <span class="fw-semi-bold">Price:</span>
                                &nbsp; $ {{ $item->token->currentStage()->price / 100 }}
                            </small>
                            <br>
                            <small>
                                <span class="fw-semi-bold">Amount Purchased:</span>
                                &nbsp; {{ number_format($item->token_value) }}
                            </small>
                        </td>
                        <td class="text-center">{{ $item->created_at }}</td>
                        <td class="text-center">
                        @switch($item->status)
                            @case(0)
                                <a data-href="{{ route('receipts.approve', $item) }}" class="btn btn-info btn-sm btn-approve">
                                    Approve<i class="fa fa-check"></i>
                                </a>&nbsp;
                                <a data-href="{{ route('receipts.dismiss', $item) }}" class="btn btn-danger btn-sm btn-dismiss">
                                    Dismiss<i class="fa fa-ban"></i>
                                </a>
                                @break
                            @case(1)
                                <span class="badge bg-gray-lighter text-gray fw-semi-bold"><i class="fa fa-check"></i> Approved</span>
                                @break
                            @default
                            <span class="badge bg-gray-lighter text-gray-light"><i class="fa fa-ban"></i> Dismissed</span>
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
        <script src="{{ asset('js/pages/receipt-index.js') }}"></script>
@endsection