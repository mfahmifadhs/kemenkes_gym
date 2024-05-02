@extends('dashboard.layout.app')
@section('content')

<!-- ChoseUs Section Begin -->
<section class="identity-section spad">
    <div class="container">
        <div class="row identity">
            <div class="col-md-9 mx-auto">
                <div class="section-title mb-2">
                    <h2>Hello, </h2>
                </div>

                <div class="section-body">
                    <div class="row">
                        <div class="col-md-4 col-6 mt-2">
                            <div class="card text-center">
                                <div class="card-body bg-main p-2">
                                    <h2>{{ $totalMember }}</h2>
                                    <h6>Total Member</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-6 mt-2">
                            <div class="card text-center">
                                <div class="card-body bg-main p-2">
                                    <h2>{{ $kelas->count() }}</h2>
                                    <h6>Total Kelas</h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-12 mt-2">
                            <div class="card text-center">
                                <div class="card-body bg-main p-2">
                                    <h2>{{ $jadwal->count() }}</h2>
                                    <h6>Total Jadwal Kelas Berlangsung</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="section-menu my-5">
                    <div class="section-title mb-2">
                        <span>Class</span>
                    </div>
                    <div class="container menu-group">
                        <div class="row text-center flex-nowrap">
                            @foreach ($kelas as $row)
                            <div class="col-sm-2 col-4">
                                <a href="{{ route('kelas.detail', $row->id_kelas) }}">
                                    <img src="{{ asset('dist/img/class/'. $row->img_icon) }}" class="text-primary img-circle">
                                    <h6 class="title">
                                        {{ $row->id_kelas != 10 ? $row->nama_kelas : 'LIIT' }}
                                    </h6>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <div class="section-data">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <div class="chart">
                                    <canvas id="memberChart" height="320px"></canvas>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mt-5">
                            <div class="table-responsive">
                                <h6 class="text-main my-2">{{ Carbon\Carbon::now()->isoFormat('DD MMMM Y') }}</h6>
                                <table class="table table-bordered text-main" style="font-size: 14px;">
                                    <thead class="text-center">
                                        <tr>
                                            <th>No</th>
                                            <th>Unit Kerja/UPT/Instansi</th>
                                            <th>Full Name</th>
                                            <th>Arrival Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($absen as $row)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $row->member->uker->nama_unit_kerja ?? $row->member->nama_instansi }}</td>
                                            <td>{{ $row->member->nama }}</td>
                                            <td class="text-center">{{ Carbon\Carbon::parse($row->waktu_masuk)->format('H.m') }}</td>
                                        </tr>
                                        @endforeach
                                        @if ($absen->count() == 0)
                                        <tr>
                                            <td colspan="4">Data no available</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
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
    var surveyUrl = "{{ route('member.chart') }}";
    var Survey = [];
    var SurveyTotal = [];

    $(document).ready(function() {
        $.get(surveyUrl, function(result) {
            result.forEach(function(data) {
                Survey.push(data.nama_kelas);
                SurveyTotal.push(data.total_member);
            });

            var doughnutChartCanvas = document.getElementById('memberChart').getContext('2d');
            var doughnutChartData = {
                labels: Survey,
                datasets: [{
                    data: SurveyTotal,
                    backgroundColor: ['#e91e63', '#00e676', '#ff5722', '#1e88e5', '#ffd600', '#00FFFF', '#8A2BE2', '#DC143C', '#B8860B', '#FF1493', '#ADFF2F'],
                }]
            };

            var doughnutChartOptions = {
                responsive: true,
                maintainAspectRatio: false,
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        boxWidth: 20,
                        fontColor: '#f36100',
                        padding: 15,
                        generateLabels: function(chart) {
                            var data = doughnutChartData;
                            if (data.labels.length && data.datasets.length) {
                                return data.labels.map(function(label, i) {
                                    var dataset = data.datasets[0];
                                    var currentValue = dataset.data[i];
                                    var total = '{{ $totalPeminatan }}'; // Menghilangkan tanda kutip
                                    var percentage = (currentValue / total) * 100;
                                    return {
                                        text: `${label} (${(currentValue / total * 100).toFixed(2)}%)`,
                                        fillStyle: dataset.backgroundColor[i] || '#fff',
                                        hidden: isNaN(dataset.data[i]) || dataset.data[i] === '',
                                        index: i
                                    };
                                });
                            }
                            return [];
                        }
                    },
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            return data.labels[tooltipItem.index] + ': ' + data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                        }
                    }
                },
                plugins: {
                    datalabels: {
                        color: '#111',
                        textAlign: 'center',
                        font: {
                            lineHeight: 1.6,
                            fontWeight: 'bold'
                        },
                        formatter: function(value, ctx) {
                            var dataset = ctx.chart.data.datasets[ctx.datasetIndex];
                            var total = '{{ $totalPeminatan }}'
                            var currentValue = dataset.data[ctx.dataIndex];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            // return ctx.chart.data.labels[ctx.dataIndex] + '\n' + percentage + '%';
                        }
                    }
                }
            };

            new Chart(doughnutChartCanvas, {
                type: 'pie',
                data: doughnutChartData,
                options: doughnutChartOptions
            });
        });
    });
</script>
@endsection
@endsection
