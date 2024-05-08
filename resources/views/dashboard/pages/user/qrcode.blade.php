@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-5 mx-auto">

                <div class="section-body">

                    <h3 class="text-main text-center mt-5">MEMBER CARD</h3>
                    <div class="my-4 text-center border border-white">
                    {!! QrCode::merge(public_path('dist/img/logo.png'), 0.5, true)
                    ->size(350)
                    ->generate(Auth::user()->member_id) !!}
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
