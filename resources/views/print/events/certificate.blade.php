<html>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@500&display=swap" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Oleo+Script&display=swap" rel="stylesheet">
<style>
    html, body {
        margin: 0
    }

    .text-name {
        top: {{$name_top}}px;
        left: {{$name_left}}px;
        font-family: 'Oleo Script', cursive;!important;
        font-size: 80px;
        width: 1850px;
        text-align: center;
        z-index: 9;
        /*background-color: yellow;*/
    }
</style>

<body style="position: relative;">
{{--	<div style=" width: 2270px;">--}}
<img src="data:image/jpg;base64, {{$img}}" style="width: 100%; top:0;left: 0">
<div class="text-name" style="position: absolute;">
    {{$name}}
</div>
{{--	</div>--}}
</body>
</html>
