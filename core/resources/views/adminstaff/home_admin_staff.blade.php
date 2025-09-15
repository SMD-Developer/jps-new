<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

<script src="https://cdnjs.cloudflare.com/ajax/libs/prefixfree/1.0.7/prefixfree.min.js"></script>

<style>
    body {
        background-color: #f4f6f9;
        overflow-y: auto;
    }

    .pie-chart {
        position: relative;
        list-style: none;
        width: 260px;
        height: 260px;
        border-radius: 50%;
        display: block;
        /* ensures Safari renders it properly */
        background:
            radial-gradient(circle closest-side,
                transparent 100%,
                #ECF0F5),
            conic-gradient(#4e79a7 0 19.3%,
                #f28e2c 19.3% 31%,
                #e15759 31% 39.1%,
                #76b7b2 39.1% 44.2%,
                #59a14f 44.2% 47.2%,
                #edc949 47.2% 50.8%,
                #af7aa1 50.8% 72.6%,
                #ff9da7 72.6% 100%);
    }

    @keyframes rotate {
        from {
            transform: rotate(0);
        }

        to {
            transform: rotate(240deg);
        }
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
        display: none;
        /* Hide the count in the pie chart */
    }

    /* Pie chart container with flex layout */
    .pie-chart-container {
        display: flex;
        align-items: flex-start;
        gap: 20px;
        flex-wrap: wrap;
    }

    /* Legend styles - positioned to the right */
    .legend {
        margin: 0;
        list-style: none;
        padding: 0;
        flex: 1;
        min-width: 200px;
        max-width: 300px;
    }

    .legend li {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .color-box {
        width: 12px;
        height: 12px;
        margin-right: 8px;
        display: inline-block;
        border-radius: 2px;
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .pie-chart-container {
            flex-direction: column;
            align-items: center;
        }

        .legend {
            max-width: 100%;
            margin-top: 20px;
        }
    }

    .graph {
        margin-bottom: 1em;
        font: normal 100%/150% arial, helvetica, sans-serif;
    }

    .graph caption {
        font: bold 150%/120% arial, helvetica, sans-serif;
        padding-bottom: 0.33em;
    }

    .graph tbody th {
        text-align: right;
    }

    @supports (display:grid) {
        @media (min-width:32em) {
            .graph {
                display: block;
                width: 350px;
                height: 200px;
            }

            .graph caption {
                display: block;
            }

            .graph thead {
                display: none;
            }

            .graph tbody {
                position: relative;
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(2em, 1fr));
                column-gap: 0%;
                align-items: end;
                height: 100%;
                margin: 3em 0 1em 2.6em;
                padding: 0 1em;
                border-bottom: 2px solid rgba(0, 0, 0, 0.5);
                background: repeating-linear-gradient(180deg,
                        rgba(170, 170, 170, 0.7) 0,
                        rgba(170, 170, 170, 0.7) 1px,
                        transparent 1px,
                        transparent 20%);
            }

            .graph tbody:before,
            .graph tbody:after {
                position: absolute;
                left: -3.2em;
                width: 2.8em;
                text-align: right;
                font: bold 80%/120% arial, helvetica, sans-serif;
            }

            .graph tbody:before {
                content: "100";
                top: -0.6em;
            }

            .graph tbody:after {
                content: "0";
                bottom: -0.6em;
            }

            .graph tr {
                position: relative;
                display: block;
            }

            .graph tr:hover {
                z-index: 999;
            }

            .graph th,
            .graph td {
                display: block;
                text-align: center;
            }

            .graph tbody th {
                position: absolute;
                top: -3em;
                width: 100%;
                font-weight: normal;
                text-align: center;
                white-space: nowrap;
                text-indent: 0;
            }

            .graph tbody th:after {
                content: "";
            }

            .graph td {
                width: auto;
                height: 100%;
                border-radius: 0.5em 0.5em 0 0;
                transition: background 0.5s;
            }

            .td1 {
                background: #1991EE;
            }

            .td2 {
                background: #AA322F;
            }

            .graph tr:hover td {
                opacity: 0.7;
            }

            .graph td span {
                overflow: hidden;
                position: absolute;
                left: 50%;
                top: 50%;
                width: 0;
                padding: 0.5em 0;
                margin: -1em 0 0;
                font: normal 85%/120% arial, helvetica, sans-serif;
                font-weight: bold;
                opacity: 0;
                transition: opacity 0.5s;
                color: white;
            }

            .toggleGraph:checked+table td span,
            .graph tr:hover td span {
                width: 4em;
                margin-left: -2em;
                /* 1/2 the declared width */
                opacity: 1;
            }
        }
    }

    .text3 {
        overflow: visible !important;
        text-overflow: unset !important;
        white-space: unset !important;
        text-align: left !important;
        text-transform: none !important;
    }

    .text1,
    .text2 {
        margin-bottom: 10px;
    }

    .info-box {
        height: 100px;
        text-transform: none;
        align-items: baseline !important;
    }
</style>

<!--@extends('app')-->
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-home"></i> @lang('app.dashboard')</h5>
    </div>
    <section class="content">
        <div class="container-fl">
            <div class="row">
                <div class="col-lg-4 col-sm-6 col-xs-12">
                    <a href="{{ route('developer_list') }}" class="info-box-link" style="text-decoration: none; color: inherit;">
                        <div class="info-box clickable-box" style="background: #E2FFED; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <i class="fa fa-users bg-aqua"></i>
                            <div class="info-box-content">
                                <span class="info-box-text text3 text-left text1">@lang('app.new_registrations')</span>
                                <span class="info-box-number">{{ $totalclient }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-4 col-sm-6 col-xs-12">
                   <a href="{{ route('application_list') }}" class="info-box-link" style="text-decoration: none; color: inherit;">
                        <div class="info-box clickable-box" style="background: #4df1782e; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <i class="fa fa-list bg-aqua"></i>
                            <div class="info-box-content">
                                <span class="info-box-text text3 text-left text1">@lang('app.total_no_of_application')</span>
                                <span class="info-box-number mb-3">{{ $totalapplication }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <a href="{{ route('application_list') }}" class="info-box-link" style="text-decoration: none; color: inherit;">
                        <div class="info-box clickable-box" style="background: #FBFFE0; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;">
                            <i class="fa fa-file-pdf-o bg-green"></i>
                            <div class="info-box-content">
                                <span class="info-box-text text3 text-left text2">@lang('app.new_applications')</span>
                                <span class="info-box-number">{{ $newapplication }}</span>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #EEF6FF;">
                        <i class="fa fa-list-alt bg-yellow"></i>
                        <div class="info-box-content pr-0" rowspan="2">
                            <span class="info-box-text text3 text-left text2 mb-0">@lang('app.number_of_applications_this')</span>
                            <span class="info-box-number">{{ $monthapplication }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #f5f3f3;">
                        <i class="fa fa-puzzle-piece bg-green"></i>
                        <div class="info-box-content pr-0">
                            <span class="info-box-text text3">@lang('app.number_of_approved')</span>
                            <span class="info-box-number">{{ $approvedapplication }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-xs-12">
                    <div class="info-box" style="background: #FFEFEF;">
                        <i class="fa fa-close bg-red"></i>
                        <div class="info-box-content pr-0">
                            <span class="info-box-text text3">@lang('app.number_of_rejected_application')</span>
                            <span class="info-box-number">{{ $rejected }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-lg-7 col-sm-6 col-xs-12 long-bar">
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
                    <div class="pie-chart-container mt-3">
                        <ul class="pie-chart">
                            @foreach ($districts as $district)
                                <li>
                                    <span class="district-name"
                                        title="{{ $district['name'] }}">{{ $district['name'] }}</span>
                                    <span class="district-count">{{ $district['count'] }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <!-- Legend will be added here by JavaScript -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const pieChartElement = document.querySelector('.pie-chart');
            const pieChartContainer = document.querySelector('.pie-chart-container');
            const districtItems = pieChartElement.querySelectorAll('li');
            const districts = [];

            districtItems.forEach(item => {
                const name = item.querySelector('.district-name').textContent;
                const count = parseInt(item.querySelector('.district-count').textContent, 10);
                districts.push({
                    name,
                    count
                });
            });

            const colors = [
                '#4e79a7', '#f28e2c', '#e15759', '#76b7b2', '#59a14f',
                '#edc949', '#af7aa1', '#ff9da7', '#9c755f', '#bab0ab'
            ];

            const total = districts.reduce((sum, district) => sum + district.count, 0);
            let cumulativePercentage = 0;
            let conicGradient = [];

            districts.forEach((district, index) => {
                const percentage = (district.count / total) * 100;
                const color = colors[index % colors.length];

                conicGradient.push(
                    `${color} ${cumulativePercentage}% ${cumulativePercentage + percentage}%`);
                const listItem = districtItems[index];
                const rotationAngle = -90 + (cumulativePercentage + percentage / 2) * 3.6;
                listItem.style.transform = `rotate(${rotationAngle}deg)`;

                cumulativePercentage += percentage;
            });

            pieChartElement.style.background = `conic-gradient(${conicGradient.join(', ')})`;

            // Add legend to the right side of pie chart
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

            // Append legend to the container (it will appear to the right due to flex layout)
            pieChartContainer.appendChild(legendElement);
        });
    </script>
@endsection
