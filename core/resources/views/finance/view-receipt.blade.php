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
        background:#F1AA2A !important;
        border: 1px solid #F1AA2A;
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
</style>
<title>{{ trans('app.list_of_payments') }} | JPS</title>
@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-list"></i> {{ trans('app.list_of_payments') }}</h5>
</div>
<!--<section class="content">-->
<!--    <div class="row">-->
<!--        <div class="col-md-12">-->
<!--             Filter Section -->
<!--            <div class="card mb-3">-->
<!--                <div class="card-body">-->
<!--                    <div class="row search-row align-items-center g-2 mb-5">-->
<!--                         Search Input -->
<!--                        <div class="col-md-2 col-sm-6">-->
<!--                            <label for="search" class="form-label"> {{ trans('app.search') }}:</label>-->
<!--                            <input type="text" id="search" class="form-control form-control-sm" placeholder="Search...">-->
<!--                        </div>-->
<!--                         District Dropdown -->
<!--                        <div class="col-md-3 col-sm-6" id="aside">-->
<!--                            <label for="district" class="form-label" >{{ trans('app.district') }}:</label>&nbsp;&nbsp;-->
<!--                            <select id="district" class="form-select form-select-sm form-control form-control-sm">-->
<!--                                <option value="" selected disabled>{{ trans('app.select_district') }}</option>-->
<!--                                <option value="district1">kajang</option>-->
<!--                                <option value="district2">⁠semenyih</option>-->
<!--                                <option value="district3">beranang</option>⁠-->
<!--                                <option value="district3">⁠Hulu semenyih</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                         Mukim Dropdown -->
<!--                        <div class="col-md-3 col-sm-6" id="aside">-->
<!--                            <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;-->
<!--                            <select id="division" class="form-select form-select-sm form-control form-control-sm">-->
<!--                                <option value="" selected disabled>{{ trans('app.select_division') }}</option>-->
<!--                                <option value="mukim1">Hulu langat</option>-->
<!--                                <option value="mukim2">sepang</option>-->
<!--                                <option value="mukim3">Gombak</option>-->
<!--                            </select>-->
<!--                        </div>-->
<!--                         Lot/PT Input -->
<!--                        <div class="col-md-3 col-sm-6" id="aside">-->
<!--                            <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }} :</label>&nbsp;&nbsp;-->
<!--                            <input type="text" id="lot" class="form-control form-control-sm" placeholder="{{ trans('app.enter_lot_pt') }}">-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->

