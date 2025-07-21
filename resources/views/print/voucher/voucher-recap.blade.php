<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Member</title>
    <style>
        body {
            font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
        }

        table.table,
        .table td,
        .table th {
            border: 1px solid #0c0000;
        }

        .table td {
            padding: 4px;
        }

        thead {
            font-weight: bold;
        }

        .table {
            border-collapse: collapse;
            border-color: blue;
        }

        h4,
        h5 {
            margin: 0 0 5px 0;
        }
    </style>
</head>
<div style="margin-bottom: 20px">
    <h4>Voucher Usage
    </h4>
</div>
@php
    $redeem_count = 0;
    $qty_count = 0;
@endphp
@foreach($vouchers as $key => $voucher)
    <div style="margin-bottom: 10px"></div>
    <div>
        <b>{{$key + 1}}. {{$voucher->name}} ( {{ count($voucher->redeem) }} / {{ $voucher->qty }})</b>
    </div>
    @php
        $redeem_count += count($voucher->redeem);
        $qty_count += $voucher->qty;
    @endphp
    @if(count($voucher['redeem']) > 0)
        @foreach($voucher['redeem'] as $r => $redeem)
            <div style="padding-left: 20px">
                <i>{{ $r + 1}}. {{$redeem->user_name}}</i>
            </div>
        @endforeach
    @endif
@endforeach

<div style="padding-top: 30px">
    Penggunaan: {{ $redeem_count }} / {{$qty_count}}
</div>
<body>
</body>
</html>
