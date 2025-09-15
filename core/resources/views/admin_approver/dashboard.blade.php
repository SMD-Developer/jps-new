 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>



<style>
body{
    background-color: #f4f6f9;
}
.pie-chart {
  position: relative;
  list-style: none;
	max-width: 350px;
	/*margin: 0;*/
 /* padding: 0;*/
	background:
		radial-gradient(
			circle closest-side,
			transparent 100%,
			/*white 0*/
	#ECF0F5
		),
		conic-gradient(
			#4e79a7 0,
			#4e79a7 19.3%,
			#f28e2c 0,
			#f28e2c 31%,
			#e15759 0,
			#e15759 39.1%,
			#76b7b2 0,
			#76b7b2 44.2%,
			#59a14f 0,
			#59a14f 47.2%,
			#edc949 0,
			#edc949 50.8%,
			#af7aa1 0,
			#af7aa1 72.6%,
			#ff9da7 0,
			#ff9da7 100%
	);
  /*animation-name: rotate;*/
  /*animation-duration: 2s;*/
  /*animation-fill-mode: forwards;*/
  /*animation-timing-function: ease;*/
}

@keyframes rotate {
  from {
    transform: rotate(0);
  }
  to {
    transform: rotate(240deg);
  }
}

.pie-chart:after {
  content: "";
  display: block;
  padding-bottom: 100%;
}

.pie-chart li {
  position: absolute;
  top: calc(50% - 0.5rem);
  left: 50%;
  padding-left: 10%;
  width: 37%;
  text-align: right;
  transform-origin: 0;
  font-family: Arial;
  font-weight: bold;
  font-size: 100%;
  color: #ffffff;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.pie-chart li:nth-child(1) {
  transform: rotate(calc(-90deg + 1.8deg * 19.3));
}

.pie-chart li:nth-child(2) {
  transform: rotate(calc(-90deg + 1.8deg * (19.3 + 31)));
}

.pie-chart li:nth-child(3) {
  transform: rotate(calc(-90deg + 1.8deg * (31 + 39.1)));
}

.pie-chart li:nth-child(4) {
  transform: rotate(calc(-90deg + 1.8deg * (39.1 + 44.2)));
}

.pie-chart li:nth-child(5) {
  transform: rotate(calc(-90deg + 1.8deg * (44.2 + 47.2)));
}

.pie-chart li:nth-child(6) {
  transform: rotate(calc(-90deg + 1.8deg * (47.2 + 50.8)));
}

.pie-chart li:nth-child(7) {
  transform: rotate(calc(-90deg + 1.8deg * (50.8 + 72.6)));
}

.pie-chart li:nth-child(8) {
  transform: rotate(calc(-90deg + 1.8deg * (72.6 + 100)));
}









.graph {
	margin-bottom:1em;
  font:normal 100%/150% arial,helvetica,sans-serif;
}

.graph caption {
	font:bold 150%/120% arial,helvetica,sans-serif;
	padding-bottom:0.33em;
}

.graph tbody th {
	text-align:right;
}

