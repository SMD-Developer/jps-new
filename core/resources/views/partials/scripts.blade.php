{{ Html::script(asset('assets/js/jquery.min.js')) }}
{{ Html::script(asset('assets/js/popper.min.js')) }}
{{ Html::script(asset('assets/js/bootstrap.min.js')) }}
{{ Html::script(asset('assets/plugins/datatables/datatables.min.js')) }}
{{ Html::script(asset('assets/js/pace.min.js')) }}
{{ Html::script(asset('assets/plugins/trumbowyg/trumbowyg.min.js')) }}
{{ Html::script(asset('assets/plugins/pikaday/moment.js')) }}
{{ Html::script(asset('assets/plugins/pikaday/pikaday.js')) }}
{{ Html::script(asset('assets/plugins/pikaday/pikaday.jquery.js')) }}
{{ Html::script(asset('assets/plugins/chosen/chosen.jquery.js')) }}
{{ Html::script(asset('assets/js/validator.min.js')) }}
{{ Html::script(asset('assets/plugins/amaranjs/js/jquery.amaran.min.js')) }}
{{ Html::script(asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.min.js')) }}
{{ Html::script(asset('assets/plugins/sweetalert2/sweetalert2.min.js')) }}
{{ Html::script(asset('assets/plugins/bootbox/bootbox.all.min.js')) }}
{{ Html::script(asset('assets/plugins/chosen/chosen.ajaxaddition.jquery.js')) }}
@if(isset($jsFiles) && is_array($jsFiles) && count($jsFiles) > 0)
@foreach($jsFiles as $jsFile)
{{ Html::script(asset($jsFile)) }}
@endforeach
@endif
@if(isset($jsIncludes) && is_array($jsIncludes) && count($jsIncludes) > 0)
@foreach($jsIncludes as $jsInclude)
@include($jsInclude)
@endforeach
@endif
{{ Html::script(asset('assets/js/app.js?v='.time())) }}
{{ Html::script(asset('assets/js/custom.js?v='.time())) }}
@stack('scripts')
@include('common.common_js')