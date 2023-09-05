<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Event Member</title>
    <style>
        body{
            font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
        }

        table.table, .table td, .table th {
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
        h4, h5{
            margin: 0 0 5px 0;
        }
    </style>
</head>
<body>
<div style="margin-bottom: 20px">
    <h4>Daftar Transaksi Jogja Cardiologi Update 2023</h4>
</div>
<table class="table">
    <thead>
    <tr>
        <td>No</td>
        <td>Date</td>
        <td>Transaction Number</td>
        <td>Name</td>
        <td>Job Type</td>
        <td>City</td>
        <td>Total</td>
        <td>Status</td>
        <td>Note</td>
        <td>Transfer Proof</td>
        <td colspan="3">Items</td>
    </tr>
    </thead>
    <tbody>
    @foreach($transactions as $key => $transaction)
        <tr>
            <td>{{$key + 1}}</td>
            <td>
                {{$transaction['created_at']}}
            </td>
            <td>{{$transaction['number']}}</td>
            <td>{{$transaction['user_name']}}</td>
            <td>{{$transaction['job_type_code']}}</td>
            <td>
                @if($transaction['user'])
                    {{$transaction['user']['city']}}
                @endif
            </td>
            <td>{{$transaction['total']}}</td>
            <td>
                @if($transaction['status'] === 200)
                    Paid
                @else
                    {{$transaction['status']}}
                @endif
            </td>
            <td>{{$transaction['note']}}</td>
            <td>
                @if($transaction['transfer_proof'])
                    <a href="{{$transaction['transfer_proof']}}">View</a>
                @endif
            </td>
            @foreach($transaction['transaction_details'] as $detail)
                <td>
                    {{$detail['event_name']}} <br>
                </td>
            @endforeach
            @if(count($transaction['transaction_details']) === 0)
                <td></td>
                <td></td>
                <td></td>
            @endif
            @if(count($transaction['transaction_details']) === 1)
                <td></td>
                <td></td>
            @endif
            @if(count($transaction['transaction_details']) === 2)
                <td></td>
            @endif
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>