@supports (display:grid) {

	@media (min-width:32em) 
	{

		.graph {
			display:block;
      width:450px;
      height:300px;
		}

		.graph caption {
			display:block;
		}

		.graph thead {
			display:none;
		}

		.graph tbody {
			position:relative;
			display:grid;
			grid-template-columns:repeat(auto-fit, minmax(2em, 1fr));
			column-gap:0%;
			align-items:end;
			height:100%;
			margin:3em 0 1em 2.6em;
			padding:0 1em;
			border-bottom:2px solid rgba(0,0,0,0.5);
			background:repeating-linear-gradient(
				180deg,
				rgba(170,170,170,0.7) 0,
				rgba(170,170,170,0.7) 1px,
				transparent 1px,
				transparent 20%
			);
		}

		.graph tbody:before,
		.graph tbody:after {
			position:absolute;
			left:-3.2em;
			width:2.8em;
			text-align:right;
			font:bold 80%/120% arial,helvetica,sans-serif;
		}

		.graph tbody:before {
			content:"100";
			top:-0.6em;
		}

		.graph tbody:after {
			content:"0";
			bottom:-0.6em;
		}

		.graph tr {
			position:relative;
			display:block;
		}

		.graph tr:hover {
			z-index:999;
		}

		.graph th,
		.graph td {
			display:block;
			text-align:center;
		}

		.graph tbody th {
			position:absolute;
			top:-3em;
			/*left: -50px;*/
			width:100%;
			font-weight:normal;
			text-align:center;
            white-space:nowrap;
			text-indent:0;
			/*transform:rotate(-45deg);*/
		}

		.graph tbody th:after {
			content:"";
		}

		.graph td {
		    width: auto;
       
			height:100%;
			/*background:#1991EE;*/

			border-radius:0.5em 0.5em 0 0;
			transition:background 0.5s;
		}
		.td1{
		    	background:#1991EE;
		}
		.td2{
		    	background: #AA322F;
		}
		

		.graph tr:hover td {
			opacity:0.7;
		}

		.graph td span {
			overflow:hidden;
			position:absolute;
			left:50%;
			top:50%;
			width:0;
			padding:0.5em 0;
			margin:-1em 0 0;
			font:normal 85%/120% arial,helvetica,sans-serif;
/* 			background:white; */
/* 			box-shadow:0 0 0.25em rgba(0,0,0,0.6); */
			font-weight:bold;
			opacity:0;
			transition:opacity 0.5s;
      color:white;
		}

		.toggleGraph:checked + table td span,
		.graph tr:hover td span {
			width:4em;
			margin-left:-2em; /* 1/2 the declared width */
			opacity:1;
		}

	} /* min-width:32em */

} /* grid only */

.text3{
    
     overflow: visible !important; 
     text-overflow: unset !important; 
     white-space: unset !important;
     text-align: left !important;
     text-transform: none !important;

     
}
.text1, .text2{
margin-bottom: 22px;
}
.info-box{
    height: 140px;
    text-transform: none;

}
/*.roww{*/
/*        height: 10%;*/
/*}*/

</style>


