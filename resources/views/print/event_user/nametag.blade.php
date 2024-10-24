<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ request('align') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet">
    <style>
        @media print {
            @page {
                margin: 0;
            }

            * {
                -webkit-print-color-adjust: exact;
            }
        }

        body {
            font-weight: bold;
            font-family: Roboto, Helvetica, Arial, sans-serif;
            font-size: 16px;
        }
    </style>
</head>

{{-- <body > --}}
@php
    $align = request('align') ?? 'center';
    $width = '400px';
    $height = '1000px';

    $font_size = '18px';

    $first_top = '155px';
    $second_top = '640px';
    $third_top = '740px';

    $url_bg = '/assets24/posters/name_tag.jpeg';

    if (strlen($event_user['user_name']) > 25) {
        $font_size = '14px';
    }

    if (strlen($event_user['user_name']) > 35) {
        $font_size = '12px';
    }
@endphp

<body onload="window.print()">
    @if ($align == 'left')
        <div
            style="position: relative; width: {{ $width }}; height: {{ $height }}; background-image: url('')">
            <div style="position: absolute; top: {{ $first_top }}; margin-left: 20px; max-width: 330px">
                <div style="font-size: {{ $font_size }}; ">
                    {{ $event_user['user_name'] }}
                </div>
            </div>
            <div
                style="position: absolute; top: {{ $second_top }}; text-align: center; font-size: 28px; width: {{ $width }}">
                PARTICIPANT
            </div>
            <div style="position: absolute; top: {{ $third_top }}; margin-left: 20px;  max-width: 330px">
                <span style="font-size: {{ $font_size }}">
                    {{ $event_user['user_name'] }}
                </span>
            </div>
        </div>
    @else
        <div
            style="position: relative; width: 100%; height: {{ $height }}; background-image: url(''); display: flex; justify-content: center; background-repeat: no-repeat; background-position: top">
            <div style="position: absolute; top: {{ $first_top }}; width: 330px; margin-left: 30px">
                <div style="font-size: {{ $font_size }}; ">
                    {{ $event_user['user_name'] }}
                </div>
            </div>
            <div
                style="position: absolute; top: {{ $second_top }}; text-align: center; font-size: 32px; width: {{ $width }}">
                PARTICIPANT
            </div>
            <div style="position: absolute; top: {{ $third_top }}; width: 330px; margin-left: 30px">
                <span style="font-size: {{ $font_size }}">
                    {{ $event_user['user_name'] }}
                </span>
            </div>
        </div>
    @endif
    <script>
        // setTimeout(() => {
        //     window.close();
        // }, 5000)
    </script>
</body>

</html>
