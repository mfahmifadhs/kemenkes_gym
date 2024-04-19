@extends('app')
@section('content')

@section('css')
<style>
    .chart {
        position: relative;
        width: 100%;
        height: auto;
    }

    canvas {
        max-width: 100%;
        height: auto;
    }
</style>
@endsection

<!-- Hero Section Begin -->
<section class="hero-section">
    <div class="hs-slider owl-carousel">
        <div class="hs-item set-bg" data-setbg="{{ asset('dist/img/hero-2.jpg') }}">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="hi-text">
                            <!-- <span>Shape your body</span> -->
                            <h1>You're <strong>stronger</strong> than you think</h1>
                            <a href="{{ route('daftar') }}" class="primary-btn btn-normal">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hs-item set-bg" data-setbg="{{ asset('dist/img/hero-1.jpg') }}" style="background-color: rgba(0, 0, 0, 0.5);">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 offset-lg-6">
                        <div class="hi-text">
                            <!-- <span>Shape your body</span> -->
                            <h1>You're <strong>stronger</strong> than you think</h1>
                            <a href="{{ route('daftar') }}" class="primary-btn btn-normal">Join Now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section End -->

<!-- ChoseUs Section Begin -->
<section class="choseus-section spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Why chose us?</span>
                    <h2>PUSH YOUR LIMITS FORWARD</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-sm-6">
                <div class="cs-item">
                    <span class="flaticon-034-stationary-bike"></span>
                    <h4>WEIGHT LOSS</h4>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="cs-item">
                    <span class="flaticon-002-dumbell"></span>
                    <h4>MUSCLE MASS INCREASE</h4>
                </div>
            </div>
            <div class="col-lg-4 col-sm-6">
                <div class="cs-item">
                    <span class="flaticon-014-heart-beat"></span>
                    <h4>MAINTAINING FITNESS</h4>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ChoseUs Section End -->

<!-- Classes Section Begin -->
<section class="classes-section spad">
    <div id="class" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <span>Our Classes</span>
                    <h2>WHAT WE CAN OFFER</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="class-item">
                    <div class="ci-pic">
                        <img src="{{ asset('dist/img/class/class-1.jpg') }}" alt="">
                    </div>
                    <div class="ci-text">
                        <span>STRENGTH</span>
                        <h5>PILATES</h5>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="class-item">
                    <div class="ci-pic">
                        <img src="{{ asset('dist/img/class/class-2.jpg') }}" alt="">
                    </div>
                    <div class="ci-text">
                        <span>STRENGTH</span>
                        <h5>Body Combat</h5>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="class-item">
                    <div class="ci-pic">
                        <img src="{{ asset('dist/img/class/class-3.jpg') }}" alt="">
                    </div>
                    <div class="ci-text">
                        <span>STRENGTH</span>
                        <h5>Zumba</h5>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="class-item">
                    <div class="ci-pic">
                        <img src="{{ asset('dist/img/class/class-4.jpg') }}" alt="">
                    </div>
                    <div class="ci-text">
                        <span>Cardio</span>
                        <h4>Bootcamp</h4>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="class-item">
                    <div class="ci-pic">
                        <img src="{{ asset('dist/img/class/class-5.jpg') }}" alt="">
                    </div>
                    <div class="ci-text">
                        <span>Training</span>
                        <h4>Muaythai</h4>
                        <a href="#"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- ChoseUs Section End -->

<section class="choseus-section spad">
    <div id="choices" class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title">
                    <h2>survey result</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 col-sm-12">
                <div class="table-responsive">
                    <div class="chart">
                        <canvas id="memberChart" height="520px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Banner Section Begin -->
<section class="banner-section set-bg" data-setbg="{{ asset('dist/img/banner-bg.jpg') }}">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <div class="bs-text">
                    <h2>Are you ready !</h2>
                    <a href="{{ route('daftar') }}" class="primary-btn  btn-normal">Join Now</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Gallery Section Begin -->
<div class="gallery-section">
    <div id="gallery" class="gallery">
        <div class="grid-sizer"></div>
        <div class="gs-item grid-wide set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-1.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-1.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
        <div class="gs-item set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-2.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-2.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
        <div class="gs-item set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-3.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-3.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
        <div class="gs-item set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-4.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-4.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
        <div class="gs-item set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-5.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-5.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
        <div class="gs-item grid-wide set-bg" data-setbg="{{ asset('dist/img/gallery/gallery-6.jpg') }}">
            <a href="{{ asset('dist/img/gallery/gallery-6.jpg') }}" class="thumb-icon image-popup"><i class="fa fa-picture-o"></i></a>
        </div>
    </div>
</div>
<!-- Gallery Section End -->

<!-- Get In Touch Section Begin -->
<div class="gettouch-section">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <div class="gt-text">
                    <i class="fa fa-map-marker"></i>
                    <p>
                        P15 Gedung Sarana Penunjang <br>
                        Jl. H. R. Rasuna Said No.Kav 4-9 Blok X-5, RT.1/RW.2, Kuningan, Kecamatan Setiabudi, Kota Jakarta Selatan,<br /> 12950
                    </p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gt-text">
                    <i class="fa fa-mobile"></i>
                    <ul>
                        <li>0812-1112-1365 (Helpdesk)</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <div class="gt-text email">
                    <i class="fa fa-envelope"></i>
                    <p>kemenkesbootcamp@gmail.com</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Get In Touch Section End -->

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
                        fontColor: '#fff',
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
