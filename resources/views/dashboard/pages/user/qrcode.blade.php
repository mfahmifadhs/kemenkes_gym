@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-5 mx-auto">
                <div class="row ml-3">
                    <div class="col-12 text-left">
                        <div class="section-title">
                            <a href="{{ url()->previous() }}" class="btn btn-primary">
                                <i class="fa fa-arrow-circle-left"></i> Back
                            </a>
                        </div>
                    </div>
                </div>
                <div class="section-body">

                    @if(Auth::user()->absen->where('waktu_keluar', null)->count() == 0)
                    <h2 class="text-main mb-3 text-center">MEMBER CARD</h2>
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
                    @else
                    <div class="text-center">
                        <h2 class="text-main">SELAMAT DATANG</h2>
                        <div class="my-3">
                            <i class="fa fa-check-circle text-main" style="font-size: 10em;"></i>
                            <h6 class="text-white">{{ Auth::user()->member_id }}</h6>
                            <h6 class="text-white">
                                {{ optional(Auth::user()->absen->where('waktu_keluar', null)->first())->tanggal }}
                                {{ optional(Auth::user()->absen->where('waktu_keluar', null)->first())->waktu_masuk }}
                            </h6>
                        </div>
                        <h2><a href="" class="btn btn-sm bg-main text-white mt-1 w-50" onclick="confirm(event, `{{ route('absen.checkout', Auth::user()->id) }}`)">
                                <i class="fa fa-sign-out"></i> Check out
                            </a>
                        </h2>
                    </div>

                    @endif
                    <!-- <div class="card">
                        <div class="card-body text-center border">
                        </div>
                    </div> -->
                </div>
            </div>
        </div>

    </div>
</section>


@section('js')
<script>
    function confirm(event, url) {
        event.preventDefault();

        Swal.fire({
            title: 'Selesai Latihan',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });

    }
</script>
@endsection
