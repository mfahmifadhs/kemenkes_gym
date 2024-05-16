<!DOCTYPE html>
<html>
<head>
    <title>Kirim Email</title>
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>
<body class="m-3">
    <img src="https://i.ibb.co/7Y6Y11n/logo.png" width="100">
    <br>
    <b style="margin-left: 5px;"><i>Account Activation</i></b>
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
    </table>
    <p>
        Please click the link below to activate your <b>Account</b>: <br>
        <a href="{{ route('aktivasi', ['token' => $data['token'], 'id' => $data['id']]) }}" style="color: blue;"><i><u>
            {{ encrypt($data['token']) }}
        </i></u></a>
    </p>

    <p style="color: red;">Don't share this link to others.</p>
</body>
</html>
