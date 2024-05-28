@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>RESET PASSWORD</u></h2>
                </div>
                <div class="leave-comment">
                    <form id="form-reset" action="{{ route('resetPass.post', $id) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label class="text-white small">Password Baru*</label>
                            <div class="input-group">
                                <input type="password" class="form-control text-dark bg-white" id="password" name="password" required>
                                <div class="input-group-append border border-dark">
                                    <span class="input-group-text h-100 rounded-0 bg-white">
                                        <i class="fa fa-eye" id="eye-icon-pass"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="text-white small">Konfirmasi Password*</label>
                            <div class="input-group">
                                <input type="password" class="form-control text-dark bg-white" id="conf-password" required>
                                <div class="input-group-append border border-dark">
                                    <span class="input-group-text h-100 rounded-0 bg-white">
                                        <i class="fa fa-eye" id="eye-conf-pass"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="mt-4" onclick="confirmSubmit(event)">Reset</button>
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

        const form = document.getElementById('form-reset');

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
            if (password != confPass && password != null) {
                Swal.fire({
                    title: 'Konfirmasi password tidak sama!',
                    icon: 'error'
                });
                return false;
            } else {
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
            }
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
