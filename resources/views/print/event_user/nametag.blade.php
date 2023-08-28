<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Name Tag</title>
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
    <div style="width: 50%; height: 50%; display: flex; justify-content: center; background-size: cover; background-image: url('/assets/images/nametag.png')">
        <div style="margin-top: 300px">
            {{$event_user->user_name}}
        </div>
    </div>
</div>
<script>
    // setTimeout(()=>{
    //     window.close();
    // }, 5000)
</script>
</body>
</html>
