@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="row mb-2">
                    <div class="col-12 text-left mt-1">
                        <div class="section-title">
                            <h4 class="text-main mb-3"><u>BODY COMPOSITION</u></h4>
                            <label class="text-justify text-white small">
                                Body composition (komposisi tubuh) mengacu pada proporsi antara lemak, otot, tulang, dan cairan
                                dalam tubuh. Data body composition dibawah ini didapatkan dari hasil pengecekan yang telah dilakukan
                                pada mesin Tanita di Kemenkes Bootcamp & Fitness Center. <br>

                                <div class="row mt-4">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-5 col-5">1. Height</div>
                                            <div class="col-md-7 col-7">: Tinggi Badan</div>

                                            <div class="col-md-5 col-5">2. Clothes</div>
                                            <div class="col-md-7 col-7">: Berat Baju</div>

                                            <div class="col-md-5 col-5">3. Weight</div>
                                            <div class="col-md-7 col-7">: Berat Badan</div>

                                            <div class="col-md-5 col-5">4. Height</div>
                                            <div class="col-md-7 col-7">: Persentase Lemak</div>

                                            <div class="col-md-5 col-5">5. Fat Mass</div>
                                            <div class="col-md-7 col-7">: Masa Lemak</div>

                                            <div class="col-md-5 col-5">6. Muscle Mass</div>
                                            <div class="col-md-7 col-7">: Masa Otot</div>

                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="row">
                                            <div class="col-md-5 col-5">7. FFM (Fat Free-Mass)</div>
                                            <div class="col-md-7 col-7">: Komponen tubuh selain lemak</div>

                                            <div class="col-md-5 col-5">8. TBW (Total Body Water)</div>
                                            <div class="col-md-7 col-7">: Total cairan dalam tubuh</div>

                                            <div class="col-md-5 col-5">9. Bone Mass</div>
                                            <div class="col-md-7 col-7">: Berat Masa Tulang</div>

                                            <div class="col-md-5 col-5">10. BMR (Basal Metabolic Rate)</div>
                                            <div class="col-md-7 col-7">: Jumlah energi yang dibutuhkan</div>

                                            <div class="col-md-5 col-5">11. Metabolic Age</div>
                                            <div class="col-md-7 col-7">: Usia metabolisme tubuh</div>

                                            <div class="col-md-5 col-5">12. Visceral Fat Rating</div>
                                            <div class="col-md-7 col-7">: Jumlah lemak di organ dalam perut</div>
                                        </div>
                                    </div>
                                </div>
                            </label>
                        </div>
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
                    <div class="section-title mb-2"><span>Progress</span></div>
                    <div class="table-responsive">
                        <table class="table table-bordered text-white text-center small">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>DATE</th>
                                    <th>HEIGHT</th>
                                    <th>CLOTHES</th>
                                    <th>WEIGHT</th>
                                    <th>FAT</th>
                                    <th>FAT&nbsp;MASS</th>
                                    <th>FFM</th>
                                    <th>MUSCLE&nbsp;MASS</th>
                                    <th>TBW</th>
                                    <th>BONE&nbsp;MASS</th>
                                    <th>BMR</th>
                                    <th>METABOLIC&nbsp;AGE</th>
                                    <th>VISCERAL&nbsp;FAT&nbsp;RATING</th>
                                    <th>BMI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bodyCp as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">
                                        {{ Carbon\Carbon::createFromFormat('d/m/Y H:i', $row->tanggal_cek)->isoFormat('HH:mm DD MMM Y') }}
                                    </td>
                                    <td>{{ $row->height }} cm</td>
                                    <td>{{ $row->clothes }} kg</td>
                                    <td>{{ $row->weight }} kg</td>
                                    <td>{{ $row->fatp }} %</td>
                                    <td>{{ $row->fatm }} kg</td>
                                    <td>{{ $row->ffm }} kg</td>
                                    <td>{{ $row->pmm }} kg</td>
                                    <td>{{ $row->tbw }} kg</td>
                                    <td>{{ $row->bonem }} kg</td>
                                    <td>{{ $row->bmr }} kJ</td>
                                    <td>{{ $row->metaage }} tahun</td>
                                    <td>{{ $row->vfatl }}</td>
                                    <td>{{ $row->bmi }}</td>
                                </tr>
                                @endforeach

                                <!-- Hasil Selisih -->
                                @if ($bodyCp->count() != 0)
                                <tr>
                                    @php
                                    $first = $bodyCp->first();
                                    $last = $bodyCp->last();
                                    @endphp
                                    <td colspan="2"></td>
                                    <td>{{ ($first->height - $last->height) < 0 ? '+' : '-' }} {{ abs($first->height - $last->height) }} cm</td>
                                    <td></td>
                                    <td>{{ ($first->weight - $last->weight) < 0 ? '+' : '-' }} {{ abs($first->weight - $last->weight) }} kg</td>
                                    <td>{{ ($first->fatp - $last->fatp) < 0 ? '+' : '-' }} {{ abs($first->fatp - $last->fatp) }} %</td>
                                    <td>{{ ($first->fatm - $last->fatm) < 0 ? '+' : '-' }} {{ abs($first->fatm - $last->fatm) }} kg</td>
                                    <td>{{ ($first->ffm - $last->ffm) < 0 ? '+' : '-' }} {{ number_format(abs($last->ffm - $first->ffm), 1) }} kg</td>
                                    <td>{{ ($first->pmm - $last->pmm) < 0 ? '+' : '-' }} {{ number_format(abs($last->pmm - $first->pmm), 1) }} kg</td>
                                    <td>{{ ($first->tbw - $last->tbw) < 0 ? '+' : '-' }} {{ abs($first->tbw - $last->tbw) }} kg</td>
                                    <td>{{ ($first->bonem - $last->bonem) < 0 ? '+' : '-' }} {{ abs($first->bonem - $last->bonem) }} kg</td>
                                    <td>{{ ($first->bmr - $last->bmr) < 0 ? '+' : '-' }} {{ abs($first->bmr - $last->bmr) }} kJ</td>
                                    <td>{{ ($first->metaage - $last->metaage) < 0 ? '+' : '-' }} {{ abs($first->metaage - $last->metaage) }} tahun</td>
                                    <td>{{ ($first->vfatl - $last->vfatl) < 0 ? '+' : '-' }} {{ abs($first->vfatl - $last->vfatl) }}</td>
                                    <td>{{ ($first->bmi - $last->bmi) < 0 ? '+' : '-' }} {{ abs($first->bmi - $last->bmi) }}</td>
                                </tr>
                                @endif

                                @if (!$bodyCp->count())
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
                                @if ($bodyCp->count() == 0)
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
    var dayUrl = "{{ route('bodycp.chart') }}";
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
