
@extends('app')
@section('content')
    <div class="col-md-12 content-header" >
        <h5><i class="fa fa-{{ $headingIcon ?? null }}"></i> {{ $heading ?? null }}</h5>
    </div>
    <section class="content">
        <div class="card border-top-primary">
            <div class="card-header">
                <a href="{{ route('estimates.index') }}" class="btn btn-xs btn-outline-info"> <i class="fa fa-arrow-circle-left"></i> @lang('app.back')</a>
                @if(hasPermission('estimate.send'))
                    <a href="{{route('estimate_send_modal',$estimate->uuid)}}" data-toggle="ajax-modal" class="btn btn-success btn-xs pull-right ml-2"> <i class="fa fa-send"></i> @lang('app.send')</a>
                @endif
                @if(hasPermission('estimate.download'))
                    <a href="{{ url('estimates/pdf', $estimate->uuid) }}" class="btn btn-primary btn-xs pull-right ml-2"> <i class="fa fa-download"></i> @lang('app.download')</a>
                @endif
                @if(hasPermission('estimate.make-invoice'))
                    <button id="btn_convert_to_invoice" data-id="{{$estimate->uuid}}" class="btn btn-success btn-xs float-right ml-2"> <i class="fa fa-mail-forward"></i> @lang('app.make_invoice')</button>
                @endif
                @if(hasPermission('estimate.edit'))
                    <a href="{{ route('estimates.edit', $estimate->uuid) }}" class="btn btn-warning btn-xs pull-right" > <i class="fa fa-pencil"></i> @lang('app.edit')</a>
                @endif
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (Session::has('flash_notification.message'))
                            {!! message() !!}
                        @endif
                    </div>
                </div>
                @include('estimates.partials.address_part')
                <div class="row mt-5">
                    <div class="col-md-12">
                        <table class="table">
                            <thead style="margin-bottom:30px;background: #2e3e4e;color: #fff;">
                            <tr>
                                @if($estimate_settings->show_product_images)
                                    <th style="width:5%">@lang('app.photo')</th>
                                @endif
                                <th style="width:50%">{{trans('app.product')}}</th>
                                <th style="width:10%" class="text-center">{{trans('app.quantity')}}</th>
                                <th style="width:15%" class="text-right">{{trans('app.price')}}</th>
                                <th style="width:10%" class="text-center">{{trans('app.tax')}}</th>
                                <th style="width:15%" class="text-right">{{trans('app.total')}}</th>
                            </tr>
                            </thead>
                            <tbody id="items">
                            @foreach($estimate->items->sortBy('item_order') as $item)
                            <tr>
                                @if($estimate_settings->show_product_images)
                                    <td style="width:5%">
                                        @if($item->product && $item->product->image != '')
                                            <img src="{{ image_url($item->product->image) }}"width="50px" alt="product photo"/>
                                        @else
                                            <img src="{{ image_url('uploads/product_images/no-product-image.png') }}" width="50px" alt="product photo"/>
                                        @endif
                                    </td>
                                @endif
                                <td><b>{!! $item->item_name !!}</b><br/>{!! $item->item_description !!}</td>
                                <td class="text-center">{{ $item->quantity }}</td>
                                <td class="text-right">{{ format_amount($item->price) }}</td>
                                <td class="text-center">{{ $item->tax ? $item->tax->value.'%' : '' }}</td>
                                <td class="text-right">{{ format_amount($item->itemTotal) }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div><!-- /.col -->
                    <div class="col-md-6"></div><!-- /.col -->
                    <div class="col-md-6">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <th style="width:50%">{{trans('app.subtotal')}}</th>
                                    <td class="text-right">
                                        <span id="subTotal">{{ format_amount($estimate->totals['subTotal']) }}</span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>{{trans('app.tax')}}</th>
                                    <td class="text-right">
                                        <span id="taxTotal">{{ format_amount($estimate->totals['taxTotal']) }}</span>
                                    </td>
                                </tr>

                                <tr class="amount_due">
                                    <th>{{trans('app.total')}}</th>
                                    <td class="text-right">
                                        <span id="grandTotal">{{format_amount($estimate->totals['grandTotal'],$estimate->currency)}}</span>
                                    </td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @if($estimate->notes)
                            <h4 class="invoice_title">{{trans('app.notes')}}</h4><hr class="separator"/>
                            {!! htmlspecialchars_decode($estimate->notes, ENT_QUOTES) !!}<br/><br/>
                        @endif
                        @if($estimate->terms)
                            <h4 class="invoice_title">{{trans('app.terms')}}</h4><hr class="separator"/>
                            {!! htmlspecialchars_decode($estimate->terms, ENT_QUOTES) !!}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection





