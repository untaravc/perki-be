<table>
    <tr>
        <td>No</td>
        <td>Category</td>
        <td>Author</td>
        <td>Title</td>
    </tr>
    @foreach($data_content as $key => $data)
        <tr>
            <td>{{$key + 1}}</td>
            <td>
                {{$data['category']}}
            </td>
            <td>
                @if($data['user']) {{$data['user']['name']}} @endif
            </td>
            <td>
                {{$data['title']}}
            </td>
        </tr>
    @endforeach
</table>
