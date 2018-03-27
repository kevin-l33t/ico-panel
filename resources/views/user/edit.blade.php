@extends('layouts.app') @section('styles') @endsection @section('content')
<h2 class="page-title">User Account
</h2>
<div class="row">
    <div class="col-lg-6">
        <section class="widget">
            <header>
                <h4>
                    <i class="fa fa-user"></i> Account Profile
                </h4>
            </header>
            <div class="body">
                <form id="user-form" class="form-horizontal form-label-left" method="post" enctype="multipart/form-data" action="{{ $action }}"
                    data-parsley-validate>
                    @csrf @isset($method) {{ $method }} @endisset @isset($user->email)
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="text-align-center">
                                <img class="img-circle" src="{{ empty($user->profile_thumb) ? asset('img/default_avatar.png') : asset('storage/'.$user->profile_thumb) }}"
                                    alt="64x64" style="height: 112px;">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <h3 class="mt-sm mb-xs">{{ $user->name }}</h3>
                            <p>
                                e-mail: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                <br>
                                phone: {{ $user->phone }}
                                <br>
                                wallet: {{ $user->wallet[0]->address }}
                            </p>
                        </div>
                    </div>
                    @endisset
                    <fieldset>
                        <legend class="section">Personal Info</legend>
                        @include('layouts.partials.formErrors')
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="name">Name
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" minlength="4" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="email">Email
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="phone">Phone Number
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="text" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required="required" class="form-control input-transparent">
                            </div>
                        </div>
                        @empty($user->email)
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" value="{{ old('password', '') }}" required="required" class="form-control input-transparent"
                                    minlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password_confirmation">Confirm Password
                                <span class="required">*</span>
                            </label>
                            <div class="col-sm-6">
                                <input type="password" id="password_confirmation" name="password_confirmation" required="required" data-parsley-equalto="#password"
                                    class="form-control input-transparent">
                            </div>
                        </div>
                        @endempty @isset($user->email)
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password">Password</label>
                            <div class="col-sm-6">
                                <input type="password" id="password" name="password" value="{{ old('password', '') }}" class="form-control input-transparent"
                                    minlength="6">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4" for="password_confirmation">Confirm Password</label>
                            <div class="col-sm-6">
                                <input type="password" id="password_confirmation" name="password_confirmation" data-parsley-equalto="#password" class="form-control input-transparent">
                            </div>
                        </div>
                        @endisset
                        @if (Auth::user()->role->name == 'Administrator')
                        <div id="wrapper_whitepaper" class="form-group">
                            <label class="control-label col-sm-4" for="whitepaper">Whitepaper</label>
                            <div class="col-sm-6">
                                <input type="url" id="whitepaper" name="whitepaper" value="{{ old('whitepaper', $user->whitepaper) }}" class="form-control input-transparent">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-4">Role</label>
                            <div class="col-sm-8">
                                <div id="role" class="btn-group" data-toggle="buttons">
                                    @foreach ($roles as $role)
                                    <label class="btn {{ $user->role_id == $role->id ? 'btn-primary active' :  'btn-default' }}" data-toggle-class="btn-primary"
                                        data-toggle-passive-class="btn-default">
                                        <input type="radio" name="role" value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'checked' : '' }} >{{ $role->name }}
                                    </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif
                    </fieldset>
                    <fieldset>
                        <legend class="section">Profile Picture</legend>
                        <div class="form-group">
                            <div class="col-md-6">
                                <div class="image-crop">
                                    <img src="{{ empty($user->profile_picture) ? '' : asset('storage/'.$user->profile_picture) }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Preview image</h4>
                                <div class="img-preview profile-pic-preview"></div>
                                <h4>Usage</h4>
                                <p>
                                    You can upload profile picture to crop container. It will saved as profile picture after save. Max filesize is <strong>8M</strong>.
                                </p>
                                <div class="btn-group">
                                    <label title="Upload image file" for="inputImage" class="btn btn-primary">
                                        <input name="profile_picture" type="file" accept="image/*" id="inputImage" class="hide"> Upload photo
                                    </label>
                                    <input id="profile_thumb" name="profile_thumb" type="hidden">
                                </div>
                                <h4>Picture manipulation</h4>
                                <div class="btn-group">
                                    <button class="btn btn-default" id="zoomIn" type="button">Zoom In</button>
                                    <button class="btn btn-default" id="zoomOut" type="button">Zoom Out</button>
                                    <button class="btn btn-default" id="rotateLeft" type="button">Rotate Left</button>
                                    <button class="btn btn-default" id="rotateRight" type="button">Rotate Right</button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="form-actions text-center">
                        <button type="submit" class="btn btn-primary">Save</button>&nbsp;&nbsp;
                        <a href="javascript:history.back()" class="btn btn-default">Cancel</a>
                    </div>
                </form>
            </div>
        </section>
    </div>
    @isset ($user->email)
    <div class="col-lg-6">
        <section class="widget">
            <header>
                <h5>Transaction <span class="fw-semi-bold">History</span></h5>
                <div class="widget-controls">
                    <a href="#"><i class="glyphicon glyphicon-cog"></i></a>
                    <a data-widgster="close" href="#"><i class="glyphicon glyphicon-remove"></i></a>
                </div>
            </header>
            <div class="widget-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Paid By</th>
                            <th>To</th>
                            <th>Value</th>
                            <th>Date</th>
                            <th class="text-center">Status</th>
                        </tr>
                        </thead>
                        <tbody>
                    @forelse ($transactions as $item)
                        <tr class="clickable-row" data-href="{{ route('tx.show', $item) }}">
                            <td>{{ $loop->index + 1}}</td>
                            <td>{{ $item->type->name }}</td>
                            <td>{{ $item->token->name }} / {{ $item->token->symbol }}</td>
                            <td>ETH {{ round($item->eth_value, 2) }} / USD {{ number_format($item->usd_value / 100) }}</td>
                            <td>{{ $item->created_at }}</td>
                            <td class="text-center">
                            @switch($item->status)
                                @case(0)
                                    <span class="badge bg-gray-lighter text-gray"><i class="glyphicon glyphicon-time"></i> Pending</span>
                                    @break
                                @case(1)
                                    <span class="badge badge-success"><i class="fa fa-check"></i> Confirmed</span>
                                    @break
                                @default
                                <span class="badge badge-danger"><i class="fa fa-ban"></i> Failed</span>
                            @endswitch
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">
                                No transactions
                            </td>
                        </tr>
                    @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
    @endisset
</div>
@endsection @section('scripts')
<!-- Page Lib -->
<script src="{{ asset('lib/parsleyjs/dist/parsley.min.js') }}"></script>
<script src="{{ asset('lib/cropperjs/cropper.min.js') }}"></script>

<!-- page specific scripts -->
<script src="{{ asset('js/pages/user-edit.js') }}"></script>
@endsection