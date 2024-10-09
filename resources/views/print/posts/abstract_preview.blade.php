<table>
    <tr>
        <td>No</td>
        <td>Category</td>
        <td>Author</td>
        <td>Institution</td>
        <td>Email</td>
        <td style="text-align: right">Transaction</td>
        {{-- <td>Voucher Code</td> --}}
        <td>Type</td>
{{--        <td>Title</td>--}}
        <td>Score</td>
        <td colspan="3">Score List</td>
    </tr>
    @foreach ($data_content as $key => $data)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>
                {{ $data['category'] }}
            </td>
            <td>
                @if ($data['user'])
                    {{ $data['user']['name'] }}
                @endif
            </td>
            <td>
                @if ($data['user'])
                    {{ $data['user']['institution'] }}
                @endif
            </td>
            <td>
                @if ($data['user'])
                    {{ $data['user']['email'] }}
                @endif
            </td>
            {{-- <td>@if ($data['user'] && $data['user']['voucher_code']) {{$data['user']['voucher_code']['code']}} @endif</td> --}}
            <td style="text-align: right">
                @if ($data['user'] && $data['user']['success_transactions'] && isset($data['user']['success_transactions'][0]))
                    {{ number_format($data['user']['success_transactions'][0]['total'], 0, ',', '.') }}
                @endif
            </td>
{{--            <td>--}}
{{--                @if ($data['user'])--}}
{{--                    @switch($data['user']['job_type_code'])--}}
{{--                        @case('DRGN')--}}
{{--                            General Practitioner--}}
{{--                        @break--}}

{{--                        @case('COAS')--}}
{{--                            Coass--}}
{{--                        @break--}}

{{--                        @case('ITRS')--}}
{{--                            Interenship--}}
{{--                        @break--}}

{{--                        @case('RSDN')--}}
{{--                            Residen--}}
{{--                        @break--}}

{{--                        @case('DRSP')--}}
{{--                            Spesialis--}}
{{--                        @break--}}

{{--                        @default--}}
{{--                            {{ $data['user']['job_type_code'] }}--}}
{{--                        @break--}}
{{--                    @endswitch--}}
{{--                @endif--}}
{{--            </td>--}}
            <td>
                {{ $data['title'] }}
            </td>
            <td>
                {{ $data['score'] }}
            </td>
            @foreach($data['scores'] as $score)
                <td>{{ $score['total'] }}</td>
            @endforeach
        </tr>
    @endforeach
</table>
