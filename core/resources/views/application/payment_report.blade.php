@extends('app')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* Card styling similar to first example */
    .card {
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
        /*margin: 20px;*/
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .table td,
    .table th {
        padding: 10px;
        border: 1px solid #ced4da;
    }

    .table th {
        background-color: #f9f9f9;
        text-align: left;
    }

    .label {
        width: 200px;
        /* font-weight: bold; */
        background-color: #f9f9f9;
    }

    .form-control {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .form-select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ced4da;
        border-radius: 4px;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 4px;
        /*font-weight: bold;*/
    }

    .btn-primary {
        background-color: #007bff;
        color: white;
        border: none;
    }

    /* Error message styling */
    #error-message {
        color: red;
        display: none;
        margin-bottom: 10px;
    }

    .content-header {
        padding: 15px;
    }

    .content-header h5 {
        /*font-weight: bold;*/
        margin: 0;
    }

    .content-header h5 i {
        margin-right: 10px;
    }
</style>
<title>@lang('app.collectors_statement_report') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-line-chart" aria-hidden="true"></i> @lang('app.generate_a_collectors_statement')</h5>
    </div>

    <section class="card p-5 m-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form id="filterForm" method="GET" action="{{ route('payment.receipt') }}">
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
                                        <select class="form-select" name="print_type">
                                            <option value="PDF" selected>PDF</option>
                                            <option value="Excel">Excel</option>
                                            <option value="Word">Word</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div id="error-message"></div>
                        <button type="submit" id="successButton"
                            class="btn btn-primary float-right">@lang('app.next')</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
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
        });
    </script>
@endsection
