@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>{{ $kelas->nama_kelas }}</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="section-body">
                    <div class="section-title mb-2"><span>Create Schedule</span></div>
                    <div class="schedule">
                        <form id="form-daftar" action="{{ route('jadwal.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $kelas->id_kelas }}">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label class="text-white small">Date*</label>
                                    <input type="date" class="form-control" name="tanggal" required>
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Kuota*</label>
                                    <input type="text" class="form-control number" name="kuota">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Start Time*</label>
                                    <input type="time" class="form-control" name="waktu_mulai">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Finish Time*</label>
                                    <input type="time" class="form-control" name="waktu_selesai">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Personal Trainer Name</label>
                                    <input type="text" class="form-control" name="nama_pelatih">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Location</label>
                                    <input type="text" class="form-control" name="lokasi" value="Kemenkes Bootcamp & Fitness Center">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block mt-3">Create</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
