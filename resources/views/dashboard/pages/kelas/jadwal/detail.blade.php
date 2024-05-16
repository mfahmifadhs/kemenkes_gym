@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-12 mx-auto">
                <div class="row mt-5">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>{{ $jadwal->kelas->nama_kelas }}</u></h4>
                        </div>
                    </div>
                    <div class="col-6 text-right mt-1">
                        <a href="{{ route('kelas.detail', $jadwal->kelas_id) }}" class="btn btn-primary">
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
                @elseif ($message = Session::get('failed'))
                <div id="alert" class="alert bg-danger">
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

                <div class="section-body">
                    <div class="information text-justify">
                        <div class="section-title mb-0 mt-0"><span>Jadwal Latihan</span></div>
                        <p>
                            {{ $jadwal->tanggal_kelas }}
                            {{ \Carbon\Carbon::parse($jadwal->waktu_mulai)->format('H:i') }} WIB -
                            {{ \Carbon\Carbon::parse($jadwal->waktu_selesai)->format('H:i') }} WIB
                        </p>
                    </div>
                    <form id="form" action="{{ route('kelas.attendance', $jadwal->id_jadwal) }}" method="GET">
                        @csrf
                        <div class="schedule my-5">
                            <div class="section-title">
                                <h6 class="float-left mb-2 text-main">Peserta Latihan</h6>
                                <h6 class="float-right mb-2 text-main">Total Peserta : {{ $jadwal->peserta->count() }}</h6>
                            </div>
                            <table class="table text-white">
                                @foreach($jadwal->peserta as $i => $row)
                                <tr onclick="toggleCheckbox(this)">
                                    <td style="width: 5%;" class="text-center align-middle">{{ $loop->iteration }}</td>
                                    <td style="width: 5%;" class="text-center align-middle">
                                        @if ($row->kehadiran == 'true')
                                        <i class="fa fa-check-square text-success" style="scale: 1.7;"></i>
                                        @else
                                        <input type="hidden" name="peserta[]" value="{{ $row->id_peserta }}">
                                        <input type="hidden" value="false" name="kehadiran[]">
                                        <input type="checkbox" class="confirm-check mt-2" style="scale: 2;" name="kehadiran[]" value="true" onclick="updateCheckbox(this)">
                                        @endif
                                    </td>
                                    <td class="small">
                                        {{ $row->member->nama }} <br>
                                        {{ ucwords($row->member->uker->nama_unit_kerja) }}
                                    </td>
                                </tr>
                                @endforeach
                            </table>

                            @if($jadwal->peserta->where('kehadiran', null)->count() != 0)
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary" onclick="confirmSubmit(event)">Submit</button>
                            </div>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    function updateCheckbox(checkbox) {
        var hiddenInput = checkbox.previousElementSibling;
        if (checkbox.checked) {
            hiddenInput.disabled = true;
        } else {
            hiddenInput.disabled = false;
        }
    }

    function toggleCheckbox(row) {
        var checkbox = row.querySelector('input[type="checkbox"]');
        checkbox.checked = !checkbox.checked;
        updateCheckbox(checkbox);
    }
</script>

<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: 'Selesai?',
            text: 'Selesai melakukan absensi',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });

    }
</script>
@endsection

@endsection
