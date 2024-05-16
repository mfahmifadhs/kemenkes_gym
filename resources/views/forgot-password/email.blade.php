<!DOCTYPE html>
<html>
<head>
    <title>Kirim Email</title>
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>
<body class="m-3">
    <img src="https://i.ibb.co/7Y6Y11n/logo.png" width="100">
    <br>
    <b style="margin-left: 5px;"><i>Your Password</i></b>
    <table style="margin-left: 5px;">
        <tr>
            <td>Full name</td>
            <td>:</td>
            <td>{{ $data['nama'] }}</td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>:</td>
            <td>{{ $data['uker'] }}</td>
        </tr>
        <tr>
            <td>Username</td>
            <td>:</td>
            <td>{{ $data['username'] }}</td>
        </tr>
        <tr>
            <td>Password</td>
            <td>:</td>
            <td>{{ substr($data['password'], 0, -3) . str_repeat('*', 3) }}</td>
        </tr>
        <tr>
            <td colspan="3">
                <span style="color: red;">Keep your Password and don't share this password to others.</span>
            </td>
        </tr>
    </table>
</body>
</html>
