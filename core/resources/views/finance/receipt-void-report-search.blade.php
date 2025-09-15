@extends('app')
<style>
/* General Styles */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }


</style>
<title>{{ $title }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ $title }}</h5>
</div>


<!--<div class="card">-->
<!--  <div class="card-body">Basic card</div>-->
<!--</div>-->
<section class="card p-5 m-5">
 <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
                    <form id="filterForm" method="GET" action="{{ route('receipt-void-report') }}">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td class="label">{{ trans('app.department') }}</td>
                                    <td>021000 - JABATAN PENGAIRAN & SALIRAN SELANGOR</td>
                                </tr>
                                <tr>
                                    <td class="label">PTJ</td>
                                    <td>21000000 - PENGARAH PENGAIRAN & SALIRAN</td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.start_date') }} : </td>
                                    <td><input type="date" class="form-control" name="start_date" value="2025-01-10">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.until_date') }} : </td>
                                    <td><input type="date" class="form-control" name="end_date" value="2025-01-10"></td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.print_type') }} :</td>
                                    <td>
                                        <select class="form-select w-100" name="print_type"
                                            style="border: 1px solid #ced4da;">
                                            <option value="PDF" selected>PDF</option>
                                            <option value="Excel">Excel</option>
                                            <option value="Word">Word</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <button type="submit" class="btn btn-primary float-right">@lang('app.next')</button>
                    </form>
                </div>
    </div>
  </div>
</section>
 <script>
            // Simple form validation if needed
            document.getElementById('filterForm').addEventListener('submit', function(e) {
                const startDate = document.querySelector('input[name="start_date"]').value;
                const endDate = document.querySelector('input[name="end_date"]').value;

                if (!startDate || !endDate) {
                    e.preventDefault();
                    alert('Please select both start and end dates');
                    return false;
                }

                if (new Date(startDate) > new Date(endDate)) {
                    e.preventDefault();
                    alert('End date must be after start date');
                    return false;
                }

                return true;
            });
    </script>
@endsection