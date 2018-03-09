@extends('layouts.app')
@section('content')
<h2 class="page-title">Invoice
    <small>for purchasing ICO</small>
</h2>
<div class="row">
    <div class="col-sm-8 col-md-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-user"></i> Transfer Details
                </h4>
            </header>
            <div class="body">
                <form enctype="multipart/form-data" method="post" action="{{ route('receipts.store') }}" class="form-horizontal form-label-left"
                    data-parsley-validate>
                    @csrf
                    <input name="order_id" type="hidden" value="{{ $order_id }}">
                    <input name="token" type="hidden" value="{{ $token->id }}">
                    <input name="token_amount" type="hidden" value="{{ $token_amount }}">
                    <fieldset>
                        <legend class="section">From Account Info</legend>
                        @include('layouts.partials.formErrors')
                        <div class="form-group">
                            <label class="control-label col-sm-5" for="bank_name">Bank</label>
                            <div class="col-sm-6">
                                <input type="text" id="bank_name" name="bank_name" value="{{ old('bank_name', '') }}" minlength="4" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5" for="account_name">Account Name</label>
                            <div class="col-sm-6">
                                <input type="text" id="account_name" name="account_name" value="{{ old('account_name', '') }}" minlength="4" required="required"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5" for="account_number">Account Number</label>
                            <div class="col-sm-6">
                                <input type="text" id="account_number" name="account_number" value="{{ old('account_number', '') }}" required="required"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5" for="usd_value">Transfer Amount</label>
                            <div class="col-sm-6">
                                <div class="input-group">
                                    <input id="usd_value" name="usd_value" class="form-control input-transparent text-right" value="{{ $usd_value }}" readonly>
                                    <span class="input-group-addon">
                                        <i class="fa fa-usd"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-5" for="receipt">Receipt</label>
                            <div class="col-sm-6">
                                <input type="file" class="form-control-file" id="receipt" name="receipt" required>
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
            </div>
        </section>
    </div>


    <div class="col-sm-8 col-md-6">
        <section class="widget">
            <div class="body no-margin">
                <div class="row">
                    <div class="col-sm-4">
                        <img class="img-rounded" src="{{ empty($token->user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$token->user->profile_thumb) }}"
                            alt="" height="80">
                    </div>
                    <div class="col-sm-8">
                        <div class="invoice-number text-align-right">
                            #{{ $order_id }} / {{ date("j M Y") }}
                        </div>
                        <div class="invoice-number-info text-align-right">
                            Some Invoice number description or whatever
                        </div>
                    </div>
                </div>
                <hr>
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
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Coin</th>
                            <th>Quantity</th>
                            <th class="hidden-xs">Price per Coin</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>{{ $token->name }}</td>
                            <td>{{ $token_amount }} {{ $token->symbol }}</td>
                            <td class="hidden-xs">{{ $token->currentStage()->price }}</td>
                            <td>$ {{ $usd_value }}</td>
                        </tr>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-sm-6 col-print-6">
                        <blockquote class="blockquote-sm">
                            <strong>Note:</strong> Keep in mind, sometimes bad things happen. But it's just sometimes.
                        </blockquote>
                    </div>
                    <div class="col-sm-6 col-print-6">
                        <div class="row text-align-right">
                            <div class="col-xs-4"></div>
                            <!-- instead of offset -->
                            <div class="col-xs-3">
                                <p class="no-margin">
                                    <strong>Total</strong>
                                </p>
                            </div>
                            <div class="col-xs-3">
                                <p class="no-margin">
                                    <strong>$ {{ $usd_value }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <p class="text-align-right mt-lg mb-xs">
                    HUNTER CORP RECORDS CEO
                </p>
                <p class="text-align-right">
                    <span class="fw-semi-bold">Joshua Hunter</span>
                </p>
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