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
                            <h4 class="text-main"><u>{{ $jadwal->kelas->nama_kelas }}</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ url()->previous() }}" class="btn btn-primary">
                            <i class="fa fa-arrow-circle-left"></i> Back
                        </a>
                    </div>
                </div>

                <div class="section-body">
                    <div class="section-title mb-2"><span>Edit Schedule</span></div>
                    <div class="schedule">
                        <form id="form-daftar" action="{{ route('jadwal.update', $jadwal->id_jadwal) }}" method="POST">
                            @csrf
                            <input type="hidden" name="kelas_id" value="{{ $jadwal->kelas_id }}">
                            <div class="row">
                                <div class="form-group col-md-6 col-12">
                                    <label class="text-white small">Date*</label>
                                    <input type="date" class="form-control" name="tanggal" value="{{ $jadwal->tanggal_kelas }}" min="{{ date('Y-m-d') }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Start Time*</label>
                                    <input type="time" class="form-control" name="waktu_mulai" value="{{ $jadwal->waktu_mulai }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Finish Time*</label>
                                    <input type="time" class="form-control" name="waktu_selesai" value="{{ $jadwal->waktu_selesai }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Kuota*</label>
                                    <input type="text" class="form-control number" name="kuota" value="{{ $jadwal->kuota }}">
                                </div>
                                <div class="form-group col-md-6 col-6">
                                    <label class="text-white small">Personal Trainer Name</label>
                                    <input type="text" class="form-control" name="nama_pelatih" value="{{ $jadwal->nama_pelatih }}">
                                </div>
                            </div>
                            <button class="btn btn-primary btn-block mt-3">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@endsection
