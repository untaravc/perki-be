<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{request('align')}}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page { margin: 0; }
            * {
                -webkit-print-color-adjust: exact;
            }
        }
        body{
            font-weight: bold;
            font-family: Roboto, Helvetica, Arial, sans-serif;
            font-size: 16px;
        }
    </style>
</head>
<body onload="window.print()">
{{--<body>--}}
<div style="width: 100%; height: 900px;">
    @if((isset($event_user['event_id']) && ($event_user['scanner_id'] === 231)))
{{--    <div style="width: 50%; height: 50%; display: flex; justify-content: center; background-size: cover; background-image: url('/assets/images/nametag.png')">--}}
    <div style="width: 100%; height: 50%; display: flex; justify-content: center; position: relative;">
        <div style="top: 310px; position: absolute; width: 200px; text-align: center; color: #010148;">
            {{$event_user->user_name}}
        </div>
        <div style="color: #010148; position: absolute; top: 400px;">
            PARTICIPANT
        </div>
    </div>
    @else
        <div style="width: 42%; height: 50%; display: flex; justify-content: center; position: relative;">
            <div style="top: 310px; position: absolute; width: 200px; text-align: center; color: #010148;">
                {{$event_user['user_name']}}
            </div>
            <div style="color: #010148; position: absolute; top: 400px;">
                PARTICIPANT
            </div>
        </div>
    @endif
</div>
<script>
    setTimeout(()=>{
        window.close();
    }, 5000)
</script>
</body>
</html>
