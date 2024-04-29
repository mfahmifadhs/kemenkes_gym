@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-5">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"> Ubah Informasi Kelas</small></h1>
                </div>
                <div class="col-sm-6 text-right">
                    <a href="{{ route('kelas') }}" class="btn btn-default border-dark">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-5">
            <div class="card">
                <form id="form" action="{{ route('kelas.update', $kelas->id_kelas) }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Nama Kelas</label>
                            <div class="col-md-8">
                                <input type="text" class="form-control" name="nama_kelas" value="{{ $kelas->nama_kelas }}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4 col-form-label">Deskripsi</label>
                            <div class="col-md-8">
                                <textarea name="deskripsi" class="form-control" rows="5">{{ $kelas->deskripsi }}</textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-4">Status</label>
                            <div class="col-md-8">
                                <input id="true" type="radio" name="status" value="true" <?php echo $kelas->status == 'true' ? 'checked' : ''; ?>>
                                <label for="true" class="font-weight-light mr-2">Aktif</label>

                                <input id="false" type="radio" name="status" value="false" <?php echo $kelas->status == 'false' ? 'checked' : '';?>>
                                <label for="false" class="font-weight-light">Tidak Aktif</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-success btn-sm" onclick="confirmSubmit(event)">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                    </div>
                </form>
            </div> <br>
        </div>
    </div>
</div>

@section('js')

<script>
    function confirmSubmit(event) {
        event.preventDefault();

        const form = document.getElementById('form');

        Swal.fire({
            title: "Menyimpan...",
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            willOpen: () => {
                Swal.showLoading();
            },
        })

        form.submit();

    }
</script>
@endsection
@endsection
