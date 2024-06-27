@extends('admin.layout.app')
@section('content')

<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid col-md-8">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">
                        <b>FAQ</b>
                        <h6 class="text-sm">Frequently Asked Questions (FAQ)</h6>
                    </h1>
                </div>
                <div class="col-sm-6 text-right">

                </div>
            </div>
        </div>
    </div>

    <div class="content">
        <div class="container-fluid col-md-8">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            <p>{!! nl2br($faq?->deskripsi) !!}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card-body">
                            <form action="{{ route('faq.store') }}" method="GET">
                                @csrf
                                <div class="form-group">
                                    <label>Judul</label>
                                    <input type="text" class="form-control" name="judul" value="{{ $faq?->judul }}">
                                </div>
                                <div class="form-group">
                                    <label>Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="15">{{ $faq?->deskripsi }}</textarea>
                                </div>
                                <div class="form-group text-right">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
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
