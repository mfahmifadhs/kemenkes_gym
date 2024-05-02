@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg">Absensi</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Absensi</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-users"></i> Tabel Absensi</label>
                </div>
                <div class="card-header">

                <!-- <form action="">
                    <input type="text" class="form-control" name="member_id" id="member_id">
                </form> -->
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="searchForm" action="{{ route('member.search') }}" method="GET">
                            @csrf
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="align-left">
                                    <div class="sort-container">
                                        <div class="input-group">
                                            <select name="perPage" class="form-control form-control-sm border-dark rounded" id="perPage" onchange="this.form.submit()">
                                                <option value="10" {{ request('perPage') == 10 ? 'selected' : '' }}>10</option>
                                                <option value="25" {{ request('perPage') == 25 ? 'selected' : '' }}>25</option>
                                                <option value="50" {{ request('perPage') == 50 ? 'selected' : '' }}>50</option>
                                                <option value="100" {{ request('perPage') == 100 ? 'selected' : '' }}>100</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <table class="table table-bordered small text-center">
                                <thead>
                                    <tr>
                                        <th>NO</th>
                                        <th>AKSI</th>
                                        <th>TANGGAL</th>
                                        <th>WAKTU DATANG</th>
                                        <th>NAMA LENGKAP</th>
                                        <th>UNIT KERJA/UPT/INSTANSI</th>
                                    </tr>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($absen as $row)
                                    <tr>
                                        <td>{{ $absen->firstItem() + $loop->index }}</td>
                                        <td>
                                            <a href=""><i class="fas fa-eye"></i></a>
                                            <a href="" class="mx-2"><i class="fas fa-edit"></i></a>
                                            <a href=""><i class="fas fa-trash"></i></a>
                                        </td>
                                        <td>{{ $row->tanggal }}</td>
                                        <td>{{ $row->waktu_masuk }}</td>
                                        <td>{{ $row->member->nama }}</td>
                                        <td>{{ $row->member->uker->nama_unit_kerja }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    Total: {{ number_format($absen->total(), 0, ',', '.') }}
                                    Current page: {{ $absen->count()}}

                                    <div class="mt-2">{{ $absen->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

@section('js')
<script>
    $(document).ready(function() {
        // Handle click event on clear button
        $(".clearSearch").on("click", function() {
            var form = $(this).closest('form');
            var inputField = form.find('input[type="search"]');
            console.log(inputField)
            inputField.val('');
            form.submit();
        });
    });
</script>
<!--
<script>
    // Menggunakan event DOMContentLoaded untuk memastikan semua elemen telah dimuat
    document.addEventListener('DOMContentLoaded', function() {
        // Dapatkan elemen input
        var memberInput = document.getElementById('member_id');

        // Fokuskan pada elemen input
        memberInput.focus();
    });
</script> -->
@endsection
@endsection
