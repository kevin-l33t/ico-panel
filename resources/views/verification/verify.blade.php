<!DOCTYPE html>
<html>
<head>
    <title>HUNTER CORP RECORDS - ICO</title>

        <link href="{{ asset('css/application.css') }}" rel="stylesheet">
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
        <div class="error-page container">
            <main id="content" class="error-container" role="main">
                <div class="row">
                    <div class="col-sm-12 text-center">
                        <div class="error-container">
                            <h2>Hunter Corp Records KYC Verification</h2>
                            <br><br>
                            <p class="error-info">
                                Please use the window below to start the verification process.
                            </p>
                            <div>
                                <iframe src="{{ $verification_link }}" width="8000" height="1000" style="border: none;"></iframe>
                            </div>
                            <a href="{{ route('verification.index') }}" class="btn btn-transparent">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="page-footer">
                2018 &copy; Hunter Corp Records
            </footer>
        </div>
<!-- common libraries. required for every page-->
<script src="{{ asset('lib/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('lib/jquery-pjax/jquery.pjax.js') }}"></script>
<script src="{{ asset('lib/bootstrap-sass/assets/javascripts/bootstrap.min.js') }}"></script>

<!-- common application js -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>
    <!-- page specific scripts -->

</body>
</html>