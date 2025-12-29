@extends('app')
<style>
.custom-file-label.pilih-button::after {
    content: "Pilih" !important;
}
</style>
@section('content')
<div class="col-md-12 content-header" >
    <h6 class="text-uppercase"><i class="fa fa-{{ $headingIcon ?? null }}"></i> {{ $heading ?? null }}</h6>
</div>

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fa fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <i class="fa fa-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<section class="content">
<div class="row">
    <div class="col-md-12">
        <div class="card border-top-primary">
            <div class="card-body">
                {!! form($form) !!}
            </div>
        </div>
    </div>
</div>
</section>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.custom-file-label').attr('data-browse', 'Pilih');
            $('.custom-file-input').on('change', function() {
                let fileName = $(this).val().split('\\').pop() || 'Tiada Fail Dipilih';
                $(this).siblings('.custom-file-label').html(fileName);
            });
        });
    </script>
@endsection