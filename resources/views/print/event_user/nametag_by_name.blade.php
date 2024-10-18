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
@php
    $width = '400px';
    $height = '1000px';

    $font_size = '22px';

    $first_top = '160px';
    $second_top = '650px';
    $third_top = '750px';

    $url_bg = '/assets24/posters/name_tag.jpeg';

    if (strlen($name) > 25) {
        $font_size = '18px';
    }

    if (strlen($name) > 35) {
        $font_size = '14px';
    }
@endphp

<body onload="window.print()">
    <div style="width: 100%; height: 900px;">
        @if ($align == 'center')
            <div
                style="width: 100%; height: {{ $height }}; display: flex; background-position: top;
            background-repeat: no-repeat; justify-content: center; position: relative;">
                <div style="position: absolute; top: {{ $first_top }}; width: 330px">
                    <div style="font-size: {{ $font_size }}; ">
                        {{ $name }}
                    </div>
                </div>
                <div
                    style="position: absolute; top: {{ $second_top }}; text-align: center; font-size: 32px; width: {{ $width }}">
                    {{ $title }}
                </div>
                <div style="position: absolute; top: {{ $third_top }}; width: 330px">
                    <span style="font-size: {{ $font_size }}">
                        {{ $name }}
                    </span>
                </div>
            </div>
        @else
            <div
                style="position: relative; width: {{ $width }}; height: {{ $height }}; background-image: url('')">
                <div style="position: absolute; top: {{ $first_top }}; margin-left: 20px; max-width: 330px">
                    <div style="font-size: {{ $font_size }}; ">
                        {{ $name }}
                    </div>
                </div>
                <div
                    style="position: absolute; top: {{ $second_top }}; text-align: center; font-size: 28px; width: {{ $width }}">
                    {{ $title }}
                </div>
                <div style="position: absolute; top: {{ $third_top }}; margin-left: 20px;  max-width: 330px">
                    <span style="font-size: {{ $font_size }}">
                        {{ $name }}
                    </span>
                </div>
            </div>
        @endif
    </div>
    <script></script>
</body>

</html>
