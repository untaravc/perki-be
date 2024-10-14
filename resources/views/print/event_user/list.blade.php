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

<body>
    <div style="margin-bottom: 20px">
        <h4>Daftar Peserta Jogja Cardiologi Update 2023</h4>
        <h5>{{ $event['name'] }}: {{ $event['title'] }}</h5>
    </div>
    <div><small>{{ date('D, d M H:i', strtotime($event['date_start'])) }}</div>
    <table class="table">
        <thead>
            <tr>
                <td>No</td>
                <td>Register</td>
                <td>Name</td>
                <td>Email</td>
                <td>NIK</td>
                <td>Phone</td>
                <td>Job Type</td>
                <td>Payment Status</td>
                <td>Paket</td>
                <td>Total</td>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction_details as $key => $detail)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td title=>
                        {{ $detail['created_at'] }}
                    </td>
                    <td>
                        @if (isset($detail['transaction']))
                            {{ $detail['transaction']['user_name'] }}
                        @else
                            {{ $detail['transaction_id'] }}
                        @endif
                    </td>
                    <td>
                        @if (isset($detail['transaction']))
                            {{ $detail['transaction']['user_email'] }}
                        @else
                            {{ $detail['transaction_id'] }}
                        @endif
                    </td>
                    <td>
                        @if (isset($detail['transaction']))
                            {{ $detail['transaction']['nik'] }}
                        @else
                            {{ $detail['transaction_id'] }}
                        @endif
                    </td>
                    <td>
                        @if (isset($detail['transaction']))
                            {{ $detail['transaction']['user_phone'] }}
                        @endif
                    </td>
                    <td>
                        {{ $detail['job_type_code'] }}
                    </td>
                    <td>
                        @if ($detail['status'] === 200)
                            Paid
                        @else
                            Pending
                        @endif
                    </td>
                    <td>
                        @if (isset($detail->transaction))
                            {{ $detail->transaction->package_name }}
                        @endif
                    </td>
                    <td>
                        @if (isset($detail->transaction))
                            {{ number_format($detail->transaction->total, 0, ',', '.') }}
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

{{-- id in (360, 172, 337, 311) --}}
