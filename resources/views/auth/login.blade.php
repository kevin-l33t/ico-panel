<!DOCTYPE html>
<html>
<head>
    <title>{{ config('app.name', 'Laravel') }}</title>
        <link href="css/application.css" rel="stylesheet">
    <link rel="shortcut icon" href="img/favicon.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta charset="utf-8">
</head>
<body>
        <div class="single-widget-container">
            <section class="widget login-widget">
                <header class="text-align-center">
                <img src="{{ asset('img/logo.png') }}" alt="Hunter Records Corp">
                    <h4>Login to your account</h4>
                </header>
                <div class="body">
                    @include('layouts.partials.formErrors')
                    <form class="no-margin" action="{{ route('login') }}" method="POST">
                        @csrf
                        <fieldset>
                            <div class="form-group">
                                <label for="email" >Email</label>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <i class="fa fa-user"></i>
                                    </span>
                                    <input id="email" type="email" class="form-control input-lg input-transparent {{ $errors->has('email') ? ' parsley-error' : '' }}" name="email" value="{{ old('email') }}" placeholder="Your Email" required autofocus>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password" >Password</label>

                                <div class="input-group input-group-lg">
                                    <span class="input-group-addon">
                                        <i class="fa fa-lock"></i>
                                    </span>
                                    <input id="password" name="password" type="password" class="form-control input-lg input-transparent {{ $errors->has('password') ? ' parsley-error' : '' }}" 
                                           placeholder="Your Password" minlength="6" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="checkbox">
                                    <input id="check_remember" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="check_remember">
                                        Remember Me
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-actions">
                            <button type="submit" class="btn btn-block btn-lg btn-danger">
                                <span class="small-circle"><i class="fa fa-caret-right"></i></span>
                                <small>Sign In</small>
                            </button>
                            <br>
                            <a href="{{ route('register') }}" class="btn btn-block btn-lg btn-default mt-5">
                                <small>Register</small>
                            </a>
                            <a class="forgot" href="{{ route('password.request') }}">Forgot Username or Password?</a>
                        </div>
                    </form>
                </div>
                <footer>
                    <div class="facebook-login hidden">
                        <a href="#"><span><i class="fa fa-facebook-square fa-lg"></i> LogIn with Facebook</span></a>
                    </div>
                </footer>
            </section>
        </div>
<!-- common libraries. required for every page-->
<script src="lib/jquery/dist/jquery.min.js"></script>
<script src="lib/jquery-pjax/jquery.pjax.js"></script>
<script src="lib/bootstrap-sass/assets/javascripts/bootstrap.min.js"></script>
<script src="lib/widgster/widgster.js"></script>
<script src="lib/underscore/underscore.js"></script>

<!-- common application js -->
<script src="js/app.js"></script>
<script src="js/settings.js"></script>

<!-- page specific scripts -->
    <!-- page specific libs -->
    <script src="lib/messenger/build/js/messenger.js"></script>
    <script src="lib/messenger/build/js/messenger-theme-flat.js"></script>

@if ($errors->any())

<script type="text/javascript">
    @foreach ($errors->all() as $error)
        Messenger().post({
            message : '{{ $error }}',
            type : 'info'
        });
    @endforeach
</script>

@endif

</body>
</html>