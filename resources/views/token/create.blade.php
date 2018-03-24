@extends('layouts.app')

@section('content')
<h2 class="page-title">ICO Wizard <small>ICO</small></h2>
<div class="row">
    <div class="col-lg-7 col-lg-offset-1">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-windows"></i>
                    Wizard
                    <small>Issuing ICO</small>
                </h4>
                <p class="text-muted">Issue ICO for new artists.</p>
            </header>
            <div class="body">
                <div id="wizard" class="form-wizard">
                    <ul class="wizard-navigation nav-justified">
                        <li><a href="#tab1" data-toggle="tab"><small>1.</small><strong> Artist Info</strong></a></li>
                        <li><a href="#tab2" data-toggle="tab"><small>2.</small> <strong>ICO Details</strong></a></li>
                        <li><a href="#tab3" data-toggle="tab"><small>3.</small> <strong>Schedule</strong></a></li>
                        <li><a href="#tab4" data-toggle="tab"><small>4.</small> <strong>Thank you!</strong></a></li>
                    </ul>
                    <div id="bar" class="progress progress-small">
                        <div class="progress-bar progress-bar-inverse"></div>
                    </div>
                    <div class="tab-content">
                        <div class="tab-pane" id="tab1">
                            <form id="form1" class="form-horizontal mt-sm" action='' method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <!-- Artist -->
                                        <label class="control-label col-md-3"  for="artist-select">Artist</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <select id="artist-select" name="artist" data-placeholder="Choose a artist..." class="select-block-level chzn-select" required>
                                                    <option value=""></option>
                                                    @foreach ($artists as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                <span class="help-block">Please choose a artist for ICO</span>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab2">
                            <form id="form2" class="form-horizontal mt-sm" action='' method="POST">
                                <fieldset>
                                    <div class="form-group">
                                        <label for="token_name" class="control-label col-md-3">Token Name</label>

                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="token_name" name="token_name" placeholder="i.e., Sarah Token" class="form-control" required>
                                                <span class="help-block pull-left">Please choose token name of the artist.</span></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="token_symbol" class="control-label col-md-3">Token Symbol</label>
                                        <div class="col-md-8">
                                            <div class="col-md-10">
                                                <input type="text" id="token_symbol" name="token_symbol" placeholder="i.e., SAH" class="form-control" required>
                                                <span class="help-block pull-left">Please choose Token Symbol</span></div>
                                        </div>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                        <div class="tab-pane" id="tab3">
                            <h2>ICO Stage can be released after deploy</h2>
                            <p class="mb-lg">Please set number of coin, duration for each stage after deploy</p>
                            <br>
                        </div>
                        <div class="tab-pane" id="tab4">
                            <h2>Issue ICO</h2>
                            <p class="mb-lg">Please review again and submit.</p>
                            <br>
                        </div>
                        <div class="description ml mr mt-n-md">
                            <ul class="pager wizard">
                                <li class="previous">
                                    <button class="btn btn-primary pull-left"><i class="fa fa-caret-left"></i> Previous</button>
                                </li>
                                <li class="next">
                                    <button class="btn btn-primary pull-right" >Next <i class="fa fa-caret-right"></i></button>
                                </li>
                                <li class="finish" style="display: none">
                                    <button id="button_submit" class="btn btn-success pull-right" onclick="submit_wizard('{{ route('tokens.store') }}', '{{ route('tokens.index') }}')" >Submit <i class="fa fa-check"></i></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
@section('scripts')
<!-- page libs -->
    <script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('lib/select2/select2.min.js') }}"></script>
    <script src="{{ asset('lib/jquery.maskedinput/dist/jquery.maskedinput.min.js') }}"></script>
    <script src="{{ asset('lib/moment/moment.js') }}"></script>
    <script src="{{ asset('lib/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ asset('lib/twitter-bootstrap-wizard/jquery.bootstrap.wizard.min.js') }}"></script>
    <script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
    <script src="{{ asset('lib/messenger/build/js/messenger.js') }}"></script>
    <script src="{{ asset('lib/messenger/build/js/messenger-theme-flat.js') }}"></script>
    <!-- page specific scripts -->
    <script src="{{ asset('js/pages/ico-wizard.js') }}"></script>
@endsection
