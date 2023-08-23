<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Invoice #{{$transaction['number']}}</title>
    <style>
        body {
            font-size: 12px;
            font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
        }

        h1, h2, h3, h4, h5, h6 {
            margin: 0;
        }

        thead {
            font-weight: bold;
        }

        .bt {
            border-top: 1px solid gray;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>
<body>
<div style="display: flex; justify-content: space-between; border-bottom: 1px solid gray">
    <div>
        <img src="https://jcu.perki-jogja.com/storage/logo/jcu_color.png" alt="Perki Logo"
             style="width: 100px">
        <h1 style="margin: 5px">Invoice</h1>
    </div>
    <div style="max-width: 250px; text-align: right">
        <b>Perki Jogja</b>
        <div>Gedung Pusat Jantung Terpadu</div>
        <div>Jl. Kesehatan No.1, Senolowo, Sinduadi, <br>Daerah Istimewa Yogyakarta 55281</div>
    </div>
</div>
<div style="display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid gray">
    <div>
        <div style="margin-bottom: 5px"><b><small>BILL TO</small></b></div>
        <div>
            <h3>{{$transaction['user_name']}}</h3>
            <div>{{$transaction['user_phone']}}</div>
            <div>{{$transaction['user']['institution']}}</div>
            <div>{{$transaction['user']['city']}}</div>
        </div>
    </div>
    <div style="max-width: 250px; text-align: right;">
        <div>Invoice#</div>
        <div style="margin-bottom: 2px"><b>{{$transaction['number']}}</b></div>
        <div>Created at</div>
        <div style="margin-bottom: 2px"><b>{{$transaction['created_at']}}</b></div>
        <div>Status</div>
        <div><b>{{$transaction['status_label']}}</b></div>
    </div>
</div>
<div style="padding: 10px 0">
    <table style="width: 100%;">
        <thead>
        <tr>
            <td>No</td>
            <td>Name</td>
            <td>Schedule</td>
            <td style="text-align: right">Price</td>
        </tr>
        </thead>
        <tbody>
        @foreach($transaction['transaction_details'] as $key => $detail)
            <tr>
                <td>{{$key + 1}}</td>
                <td>{{$detail['event_name']}}</td>
                <td>{{date('M jS, H:i',strtotime($detail['event']['date_start']))}}</td>
                <td style="text-align: right">{{number_format($detail['price'], 0, ',', '.')}}</td>
            </tr>
        @endforeach
        <tr>
            <td class="bt"></td>
            <td class="bt"></td>
            <td class="bt" style="text-align: right">Subtotal</td>
            <td class="bt" style="text-align: right">{{number_format($transaction['subtotal'], 0, ',', '.')}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right">Discount</td>
            <td style="text-align: right">{{number_format($transaction['subtotal'] - $transaction['total'], 0, ',', '.')}}</td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: right"><b>Total</b></td>
            <td style="text-align: right"><b>{{number_format($transaction['total'], 0, ',', '.')}}</b></td>
        </tr>
        </tbody>
    </table>
</div>
<div>
    <div style="margin-bottom: 5px">
        <b>Payment Account</b>
    </div>
    <div style="margin-bottom: 5px">
        <img src="https://jcu.perki-jogja.com/storage/logo/Mandiri_logo.png" alt="" style="width: 50px">
    </div>
    <div style="margin-bottom: 5px">
        <h3>1370 0013 3133 5</h3>
        Bank Mandiri an. <b>PERKI Yogyakarta</b>
    </div>
</div>
<div class="bt" style="padding: 3px 0; text-align: right">
    <small><i>valid access on <a href="{{url()->full()}}">{{url()->full()}}</a></i></small>
</div>
</body>
</html>
