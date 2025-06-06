<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kemenkes Bootcamp & Fitness Center</title>
    <link rel="icon" href="{{ asset('dist/img/icon-kemenkes.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/admin/css/adminlte.css') }}">
    <!-- Data Tables -->
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">

    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/select2/css/select2.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('dist/admin/plugins/select2/css/select2.min.css') }}">

    @yield('css')

</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ route('dashboard') }}" class="navbar-brand">
                    <img src="{{ asset('dist/img/logo-light.png') }}" alt="Logo" class="brand-image mt-1">
                </a>

                <div class="collapse navbar-collapse order-3" id="navbarCollapse">

                    <ul class="navbar-nav mt-1">
                        <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="nav-link">Dashboard</a>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Class</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a href="{{ route('kelas') }}" class="dropdown-item">
                                        <i class="fa fa-table"></i> List
                                    </a>
                                    @if (Auth::user()->uker->unit_utama_id != 46591)
                                    <a href="{{ route('jadwal.show') }}" class="dropdown-item">
                                        <i class="fa fa-calendar"></i> Schedule
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </li>

                        @if (Auth::user()->uker_id != '121103')
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Attendance</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a href="{{ route('absen.show') }}" class="dropdown-item">
                                        <i class="fa fa-table"></i> List
                                    </a>
                                    @if (Auth::user()->uker->unit_utama_id != 46591)
                                    <a href="{{ route('absen.report') }}" class="dropdown-item">
                                        <i class="fa fa-pie-chart"></i> Report
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="menuMembers" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Members</a>
                            <ul aria-labelledby="menuMembers" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a href="{{ route('member') }}" class="dropdown-item">
                                        <i class="fa fa-users"></i> List
                                    </a>
                                    @if (Auth::user()->uker->unit_utama_id != 46591)
                                    <a href="{{ route('penalty') }}" class="dropdown-item">
                                        <i class="fa fa-calendar-times"></i> Penalty
                                    </a>
                                    @endif
                                </li>
                            </ul>
                        </li>
                        @endif

                        @if (Auth::user()->uker->unit_utama_id != 46591)
                        <li class="nav-item dropdown">
                            <a id="menu" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Menu</a>
                            <ul aria-labelledby="menu" class="dropdown-menu border-0 shadow">
                                <li>
                                    @if (Auth::user()->uker_id != '121103')
                                    <!-- <a href="{{ route('bodyck') }}" class="dropdown-item">
                                        <i class="fa fa-weight-scale"></i> Body Composition
                                    </a> -->
                                    <a href="{{ route('challenge') }}" class="dropdown-item">
                                        <i class="fa fa-award"></i> Challenge
                                    </a>
                                    <a href="{{ route('loker.show') }}" class="dropdown-item">
                                        <i class="fa fa-th-large"></i> Loker
                                    </a>
                                    @endif
                                    <a href="{{ route('konsul') }}" class="dropdown-item">
                                        <i class="fa fa-stethoscope"></i> Konsultasi
                                    </a>
                                    <a href="{{ route('faq') }}" class="dropdown-item">
                                        <i class="fa fa-circle-question"></i> FAQ
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Profile</a>
                            <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                                <li>
                                    <a href="{{ route('member.detail', Auth::user()->id) }}" class="dropdown-item">
                                        <i class="fa fa-user-circle"></i> &nbsp; Profile
                                    </a>
                                    @if (Auth::user()->role_id == 1)
                                    <a href="{{ route('user') }}" class="dropdown-item">
                                        <i class="fa fa-users"></i> &nbsp;Pengguna
                                    </a>
                                    @endif
                                </li>
                                <li class="dropdown-divider"></li>
                                <li>
                                    <a href="{{ route('logout') }}" class="dropdown-item">
                                        <i class="fa fa-right-from-bracket"></i> Sign Out
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </div>

                <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

                    <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </ul>
            </div>
        </nav>
        <!-- /.navbar -->

        @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ Session::get("success") }}',
                timer: 5000, // Durasi popup (dalam milidetik)
                showConfirmButton: false // Tombol OK tidak ditampilkan
            });
        </script>
        @endif

        @if (Session::has('pending'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: '{{ Session::get("pending") }}',
            });
        </script>
        @endif

        @if (Session::has('failed'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'error',
                text: '{{ Session::get("failed") }}',
                timer: 2000, // Durasi popup (dalam milidetik)
                showConfirmButton: false // Tombol OK tidak ditampilkan
            });
        </script>
        @endif

        @if (Session::has('confirm'))
        <script>
            Swal.fire({
                icon: "success",
                title: '{{ Session::get("confirm") }}',
                showConfirmButton: false,
                timer: 1500
            });
        </script>
        @endif

        @yield('content')

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="float-right d-none d-sm-inline">
                Version 1.0
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; 2024 <a href="#">Biro Umum</a>.</strong>
        </footer>
    </div>
    <!-- ./wrapper -->

    <script src="{{ asset('dist/admin/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('dist/admin/js/adminlte.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/pdfmake/pdfmake.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('dist/js/sweetalert2.all.min.js') }}"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script> -->


    <!-- DataTables  & Plugins -->
    <script src="{{ asset('dist/admin/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/pdfmake/pdfmake.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('dist/admin/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <script src="{{ asset('dist/admin/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chartjs-plugin-datalabels/0.7.0/chartjs-plugin-datalabels.min.js"></script>

    @yield('js')

    <!-- table -->
    <script>
        $(function() {
            var currentdate = new Date();
            var datetime = "Tanggal: " + currentdate.getDate() + "/" +
                (currentdate.getMonth() + 1) + "/" +
                currentdate.getFullYear() + " \n Pukul: " +
                currentdate.getHours() + ":" +
                currentdate.getMinutes() + ":" +
                currentdate.getSeconds()

            $("#table").DataTable({
                "responsive": false,
                "lengthChange": true,
                "autoWidth": false,
                "info": true,
                "paging": true,
                "searching": true,
                buttons: [{
                    extend: 'pdf',
                    text: ' Print PDF',
                    pageSize: 'A4',
                    className: 'bg-danger',
                    title: 'Kehadiran',
                    exportOptions: {
                        columns: [2, 3]
                    },
                }],
                "bDestroy": true
            }).buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');

            $("#table-sort-1").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "info": false,
                "paging": false,
                "searching": false,

                buttons: [{
                        extend: 'pdf',
                        text: ' Pdf',
                        pageSize: 'A4',
                        className: 'bg-danger',
                        title: 'Report'
                    },
                    {
                        extend: 'excel',
                        text: ' Excel',
                        className: 'bg-success',
                        title: 'Report'
                    }
                ],
                "bDestroy": true
            }).buttons().container().appendTo('#table-sort-1_wrapper .col-md-6:eq(0)');

            $("#table-sort-2").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "info": false,
                "paging": false,
                "searching": false,

                buttons: [{
                        extend: 'pdf',
                        text: ' Pdf',
                        pageSize: 'A4',
                        className: 'bg-danger',
                        title: 'Report'
                    },
                    {
                        extend: 'excel',
                        text: ' Excel',
                        className: 'bg-success',
                        title: 'Report'
                    }
                ],
                "bDestroy": true
            }).buttons().container().appendTo('#table-sort-2_wrapper .col-md-6:eq(0)');

            $("#table-sort-3").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "info": false,
                "paging": true,
                "searching": false,

                buttons: [{
                        extend: 'pdf',
                        text: ' Pdf',
                        pageSize: 'A4',
                        className: 'bg-danger',
                        title: 'Report'
                    },
                    {
                        extend: 'excel',
                        text: ' Excel',
                        className: 'bg-success',
                        title: 'Report'
                    }
                ],
                "bDestroy": true
            }).buttons().container().appendTo('#table-sort-3_wrapper .col-md-6:eq(0)');
        })

        $(document).ready(function() {
            $('.number').on('input', function() {
                // Menghapus karakter selain angka dan simbol /
                var value = $(this).val().replace(/[^0-9\/]/g, '');

                // Memastikan hanya ada satu simbol / di input
                if ((value.match(/\//g) || []).length > 1) {
                    value = value.substring(0, value.lastIndexOf("/"));
                }

                // Mengembalikan nilai yang telah difilter ke input field
                $(this).val(value);
            });
        });

        // Waktu live
        $(function() {
            setInterval(timestamp, 1000);
        });

        function timestamp() {
            $.ajax({
                url: "{{ route('dashboard.time') }}",
                success: function(response) {
                    $('#timestamp').html(response);
                },
            });
        }
    </script>

    <script>
        function confirmLink(event, url) {
            event.preventDefault(); // Prevent the default link behavior
            Swal.fire({
                title: 'Proses',
                text: '',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya!',
                cancelButtonText: 'Batal!',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Proses...',
                        text: 'Mohon menunggu.',
                        icon: 'info',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    window.location.href = url;
                }
            });
        }
    </script>
</body>

</html>
