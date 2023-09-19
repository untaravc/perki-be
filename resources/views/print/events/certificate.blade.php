<html>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Lobster&display=swap');
</style>
<style>
    /*@font-face {*/
    /*    font-family: 'Oleo Script';*/
    /*    src: url('/fonts/OleoScript-Regular.ttf');*/
    /*}*/

    html, body {
        margin: 0
    }

    .text-name {
        top: {{$name_top}}px;
        left: {{$name_left}}px;
        font-family: 'Lobster', cursive; !important;
        font-size: 80px;
        width: 1850px;
        text-align: center;
        z-index: 9;
        /*background-color: yellow;*/
    }
</style>

<body style="position: relative;">
<img src="data:image/jpg;base64, {{$img}}" style="width: 100%; top:0;left: 0">
<div class="text-name" style="position: absolute;">
    {{$name}}
</div>
</body>
</html>
