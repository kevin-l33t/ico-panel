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
                            <form class="form-horizontal form-label-left" method="post" action="{{ route('verification.verify') }}">
                                @csrf
                                <h1>Please verify your identity before get started</h1>
                                <br><br>
                                <p class="error-info">
                                    Every user have to verify ID before participating ICO.
                                </p>
                                <div style="margin: 20px auto; width: 300px;">
                                    <div class="form-group row">
                                        <label class="col-sm-6 control-label" for="method">Verification Method</label>
                                        <div class="col-sm-6">
                                            <select class="selectpicker" data-style="btn-default"
                                                    data-width="auto" id="method" name="method">
                                                <option value="id_card">ID Card</option>
                                                <option value="passport">Passport</option>
                                                <option value="driving_license">Driving License</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success">&nbsp; Go to Verify &nbsp;</button>
                                <p class="error-help mt-lg">
                                    Please email me support@huntercorprecords.com if you have any inquires.
                                </p>
                            </form>
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
<script src="{{ asset('lib/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>

<!-- common application js -->
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/settings.js') }}"></script>
    <!-- page specific scripts -->
    <script>
        $(function () {
            $(".selectpicker").selectpicker();
        });
    </script>

</body>
</html>