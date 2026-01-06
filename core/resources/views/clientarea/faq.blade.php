@extends('clientarea.app')

<style>
    .accordion-title:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
.accordion-title.collapsed:before {
    float: right !important;
    content:"\f067";
}
</style>
<title>@lang('app.faq') | JPS</title>
@section('content')

<div class="col-md-12 content-header">
        <h6><i class="fa fa-question-circle nav-icon"></i> @lang('app.faq')</h6>
    </div>
<section class="pb-5">
  <div class="container" style="width: 99%;">
     <div id="accordion" class="mb-5">
    @if($faqs->count() > 0)
        @foreach($faqs as $index => $faq)
            <div class="card">
                <div class="card-header">
                    <a class="card-link accordion-title {{ $index == 0 ? '' : 'collapsed' }}" 
                       data-toggle="collapse" 
                       href="#collapse{{ $faq->id }}">
                        <h6>{{ $index + 1 }}. {{ $faq->question }}</h6>
                    </a>
                </div>
                <div id="collapse{{ $faq->id }}" 
                     class="collapse {{ $index == 0 ? 'show' : '' }}" 
                     data-parent="#accordion">
                    <div class="card-body">
                        <p>{!! nl2br(e($faq->answer)) !!}</p>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">
            <i class="fa fa-info-circle"></i> No FAQs available at the moment.
        </div>
    @endif
</div>  


</div>
</section>
@endsection