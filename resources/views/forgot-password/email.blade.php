<!DOCTYPE html>
<html>

<head>
    <title>Reset Password Email</title>
    <link href="{{ asset('dist/css/bootstrap.min.css') }}" rel="stylesheet" />
</head>

<body class="m-3">
    <img src="https://i.ibb.co/7Y6Y11n/logo.png" width="100">
    <br>
    <b><i>Reset Password</i></b>
    <table>
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
        <a href="{{ route('resetPass.show', ['token' => $data['token'], 'id' => $data['id']]) }}" style="background-color: #F8F8FF; border: 1px #000 solid; padding: 5px; color: #000;">
            <b>Reset Password</b>
        </a> <br> <br>
        <span style="color: red; font-size: 12px;">Link reset password hanya dapat digunakan 1 kali.</span>
    </p>
</body>

</html>
