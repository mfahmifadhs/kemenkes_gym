@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-5 mx-auto">

                <div class="section-body">

                    <h2 class="text-main my-5 text-center">MEMBER CARD</h2>
                    <div class="card">
                        <div class="card-body text-center border">
                            {!! QrCode::size(320)
                            ->generate(Auth::user()->member_id) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
