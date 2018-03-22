@extends('layouts.app')
@section('content')
<h2 class="page-title">
Complete Payment
</h2>
<div class="row">
    <div class="col-sm-10 col-md-8">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-bank"></i> Bank Transfer
                    <small class="pull-right">#{{ $order_id }} / {{ date("j M Y") }}</small>
                </h4>
            </header>
            <div class="body">
                <legend></legend>
                <h4>You are agreeing to purchase the following coins</h4>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th class="text-center">Coin</th>
                            <th class="text-center hidden-xs">Quantity</th>
                            <th class="text-center hidden-xs">Price per Coin</th>
                            <th class="text-center">Total</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td>1</td>
                            <td>{{ $token->name }}</td>
                            <td class="hidden-xs">{{ number_format($token_value) }} {{ $token->symbol }}</td>
                            <td class="hidden-xs">USD {{ $token->currentStage()->price / 100 }}</td>
                            <td>USD {{ number_format($usd_value, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-5">
                    </div>
                    <div class="col-sm-7">
                        <div class="row text-align-right">
                            <div class="col-xs-6">
                                <p>Subtotal</p>
                                <p>Transfer Fee</p>
                                <p class="no-margin"><strong>Total</strong></p>
                            </div>
                            <div class="col-xs-4">
                                <p>USD {{ number_format($usd_value, 2) }}</p>
                                <p>USD 30</p>
                                <p class="no-margin"><strong>USD {{ number_format($usd_value + 30, 2) }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <legend>Step 1: Transfer Funds: <small>Please transfer the amount above in USD from your bank account to the Hunter Corp Records account below.</small></legend>
                <section class="invoice-info well">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="details-title"><strong>Bank Information</strong></h4>
                            <p id="bank-info" class="mt-lg">
                                Bank Name:&nbsp;&nbsp;&nbsp;HSBC Hong Kong
                                <br>Bank Address:&nbsp;&nbsp;&nbsp;SUN HUNG KAI CENTRE 30 Harbour Road, Wan Chai, Hong Kong Island, Hong Kong
                                <br>
                                Account Name:&nbsp;&nbsp;&nbsp;
                                LENYORK LIMITED
                                <br>
                                Account Number:&nbsp;&nbsp;&nbsp;
                                499-792844-838
                                <br>
                                SWIFT Code: &nbsp;&nbsp;&nbsp;
                                HSBCHKHHHKH
                            </p>
                            <button id="copy_bank_info" type="button" class="btn btn-default" title="Copied!" data-clipboard-text="Bank Name: HSBC Hong Kong&#10;Bank Address: SUN HUNG KAI CENTRE 30 Harbour Road, Wan Chai, Hong Kong Island, Hong Kong&#10;Account Name: LENYORK LIMITED&#10;Account Number: 499-792844-838&#10;SWIFT Code: HSBCHKHHHKH"><i class="fa fa-clipboard"></i> Copy to clipboard</a>
                        </div>
                    </div>
                </section>
                <div class="row">
                    <div class="col-md-11">
                        <blockquote class="blockquote-sm">
                            <strong>Note:</strong> In the transfer description please insert your name and the quantity (Quantity listed above).<br>
                            <strong>For Example:</strong> Your Billy Smith 340 SAH
                        </blockquote>
                    </div>
                </div>
                <hr>
                <form enctype="multipart/form-data" method="post" action="{{ route('receipts.store') }}" class="form-horizontal form-label-left"
                    data-parsley-validate>
                    @csrf
                    <input name="order_id" type="hidden" value="{{ $order_id }}">
                    <input name="token" type="hidden" value="{{ $token->id }}">
                    <input name="token_value" type="hidden" value="{{ $token_value }}">
                    <fieldset>
                        <legend>Step 2: Verify Transfer: <small>Please provide proof of transfer by completing the information below and attaching a copy of the transfer receipt (Screenshot/photo). This will help HCR to track and process your payment.</small></legend>
                        @include('layouts.partials.formErrors')
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="bank_name">Bank Name</label>
                            <div class="col-sm-6">
                                <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', '') }}" minlength="4" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="account_name">Account Name</label>
                            <div class="col-sm-6">
                                <input type="text" id="account_name" name="account_name" value="{{ old('account_name', '') }}" minlength="4" required="required"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="account_number">Account Number</label>
                            <div class="col-sm-6">
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number', '') }}" required="required"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="usd_value">Transfer Amount</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="usd_value" name="usd_value" class="form-control input-transparent text-right" value="{{ $usd_value + 30 }}" lang="en-150" readonly>
                                    <input name="eth_value" value="{{ $eth_value }}" type="hidden">
                                    <span class="input-group-addon">
                                        <i class="fa fa-usd"></i>
                                    </span>
                                </div>
                                <p class="help-block text-right">Ethereum Value: {{ round($eth_value, 3) }} ETH</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="receipt">Receipt</label>
                            <div class="col-sm-4">
                                <input type="file" class="form-control-file" id="receipt" name="receipt" required>
                            </div>
                            <div class="col-sm-4">
                                <a href="{{ asset('img/bank_receipt_sample.png') }}" target="_blank">Click here</a> to see a sample receipt
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a href="{{ route('users.buy', $token) }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
                <hr>
                <legend>Please Note: <small>The coins you have purchased have now been reserved for you. They will be transferred into your HCR wallet when we have received payment. This normally takes 3 working days.</small></legend>
                <p>If you have any transaction inquiries please email: transfers@huntercorprecords.com<br> A member of the HCR accounts team will respond to your inquiry within 1 working day.</p>
                <p class="text-align-right mt-lg mb-xs">
                    HUNTER CORP RECORDS
                </p>
                <!-- <p class="text-align-right">
                    <span class="fw-semi-bold">Joshua Hunter</span>
                </p> -->
            </div>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>

    <!-- page specific scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/clipboard.js/2.0.0/clipboard.min.js"></script>
    <script>
        $(function () {
            var clipboard = new ClipboardJS('#copy_bank_info');
            $('#copy_bank_info').tooltip({
                trigger: 'click',
                placement: 'bottom',
                delay: { show: 100, hide: 500 }
            });

            $('#copy_bank_info').on('shown.bs.tooltip', function (e) {
                setTimeout(function () {
                    $(e.target).tooltip('hide');
                }, 1000);
            });
        });
    </script>
@endsection