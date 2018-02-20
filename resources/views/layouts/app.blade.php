<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <link href="{{ asset('css/application.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.12.11/sweetalert2.min.css" />
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
    <script>
        /* yeah we need this empty stylesheet here. It's cool chrome & chromium fix
           chrome fix https://code.google.com/p/chromium/issues/detail?id=167083
                      https://code.google.com/p/chromium/issues/detail?id=332189
        */
    </script>
</head>
<body>
    <div class="logo">
        <h4><a href="index.html">Hunter Corp Records <strong>ICO</strong></a></h4>
    </div>

    <!-- Navigation -->
    @include('layouts.navigation')

    <!-- Page Wrapper -->
    <div class="wrap">
        <!-- Page Header -->
        @include('layouts.header')

        <div class="content container">
            <!-- Main view  -->
            @yield('content')

            <!-- Footer -->
            @include('layouts.footer')
        </div>

        <div class="loader-wrap hiding hide">
            <i class="fa fa-circle-o-notch fa-spin"></i>
        </div>
    </div>

<!-- common libraries. required for every page-->
<script src="{{ asset('lib/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jquery-pjax/jquery.pjax.js') }}"></script>
<script src="{{ asset('lib/bootstrap-sass/assets/javascripts/bootstrap.min.js') }}"></script>
<script src="{{ asset('lib/widgster/widgster.js') }}"></script>
<script src="{{ asset('lib/underscore/underscore.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.12.11/sweetalert2.min.js"></script>

<!-- common application js -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>

@section('scripts')
@show
</body>