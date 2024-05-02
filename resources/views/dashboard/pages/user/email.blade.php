@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-7 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>PROFILE</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('profile', $member->id) }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div id="alert" class="alert bg-success">
                    <div class="row">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('alert').style.display = 'none';
                    }, 5000);
                </script>
                @endif

                <div class="section-body mb-5">
                    <div class="card">
                        <form id="form" action="{{ route('member.updateEmail', $member->id) }}" method="POST">
                            @csrf
                            <div class="card-body">
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Email</label>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <input type="email" name="email" class="form-control" placeholder="{{ $member->email }}">
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
                                @if (!Auth::user()->member_id)
                                <a href="{{ route('member.resendMail', $member->id) }}" onclick="confirmSend(event)" class="btn btn-primary">
                                    <i class="fa fa-paper-plane"></i> Send Link Activation
                                </a>
                                @endif
                                <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event)">
                                    <i class="fa fa-save"></i> Save
                                </button>
                            </div>
                        </form>
                    </div><br>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

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
            title: 'Save',
            text: '',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
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
            title: "Sending...",
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
