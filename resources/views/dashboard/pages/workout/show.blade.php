@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2">
                    <div class="col-7 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>MY WORKOUT</u></h4>
                        </div>
                    </div>
                    <!-- <div class="col-5 text-right mt-2">
                        <a href="{{ route('bodyck.create') }}" class="btn btn-primary p-2">
                            <small><i class="fa fa-heartbeat"></i> Create Progress</small>
                        </a>
                    </div> -->
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
                    <div class="schedule">
                        <div class="section-title mb-2"><span>Body Composition Result</span></div>
                        @foreach ($kelas as $i => $row)
                        <div class="card my-2">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 col-9">
                                        <div class="input-group">
                                            <img src="{{ asset('dist/img/class/'. $row->jadwal->kelas->img_icon) }}" width="58">
                                            <h6 class="ml-2 mt-1">
                                                {{ $row->jadwal->kelas->nama_kelas }} <br>
                                                <small>{{ \Carbon\Carbon::parse($row->tanggal_kelas)->isoFormat('DD MMMM Y') }} |
                                                    {{ \Carbon\Carbon::parse($row->jadwal->waktu_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($row->jadwal->waktu_selesai)->format('H:i') }}
                                                </small> <br>
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-4 col-3 text-center mt-2">
                                        <h6>
                                            @if ($row->kehadiran == 'true')
                                            <i class="fa fa-check-circle fa-3x text-success"></i>
                                            @else
                                            <i class="fa fa-times-circle fa-3x text-danger"></i>
                                            @endif
                                        </h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($i == 0)
                        <hr class="divider">
                        @endif
                        @endforeach
                        @if ($kelas->count() == 0)
                        <div class="text-white" style="height: 100px;">
                            <p>Data not available</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>
<!-- ChoseUs Section End -->

@section('js')
<script>
    // Ambil data dari controller
    var dayUrl = "{{ route('progres.chart') }}";
    var Title = [];
    var Weight = [];
    var FatMass = [];
    var MuscleMass = [];

    $(document).ready(function() {
        $.get(dayUrl, function(result) {
            var i = 1;
            // Iterasi melalui setiap elemen dalam array result
            for (var key in result) {
                if (result.hasOwnProperty(key)) {
                    var data = result[key];
                    Title.push('Result ' + (i++));
                    Weight.push(data.weight);
                    FatMass.push(data.fat_mass);
                    MuscleMass.push(data.muscle_mass);
                }
            }


            // Inisialisasi grafik menggunakan Chart.js
            var lineChartCanvas = $('#progressChart').get(0).getContext('2d');
            var lineChartData = {
                labels: Title,
                datasets: [{
                    label: 'Weight',
                    borderColor: 'rgb(255, 0, 0)',
                    borderWidth: 1,
                    fill: false,
                    data: Weight
                }, {
                    label: 'Fat Mass',
                    borderColor: 'rgb(0, 255, 100)',
                    borderWidth: 1,
                    fill: false,
                    data: FatMass
                }, {
                    label: 'Muscle Mass',
                    borderColor: 'rgb(0, 0, 255)',
                    borderWidth: 1,
                    fill: false,
                    data: MuscleMass
                }]
            };

            var lineChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            };

            // Buat grafik menggunakan Chart.js
            new Chart(lineChartCanvas, {
                type: 'line',
                data: lineChartData,
                options: lineChartOptions
            });
        });
    });
</script>
@endsection

@endsection
