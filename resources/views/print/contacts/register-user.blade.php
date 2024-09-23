<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }

        td,
        th {
            padding: 2px;
        }

        table {
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <table>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
        </tr>
        @foreach ($users as $key => $user)
            <tr>
                <td>
                    {{ $key + 1 }}
                </td>
                <td>
                    {{ $user->name }}
                </td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->email }}</td>
            </tr>
        @endforeach
    </table>
</body>

</html>