<!--@extends('app')-->
@section('content')
    <div class="col-md-12 content-header" >
        <h5><i class="fa fa-home"></i> @lang('app.dashboard')</h5>
    </div>
    <section class="content">
        <div class="container-fl">
            <div class="row">
                <div class="col-lg-3 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #E2FFED;">
                        <i class="fa fa-users bg-aqua"></i>
                        <div class="info-box-content">
                            <span class="info-box-text text3 text-left text1">@lang('app.new_registrations')</span>
                            <span class="info-box-number">{{ $clients }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #FBFFE0;">
                        <i class="fa fa-file-pdf-o bg-green"></i>
                        <div class="info-box-content">
                            <span class="info-box-text text3 text-left text2">@lang('app.new_applications')</span>
                            <span class="info-box-number">{{ $invoices }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #EEF6FF;">
                        <i class="fa fa-list-alt bg-yellow"></i>
                        <div class="info-box-content pr-0" rowspan="2" >
                            <span class="info-box-text text3 text-left text2 mb-">@lang('app.number_of_applications_this')</span>
                            <span class="info-box-number">{{ $estimates }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #FFEFEF;">
                        <i class="fa fa-puzzle-piece bg-red"></i>
                        <div class="info-box-content pr-0">
                            <span class="info-box-text text3">@lang('app.number_of_approved')</span>
                            <span class="info-box-number">{{ $products }}</span>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="row mt-5">
                <div class="col-lg-7 col-sm-6 col-xs-12 long-bar">
                     <h5>@lang('app.application_status')</h5>
                     
                     <table class="graph mt-5">
                    	<tbody>
                    		<tr style="height:85%; margin-left: 40px; margin-right: 40px;">
                    			<th scope="row">@lang('app.passed')</th>
                    			<td class="td1" ><span></span></td>
                    			<!--<td>@lang('app.passed')</td>-->
                    		</tr>
                    		<tr style="height:23%; margin-left: 40px; margin-right: 40px;">
                    			<th scope="row">@lang('app.reject')</th>
                    			<td class="td2"><span></span></td>
                    			<!--<td>@lang('app.pending')</td>-->
                    		</tr>
                    	</tbody>
                    </table>
    
                </div>
                <div class="col-lg-5 col-sm-6 col-xs-12">
                    <h5>@lang('app.application_according_to_the_district')</h5> 
                    
                     <ul class="pie-chart mt-5">
                        <li>split</li>
                        <li>petals</li>
                        <li>kuala langat</li>
                        <li>bernam slate</li>
                        <li>gombak</li>
                        <li>clang</li>
                        <li>kuala langat</li>
                        <li>kuala selangor</li>
                        <!--<li>clang</li>-->
                      </ul>
                </div>
            </div>
        </div>
        
        
        
        <!--<div class="row">-->
        <!--    <div class="col-md-3 col-sm-6 col-xs-12">-->
        <!--        <div class="info-box bg-primary">-->
        <!--            <i class="fa fa-usd fa-3x"></i>-->
        <!--            <div class="info-box-content">-->
        <!--                <span class="info-box-number">{{ $invoice_stats['partiallyPaid'] }}</span>-->
        <!--                <span class="info-box-text">@lang('app.invoices_partially_paid')</span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-md-3 col-sm-6 col-xs-12">-->
        <!--        <div class="info-box bg-warning">-->
        <!--            <i class="fa fa-money fa-3x"></i>-->
        <!--            <div class="info-box-content">-->
        <!--                <span class="info-box-number text-white">{{ $invoice_stats['unpaid'] }}</span>-->
        <!--                <span class="info-box-text text-white">@lang('app.unpaid_invoices')</span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-md-3 col-sm-6 col-xs-12">-->
        <!--        <div class="info-box bg-danger">-->
        <!--            <i class="fa fa-times fa-3x"></i>-->
        <!--            <div class="info-box-content">-->
        <!--                <span class="info-box-number">{{ $invoice_stats['overdue'] }}</span>-->
        <!--                <span class="info-box-text">@lang('app.invoices_overdue')</span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-md-3 col-sm-6 col-xs-12">-->
        <!--        <div class="info-box bg-success">-->
        <!--            <i class="fa fa-check fa-3x"></i>-->
        <!--            <div class="info-box-content">-->
        <!--                <span class="info-box-number">{{ $invoice_stats['paid'] }}</span>-->
        <!--                <span class="info-box-text">@lang('app.paid_invoices')</span>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
        <!--<div class="row">-->
        <!--    <section class="col-md-6">-->
        <!--        <div class="card border-top-primary">-->
        <!--            <div class="card-header">-->
        <!--                <h3 class="card-title">-->
        <!--                    <i class="fa fa-pie-chart mr-1"></i> @lang('app.yearly_overview')-->
        <!--                </h3>-->
        <!--            </div>-->
        <!--            <div class="card-body">-->
        <!--                <div id="yearly_overview">-->
        <!--                    <canvas id="yearly_overview_inner"></canvas>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </section>-->
        <!--    <section class="col-md-6">-->
        <!--        <div class="card border-top-primary">-->
        <!--            <div class="card-header">-->
        <!--                <h3 class="card-title">-->
        <!--                    <i class="fa fa-usd mr-1"></i> @lang('app.payment_overview')-->
        <!--                </h3>-->
        <!--            </div>-->
        <!--            <div class="card-body">-->
        <!--                <div id="payment_overview">-->
        <!--                    <canvas id="payment_overview_inner"></canvas>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </section>-->
        <!--</div>-->
        <!--<div class="row">-->
        <!--    <div class="col-md-12">-->
        <!--        <div class="card border-top-primary">-->
        <!--            <div class="card-header with-border">-->
        <!--                <h3 class="card-title"> @lang('app.recent_invoices')</h3>-->
        <!--            </div>-->
        <!--            <div class="card-body">-->
        <!--                <div class="table-responsive">-->
        <!--                    <table class="table table-bordered table-striped table-hover dataTable">-->
        <!--                        <thead>-->
        <!--                            <tr>-->
        <!--                                <th></th>-->
        <!--                                <th>@lang('app.invoice_number')</th>-->
        <!--                                <th>@lang('app.invoice_status')</th>-->
        <!--                                <th>@lang('app.client')</th>-->
        <!--                                <th class="text-right">@lang('app.date')</th>-->
        <!--                                <th class="text-right">@lang('app.due_date')</th>-->
        <!--                                <th class="text-right">@lang('app.amount')</th>-->
        <!--                                <th class="text-right" width="20%">@lang('app.action')</th>-->
        <!--                            </tr>-->
        <!--                        </thead>-->
        <!--                        <tbody>-->
        <!--                            @if(count($recentInvoices) > 0)-->
        <!--                                @foreach($recentInvoices as $count=>$invoice)-->
        <!--                                    <tr>-->
        <!--                                        <td>{{ $count+1 }}</td>-->
        <!--                                        <td><a href="{{ route('invoices.show', $invoice->uuid) }}">{{ $invoice->invoice_no }}</a> </td>-->
        <!--                                        <td><span class="badge {{ statuses()[$invoice->status]['class'] }}">{{ ucwords(statuses()[$invoice->status]['label']) }} </span></td>-->
        <!--                                        <td><a href="{{route('clients.show', $invoice->client_id) }}">{{ $invoice->client->name ?? '' }}</a> </td>-->
        <!--                                        <td class="text-right">{{ format_date($invoice->invoice_date) }} </td>-->
        <!--                                        <td class="text-right">{{ format_date($invoice->due_date) }} </td>-->
        <!--                                        <td class="text-right">{!! format_amount($invoice->totals['grandTotal'],$invoice->currency) !!} </td>-->
        <!--                                        <td class="text-right">-->
        <!--                                            <a href="{{ route('invoices.show',$invoice->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> @lang('app.view')</a>-->
        <!--                                            @if(hasPermission('edit_invoice'))-->
        <!--                                                <a href="{{ route('invoices.edit',$invoice->uuid) }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> @lang('app.edit')</a>-->
        <!--                                            @endif-->
        <!--                                        </td>-->
        <!--                                    </tr>-->
        <!--                                @endforeach-->
        <!--                            @else-->
        <!--                                <tr><td class="text-center" colspan="8">No data available in table</td></tr>-->
        <!--                            @endif-->
        <!--                        </tbody>-->
        <!--                    </table>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--    <div class="col-md-12">-->
        <!--        <div class="card border-top-primary">-->
        <!--            <div class="card-header with-border">-->
        <!--                <h3 class="card-title"> @lang('app.recent_estimates')</h3>-->
        <!--            </div>-->
        <!--            <div class="card-body">-->
        <!--                <div class="table-responsive">-->
        <!--                    <table class="table table-bordered table-striped table-hover">-->
        <!--                        <thead>-->
        <!--                        <tr>-->
        <!--                            <th></th>-->
        <!--                            <th>@lang('app.estimate_number')</th>-->
        <!--                            <th>@lang('app.client')</th>-->
        <!--                            <th class="text-right">@lang('app.date')</th>-->
        <!--                            <th class="text-right">@lang('app.amount')</th>-->
        <!--                            <th width="20%" class="text-right">@lang('app.action')</th>-->
        <!--                        </tr>-->
        <!--                        </thead>-->
        <!--                        <tbody>-->
        <!--                        @if(count($recentInvoices) > 0)-->
        <!--                            @foreach($recentEstimates as $count=>$estimate)-->
        <!--                                <tr>-->
        <!--                                    <td>{{ $count+1 }}</td>-->
        <!--                                    <td><a href="{{ route('estimates.show', $estimate->uuid) }}">{{ $estimate->estimate_no }} </a></td>-->
        <!--                                    <td><a href="{{ route('clients.show', $estimate->client_id) }}">{{ $estimate->client->name ?? '' }}</a> </td>-->
        <!--                                    <td class="text-right">{{ format_date($estimate->estimate_date) }} </td>-->
        <!--                                    <td class="text-right">{!! format_amount($estimate->totals['grandTotal'],$estimate->currency).'</span>' !!} </td>-->
        <!--                                    <td class="text-right">-->
        <!--                                        <a href="{{ route('estimates.show',$estimate->uuid) }}" class="btn btn-xs btn-info"><i class="fa fa-eye"></i> @lang('app.view')</a>-->
        <!--                                        @if(hasPermission('edit_estimate'))-->
        <!--                                            <a href="{{ route('estimates.edit',$estimate->uuid) }}" class="btn btn-xs btn-success"><i class="fa fa-pencil"></i> @lang('app.edit')</a>-->
        <!--                                        @endif-->
        <!--                                    </td>-->
        <!--                                </tr>-->
        <!--                            @endforeach-->
        <!--                        @else-->
        <!--                            <tr><td class="text-center" colspan="6">No data available in table</td></tr>-->
        <!--                        @endif-->
        <!--                        </tbody>-->
        <!--                    </table>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </div>-->
        <!--    </div>-->
        <!--</div>-->
    </section>
@endsection
@push('scripts')
    <script src="{{ asset('assets/js/chart.js') }}"></script>
    <script>
        var income_data     = JSON.parse('<?php echo $yearly_income; ?>');
        var expense_data    = JSON.parse('<?php echo $yearly_expense; ?>');
        var lineChartData   = {
            labels : ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],
            datasets : [{
                label               : "{{ trans('app.income') }}",
                fillColor           : "rgba(14,172,147,0.1)",
                strokeColor         : "rgba(14,172,147,1)",
                pointColor          : "rgba(14,172,147,1)",
                pointStrokeColor    : "#fff",
                pointHighlightFill  : "rgba(54,73,92,0.8)",
                pointHighlightStroke: "rgba(54,73,92,1)",
                data                : income_data
            },
                {
                    label               : "{{ trans('app.expenditure') }}",
                    fillColor           : "rgba(244,167,47,0)",
                    strokeColor         : "rgba(244,167,47,1)",
                    pointColor          : "rgba(217,95,6,1)",
                    pointStrokeColor    : "#fff",
                    pointHighlightFill  : "rgba(54,73,92,0.8)",
                    pointHighlightStroke: "rgba(54,73,92,1)",
                    data                : expense_data
                }
            ]
        };
        var pieData = [{
                value: '<?php echo $total_payments; ?>',
                color:"#2FB972",
                highlight: "#37D484",
                label: "{{ trans('app.amount_received') }}"
            },
            {
                value: '<?php echo $total_outstanding; ?>',
                color:"#C84135",
                highlight: "#EA5548",
                label: "{{ trans('app.outstanding_amount') }}"
            }
        ];

        $(function(){
            Chart.defaults.global.scaleFontSize = 12;
            var chartDiv = document.getElementById("yearly_overview_inner").getContext("2d");
            lineChart = new Chart(chartDiv).Line(lineChartData, {
                responsive: true
            });
            $('#yearly_overview').append(lineChart.generateLegend());
            var chartDiv = document.getElementById("payment_overview_inner").getContext("2d");
            pieChart = new Chart(chartDiv).Pie(pieData, {
                responsive : true
            });
            $('#payment_overview').append(pieChart.generateLegend());
        });
    </script>
@endpush