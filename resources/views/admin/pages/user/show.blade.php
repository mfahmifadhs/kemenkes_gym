@extends('admin.layout.app')

@section('content')

@if (Session::has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: '{{ Session::get("success") }}',
    });
</script>
@endif


<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-lg">Pengguna</h1>
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Pengguna</li>
                    </ol>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('user.create') }}" class="btn btn-default border-dark">
                        <i class="fas fa-circle-plus"></i> Create
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <label class="card-title"><i class="fas fa-users"></i> Tabel Pengguna</label>
                </div>
                <div class="card-header">
                    <div class="table-responsive">
                        <table id="table" class="table table-bordered text-center">
                            <thead class="text-sm">
                                <tr>
                                    <th>No</th>
                                    <th>Aksi</th>
                                    <th>Instansi</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Password</th>
                                    <th>Role</th>
                                    <th>Aktivasi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm">
                                @foreach($user as $row)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>
                                        <a href="{{ route('member.detail', $row->id) }}">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('member.edit', $row->id) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    </td>
                                    <td class="text-left">
                                        {{ $row->uker ? $row->uker->nama_unit_kerja : $row->nama_instansi }}
                                    </td>
                                    <td class="text-left">{{ $row->nama }}</td>
                                    <td>{{ $row->username }}</td>
                                    <td>{{ $row->password_teks }}</td>
                                    <td>{{ $row->role->role }}</td>
                                    <td>{{ $row->isVerify == 'true' ? '✅' : '❌' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div><br>
</div>

@endsection
