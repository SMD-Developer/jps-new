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
    <h5><i class="fa fa-list"></i> {{ trans('app.daily_payment_receipt_report_by') }}</h5>
</div>


<!--<div class="card">-->
<!--  <div class="card-body">Basic card</div>-->
<!--</div>-->
<section class="card p-5 m-5">
 <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12">
                    <form id="filterForm" method="GET"
                        action="{{ route('daily_payment_receipt_report_finance') }}">
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
                                    <td><input type="date" class="form-control" name="start_date" value=""
                                            onchange="validateDates()"></td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.until_date') }} : </td>
                                    <td><input type="date" class="form-control" name="end_date" value=""
                                            onchange="validateDates()"></td>
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
                        <div id="error-message" style="color: red; display: none; margin-bottom: 10px;"></div>
                        <button type="submit" id="successButton"
                            class="btn btn-primary float-right">@lang('app.next')</button>
                    </form>
                </div>
    </div>
  </div>
</section>
<script>
        function toggleDropdown() {
            document.getElementById("districtDropdown").classList.toggle("show");
        }
        
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                const dropdowns = document.getElementsByClassName("dropdown-content");
                for (let i = 0; i < dropdowns.length; i++) {
                    const openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
        function validateDates() {
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const submitButton = document.getElementById("successButton");
            const errorDiv = document.getElementById("error-message");

            if (startDate && endDate) {
                const start = new Date(startDate);
                const end = new Date(endDate);

                if (end < start) {
                    errorDiv.textContent = "End date cannot be earlier than start date.";
                    errorDiv.style.display = "block";
                    submitButton.disabled = true;
                } else {
                    errorDiv.style.display = "none";
                    submitButton.disabled = false;
                }
            } else {
                errorDiv.style.display = "none";
                submitButton.disabled = false;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            if (!document.querySelector('input[name="start_date"]').value) {
                const today = new Date().toISOString().split('T')[0];
                document.querySelector('input[name="start_date"]').value = today;
            }

            if (!document.querySelector('input[name="end_date"]').value) {
                const today = new Date().toISOString().split('T')[0];
                document.querySelector('input[name="end_date"]').value = today;
            }

            validateDates();
            // Don't show account type error on initial load, only on submission attempt
        });
    </script>
@endsection