<!--             Table Section -->
<!--            <div class="card">-->
<!--                <div class="card-body">-->
<!--                     Table Wrapper for Responsiveness -->
<!--                    <div class="table-responsive">-->
<!--                        <table class="table table-bordered table-striped">-->
<!--                            <thead>-->
<!--                                <tr>-->
<!--                                    <th><strong>{{ trans('app.bil') }}</strong></th>-->
<!--                                    <th><strong>{{ trans('app.date') }}</strong></th>-->
<!--                                    <th><strong>{{ trans('app.applicant') }}</strong></th>-->
<!--                                    <th><strong>{{ trans('app.lot_pt') }}</strong></th>-->
<!--                                    <th><strong>{{ trans('app.for_action') }}</strong></th>-->
<!--                                </tr>-->
<!--                            </thead>-->
<!--                            <tbody>-->
<!--                                <tr>-->
<!--                                    <td>1</td>-->
<!--                                    <td>25/11/2024</td>-->
<!--                                    <td>ABDULLAH BIN KHAIMIS</td>-->
<!--                                    <td>Hakmilik HSM 10231 PT 49739, Mukim Semenyih, Daerah Hulu Langat, Seluas 0.406 Hektar</td>-->
<!--                                    <td>-->
<!--                                        <div class="sbtn">-->
<!--                                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>-->
<!--                                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
<!--                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>2</td>-->
<!--                                    <td>19/11/2024</td>-->
<!--                                    <td>ARMANI DEVELOPMENT SDN BHD</td>-->
<!--                                    <td>Hakmilik GRN 4149 SELUAS 43739 METER</td>-->
<!--                                    <td>-->
<!--                                        <div class="sbtn">-->
<!--                                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>-->
<!--                                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
<!--                                            <button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
<!--                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>3</td>-->
<!--                                    <td>16/11/2024</td>-->
<!--                                    <td>HAKMIL DEVELOPMENT SDN BHD</td>-->
<!--                                    <td>Hakmilik GRN 4139 SELUAS 43738 METER</td>-->
<!--                                    <td>-->
<!--                                        <div class="sbtn">-->
<!--                                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>-->
<!--                                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
<!--                                            <button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
<!--                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>4</td>-->
<!--                                    <td>11/11/2024</td>-->
<!--                                    <td>ABDUL DEVELOPMENT SDN BHD</td>-->
<!--                                    <td>Hakmilik HSM 10230 PT 49739, GRN 4151 SELUAS 43740 METER</td>-->
<!--                                    <td>-->
<!--                                        <div class="sbtn">-->
<!--                                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>-->
<!--                                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
<!--                                            <button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
<!--                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                                <tr>-->
<!--                                    <td>5</td>-->
<!--                                    <td>9/11/2024</td>-->
<!--                                    <td>HARMAN DEVELOPMENT SDN BHD</td>-->
<!--                                    <td>Hakmilik HSM 10229 PT 49738, GRN 4150 SELUAS 43741 METER</td>-->
<!--                                    <td>-->
<!--                                        <div class="sbtn">-->
<!--                                            <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i></a>-->
<!--                                            <a href="#" class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></a>-->
<!--                                            <button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
<!--                                            <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
<!--                                        </div>-->
<!--                                    </td>-->
<!--                                </tr>-->
<!--                            </tbody>-->
<!--                        </table>-->
<!--                    </div>-->
<!--                     End Table Responsive -->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<section class="content">
    <div class="row">
        <div class="col-md-12">
            <!-- Filter Section -->
            <div class="card mb-3">
                <div class="card-body">
                    <!--<button class="btn btn-primary mb-5" style="background-color: #D9D9D9; border-color: #D9D9D9;">-->
                    <!--    {{trans('app.all')}} - 5-->
                    <!--</button>-->
                    <!--<button class="btn btn-alert mb-5" style="background-color: #4891FD; border-color: #4891FD;color: #fff;">-->
                    <!--    {{trans('app.passed')}} - 4-->
                    <!--</button>-->
                    <!--<button class="btn btn-danger mb-5" style="background-color: #FF7F7F; border-color: #FF7F7F;">-->
                    <!--    {{trans('app.reject')}} -1-->
                    <!--</button>-->

                    <!--<div class="row search-row align-items-center g-2 mb-5">-->
                        <!-- Search Input -->
                    <!--    <div class="col-md-2 col-sm-6">-->
                    <!--        <label for="search" class="form-label"> {{ trans('app.search') }}:</label>-->
                            <!--<input type="text" id="search" class="form-control form-control-sm" placeholder="Search...">-->
                    <!--    </div>-->
                        <!-- District Dropdown -->
                    <!--    <div class="col-md-3 col-sm-6" id="aside">-->
                    <!--        <label for="district" class="form-label" >{{ trans('app.district') }}:</label>&nbsp;&nbsp;-->
                    <!--        <select id="district" class="form-select form-select-sm form-control form-control-sm">-->
                    <!--            <option value="" selected disabled>{{ trans('app.select_district') }}</option>-->
                    <!--            <option value="district1">kajang</option>-->
                    <!--            <option value="district2">⁠semenyih</option>-->
                    <!--            <option value="district3">beranang</option>⁠-->
                    <!--            <option value="district3">⁠Hulu semenyih</option>-->
                    <!--        </select>-->
                    <!--    </div>-->
                        <!-- Mukim Dropdown -->
                    <!--    <div class="col-md-3 col-sm-6" id="aside">-->
                    <!--        <label for="division" class="form-label">{{ trans('app.division') }}:</label>&nbsp;&nbsp;-->
                    <!--        <select id="division" class="form-select form-select-sm form-control form-control-sm">-->
                    <!--            <option value="" selected disabled>{{ trans('app.select_division') }}</option>-->
                    <!--            <option value="mukim1">Hulu langat</option>-->
                    <!--            <option value="mukim2">sepang</option>-->
                    <!--            <option value="mukim3">Gombak</option>-->
                    <!--        </select>-->
                    <!--    </div>-->
                        <!-- Lot/PT Input -->
                    <!--    <div class="col-md-3 col-sm-6" id="aside">-->
                    <!--        <label for="lot" class="form-label me-2">{{ trans('app.lot_pt') }} :</label>&nbsp;&nbsp;-->
                    <!--        <input type="text" id="lot" class="form-control form-control-sm" placeholder="{{ trans('app.enter_lot_pt') }}">-->
                    <!--    </div>-->
                    <!--</div>-->
            <!--    </div>-->
            <!--</div>-->

            <!-- Table Section -->
            <!--<div class="card">-->
                <!--<div class="card-body">-->
                    <!-- Table Wrapper for Responsiveness -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th><strong>{{ trans('app.bil') }}</strong></th>
                                    <th><strong>{{ trans('app.date') }}</strong></th>
                                    <th><strong>{{ trans('app.reference _no') }}</strong></th>
                                    <th><strong>{{ trans('app.applicant_list') }}</strong></th>
                                    <th><strong>{{ trans('app.account_type') }}</strong></th>
                                    <th><strong>{{ trans('app.lot/PT') }}</strong></th>
                                    <th><strong>{{ trans('app.total_contribution') }}</strong></th>
                                    <th><strong>{{ trans('app.for_action') }}</strong></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>25/11/2024</td>
                                    <td>No. (66) in JPS. Tue. 02/7/77 Vol. 335</td>
                                    <td>ABDULLAH BIN KHAIMIS</td>
                                    <td>Agensi Kerajaan</td>
                                    <td>Hakmilik HSM 10231 PT 49739, Mukim Semenyih, Daerah Hulu Langat, Seluas 0.406 Hektar</td>
                                    <td>RM 5,016.00</td>
                                    <td>
                                        <!--<div class="status-badge">-->
                                        <!--    <span class="badge bg-warning text-dark d-flex align-items-center">-->
                                        <!--        <i class="bi bi-hourglass-split me-2"></i>-->
                                                <!-- Icon -->
                                        <!--        {{ trans('app.approved') }}-->
                                        <!--    </span>-->
                                        <!--</div>-->
                                        <div class="sbtn">
                                            <a href="{{route('finance.payment.letter')}}" class="btn btn-primary btn-sm"><strong>{{ trans('app.view_receipt') }}</strong></a>
                                            <!--<button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
                                            <!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>19/11/2024</td>
                                    <td>No. (65) in JPS. Tue. 02/7/76 Vol. 334</td>
                                    <td>ARMANI DEVELOPMENT SDN BHD</td>
                                    <td>Agensi Kerajaan</td>
                                    <td>Hakmilik GRN 4149 SELUAS 43739 METER</td>
                                    <td>RM 5,036.00</td>
                                    <td>
                                        <!--<div class="status-badge">-->
                                        <!--    <span class="badge bg-warning text-dark d-flex align-items-center">-->
                                        <!--        <i class="bi bi-hourglass-split me-2"></i>-->
                                                <!-- Icon -->
                                        <!--        {{ trans('app.approved') }}-->
                                        <!--    </span>-->
                                        <!--</div>-->
                                        <div class="sbtn">
                                            <a href="{{route('finance.payment.letter')}}" class="btn btn-primary btn-sm"><strong>{{ trans('app.view_receipt') }}</strong></a>
                                            <!--<button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
                                            <!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>16/11/2024</td>
                                    <td>No. (64) in JPS. Tue. 02/7/75 Vol. 335</td>
                                    <td>HAKMIL DEVELOPMENT SDN BHD</td>
                                    <td>Agensi Kerajaan</td>
                                    <td>Hakmilik GRN 4139 SELUAS 43738 METER</td>
                                    <td>RM 5,055.00</td>
                                    <td>
                                        <!--<div class="status-badge">-->
                                        <!--    <span class="badge bg-warning text-dark d-flex align-items-center">-->
                                        <!--        <i class="bi bi-hourglass-split me-2"></i>-->
                                                <!-- Icon -->
                                        <!--        {{ trans('app.approved') }}-->
                                        <!--    </span>-->
                                        <!--</div>-->
                                        <div class="sbtn">
                                            <a href="{{route('finance.payment.letter')}}" class="btn btn-primary btn-sm"><strong>{{ trans('app.view_receipt') }}</strong></a>
                                            <!--<button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
                                            <!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>4</td>
                                    <td>11/11/2024</td>
                                    <td>No. (63) in JPS. Tue. 02/7/73 Vol. 334</td>
                                    <td>ABDUL DEVELOPMENT SDN BHD</td>
                                    <td>Agensi Kerajaan</td>
                                    <td>Hakmilik HSM 10230 PT 49739, GRN 4151 SELUAS 43740 METER</td>
                                    <td>RM 5,010.00</td>
                                    <td>
                                        <!--<div class="status-badge">-->
                                        <!--    <span class="badge bg-warning text-dark d-flex align-items-center">-->
                                        <!--        <i class="bi bi-hourglass-split me-2"></i>-->
                                                <!-- Icon -->
                                        <!--        {{ trans('app.approved') }}-->
                                        <!--    </span>-->
                                        <!--</div>-->
                                        <div class="sbtn">
                                            <a href="{{route('finance.payment.letter')}}" class="btn btn-primary btn-sm"><strong>{{ trans('app.view_receipt') }}</strong></a>
                                            <!--<button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
                                            <!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>9/11/2024</td>
                                    <td>No. (61) in JPS. Tue. 02/7/75 Vol. 330</td>
                                    <td>HARMAN DEVELOPMENT SDN BHD</td>
                                    <td>Agensi Kerajaan</td>
                                    <td>Hakmilik HSM 10229 PT 49738, GRN 4150 SELUAS 43741 METER</td>
                                    <td>RM 4,001.00</td>
                                    <td>
                                        <!--<div class="status-badge">-->
                                        <!--    <span class="badge bg-warning text-dark d-flex align-items-center">-->
                                        <!--        <i class="bi bi-hourglass-split me-2"></i>-->
                                                <!-- Icon -->
                                        <!--        {{ trans('app.approved') }}-->
                                        <!--    </span>-->
                                        <!--</div>-->
                                        <div class="sbtn">
                                            <a href="{{route('finance.payment.letter')}}" class="btn btn-primary btn-sm"><strong>{{ trans('app.view_receipt') }}</strong></a>
                                            <!--<button class="btn btn-warning btn-sm"><i class="fa fa-edit"></i></button>-->
                                            <!--<button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>-->
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div> <!-- End Table Responsive -->
                </div>
            </div>
        </div>
    </div>
</section>
@endsection