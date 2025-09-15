@extends('app')
<style>
    body {
        font-family: Arial, sans-serif;
        font-size: 12px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 5px;
        text-align: left;
    }

    th {
        background-color: #f0f0f0;
        text-align: center;
    }

    .scrollbar {
        overflow-x: auto;
    }

    .form-container {
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        background: #fff;
    }

    .date-column {
        display: inline-block;
        min-width: 100px;
    }

    .spaced-column {
        padding: 8px 16px;
        min-width: 150px;
    }
</style>

<title>{{ $title }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-file" aria-hidden="true"></i> {{ $title }}</h5>
    </div>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="col-md-12">
                    <!-- First Box (Header Section) -->
                    <div class="border p-3 mb-3"> <!-- Added border and padding -->
                        <div class="row">
                            <!-- Replace this part in your view -->
                            <div class="col-2">
                                <p class="mb-0"><b>TARIKH : {{ $currentDate }}</b></p>
                                <p><b>MASA : {{ $currentTime }}</b></p>
                            </div>
                            <div class="col-8 text-center">
                                <p class="mb-0"><b>KERAJAAN NEGERI SELANGOR DARUL EHSAN</b></p>
                                <!--<p><b>S 10/01/2025 HINGGA 10/01/2025</b></p>-->
                                <p><b> LAPORAN KUTIPAN CARUMAN PARIT MENGIKUT DAERAH PADA {{ $formattedStartDate }} HINGGA
                                        {{ $formattedEndDate }}</b></p>

                                @if ($isFilteredByDistrict && $selectedDistrictName)
                                    <p><b>DAERAH: {{ strtoupper($selectedDistrictName) }}</b></p>
                                @else
                                    <p><b>DAERAH: SEMUA DAERAH</b></p>
                                @endif
                            </div>
                            <div class="col-2">
                                <p class="mb-0"><b>MUKA SURAT : 1/1</b></p>
                                <p><b></b></p>
                            </div>
                        </div>
                    </div>

                    <!-- Second Box (Department Info Section) -->
                    <div class="border p-3 mb-3"> <!-- Added border and padding -->
                        <div class="col-md-12">
                            <table class="mb-2">
                                <tr>
                                    <th>MENERIMA</th>
                                    <th style="border-left: hidden; border-right: hidden;">KOD</th>
                                    <th colspan="7">PERIHAL</th>
                                </tr>
                                <tr style="border-top: hidden; border-bottom: hidden;">
                                    <th>JABATAN</th>
                                    <th style="border-left: hidden; border-right: hidden;"> : 021000</th>
                                    <th colspan="7">JABATAN PENGAIRAN & SALIRAN SELANGOR</th>
                                </tr>
                                <tr>
                                    <th>PTJ/PK</th>
                                    <th style="border-left: hidden; border-right: hidden;"> : 02100000</th>
                                    <th colspan="7">PENGARAH PENGAIRAN & SALIRAN</th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="form-container">

                    <div class="scrollbar">
                        <table>
                            <thead>
                                <tr>
                                    <th>@lang('app.bil')</th>
                                    <th>@lang('app.date')</th>
                                    <th>@lang('app.reference_no')</th>
                                    <th>@lang('app.account_type')</th>
                                    <th>@lang('app.applicant_list')</th>
                                    <th>District</th>
                                    <th>@lang('app.lot_pt')</th>
                                    <th>@lang('app.total_contribution')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($applications as $index => $application)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        {{-- <td>{{ date('d/m/Y', strtotime($application->created_at)) }}</td> --}}
                                        <td class="date-column">
                                            {{ \Carbon\Carbon::parse($application->created_at)->format('d-m-Y') }}</td>
                                        <td>{{ $application->refference_no ?? 'N/A' }}</td>
                                        <td>{{ $application->account_type_name }}</td>
                                        <td>{{ $application->applicant ?? 'N/A' }}</td>
                                        <td class="spaced-column">{{ $application->district_name }}</td>
                                        <td class="spaced-column">{{ $application->land_lot ?? 'N/A' }}</td>
                                        <td>RM {{ number_format($application->final_amount, 2) }}</td>
                                        <!-- Add other fields -->
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-primary" onclick="window.print()">@lang('app.print')</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
