@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>LOGIN</u></h2>
                </div>
                <div class="leave-comment">
                    @if ($message = Session::get('success'))
                    <div id="alert" class="alert bg-success">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 10000);
                    </script>
                    @endif
                    @if ($message = Session::get('failed'))
                    <div id="alert" class="alert bg-danger">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                    <script>
                        setTimeout(function() {
                            document.getElementById('alert').style.display = 'none';
                        }, 5000);
                    </script>
                    @endif
                    <form id="form-login" action="{{ route('masuk') }}" method="POST">
                        @csrf
                        <label class="text-white small">Username</label>
                        <input type="text" name="username" class="form-control text-dark bg-white" placeholder="Username">
                        <label class="text-white small">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control text-dark bg-white rounded-0" id="password" name="password" placeholder="Password" required>
                            <div class="input-group-append border border-dark">
                                <span class="input-group-text h-100 rounded-0 bg-white">
                                    <i class="fa fa-eye" id="eye-icon-pass"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="mt-4" onclick="confirmSubmit(event)">Login</button>
                        <small class="text-white">
                            If your Account <b>Isn't Active</b>, Please <a href="{{ route('activation.show') }}"><u>Click Here</u></a>
                        </small><br>
                        <small class="text-white">
                            Forgot Password ? Please <a href="{{ route('mailResetPass.show') }}"><u>Click Here</u></a>
                        </small>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form-login');

        var password = $("#password").val();
        var confPass = $("#conf-password").val();
        const inputs = form.querySelectorAll('select[required], input[required], textarea[required]');
        let isFormValid = true;

        inputs.forEach(input => {
            if (input.hasAttribute('required') && input.value.trim() === '') {
                input.style.borderColor = 'red';
                isFormValid = false;
            } else {
                input.style.borderColor = '';
            }
        });

        if (isFormValid) {
            Swal.fire({
                title: "Proses...",
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                willOpen: () => {
                    Swal.showLoading();
                },
            })

            form.submit();
        } else {
            Swal.fire({
                title: 'Gagal',
                text: 'Seluruh Kolom Harus Diisi',
                icon: 'error',
            });
        }

    }
</script>
@endsection

@endsection
