
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>



<style>
body{
    background-color: #f4f6f9;
    /*overflow-y: hidden;*/
}


    .pie-chart {
        position: relative;
        list-style: none;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        display: block;
        padding: 0;
        margin: 0;
        /* The background gradient will be set dynamically by JavaScript */
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
        font-size: 80%;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.7);
        z-index: 2;
    }
    
    .district-name {
        display: inline-block;
        vertical-align: middle;
    }
    
    .district-count {
        display: none; /* Hide the count in the pie chart */
    }
    
    /* Legend styles */
    .legend {
        margin-top: 20px;
        list-style: none;
        padding: 0;
    }
    
    .legend li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
    }
    
    .color-box {
        width: 12px;
        height: 12px;
        margin-right: 8px;
        display: inline-block;
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
           width: 350px;
          height: 200px;
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
			top:-4em;
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
                    <a href="{{route('view.receipt')}}" style="color:#212529;">
                    <div class="info-box" style="background: #E2FFED;">
                        <i class="fa fa-users bg-aqua"></i>
                        <div class="info-box-content">
                            <span class="info-box-text text3 text-left text1 mb-0">@lang('app.applications_for_government_agencies')</span>
                            <span class="info-box-number">{{$totalAgencyApplication}}</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                <a href="{{route('payment_report')}}" style="color:#212529;">
                    <div class="info-box" style="background: #FBFFE0;">
                        <i class="fa fa-file-pdf-o bg-green"></i>
                        <div class="info-box-content">
                            <span class="info-box-text text3 text-left text2 mb-0">@lang('app.generate_collectors_statement')</span>
                            <span class="info-box-number">{{$generateCollectorReport}}</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <a href="{{route('approved-statement')}}" style="color:#212529;">
                    <div class="info-box" style="background: #EEF6FF;">
                        <i class="fa fa-list-alt bg-yellow"></i>
                        <div class="info-box-content pr-0" rowspan="2" >
                                <span class="info-box-text text3 text-left text2">@lang('app.assignments_not_taken')</span>
                                <span class="info-box-number">{{$assignmentNotTaken}}</span>
                        </div>
                    </div>
                    </a>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                     <a href="{{route('task_not_completed_finance')}}" style="color:#212529;">
                    <div class="info-box" style="background: #FFEFEF;">
                        <i class="fa fa-puzzle-piece bg-red"></i>
                        <div class="info-box-content pr-0" rowspan="2" >
                            <span class="info-box-text text3 text-left text2">@lang('app.unfinished_tasks')</span>
                            <span class="info-box-number">0</span>
                        </div>
                    </div>
                    </a>
                </div>
                
            </div>
            
            
            <div class="row mt-2">
                <div class="col-lg-7 col-sm-6 col-xs-12 long-bar pl-5">
                     <h5>@lang('app.application_status')</h5>
                     
                     <table class="graph mt-3">
                        <tbody>
                            <tr style="height:85%; margin-left: 40px; margin-right: 40px;">
                                <th scope="row">@lang('app.passed')</th>
                                <td class="td1">
                                    <span class="count-display">{{ $passed ?? 0 }}</span>
                                </td>
                            </tr>
                            <tr style="height:23%; margin-left: 40px; margin-right: 40px;">
                                <th scope="row">@lang('app.reject')</th>
                                <td class="td2">
                                    <span class="count-display">{{ $rejected ?? 0 }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
    
                </div>
                <div class="col-lg-5 col-sm-6 col-xs-12">
                    <h5>@lang('app.application_according_to_the_district')</h5>
                    <ul class="pie-chart mt-3">
                        @foreach ($districts as $district)
                            <li>
                                <span class="district-name" title="{{ $district['name'] }}">{{ $district['name'] }}</span>
                                <span class="district-count">{{ $district['count'] }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
     <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get the pie chart element
            const pieChartElement = document.querySelector('.pie-chart');
            
            // Get all district items
            const districtItems = pieChartElement.querySelectorAll('li');
            
            // Create an array to store district data
            const districts = [];
            
            // Extract data from HTML
            districtItems.forEach(item => {
                const name = item.querySelector('.district-name').textContent;
                const count = parseInt(item.querySelector('.district-count').textContent, 10);
                districts.push({ name, count });
            });
            
            // Colors for the pie chart segments
            const colors = [
                '#4e79a7', '#f28e2c', '#e15759', '#76b7b2', '#59a14f', 
                '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'
            ];
            
            // Calculate total applications
            const total = districts.reduce((sum, district) => sum + district.count, 0);
            
            // Calculate percentages and cumulative angles
            let cumulativePercentage = 0;
            let conicGradient = [];
            
            districts.forEach((district, index) => {
                const percentage = (district.count / total) * 100;
                const color = colors[index % colors.length];
                
                conicGradient.push(`${color} ${cumulativePercentage}% ${cumulativePercentage + percentage}%`);
                
                // Get the corresponding list item
                const listItem = districtItems[index];
                
                // Calculate rotation angle (starting from -90 degrees)
                const rotationAngle = -90 + (cumulativePercentage + percentage / 2) * 3.6;
                listItem.style.transform = `rotate(${rotationAngle}deg)`;
                
                cumulativePercentage += percentage;
            });
            
            // Apply conic gradient background to pie chart - FULL coverage with no center circle
            pieChartElement.style.background = `conic-gradient(${conicGradient.join(', ')})`;
            
            // Add legend below pie chart
            const legendElement = document.createElement('ul');
            legendElement.className = 'legend';
            
            districts.forEach((district, index) => {
                const percentage = (district.count / total) * 100;
                const color = colors[index % colors.length];
                
                const legendItem = document.createElement('li');
                
                const colorBox = document.createElement('span');
                colorBox.className = 'color-box';
                colorBox.style.backgroundColor = color;
                
                const legendText = document.createElement('span');
                legendText.textContent = `${district.name}: ${district.count} (${percentage.toFixed(1)}%)`;
                
                legendItem.appendChild(colorBox);
                legendItem.appendChild(legendText);
                legendElement.appendChild(legendItem);
            });
            
            pieChartElement.parentNode.appendChild(legendElement);
        });
    </script>
@endsection