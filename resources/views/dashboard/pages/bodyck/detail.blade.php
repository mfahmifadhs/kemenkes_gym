@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-7 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>BODY COMPOSITION</u></h4>
                        </div>
                    </div>
                    <div class="col-5 text-right mt-1">
                        <a href="{{ route('bodyck') }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                @if ($message = Session::get('success'))
                <div id="alert" class="alert bg-success">
                    <div class="row">
                        <p style="color:white;margin: auto;">{{ $message }}</p>
                    </div>
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('alert').style.display = 'none';
                    }, 5000);
                </script>
                @endif

                <div class="section-body mb-5">
                    <div class="schedule px-3 pb-3" style="border: 1px solid #00b9ad;">
                        <div class="section-title mb-2 text-center">
                            <span>Body  Composition</span>
                            <h6 class="text-main">{{ $bodyck->tanggal_cek }}</h6>
                            <h6 class="text-main">SERIAL NO. {{ str_pad($bodyck->no_serial, 8, '0', STR_PAD_LEFT) }}</h6>
                        </div>

                        <label class="text-white small font-weight-bold">Input</label>
                        <div class="row text-white mb-2">
                            <label class="col-md-3 col-5">Body Type</label>
                            <div class="col-md-9 col-7">: {{ $bodyck->tipe_badan }}</div>
                            <label class="col-md-3 col-5">Height</label>
                            <div class="col-md-9 col-7">: {{ $bodyck->bodyck_tinggi }} cm</div>
                            <label class="col-md-3 col-5">Clothes Weight</label>
                            <div class="col-md-9 col-7">: {{ $bodyck->berat_baju }} kg</div>
                        </div>
                        <hr class="divider">
                        <label class="text-white small font-weight-bold">Result</label>
                        @foreach ($bodyck->detail as $row)
                        <div class="row text-white mb-2">
                            <label class="col-md-3 col-6">{{ $row->param->nama_param }}</label>
                            <div class="col-md-9 col-6">: {{ $row->nilai.' '. $row->param->satuan }}</div>
                        </div>
                        @endforeach

                        <!-- <a href="" class="btn btn-danger btn-block font-weight-bold">
                            <i class="fa fa-file"></i> Download
                        </a> -->
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Join Class ?',
            text: 'if you join the class and you don`t come as long 3 times, you can`t join the class again',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }
</script>


@endsection
@endsection
