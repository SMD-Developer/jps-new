@extends('app')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
<style>
    /* Flex container for buttons */
    .sbtn {
        display: flex;
        justify-content: flex-start;
        gap: 0.5rem;
    }

    /* Adjust input and dropdown widths for responsiveness */
    .form-label {
        white-space: nowrap; /* Prevent labels from wrapping */
    }

    #lot #district #division{
        max-width: 180px; /* Restrict width for smaller inputs */
    }
   
    /* Responsive layout tweaks */
    @media (max-width: 768px) {
        .search-row > .col-sm-6 {
            margin-bottom: 1rem; /* Add spacing on smaller screens */
        }
    }
    #aside{display: flex;align-items: baseline;}
    table.table.table-bordered.table-striped {
    text-align: center;
    font-size: 13px;
}

/*some css need to remove*/

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
        background: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #ddd;
    }

    /* Headings */
    h2, h3, h4{
        margin-bottom: 20px;
        color: #333;
        font-weight: 600;
    }
    /* Flex container for buttons */
    /* Flex container for buttons */
    .sbtn
    {
        display: flex;
        flex-wrap: wrap; /* Allow wrapping for smaller screens */
        justify-content: center;
        gap: 0.5rem; /* Uniform spacing */
    }
    
    /* Smaller, compact buttons */
    .sbtn a {
        flex: 0 1 auto; /* Prevents buttons from stretching too much */
        max-width: 150px; /* Restrict the button width */
        padding: 4px 8px; /* Reduce padding for a compact size */
        font-size: 0.75rem; /* Smaller font size */
        line-height: 1; /* Compact line height */
        background:#E85B6C !important;
        border: 1px solid #E85B6C;
        border-radius:25px;
    }
    
    .btn-sm {
        padding: 4px 8px; /* Ensure consistency with other small buttons */
        font-size: 0.75rem;
        line-height: 1; /* Reduce button height */
       
    }
    
    /* Adjust button gap for smaller buttons */
    .sbtn {
        gap: 0.25rem; /* Smaller spacing between buttons */
    }

    
    /* Responsive design */
    @media (max-width: 768px) {
        .sbtn {
            justify-content: center; /* Center buttons on smaller screens */
        }
    
        .sbtn a {
            flex: 1 1 100%; /* Stack buttons on smaller screens */
            max-width: none;
        }
    }
    
    /* Adjust button appearance */
    .btn-sm {
        padding: 6px 10px !important; /* Smaller padding for compact design */
    }


    /* Adjust input and dropdown widths for responsiveness */
    .form-label {
        white-space: nowrap; /* Prevent labels from wrapping */
    }

    #lot #district #division{
        max-width: 180px; /* Restrict width for smaller inputs */
    }
   
    /* Responsive layout tweaks */
    @media (max-width: 768px) {
        .search-row > .col-sm-6 {
            margin-bottom: 1rem; /* Add spacing on smaller screens */
        }
    }
    #aside{display: flex;align-items: baseline;}
    table.table.table-bordered.table-striped {
    text-align: center;
    font-size: 13px;
}
    /*border-radius: 15px !important;*/
    
    
/* Add extra styling for badges if needed */
.status-badge {
    display: inline-block;
    margin: 5px 0;
}

.status-badge .badge {
    font-size: 0.8rem;
    padding: 8px 15px;
    border-radius: 25px;
    background-color: #1991EE !important;
    color: #fff !important;
}

/* Add hover effects */
.status-badge .badge:hover {
    opacity: 0.9; /* Slight transparency */
    cursor: pointer;
}
/* Ensure the table stays within the card */
.card {
    overflow: hidden !important; /* Prevents scrollbar from going outside */
}

/* Allow table container to expand properly */
.scrollbar {
    max-width: 100% !important; /* Ensure it stays within the parent */
    overflow-x: auto !important; /* Allow horizontal scrolling if needed */
    overflow-y: auto !important; /* Enable vertical scrolling only when required */
    display: block !important;
    padding-bottom: 10px; /* Prevents scrollbar from being cut off */
}

/* Ensure the table adjusts properly */
.table {
    width: 100%;
    table-layout: auto;
    border-collapse: collapse;
}

/* Fix scrollbar appearance */
.scrollbar:-webkit-scrollbar {
    height: 8px; /* Horizontal scrollbar size */
    width: 8px; /* Vertical scrollbar size */
}

.scrollbar:-webkit-scrollbar-thumb {
    background: #aaa;
    border-radius: 4px;
}

.scrollbar:-webkit-scrollbar-track {
    background: #f1f1f1;
}



