<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta name="viewport" content="width=device-width" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Successfully submitted bank receipt</title>
    @include('layouts.partials.mailStyles')
</head>

<body>
    <div class="logo">
        <img src="{{ asset('img/logo.png') }}" alt="Hunter Records Corp" width="200px;">
    </div>
    <table class="body-wrap">
        <tr>
            <td></td>
            <td class="container" width="600">
                <div class="content">
                    <table class="main" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="alert alert-good">
                                Congratulations
                            </td>
                        </tr>
                        <tr>
                            <td class="content-wrap">
                                <table width="100%" cellpadding="0" cellspacing="0">
                                    <tr>
                                        <td class="content-block aligncenter">
                                            <a class="btn btn-success">Confirmed</a>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            Congratulations as your <strong>Bank Transfer</strong> has cleared and your payment has been confirmed.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                        Your coins have been deposited into your HCR wallet.  Please login to your HCR account to refresh your wallet portfolio.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="content-block">
                                            <table class="invoice">
                                                <tr>
                                                    <td>
                                                        <table class="invoice-items" cellpadding="0" cellspacing="0">
                                                            <tr>
                                                                <td>Transaction Link</td>
                                                                <td>
                                                                    <a href="{{ route('tx.show', $receipt->transactionLogs()->first()) }}">Transaction Details</a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Coin Purchased</td>
                                                                <td>{{ $receipt->token->name }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Number of Coins</td>
                                                                <td>{{ number_format($receipt->token_value) }} {{ $receipt->token->symbol }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Amount Paid</td>
                                                                <td>$ {{ number_format($receipt->usd_value / 100, 2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Transfer Date</td>
                                                                <td>{{ date_create($receipt->created_at)->format('F jS Y g:i A') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td>Confirmed Date</td>
                                                                <td>{{ date_create($receipt->update_at)->format('F jS Y g:i A') }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2"></td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
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