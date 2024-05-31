@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2">
                    <div class="col-6 text-left">
                        <div class="section-title">
                            <h4 class="text-main"><u>MY PROGRESS</u></h4>
                        </div>
                    </div>
                </div>

                <div class="section-body">
                    <div class="table-responsive">
                        <table class="table table-bordered text-white text-center">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>DATE</th>
                                    <th>WEIGHT</th>
                                    <th>FAT</th>
                                    <th>FAT&nbsp;MASS</th>
                                    <th>FFM</th>
                                    <th>MUSCLE&nbsp;MASS</th>
                                    <th>TBW</th>
                                    <th>TBW&nbsp;%</th>
                                    <th>BONE&nbsp;MASS</th>
                                    <th>BMR</th>
                                    <th>METABOLIC&nbsp;AGE</th>
                                    <th>VISCERAL&nbsp;FAT&nbsp;RATING</th>
                                    <th>BMI</th>
                                    <th>IDEAL&nbsp;BODY&nbsp;WEIGHT</th>
                                    <th>DEGREE&nbsp;OF&nbsp;OBESITY</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($bodyck->count() != 0)
                                @foreach($bodyck as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ Carbon\Carbon::parse($row->tanggal_cek)->format('d-m-Y H:m') }}</td>
                                    @foreach ($row->detail as $i => $subRow)
                                    @php $idLoop = $i+1; @endphp
                                    <td>
                                        @if ($subRow->param_id == $idLoop)
                                        {{ $subRow->nilai.$subRow->param->satuan }}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2"></td>
                                    @foreach ($row->detail as $i => $subRow)
                                    @php $idLoop = $i+1; @endphp
                                    <td>
                                        @if ($subRow->param_id == $idLoop)
                                        @php
                                        $hasil_pertama = $bodyck->first()->detail()->where('param_id', $subRow->param_id)->first()->nilai;
                                        $hasil_akhir = $row->detail()->orderBy('id_detail', 'DESC')->where('param_id', $subRow->param_id)->first()->nilai;
                                        @endphp
                                        @if ($hasil_akhir > $hasil_pertama) + @else - @endif
                                        {{ abs($hasil_pertama - $hasil_akhir). $subRow->param->satuan }}
                                        @endif
                                    </td>
                                    @endforeach
                                </tr>
                                @else
                                <tr>
                                    <td colspan="16">data not available</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="section-chart my-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                @if ($bodyck->count() == 0)
                                data not available
                                @endif
                                <div class="chart">
                                    <canvas id="progressChart" style="height: 320px;"></canvas>

                                </div>
                            </div>
                        </div>
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
            // Iterasi melalui setiap elemen dalam array result
            for (var key in result) {
                if (result.hasOwnProperty(key)) {
                    var data = result[key];
                    Title.push('Check ' + data.bodyck_id);
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
