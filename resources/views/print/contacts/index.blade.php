<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact List</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            @if ($columns['no'])
                <th>No</th>
            @endif
            @if ($columns['type'])
                <th>Type</th>
            @endif
            @if ($columns['name'])
                <th>Name</th>
            @endif
            @if ($columns['email'])
                <th>Email</th>
            @endif
            @if ($columns['phone'])
                <th>Phone</th>
            @endif
        </tr>
        @foreach ($contacts as $contact)
            <tr>
                @if ($columns['no'])
                    <td>{{ $loop->iteration }}</td>
                @endif
                @if ($columns['type'])
                    <td>{{ $contact->type }}</td>
                @endif
                @if ($columns['name'])
                    <td>{{ $contact->name }}</td>
                @endif
                @if ($columns['email'])
                    <td>{{ $contact->email }}</td>
                @endif
                @if ($columns['phone'])
                    <td>{{ $contact->phone }}</td>
                @endif
            </tr>
        @endforeach
    </table>
    page: {{ $contacts->currentPage() }} | pages: {{ $contacts->lastPage() }} | per_page: {{ $contacts->perPage() }}
</body>

</html>
