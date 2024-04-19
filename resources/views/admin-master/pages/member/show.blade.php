@extends('admin-master.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Daftar Member</small></h1>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <div style="">
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
                                            <th style="width: 0%;">NO</th>
                                            <th style="width: 6%;">AKSI</th>
                                            <th style="width: 10%;">ID</th>
                                            <th style="width: 10%;">TANGGAL</th>
                                            <th style="width: 12%;">INSTANSI</th>
                                            <th style="width: 12%;">ASAL</th>
                                            <th style="width: 12%;">NAMA</th>
                                            <th style="width: 10%;">NIP/NIK</th>
                                            <th style="width: 10%;">EMAIL</th>
                                            <th style="width: 10%;">KELAS</th>
                                            <th style="width: 13%;">TARGET</th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control form-control-navbar" type="search" placeholder="Cari" name="col1" value="{{ $searchCol1 }}">
                                                    <div class="input-group-append">
                                                        <div class="btn btn-navbar border-top border-dark" type="submit">
                                                            <button type="submit" class="mx-1 btn btn-default bg-white border border-white btn-xs p-0 m-0">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <select name="col2" class="form-control form-control-sm text-xs" onchange="this.form.submit()">
                                                    <option value="" class="text-center">Seluruh Instansi</option>
                                                    @php $instansi = ['pusat','upt','umum']; @endphp
                                                    @foreach ($instansi as $key => $val)
                                                    <option value="{{ $val }}" <?php echo $searchCol2 == $val ? 'selected' : '' ?>>
                                                        {{ strtoupper($val) }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </th>
                                            <th>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control form-control-navbar" type="search" placeholder="Cari" name="searchUker" value="{{ $searchUker }}">
                                                    <div class="input-group-append">
                                                        <div class="btn btn-navbar border-top border-dark" type="submit">
                                                            <button type="submit" class="mx-1 btn btn-default bg-white border border-white btn-xs p-0 m-0">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control form-control-navbar" type="search" placeholder="Cari" name="searchNama" value="{{ $searchNama }}">
                                                    <div class="input-group-append">
                                                        <div class="btn btn-navbar border-top border-dark" type="submit">
                                                            <button type="submit" class="mx-1 btn btn-default bg-white border border-white btn-xs p-0 m-0">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control form-control-navbar" type="search" placeholder="Cari" name="searchNip" value="{{ $searchNip }}">
                                                    <div class="input-group-append">
                                                        <div class="btn btn-navbar border-top border-dark" type="submit">
                                                            <button type="submit" class="mx-1 btn btn-default bg-white border border-white btn-xs p-0 m-0">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th>
                                                <div class="input-group input-group-sm">
                                                    <input class="form-control form-control-navbar" type="search" placeholder="Cari" name="searchMail" value="{{ $searchMail }}">
                                                    <div class="input-group-append">
                                                        <div class="btn btn-navbar border-top border-dark" type="submit">
                                                            <button type="submit" class="mx-1 btn btn-default bg-white border border-white btn-xs p-0 m-0">
                                                                <i class="fas fa-search"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($member as $row)
                                        <tr>
                                            <td>{{ $member->firstItem() + $loop->index }}</td>
                                            <td>
                                                <a href=""><i class="fas fa-eye"></i></a>
                                                <a href=""><i class="fas fa-pencil mx-1"></i></a>
                                                <a href=""><i class="fas fa-trash"></i></a>
                                            </td>
                                            <td>{{ $row->member_id }}</td>
                                            <td>{{ $row->created_at }}</td>
                                            <td>{{ strtoupper($row->instansi) }}</td>
                                            <td class="text-left">{{ $row->uker ? $row->uker->nama_unit_kerja : $row->nama_instansi }}</td>
                                            <td class="text-left">{{ $row->nama }}</td>
                                            <td class="text-left">{{ $row->nip_nik }}</td>
                                            <td>{{ $row->email }}</td>
                                            <td class="text-left">
                                                @foreach($row->minatKelas as $subRow)
                                                {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->kelas->nama_kelas)) }} <br>
                                                @endforeach
                                            </td>
                                            <td class="text-left">
                                                @foreach($row->minatTarget as $subRow)
                                                {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->target->nama_target)) }} <br>
                                                @endforeach
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="row">
                                    <div class="col-md-6 col-6 text-left">
                                        Total: {{ number_format($member->total(), 0, ',', '.') }}
                                        Current page: {{ $member->count()}}
                                    </div>
                                    <div class="col-md-6 col-6 text-right">
                                        {{ $member->appends(request()->query())->links('pagination::bootstrap-4') }}
                                    </div>
                                </div>
                            </form>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
