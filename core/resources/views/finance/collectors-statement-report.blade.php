<!--@extends('app')-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* General Styles */
    body {
        font-family: sans-serif;
        line-height: 1.5;
        margin: 20px;
        color: #333;
        font-weight: 700;
    }

    /* Container */
    .form-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px;
        /*background: #fff;*/
        border-radius: 10px;
        /*box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);*/
        /*border: 1px solid #ddd;*/
    }

    /* Headings */
    h2, h3, h4{
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }

    /* Form Layout */
    .form-group {
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
    }

    .form-group label {
        width: 220px;
        font-weight: 600;
        margin-right: 15px;
        font-size: 13px;
        color: #555;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 13px;
        box-sizing: border-box;
        background-color: #f9f9f9;
        transition: border 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
        border-color: #007bff;
        outline: none;
    }

    .form-group textarea {
        resize: vertical;
    }

    input::placeholder {
        color: #aaa;
        font-style: italic;
    }

    /* File Upload */
    .form-group input[type="file"] {
        padding: 5px;
        border-radius: 5px;
    }

    /* Section */
    .section {
        margin-bottom: 40px;
    }

    /* Buttons */
    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 20px;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 25px;
        font-size: 16px;
        cursor: pointer;
        font-weight: 600;
    }

    .btn-secondary {
        background: #f1f1f1;
        color: #333;
        border: 1px solid #ccc;
    }

    .btn-primary {
        background: #007bff;
        color: #fff;
    }

    .btn-secondary:hover,
    .btn-primary:hover {
        opacity: 0.9;
    }

    /* File Upload Section */
    .note {
        font-size: 14px;
        color: #d9534f;
        margin-top: 10px;
        text-align: end;
    }
    .content{background:#F4F6F9;}
    
    .btn1, .btn2, .btn3{
           border-radius: 20px !important;
           padding: 7px 25px !important;
        }
        
        .small-input{
            border-radius: 1px !important; 
            border: 2px solid black !important;
            padding: 4px 0 !important;
        }
        
        
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: center;
    }

    th {
      background-color: #f9f9f9;
    }

    .total-row td {
      font-weight: bold;
      background-color: #f1f1f1;
    }

    .delete-btn {
      color: red;
      cursor: pointer;
      font-weight: bold;
    }
</style>
<title>@lang('app.collectors_statement_report') | JPS</title>
@section('content')
    <div class="col-md-12 content-header" >
        <h5><i class="fa fa-line-chart" aria-hidden="true"></i> @lang('app.generate_a_collectors_statement')</h5>
    </div>
 

    <section class="content">
        <div class="card">
            <div class="container"> 
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-container">
                            <div class="section">
                                <h4 class="mb-4">@lang('app.collectors_statement_report')</h4>
                                <form>
                                    <div class="form-group">
                                        <label for="negeri">@lang('app.document_type')</label>
                                        <select id="negeri" class="form-control"  readOnly>
                                            <option value="" selected disabled>@lang('app.please_select')</option>
                                            <option value="negeri1" selected>@lang('app.land_grant')</option>
                                            <option value="negeri2">@lang('app.planning_permission_plan')</option>
                                            <option value="negeri3">@lang('app.letter_of_support')</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="No. Application Reference">@lang('app.collector_payment_serial_number')</label>
                                        <input id="text" class="form-control" placeholder="@lang('app.collector_payment_serial_number')" value="123456" readOnly>
                                    </div>
                                    <div class="form-group">
                                        <label for="date">@lang('app.collector_payment_date')</label>
                                        <input type="date" id="tarikh" class="form-control" value="{{ now()->format('Y-m-d') }}" readOnly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="tarikh">@lang('app.date')</label>
                                        <input type="date" id="tarikh" name="uploade_date" class="form-control" value="{{ now()->format('Y-m-d') }}" placeholder=""  readOnly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.collection_date_from')</label>
                                        <input type="date" id="" class="form-control" placeholder="" value="{{ now()->format('Y-m-d') }}" readOnly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.collection_date_until')</label>
                                        <input type="date" id="" class="form-control" placeholder="" value="{{ now()->format('Y-m-d') }}" readOnly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.payment_method')</label>
                                        <select id="" class="form-control"  readOnly>
                                            <option value="" disabled>@lang('app.please_select')</option>
                                            <option value="negeri1" selected >Card</option>
                                            <option value="negeri2">Cash</option>
                                        </select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.bank_account_number')</label>
                                        <select id="" class="form-control"  readOnly>
                                            <option value="" disabled>@lang('app.please_select')</option>
                                            <option value="negeri1" selected >1234567890</option>
                                            <option value="negeri2">1234567890</option>
                                            <option value="negeri3">0987654321</option>
                                        </select>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.bank_date')</label>
                                        <input type="date" id="" class="form-control" value="{{ now()->format('Y-m-d') }}" readOnly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.slip_bank_no')</label>
                                        <input type="text" id="" class="form-control" placeholder="@lang('app.slip_bank_no')" value="">
                                    </div>
        
        
                                    <div class="form-group">
                                        <label for="">@lang('app.receipt_no')</label>
                                        <input type="text" id="" class="form-control" placeholder="@lang('app.receipt_no')" value="0123456789" readOnly>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="">@lang('app.receipt_amount_rm')</label>
                                        <input type="text" id="" class="form-control" placeholder="@lang('app.receipt_amount_rm')"  value="20000" readonly>
                                    </div>
        
                                    <div class="form-group">
                                        <label for="">@lang('app.description')</label>
                                        <textarea id="" class="form-control" rows="4" placeholder=""  readOnly> A receipt is a document which is provided</textarea>
                                    </div>
                                   <a href="{{route('collectors-statement-send-report-finance')}}" type="submit" class="btn btn-primary btn2 float-right" id="">@lang('app.submit')</a>
                                   <a href="#" id="info" class="btn btn-primary btn2 float-right mr-4">@lang('app.simpan')</a>
                                </form>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

<script>
    // Ensure DOM is fully loaded before running scripts
    document.addEventListener('DOMContentLoaded', function () {
        
        function attachClickEvent(selector, callback) {
            let element = document.querySelector(selector);
            if (element) {
                element.addEventListener('click', function (e) {
                    e.preventDefault(); // Prevent default action
                    callback();
                });
            }
        }

        // Simpan Button Event
        attachClickEvent('#info', function () {
            Swal.fire({
                title: '{{ __("app.are_you_sure") }}',
                // text: '{{ __("app.do_you_want_save") }}',
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '{{ __("app.yes") }}',
                cancelButtonText: '{{ __("app.no") }}'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire('{{ __("app.list_of_receipt_save_successfully") }}', '', 'success');
                }
            });
        });

    });
</script>
