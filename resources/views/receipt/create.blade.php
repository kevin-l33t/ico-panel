@extends('layouts.app')
@section('content')
<h2 class="page-title">Process
    <small>for purchasing ICO</small>
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
                <legend><small>Buying artist coins using bank transfer is a 3 step process</small></legend>
                <h4>You are agreeing to purchase the following coins</h4>
                <br>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Coin</th>
                            <th>Quantity</th>
                            <th class="hidden-xs">Price per Coin</th>
                            <th>Total (USD)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $token->name }}</td>
                            <td>{{ number_format($token_value) }} {{ $token->symbol }}</td>
                            <td class="hidden-xs">{{ $token->currentStage()->price }}</td>
                            <td>$ {{ number_format($usd_value, 2) }}</td>
                        </tr>
                    </tbody>
                </table>
                <hr>
                <legend>Step 1. <small>Go to your personal online or physical bank and transfer the amount list above in USD to the Hunter Corp rcords Bank Account</small></legend>
                <section class="invoice-info well">
                    <div class="row">
                        <div class="col-sm-12">
                            <h4 class="details-title">Bank Information</h4>
                            <h3 class="company-name">
                                HSBC Hong Kong
                            </h3>
                            <address>
                                <br> Address:&nbsp;&nbsp;&nbsp;SUN HUNG KAI CENTRE
                                <br> 30 Harbour Road, Wan Chai, Hong Kong Island, Hong Kong
                                <br>
                                <abbr title="Account">Account: </abbr>
                                &nbsp;&nbsp;&nbsp;LENYORK LIMITED
                                <br>
                                <abbr title="Work Phone">Account Number: </abbr> &nbsp;&nbsp;&nbsp;
                                <strong>499-792844-838</strong>
                                <br>
                                <abbr title="SWIFT Code">SWIFT Code: </abbr> &nbsp;&nbsp;&nbsp;
                                <strong>HSBCHKHHHKH</strong>
                            </address>
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
                        <legend>Step 2.<small> After you complete the transfer please insert the relevant information into the boxes below and attach a screenshot or photo of the transfer receipt and attach it to this transaction. This will assist the HCR team to track your deposit.</small></legend>
                        @include('layouts.partials.formErrors')
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="bank_name">Bank</label>
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
                                    <input id="usd_value" name="usd_value" class="form-control input-transparent text-right" value="{{ $usd_value }}" readonly>
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
                    <div class="form-actions">
                        <div class="row">
                            <div class="col-sm-8 col-sm-offset-4">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </div>
                </form>
                <hr>
                <legend>Step 3.<small> Your artist coins are transferred to trust until your funds have been cleared, At which time your coins will be automatically transferred into your account. This process normally takes 3 working days.</small></legend>
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
@endsection