<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Verify your email</title>
    @include('layouts.partials.mailStyles')
</head>

<body>
    <div class="logo">
        <img src="{{ asset('img/logo_black.png') }}" alt="Hunter Records Corp" width="200px;">
    </div>
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="alert alert-good">
                                Welcome to Hunter Corp Records
                            </td>
                        </tr>
                        <tr>
                            <td class="content-wrap">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block">
                                            Your registered email is <strong>{{ $user->email }}</strong> , Please click on the below link to verify your email.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <a href="{{ url('verification/email', $user->emailVerification[0]->token) }}">{{ url('verification/email', $user->emailVerification[0]->token) }}</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block aligncenter">
                                            <a href="{{ route('verification.email', $user->emailVerification[0]->token) }}" class="btn btn-primary">Confirm email address</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block aligncenter">
                                        For customer inquires, please contact <a href="mailto:support@huntercorprecords.com">Customer support</a>.<br>
                                        Please Include your transaction link with your request.
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <div class="footer">
                        <table width="100%">
                            <tr>
                                <td class="aligncenter content-block">&copy; Hunter Corp Records 2018</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </td>
            <td></td>
        </tr>
    </table>

</body>

</html>