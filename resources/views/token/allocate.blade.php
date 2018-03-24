@extends('layouts.app')
@section('content')
<h2 class="page-title">Issue Tokens to users
</h2>
<div class="row">
    <div class="col-md-8">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-user"></i> Allocate Token
                </h4>
            </header>
            <div class="body">
                <form id="form_allocate" class="form-horizontal form-label-left" method="post" action="{{ route('tokens.allocate') }}"
                    data-parsley-validate>
                    @csrf
                    @include('layouts.partials.formErrors')
                    <fieldset>
                        <legend class="section">User</legend>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="coin-select">User</label>
                            <div class="col-sm-6">
                                <select id="user-select"
                                        data-placeholder="Select user"
                                        class="select2 form-control"
                                        tabindex="-1"
                                        name="user" required>
                                    <option value=""></option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->wallet[0]->address }})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </fieldset>
                    <fieldset>
                        <legend class="section">Artist Coin</legend>
                        <div class="form-group">
                            <label class="col-sm-4 control-label" for="coin-select">Coins</label>
                            <div class="col-sm-6">
                                <select id="coin-select"
                                        data-placeholder="Select coin"
                                        class="select2 form-control"
                                        tabindex="-1"
                                        name="token" required>
                                    <option value=""></option>
                                    @foreach ($tokens as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }} / {{ $item->symbol }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="amount">Number of Coins
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input id="amount" name="amount" class="form-control input-transparent text-right"  value="{{ old('amount', '') }}" type="number" required>
                            </div>
                        </div>
                        <div id="wrapper_console" class="form-group" style="display:none">
                            <label class="control-label col-sm-4">Transaction Hash</label>
                            <div class="col-sm-7">
                                <p class="form-control-static text-truncate"><i class="fa fa fa-external-link"></i>&nbsp;<a target="_blank" id="link_tx_hash"></a></p>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <button type="submit" class="btn btn-primary">Allocate</button>&nbsp;&nbsp;
                        <a href="{{ route('users.dashboard') }}" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>
@endsection @section('scripts')
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('lib/select2/select2.min.js') }}"></script>
<!-- page specific scripts -->
<script src="{{ asset('js/pages/token-allocate.js') }}"></script>
@endsection