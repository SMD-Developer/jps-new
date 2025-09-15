@extends('app')
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

        .status-badge .badge:hover {
            opacity: 0.9;
            cursor: pointer;
        }
        .title {
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
        }
        .info {
            display: flex;
            justify-content: space-between;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        } 
        /* table{
            border-collapse: collapse;
        } */
        .no-border{
            border: hidden;
        }
  
     table th, .table td {
    border-top: 1px solid black !important;
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
                    <div class="d-flex justify-content-center">
                        <img src="{{ asset('assets/images/uploads/settings/1732803848.png') }}" alt="">
                    </div>
                        <div class="title">
                            <p>Resit Rasmi</p>
                            <p>Kerajaan Negeri Selangor Darul Ehsan</p>
                            <p>Salinan</p>
                        </div>
                        <table class="no-border mb-5">
                            <tr class="no-border">
                                <td class="no-border">No. Resit</td>
                                <td class="no-border"> : 794079</td>
                                <td class="no-border"> Tempoh Pungutan</td>
                                <td class="no-border">Dari</td>
                                <td class="no-border"> : 08/01/2025</td>
                            </tr >
                            <tr class="no-border">
                                <td class="no-border">Tarikh Resit</td>
                                <td class="no-border" colspan="2"> : 09/01/2025</td>
                                <td class="no-border">Hingga</td>
                                <td class="no-border"> : 08/01/2025</td>
                            </tr>
                            <tr class="no-border">
                                <td class="no-border">No. Penyata Pemungut:</td>
                                <td class="no-border" colspan="2">25COPP050007</td>
                                <td class="no-border">Kod Jabatan</td>
                                <td class="no-border"> : 021000</td>
                            </tr>
                            <tr class="no-border">
                                <td class="no-border">Tarikh Penyata Pemungut:</td>
                                <td class="no-border"colspan="2"> : 08/01/2025</td>
                                <td class="no-border">Kod PTJ/Kos</td>
                                <td class="no-border"> : 21000000</td>
                            </tr>
                            <tr class="no-border">
                                <td class="no-border">Diterima Daripada:</td>
                                <td class="no-border" colspan="2"> : Pengarah Pengairan & Saliran</td>
                                <td class="no-border">No. Akaun Bank</td>
                                <td class="no-border"> : 8001964651</td>
                            </tr>
                        </table>
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th colspan="6" style="border: none !important;">RINGGIT</th>
                                    <th style="border: none !important;">AMAUN RM</th>
                                    <th colspan="2">******* 347,502.00</th>
                                </tr>
                                <tr>
                                    <th>RATUS JUTA</th>
                                    <th>PULUH JUTA</th>
                                    <th>JUTA</th>
                                    <th>RATUS RIBU</th>
                                    <th>PULUH RIBU</th>
                                    <th>RIBU</th>
                                    <th>RATUS</th>
                                    <th>PULUH</th>
                                    <th>SEN</th>
                                </tr>
                                <tr>
                                    <td>*******</td>
                                    <td>*******</td>
                                    <td>*******</td>
                                    <td>TIGA</td>
                                    <td>EMPAT</td>
                                    <td>TUJUH</td>
                                    <td>LIMA</td>
                                    <td>KOSONG</td>
                                    <td>DUA</td>
                                </tr>
                                <tr>
                                    <td colspan="6"></td>
                                    <td>DAN SEN</td>
                                    <td>KOSONG</td>
                                    <td>KOSONG</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-end">
                            <div class=" gap-4 mt-5">
                            <button type="button" class="btn btn-danger px-5">
                                @lang('app.download')
                            </button>
                        </div>
                            <div class=" gap-4 mt-5 mx-3">
                            <button class="btn btn-primary px-5" onclick="window.print()">
                                @lang('app.print')
                            </button>
                            </div>
                        
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
</section>
@endsection