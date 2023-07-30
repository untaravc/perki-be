<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Name Tag</title>
</head>
<body onload="window.print()">
<div style="border: 1px solid lightgrey; width: 300px; height: 200px; display: flex; justify-content: center; align-items: center">
    {{$event_user->user_name}}
</div>
</body>
</html>
