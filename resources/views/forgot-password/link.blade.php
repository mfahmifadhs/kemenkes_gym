@extends('app')
@section('content')

<!-- Contact Section Begin -->
<section class="contact-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 mx-auto mt-5">
                <div class="section-title contact-title text-center">
                    <h2><u>Forgot Password</u></h2>
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
                    <form id="form-mail" action="{{ route('resetPass.mail') }}" method="GET">
                        @csrf
                        <label class="text-white h4 mb-0">Email</label><br>
                        <small class="text-white mt-0">Please enter the email you used during registration.</small>
                        <input type="email" name="email" class="form-control bg-white" placeholder="Email">
                        <button type="submit" class="" onclick="confirm(event)"><i class="fa fa-paper-plane"></i> Send</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@section('js')
<script>
    function confirm(event) {
        event.preventDefault();
        const form = document.getElementById('form-mail');
        Swal.fire({
            title: "Sending...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            },
        })

        form.submit();
    }
</script>

@endsection
@endsection
