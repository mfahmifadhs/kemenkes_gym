@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg">Member</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Member</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-users"></i> Tabel Member</label>
                    <div class="card-tools">
                        <a id="downloadButton" onclick="downloadFile('pdf')" class="btn btn-csv bg-danger border-danger" target="__blank">
                            <span class="btn btn-danger btn-sm"><i class="fas fa-print"></i></span>
                            <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                            <small>PRINT</small>
                        </a>
                        <a id="downloadButton" onclick="downloadFile('excel')" class="btn btn-csv bg-success border-success" target="__blank">
                            <span class="btn btn-success btn-sm"><i class="fas fa-download"></i></span>
                            <span id="downloadSpinner" class="spinner-border spinner-border-sm" style="display: none;" role="status" aria-hidden="true"></span>
                            <small>XLSX</small>
                        </a>
                    </div>
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
                                            <select style="width: 18vh;" name="searchInst" class="form-control form-control-sm text-xs" onchange="this.form.submit()">
                                                <option value="" class="text-center">Seluruh Instansi</option>
                                                @php $instansi = ['pusat','upt','umum']; @endphp
                                                @foreach ($instansi as $key => $val)
                                                <option value="{{ $val }}" <?php echo $searchInst == $val ? 'selected' : '' ?>>
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
                                            @if (Auth::user()->role_id == 1)
                                            <a href="{{ route('member.detail', $row->id) }}"><i class="fas fa-eye"></i></a>
                                            <a href="{{ route('member.edit', $row->id) }}"><i class="fas fa-pencil mx-1"></i></a>
                                            <a href="{{ route('member.delete', $row->id) }}"><i class="fas fa-trash"></i></a>
                                            @endif
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
                                            {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->kelas?->nama_kelas)) }} <br>
                                            @endforeach
                                        </td>
                                        <td class="text-left">
                                            @foreach($row->minatTarget as $subRow)
                                            {{ $loop->iteration }}. {{ ucwords(strtolower($subRow->target?->nama_target)) }} <br>
                                            @endforeach
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="row">
                                <div class="col-md-12 col-12">
                                    Total: {{ number_format($member->total(), 0, ',', '.') }}
                                    Current page: {{ $member->count()}}

                                    <div class="mt-2">{{ $member->appends(request()->query())->links('pagination::bootstrap-4') }}</div>
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

    function downloadFile(downloadFile) {
        var form = document.getElementById('searchForm');
        var downloadButton = document.getElementById('downloadButton');
        var downloadSpinner = document.getElementById('downloadSpinner');

        downloadSpinner.style.display = 'inline-block';

        var existingDownloadFile = form.querySelector('[name="downloadFile"]');
        if (existingDownloadFile) {
            existingDownloadFile.remove();
        }

        var downloadFileInput = document.createElement('input');
        downloadFileInput.type = 'hidden';
        downloadFileInput.name = 'downloadFile';
        downloadFileInput.value = downloadFile;
        form.appendChild(downloadFileInput);

        downloadButton.disabled = true;
        form.target = '_blank';

        form.submit();
        location.reload();
    }
</script>
@endsection
@endsection
