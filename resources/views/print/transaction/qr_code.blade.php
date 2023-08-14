<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Qr Code Pass</title>
    <style>
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 12px;
        }

        table tr td {
            vertical-align: top
        }
    </style>
</head>
<body>
<div style="max-width: 600px">
    <div style="text-align: center">
        <img src="https://jcu.perki-jogja.com/storage/logo/jcu_color.png"
            height="32"
        />
    </div>
    <h3 style="text-align: center">QR Code Pass</h3>
    <div style="padding: 10px 50px; text-align: center;">
        <img style="width: 200px; max-height: 200px; margin-bottom: 20px"
             src="data:image/svg+xml;base64,{{$qr_link}}"
             alt="">
        <span style="letter-spacing: 10px; width: 300px; border: 1px solid black; border-radius: 10px; padding: 10px; text-align: center; font-size: 1em; font-weight: bold;">{{$transaction['number']}}</span>
    </div>

    <div style="margin-top: 10px">
        <div style="border: 1px solid grey; margin: 10px 0; padding: 10px; border-radius: 10px">
            <table style="width: 100%">
                <tr>
                    <td>
                        <div>
                            <b>{{$transaction['user_name']}}</b>
                        </div>
                        <i>{{$transaction['job_type_code']}}</i>
                    </td>
                    <td style="border-left: 1px solid grey; font-size: 0.8em; padding-left: 20px">
                        @if($transaction['status'] === 200)
                            <b>paid</b>
                        @endif
                        <div>Rp {{number_format($transaction['total'], 0,',','.')}}</div>
                        <div><i>at {{$transaction['paid_at']}}</i></div>
                    </td>
                </tr>
            </table>
        </div>

        <div style="border: 1px solid grey; padding: 10px; border-radius: 10px">
            <table style="width: 100%">
                @foreach($transaction_details as $detail)
                    <tr>
                        <td style="width: 70%; border-bottom: 1px solid lightgrey">
                            <b>{{$detail['event_name']}}</b>
                            <br>
                            <small><i>{{$detail['event']['title']}}</i></small>
                        </td>
                        <td style="border-bottom: 1px solid lightgrey">
                            <small><b>start at</b></small>
                            <br>
                            <small><i>{{$detail['event']['date_start']}}</i></small>
                        </td>
                    </tr>
                @endforeach
            </table>
        </div>

    </div>
</div>
</body>
</html>
