@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-9 col-12 mx-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <small>Attendance Report</small>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-calendar-alt"></i> Total Kehadiran
                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <div class="chart">
                                        <canvas id="memberChart" height="200px"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <i class="fas fa-fire"></i> Top Member Active 2024
                        <div class="row">
                            @foreach ($listTopMember as $row)
                            <div class="col-md-3 mt-2">
                                <div class="info-box">
                                    <span class="info-box-icon bg-info elevation-1">
                                        <h2 class="font-weight-bold mt-2">{{ $loop->iteration }}</h2>
                                    </span>
                                    <div class="info-box-content">
                                        <span class="info-box-text small">
                                            {{ $row->nama }} <br>
                                            {{ $row->nama_unit_kerja }}
                                        </span>
                                        <span class="info-box-number">
                                            {{ $row->total_absen }} <small class="text-xs">kehadiran</small>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('js')
<script>
    var surveyUrl = "{{ route('absen.chart') }}";
    var Survey = [];
    var SurveyTotal = [];

    $(document).ready(function() {
        $.get(surveyUrl, function(result) {
            result.forEach(function(data) {
                Survey.push(data.tanggal);
                SurveyTotal.push(data.total_absen);
            });

            var doughnutChartCanvas = document.getElementById('memberChart').getContext('2d');
            var doughnutChartData = {
                labels: Survey,
                datasets: [{
                    data: SurveyTotal,
                    borderColor: 'rgb(0, 0, 255)',
                    fill: false,
                    borderWidth: 1,
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
                        fontColor: '#fff',
                        padding: 15,
                        generateLabels: function(chart) {
                            var data = doughnutChartData;
                            return [];
                        }
                    },
                },
                plugins: {
                    datalabels: {
                        color: '#111',
                        textAlign: 'center',
                        font: {
                            lineHeight: 1.6,
                            fontWeight: 'bold'
                        }
                    }
                }
            };

            new Chart(doughnutChartCanvas, {
                type: 'line',
                data: doughnutChartData,
                options: doughnutChartOptions
            });
        });
    });
</script>
@endsection

@endsection
