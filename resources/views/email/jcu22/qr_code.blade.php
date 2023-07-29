<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QR CODE</title>
</head>
<body>
<div style="width: 300px">
    {!! QrCode::size(300)->generate($qr_link) !!}
    <div style="text-align: center; font-size: 30px; letter-spacing: 4px; font-weight: bold">
        {{$qr_link}}
    </div>
</div>

</body>
</html>
