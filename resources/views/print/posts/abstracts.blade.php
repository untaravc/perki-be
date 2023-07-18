<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Abstract Submission</title>
    <style>
        @media print {
            .pagebreak {
                clear: both;
                page-break-after: always;
            }
        }
    </style>
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

    @foreach($data['body_parsed'] as $section)
        <div style="margin-bottom: 10px">
            <b>{{$section['title']}}:</b>
            {{$section['content']}}
        </div>
    @endforeach

    <div>
        Keywords: <i>{{$data['subtitle']}}</i>
    </div>
    @if($data['file'])
        <div style="text-align: center">
            <img style="max-width: 100%" src="{{$data['file']}}" alt="">
            <br>
            <a target="_blank" href="{{$data['file']}}">{{$data['file']}}</a>
        </div>
    @endif
    <div class="pagebreak" style="border-bottom: 1px solid darkgrey; margin-top: 5px; margin-bottom: 10px"></div>
@endforeach
</body>
</html>
