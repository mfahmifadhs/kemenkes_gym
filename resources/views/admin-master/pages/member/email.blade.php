@extends('admin-master.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-5">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Ubah Email</small></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('member.detail', $member->id) }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-5">
            <div class="card">
                <form id="form" action="{{ route('member.updateEmail', $member->id) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label">Email</label>
                            <div class="col-md-10">
                                <div class="input-group">
                                    <input type="email" class="form-control" placeholder="{{ $member->email }}">
                                    <div class="input-group-append">
                                        <span class="input-group-text border-secondary">
                                            <i class="fa fa-envelope" id="eye-icon-old"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('member.resendMail', $member->id) }}" onclick="confirmSend(event)" class="btn btn-primary">
                            Kirim link aktivasi
                        </a>
                        <button type="submit" class="btn btn-success" onclick="confirmSubmit(event)">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div> <br>
        </div>
    </div>
</div>

@section('js')
<script>
    $(document).ready(function() {
        $("#eye-icon-old").click(function() {
            var password = $("#old-password")
            var icon = $("#eye-icon")
            if (password.attr("type") == "password") {
                password.attr("type", "text")
                icon.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
            } else {
                password.attr("type", "password")
                icon.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
            }
        });
        $("#eye-icon-pass").click(function() {
            var password = $("#password")
            var icon = $("#eye-icon")
            if (password.attr("type") == "password") {
                password.attr("type", "text")
                icon.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
            } else {
                password.attr("type", "password")
                icon.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
            }
        });

        $("#eye-icon-conf").click(function() {
            var password = $("#conf-password")
            var icon = $("#eye-icon")
            if (password.attr("type") == "password") {
                password.attr("type", "text")
                icon.removeClass("fa fa-eye").addClass("fa fa-eye-slash");
            } else {
                password.attr("type", "password")
                icon.removeClass("fa fa-eye-slash").addClass("fa fa-eye");
            }
        });
    })
</script>

<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        var now_password = '{{ $member->password_teks }}';
        var old_password = $("#old-password").val();
        var password = $("#password").val();
        var conf_password = $("#conf-password").val();

        if (password != conf_password && password != null) {
            Swal.fire({
                text: 'Konfirmasi password tidak sama!',
                icon: 'error'
            });
            return false;
        }

        if (old_password != now_password && old_password) {
            Swal.fire({
                text: 'Password lama Anda salah!',
                icon: 'error'
            });
            return false;
        }

        if (old_password == now_password && !password) {
            Swal.fire({
                text: 'Anda belum menambahkan Password Baru!',
                icon: 'error'
            });
            return false;
        }

        if (!old_password) {
            $('input[name="password"]').val(now_password);
        }

        Swal.fire({
            title: 'Simpan perubahan',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }
</script>

<script>
    function confirmSend(event) {
        event.preventDefault();

        Swal.fire({
            title: "Mengirim...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            },
        })

        window.location.href = event.target.href;

    }
</script>
@endsection
@endsection
