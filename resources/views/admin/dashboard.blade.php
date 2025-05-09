@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <small>Hello, {{ Auth::user()->nama }}</small>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row">
                    <div class="col-md-4">
                        @if (!$bkpk)
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-pie-chart text-danger"></i> Total Peminatan
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="chart">
                                        <canvas id="memberChart" height="520px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else
                        <img src="{{ asset('dist/img/bkpk-logo.png') }}" class="img-fluid bg-dark rounded" alt="">
                        @endif
                    </div>
                    <div class="col-md-8">
                        <div class="card border border-dark">
                            @if (Auth::user()->uker_id != '121103')
                            <div class="card-header border-dark">
                                <div class="row text-sm">
                                    <div class="col-md-8 col-12">
                                        <i class="fas fa-users"></i> Total Member : <b>{{ $totalMember->count() }}</b> <br>
                                        <i class="fas fa-user-check text-success"></i> Total Member Aktif : <b>{{ $totalMember->where('status', 'true')->count() }}</b> &emsp;
                                        <i class="fas fa-user-times text-danger"></i> Total Member Tidak Aktif : <b>{{ $totalMember->where('status', 'false')->count() }}</b>
                                    </div>
                                    <!-- <div class="col-md-4 col-12 text-right mt-2">
                                        <i class="fas fa-face-smile text-success border-dark"></i> Puas : <b>{{ $totalKepuasan->where('kepuasan', 'puas')->count() }}</b>
                                        <i class="fas fa-face-frown ml-2 text-danger border-dark"></i> Tidak Puas : <b>{{ $totalKepuasan->where('kepuasan', 'tidak puas')->count() }}</b>
                                    </div> -->
                                </div>
                            </div>
                            @endif
                            <div class="card-body">
                                <div class="table-responsive">
                                    <i class="fas fa-table"></i> Total Peminatan (Unit Utama)
                                    <table id="table-sort-1" class="table table-bordered text-sm mt-2">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Unit Utama</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($totalUtama as $row)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                    <a href="{{ route('member.searchBy', ['var' => 'utama', 'id' => $row->id_unit_utama]) }}">
                                                        <i class="fas fa-eye mx-1"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $row->nama_unit_utama }}</td>
                                                <td class="text-center">{{ $row->total_member }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @if (!$bkpk)
                            <div class="card-body">
                                <div class="table-responsive">
                                    <i class="fas fa-table"></i> Total Peminatan (Kelas)
                                    <table id="table-sort-2" class="table table-bordered text-sm mt-2">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Unit Utama</th>
                                                <th>Jumlah</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($totalKelas as $row)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                    <a href="{{ route('kelas.detail', $row->id_kelas) }}">
                                                        <i class="fas fa-eye mx-1"></i>
                                                    </a>
                                                </td>
                                                <td>{{ $row->nama_kelas }}</td>
                                                <td class="text-center">{{ $row->total_member }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <i class="fas fa-table"></i> Total Peminatan (Status Kepegawaian)
                                    <table id="table-sort-3" class="table table-bordered text-sm mt-2">
                                        <thead>
                                            <tr class="text-center">
                                                <th>No</th>
                                                <th>Unit Utama</th>
                                                <th>Total Peserta</th>
                                                <th>Total PNS</th>
                                                <th>Total PPNPN</th>
                                                <th>Total Lainnya</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($totalStatus as $row)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>{{ strtoupper($row->instansi) }}</td>
                                                <td class="text-center">{{ $row->total_member }}</td>
                                                <td class="text-center">{{ $row->instansi == 'pusat' ? $row->total_pns : '-' }}</td>
                                                <td class="text-center">{{ $row->instansi == 'pusat' ? $row->total_ppnpn : '-' }}</td>
                                                <td class="text-center">{{ $row->instansi == 'pusat' ? $row->total_member - $row->total_pns - $row->total_ppnpn : '-' }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

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
                        fontColor: '#000',
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
