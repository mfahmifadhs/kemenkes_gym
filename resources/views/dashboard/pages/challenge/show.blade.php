@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2 mt-5">
                    <div class="col-7 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>CHALLENGE</u></h4>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="schedule">
                        <div class="row">
                            <div class="col-md-6">
                                <center class="border-main p-5">
                                    <img src="{{ asset('dist/img/challenge/fatloss.png') }}" class="w-75" alt=""><br>
                                    <h3 class="text-main mt-3">Fat Loss Challenge</h3>
                                    <a href="{{ route('challenge.detail', 'fatloss') }}" class="btn btn-primary bg-main w-75 p-3">
                                        Join Challenge
                                    </a>
                                </center>
                            </div>
                            <div class="col-md-6">
                                <center class="border-main p-5">
                                    <img src="{{ asset('dist/img/challenge/musclegain.png') }}" class="w-75" alt=""><br>
                                    <h3 class="text-main mt-3">Muscle Gain Challenge</h3>
                                    <a href="{{ route('challenge.detail', 'musclegain') }}" class="btn btn-primary bg-main w-75 p-3">
                                        Join Challenge
                                    </a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
