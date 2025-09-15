@extends('app')
@section('content')
<div class="col-md-12 content-header" >
    <h6 class="text-uppercase">
        <i class="fa fa-{{ $headingIcon ?? null }}"></i> {{ $heading ?? null }}
    </h6>
</div>
<section class="content">
<div class="row">
    @if(isset($settingsMode) && $settingsMode)
        <div class="col-md-3">
            @include('settings.partials._menu')
        </div>
    @endif
    <div class="{{ isset($settingsMode) && $settingsMode ? 'col-md-9' : 'col-md-12' }}">
        <div class="card border-top-primary">
            @if($showBtnCreate)
                <div class="card-header">
                    <h3 class="card-title float-right">
                        <div class="card-tools">
                            {!! btnCreate($routes['create'], $createDisplayMode, $btnCreateText,$iconCreate) !!}
                        </div>
                    </h3>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    {!! $dataTable->table(['width' => '100%']) !!}
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection
@push('scripts')
{!! $dataTable->scripts() !!}
@endpush

