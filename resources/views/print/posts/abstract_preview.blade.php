<table>
    <tr>
        <td>No</td>
        <td>Category</td>
        <td>Author</td>
        <td>Email</td>
        <td>Voucher Code</td>
        <td>Type</td>
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
            <td>@if($data['user']) {{$data['user']['email']}} @endif</td>
            <td>@if($data['user'] && $data['user']['voucher_code']) {{$data['user']['voucher_code']['code']}} @endif</td>
            <td>
                @if($data['user'])
                    @switch($data['user']['job_type_code'])
                        @case('DRGN')General Practitioner @break
                        @case('COAS')Coass @break
                        @case('ITRS')Interenship @break
                        @case('RSDN')Residen @break
                        @case('DRSP')Spesialis @break
                        @default {{$data['user']['job_type_code']}} @break
                    @endswitch
                @endif
            </td>
            <td>
                {{$data['title']}}
            </td>
        </tr>
    @endforeach
</table>
