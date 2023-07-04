<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abstract Submission</title>
</head>
<body>
@foreach($data_content as $data)
    <div style="text-align: center; margin-bottom: 10px">
        <div>Nomor: {{$data['abstract_number']}}</div>
        <h3>{{$data['title']}}</h3>
        @if($type === 'full_text')
            <div style="margin-bottom: 10px">
                @foreach($data['authors'] as $key => $author)
                    <span>
                {{$author['first_name']}} {{$author['surname']}}<sup>{{$key+1}}</sup>@if($author['type'] == 'presenter')
                            <sup>,*</sup>
                        @endif,
            </span>
                @endforeach
            </div>
            <div style="margin-bottom: 10px">
                @foreach($data['authors'] as $key => $author)
                    <div>
                        <sup>{{$key + 1}}</sup> {{$author['institution']}}
                    </div>
                @endforeach
            </div>
            @foreach($data['authors'] as $key => $author)
                @if($author['type'] == 'presenter')
                    <div>
                        {{$author['email']}}
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div style="margin-bottom: 5px">
        <b>Background:</b>
        @if($data['body_parsed'])
            @if(isset($data['body_parsed']['body_background']))
                {{$data['body_parsed']['body_background']}}
            @endif
        @endif
    </div>
    <div style="margin-bottom: 5px">
        <b>Aim:</b>
        @if($data['body_parsed'])
            @if(isset($data['body_parsed']['body_aim']))
                {{$data['body_parsed']['body_aim']}}
            @endif
        @endif
    </div>
    <div style="margin-bottom: 5px">
        <b>Method:</b>
        @if($data['body_parsed'])
            @if(isset($data['body_parsed']['body_method']))
                {{$data['body_parsed']['body_method']}}
            @endif
        @endif
    </div>
    <div style="margin-bottom: 5px">
        <b>Results:</b>
        @if($data['body_parsed'])
            @if(isset($data['body_parsed']['body_results']))
                {{$data['body_parsed']['body_results']}}
            @endif
        @endif
    </div>
    <div style="margin-bottom: 10px">
        <b>Conclusions:</b>
        @if($data['body_parsed'])
            @if(isset($data['body_parsed']['body_conclusions']))
                {{$data['body_parsed']['body_conclusions']}}
            @endif
        @endif
    </div>
    <div>
        Keywords: <i>{{$data['subtitle']}}</i>
    </div>
    <div style="border-bottom: 1px solid darkgrey; margin-top: 5px; margin-bottom: 10px"></div>
@endforeach
</body>
</html>
