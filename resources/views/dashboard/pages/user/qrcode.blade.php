@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-5 mx-auto">
                <a href="{{ url()->previous() }}" class="btn btn-primary">
                    <i class="fa fa-arrow-circle-left"></i> Back
                </a>
                <div class="section-body">

                    <h2 class="text-main mt-4 mb-3 text-center">MEMBER CARD</h2>
                    <div class="qrcode">
                        <div class="bg-dark p-4 rounded">
                            <div class="text-center">
                                <img class="bg-white p-2" src="{{ asset($tempImagePath) }}" alt="QR Code">
                            </div>
                            <div class="bg-main p-1 mt-3 text-center text-white" style="border-radius: 10px;">
                                <div>{{ Auth::user()->member_id }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card">
                        <div class="card-body text-center border">
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

    </div>
</section>

@endsection
