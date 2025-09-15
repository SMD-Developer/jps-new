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
<title>{{ trans('app.daily_receipt_report_type') }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ trans('app.daily_receipt_report_type') }}</h5>
</div>


<!--<div class="card">-->
<!--  <div class="card-body">Basic card</div>-->
<!--</div>-->
<section class="card p-5 m-5">
 <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
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
              <td><input type="date" class="form-control" value="2025-01-10"></td>
            </tr>
            <tr>
              <td class="label">{{ trans('app.until_date') }} : </td>
              <td><input type="date" class="form-control" value="2025-01-10"></td>
            </tr>
            <tr>
              <td class="label">Print Type:</td>
              <td>
                <select class="form-select w-100" style="border: 1px solid #ced4da;">
                  <option value="PDF" selected>PDF</option>
                  <option value="Excel">Excel</option>
                  <option value="Word">Word</option>
                </select>
              </td>
            </tr>
          </tbody>
        </table>
        <a type="button" href="{{ route('daily_payment_receipt_report_reviewer') }}"  class="btn btn-primary float-right" id="successButton">@lang('app.next')</a>
      </div>
    </div>
  </div>
</section>
@endsection