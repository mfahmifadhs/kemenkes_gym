@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Daftar Kelas</small></h1>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <form id="searchForm" action="{{ route('member.search') }}" method="GET">
                            @csrf
                            <table class="table table-bordered small text-center">
                                <thead>
                                    <tr>
                                        <th style="width: 0%;">NO</th>
                                        <th style="width: 10%;">AKSI</th>
                                        <th>NAMA KELAS</th>
                                        <th style="width: 15%;">TOTAL KELAS</th>
                                        <th style="width: 15%;">TOTAL KELAS AKTIF</th>
                                        <th>DESKRIPSI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($kelas as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}

                                            @if ($row->status == 'true')  <i class="fas fa-circle-check text-success"></i> @endif
                                            @if ($row->status == 'false') <i class="fas fa-times-circle text-danger"></i> @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('kelas.detail', $row->id_kelas) }}"><i class="fas fa-eye mx-1"></i></a>
                                            @if (Auth::user()->role_id == 1)
                                            <a href="{{ route('kelas.edit', $row->id_kelas) }}"><i class="fas fa-pencil mx-1"></i></a>
                                            @endif
                                        </td>
                                        <td class="text-left">{{ $row->nama_kelas }}</td>
                                        <td>{{ $row->jadwal->count() }}</td>
                                        <td>{{ $row->jadwal->where('tanggal_kelas', '>', \Carbon\Carbon::now())->count() }}</td>
                                        <td class="text-left">
                                            <div style="width: 10%;">{{ $row->deskripsi }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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
@endsection
@endsection
