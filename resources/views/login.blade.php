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
                    <form action="{{ route('masuk') }}" method="POST">
                        @csrf
                        <label class="text-white small">Username</label>
                        <input type="text" name="username" placeholder="Username">
                        <label class="text-white small">Password</label>
                        <div class="input-group">
                            <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Password" required>
                            <div class="input-group-append border border-dark">
                                <span class="input-group-text h-100 rounded-0 bg-white">
                                    <i class="fa fa-eye" id="eye-icon-pass"></i>
                                </span>
                            </div>
                        </div>
                        <button type="submit" class="mt-4">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Contact Section End -->

@endsection
