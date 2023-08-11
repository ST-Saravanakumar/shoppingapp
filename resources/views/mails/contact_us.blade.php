<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>
    <h1>Someone Contacted You!</h1>

    <table class="table">
        <tr>
            <th>Name</th>
            <td>{{ $details['name'] }}</td>
            <th>Email</th>
            <td>{{ $details['email'] }}</td>
            <th>Subject</th>
            <td>{{ $details['subject'] }}</td>
            <th>Message</th>
            <td>{!! $details['message'] !!}</td>
        </tr>
    </table>
</body>
</html>