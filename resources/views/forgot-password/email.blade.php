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

        <tr>
            <td colspan="3">

            </td>
        </tr>
    </table>
    <p>
        Klik link dibawah ini untuk <i>Reset Password</i>: <br>
        <a href="{{ route('resetPass.show', ['token' => $data['token'], 'id' => $data['id']]) }}" style="color: blue;"><i><u>
                    {{ encrypt($data['token']) }}
            </i></u></a>

        <h6 class="small" style="color: red;">Link reset password hanya dapat digunakan 1 kali.</h6>
    </p>
</body>

</html>