</style>
<title>{{ trans('app.treasury_eceipts') }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-check" aria-hidden="true"></i> {{ trans('app.treasury_eceipts') }}</h5>
</div>
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Filter Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <div class="mb-3 d-flex justify-content-end">
                        <a href="#" class="btn btn-primary text-right" id="loadReceipts">@lang('app.list_of_receipt')</a>
                    </div>
                    
                    <div class="row search-row align-items-center g-2 mb-5">
                        {{-- <div class="col-md-3 col-sm-6 colsm36">
                            <label for="search" class="form-label"> {{ trans('app.search') }}:&nbsp;</label>
                            <input type="text" id="search" class="form-control form-control-sm" placeholder="{{ trans('app.search') }}">
                        </div>
                        <div class="col-md-3 col-sm-6" id="aside">
                            <label for="district" class="form-label" >{{ trans('app.district') }}:</label>&nbsp;&nbsp;
                            <select id="district" class="form-select form-select-sm form-control form-control-sm">
                                <option value="" selected disabled> @lang('app.please_select')</option>
                                    <option value="mukim1">@lang('Kajang')</option>
                                    <option value="mukim2">@lang('Labu')</option>
                                    <option value="mukim3">@lang('Batu')</option>>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6" id="aside">
                            <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;
                            <select id="division" class="form-select form-select-sm form-control form-control-sm">
                                <option value="" selected disabled>{{ trans('app.select_division') }}</option>
                                <option value="mukim1">Hulu langat</option>
                                <option value="mukim2">sepang</option>
                                <option value="mukim3">Gombak</option>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6" id="aside">
                            <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }} :</label>&nbsp;&nbsp;
                            <input type="text" id="lot" class="form-control form-control-sm" placeholder="{{ trans('app.enter_lot_pt') }}">
                        </div> --}}

                        <div class="col-md-3" id="aside">
                            <label for="district" class="form-label" >{{ trans('app.show') }}:</label>&nbsp;&nbsp;
                            <select id="district" class="form-select form-select-sm form-control form-control-sm">
                                <option value="" selected disabled> @lang('app.please_select')</option>
                                    <option value="mukim1" selected>@lang('1')</option>
                                    <option value="mukim2">@lang('2')</option>
                                    <option value="mukim3">@lang('3')</option>>
                            </select>
                            &nbsp;&nbsp;<label for="district" class="form-label" >{{ trans('app.entries') }}</label>
                        </div>
                        <div class="col-md-6"></div>
                        <div class="col-md-3" id="aside">
                            <label for="lot" class="form-label me-2">{{ trans('app.search') }} :</label>&nbsp;&nbsp;
                            <input type="text" id="lot" class="form-control form-control-sm" >
                        </div>
                    </div>

            <!-- Table Section -->
       
                    <div class="scrollbar">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><strong>{{ trans('#') }}</strong></th>
                                    <th><strong>{{ trans('app.process') }}</strong></th>
                                    <th><strong>{{ trans('app.record_no') }}</strong></th>
                                    <th><strong>{{ trans('app.reference_no') }}</strong></th>
                                    <th><strong>{{ trans('app.department') }}</strong></th>
                                    <th><strong>@lang('app.description_table')</strong></th>
                                    <th><strong>@lang('app.bank/Company/Individu')</strong></th>
                                    <th><strong>{{ trans('app.date') }}</strong></th>
                                    <th><strong>@lang('app.amount_table')</strong></th>
                                    <th><strong>@lang('Status')</strong></th>
                                    <th><strong>@lang('app.for_action')</strong></th>
                                </tr>
                            </thead>
                            <tbody id="receiptTableBody">
                                <tr id="noDataRow">
                                    <td colspan="11">No data available in table</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Table Responsive -->
                </div>
                <div class="row px-5 pb-4 align-items-center justify-content-between">
                    <div class="col-md-6 text-left">
                        <span class="text-muted">Showing 0 to 0 of 0 entries</span>
                    </div>
                    <div class="col-md-6 text-right">
                        <a href="#" class="btn btn-outline-primary me-2" id="prevPage">
                            <i class="fas fa-arrow-left"></i> {{ trans('app.previous') }}
                        </a>
                        <a href="#" class="btn btn-outline-primary" id="nextPage">
                            {{ trans('app.next') }} <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById('loadReceipts').addEventListener('click', function(event) {
    event.preventDefault(); // Prevent default link behavior

    let tableBody = document.getElementById('receiptTableBody');

    // Remove "No data available" row if present
    let noDataRow = document.getElementById('noDataRow');
    if (noDataRow) {
        noDataRow.remove();
    }

    // Check if rows already exist (prevent duplicates)
    if (document.querySelectorAll('.static-receipt-row').length > 0) {
        return; // If already added, do nothing
    }

    // Static rows to add
    let staticRows = `
        <tr class="static-receipt-row">
            <td>1</td>
            <td>Hantar</td>
            <td>25CQP050100009</td>
            <td>25CQP050100009</td>
            <td>021000</td>
            <td>Resit Perbendaharaan</td>
            <td>CIMB BANK BERHAD</td>
            <td>10/01/2025</td>
            <td>RM 63,512.00</td>
            <td>Belum Selesai</td>
            <td><a href="{{route('treasury_receipt_show')}}" class="btn btn-success">@lang('app.view')</a></td>
        </tr>
        <tr class="static-receipt-row">
            <td>2</td>
            <td>Hantar</td>
            <td>25CQP050100008</td>
            <td>25CQP050100008</td>
            <td>021000</td>
            <td>Resit Perbendaharaan</td>
            <td>CIMB BANK BERHAD</td>
            <td>09/01/2025</td>
            <td>RM 7,286.00</td>
            <td>Selesai</td>
            <td><a href="{{route('treasury_receipt_show')}}" class="btn btn-success">@lang('app.view')</a></td>
        </tr>
    `;

    // Append the static rows instantly
    tableBody.insertAdjacentHTML('beforeend', staticRows);
    
    //  Ensure immediate visual update
    let tableContainer = document.querySelector('.scrollbar');
    tableContainer.style.overflowY = 'hidden'; // Reset overflow
    setTimeout(() => {
        tableContainer.style.overflowY = 'auto'; // Ensure scrollbar appears instantly when needed
    }, 10);
});

</script>
@endsection