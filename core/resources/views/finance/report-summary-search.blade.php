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

    .is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: none;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
    }
</style>

<title>{{ $title }} | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-list"></i> {{ $title }}</h5>
    </div>

    <section class="card p-5 m-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <form id="filterForm" method="GET" action="{{ route('payment-summary-report') }}">
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
                                    <td class="label">{{ trans('app.start_date') }} :</td>
                                    <td>
                                        <input type="date" id="start_date" class="form-control" name="start_date"
                                            value="{{ old('start_date', date('Y-m-d')) }}">
                                        <div id="start_date_error" class="error-message"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.until_date') }} :</td>
                                    <td>
                                        <input type="date" id="end_date" class="form-control" name="end_date"
                                            value="{{ old('end_date', date('Y-m-d')) }}">
                                        <div id="end_date_error" class="error-message"></div>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label">{{ trans('app.print_type') }} :</td>
                                    <td>
                                        <select class="form-select w-100" name="print_type"
                                            style="border: 1px solid #ced4da;">
                                            <option value="PDF"
                                                {{ old('print_type', 'PDF') == 'PDF' ? 'selected' : '' }}>PDF</option>
                                            <option value="Excel" {{ old('print_type') == 'Excel' ? 'selected' : '' }}>
                                                Excel</option>
                                            <option value="Word" {{ old('print_type') == 'Word' ? 'selected' : '' }}>Word
                                            </option>
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
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            let isValid = true;
            const startDate = document.getElementById('start_date').value;
            const endDate = document.getElementById('end_date').value;
            const startDateError = document.getElementById('start_date_error');
            const endDateError = document.getElementById('end_date_error');

            // Reset error messages
            startDateError.textContent = '';
            endDateError.textContent = '';

            // Validate start date
            if (!startDate) {
                startDateError.textContent = 'Start date is required';
                isValid = false;
            }

            // Validate end date
            if (!endDate) {
                endDateError.textContent = 'End date is required';
                isValid = false;
            }

            // Validate date range if both dates exist
            if (startDate && endDate) {
                if (new Date(startDate) > new Date(endDate)) {
                    startDateError.textContent = 'Start date cannot be after end date';
                    endDateError.textContent = 'End date cannot be before start date';
                    isValid = false;
                }
            }

            if (!isValid) {
                event.preventDefault();
            }
        });

        // Optional: Add real-time validation as users type
        document.getElementById('start_date').addEventListener('change', function() {
            const endDate = document.getElementById('end_date').value;
            if (endDate && new Date(this.value) > new Date(endDate)) {
                document.getElementById('start_date_error').textContent = 'Start date cannot be after end date';
            } else {
                document.getElementById('start_date_error').textContent = '';
            }
        });

        document.getElementById('end_date').addEventListener('change', function() {
            const startDate = document.getElementById('start_date').value;
            if (startDate && new Date(startDate) > new Date(this.value)) {
                document.getElementById('end_date_error').textContent = 'End date cannot be before start date';
            } else {
                document.getElementById('end_date_error').textContent = '';
            }
        });
    </script>
@endsection
