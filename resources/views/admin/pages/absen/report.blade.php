@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mx-auto">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">
                            <small>Laporan Kehadiran</small>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12 col-12 mx-auto">
                <div class="row">
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
                                            <h6>{{ ucwords(strtolower($row->nama)) }} <br>
                                                <small>{{ Str::limit($row->nama_unit_kerja, 40) }}</small>
                                            </h6>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <i class="fas fa-calendar-alt"></i> Total Kehadiran : {{ $total }}
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-report" class="table table-striped small text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Tanggal</th>
                                                <th>Total Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <!-- Data akan ditambahkan di sini oleh JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <i class="fas fa-table"></i> Laporan Kehadiran Unit Utama

                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-sort-1" class="table table-striped small text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Unit Utama</th>
                                                <th>Total Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reportUtama as $row)
                                            <tr class="bg-white">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->nama_unit_utama }}</td>
                                                <td>{{ $row->total }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-7">
                        <i class="fas fa-table"></i> Laporan Kehadiran Unit Kerja

                        <div class="card mt-2">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="table-sort-2" class="table table-striped small text-center">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Unit Kerja</th>
                                                <th>Total Kehadiran</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($reportUker as $row)
                                            <tr class="bg-white">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $row->nama_unit_kerja }}</td>
                                                <td>{{ $row->total }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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

        $.get(surveyUrl, function(result) {
            if (result.length > 0) {
                // Konversi string tanggal ke objek Date untuk pengurutan yang akurat
                result.forEach(function(data) {
                    data.tanggal = new Date(data.tanggal);
                });

                // Urutkan data berdasarkan tanggal dalam urutan menurun (descending)
                result.sort(function(a, b) {
                    return b.tanggal - a.tanggal;
                });

                // Tambahkan data ke tabel
                var tbody = $('#table-body');
                result.forEach(function(data, index) {
                    let formattedDate = data.tanggal.toISOString().split('T')[0]; // Format tanggal sebagai YYYY-MM-DD
                    let row = `<tr class="bg-white">
                    <td>${index + 1}</td>
                    <td>${formattedDate}</td>
                    <td>${data.total_absen}</td>
                </tr>`;
                    tbody.append(row);
                });

                // Inisialisasi DataTables setelah data ditambahkan
                $("#table-report").DataTable({
                    "responsive": false,
                    "lengthChange": true,
                    "autoWidth": true,
                    "info": true,
                    "paging": true,
                    "searching": false,
                    buttons: [{
                        extend: 'pdf',
                        text: ' Print PDF',
                        pageSize: 'A4',
                        className: 'bg-danger',
                        title: 'Kehadiran',
                        exportOptions: {
                            columns: [0, 1, 2]
                        },
                    }],
                    "bDestroy": true,
                }).buttons().container().appendTo('#table-report_wrapper .col-md-6:eq(0)');
            } else {
                // Jika tidak ada data, tambahkan pesan ke tbody
                $('#table-body').html('<tr><td colspan="3">No data available in table</td></tr>');
            }
        });
    });
</script>
@endsection

@endsection
