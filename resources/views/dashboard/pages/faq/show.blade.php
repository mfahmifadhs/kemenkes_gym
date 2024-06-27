@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-12 mx-auto">
                <div class="row mt-5">
                    <div class="col-12 text-left">
                        <div class="section-title">
                            <h4 class="text-main">FAQ</h4>
                            <p class="text-xs text-white">{{ $faq->judul }}</p>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="information">
                        <p>{!! nl2br(e($faq->deskripsi)) !!}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
