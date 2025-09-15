    <!-- @extends('app') -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
        /* General Styles */
        body {
             font-family: 'Poppins';
            line-height: 1.5;
            margin: 20px;
            color: #333;
            font-weight: 400;
        }
    
        /*.content-header h5 {*/
        /*    font-weight: 600;*/
        /*    color: #ff7700;*/
        /*}*/
    
        /* Container */
        .form-container {
            /*max-width: 1000px;*/
            margin: 0 auto;
            padding: 20px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    
        /* Table Styles */
        .table-header {
            background-color: #eef5f9;
            font-weight: 600;
            text-align: center;
        }
    
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
    
        /* Scrollbar for Table */
        .scrollbar {
            overflow-x: auto;
            margin-bottom: 15px;
        }
    
        .scrollbar table {
            min-width: 100%;
        }
    
        /* Pagination Controls */
        .pagination-controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }
    
        .dropdowns {
            width: 80px;
            display: inline-block;
        }
    
        .page-navigation {
            display: flex;
            align-items: center;
            gap: 5px;
        }
    
        .page-navigation span, .page-navigation i {
            background-color: #f5f5f5;
            padding: 5px 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
    
        .page-navigation span:hover, .page-navigation i:hover {
            background-color: #ddd;
        }
    
        /* Summary Section */
        .summary-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
            padding: 10px;
            background-color: #eef5f9;
            border-radius: 5px;
            font-weight: 600;
            color: #333;
        }
    
        .highlight-text {
            color: #ff7700;
            font-weight: 600;
        }
    
        /* Section Header */
        .section-header {
            background-color: #eef5f9;
            padding: 10px;
            border-radius: 5px 5px 0 0;
            font-weight: 600;
            color: #333;
            /*margin-bottom: 20px;*/
        }
    
        /* Buttons */
        .buttons button {
            margin-right: 10px;
            font-weight: 500;
        }
        
        body {
          font-family: Arial, sans-serif;
          font-size: 12px;
        }
        table {
            font-size: 13px;
          width: 100%;
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid black;
          padding: 5px;
          text-align: left;
        }
        .header-table {
          text-align: center;
          border: none;
          margin-bottom: 20px;
        }
        .section-title {
          font-weight: bold;
          text-align: center;
          padding: 10px 0;
        }
        .note {
          text-align: center;
          font-size: 12px;
          font-weight: bold;
          color: orange;
        }
        .summary-table th, .summary-table td {
          text-align: center;
        }
        .total-row td {
          font-weight: bold;
        }
        
        
            }
        table {
          width: 100%;
          border-collapse: collapse;
        }
        th, td {
          border: 1px solid black;
          padding: 8px;
          text-align: left;
        }
        /*th {*/
        /*  background-color: #f2f2f2;*/
        /*}*/
        .header {
          text-align: center;
          font-weight: bold;
          margin-bottom: 10px;
        }
        .total-row td {
          font-weight: bold;
          text-align: right;
        }
        .total-row td:first-child {
          text-align: left;
        }
        .note {
          font-size: 12px;
          font-weight: bold;
          color: orange;
          text-align: left;
        }
        .last td{
            text-align: center;
        }
    
    
    
      th {
            background-color: #f0f0f0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }
        /*th {*/
        /*    background-color: #f2f2f2;*/
        /*    text-align: center;*/
        /*}*/
        .section-title {
            font-weight: bold;
            margin: 20px 0 10px;
        }
        .no-border td {
            border: none;
        }
        .center {
            text-align: center;
        }
        
        
        
        table {
            border-collapse: collapse;
            width: 100%;
        }
        td {
            border: 1px solid black;
            vertical-align: top;
        }
        .design-cell {
            text-align: left;
            padding: 10px;
        }
        .box-container {
            display: flex;
            align-items: center;
            margin: 10px 0;
        }
        .box {
            width: 20px;
            height: 20px;
            border: 1px solid black;
            margin-right: 10px;
        }
        .line-text {
            flex: 1;
        }
    
    .custom-dropdown { position: relative; display: inline-block; }
    .custom-dropdown-btn { background-color: #007bff; color: white; border: none; padding: 8px 15px; cursor: pointer; border-radius: 5px; width: auto; white-space: nowrap; }
    .custom-dropdown-btn::after { display: none !important; }
    .custom-dropdown-menu { display: none; position: absolute; background-color: white; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1); min-width: 150px; padding: 5px 0; list-style: none; border-radius: 5px; z-index: 1050; max-height: 300px; overflow-y: auto; bottom: 100%; left: -75px; margin-bottom: 5px; }
    .custom-dropdown-item { padding: 8px 15px; display: block; text-decoration: none; color: black; cursor: pointer; }
    .custom-dropdown-item:hover { background-color: #f1f1f1; }
    .custom-dropdown.active .custom-dropdown-menu { display: block; }
</style>

<title>@lang('app.unfinished_tasks') | JPS</title>

@section('content')
<div class="col-md-12 content-header">
    <h5><i class="fa fa-file" aria-hidden="true"></i> @lang('app.unfinished_tasks')</h5>
</div>

<section class="content" >
    <div class="row">
        <div class="col-md-12">
            <div style="max-width: 100%; padding: 15px; border: 1px solid #ddd; border-radius: 8px; box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1); background: #fff;">
                <div style="overflow-x: auto; max-width: 100%;">
                    <table border="1" cellspacing="0" cellpadding="5" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <!--<th>@lang('app.modul')</th>-->
                                <th>@lang('app.process')</th>
                                <th>@lang('app.record_no')</th>
                                <th>@lang('app.reference_no')</th>
                                <th>@lang('app.department')</th>
                                <th>@lang('app.description_table')</th>
                                <th>@lang('app.bank/Company/Individu')</th>
                                <th>@lang('app.amount_table')</th>
                                <th>@lang('Status')</th>
                                <th>@lang('app.manager_name')</th>
                                <th>@lang('app.date')</th>
                                <th>@lang('app.day_no')</th>
                                <th>@lang('app.for_action')</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <!--<td>AR</td>-->
                                <td>Hantar</td>
                                <td>25CQPP050100009</td>
                                <td>25CQPP0500009</td>
                                <td>021000</td>
                                <td>PP0501 - PENYATA PEMUNGUT-AUTO</td>
                                <td>CIMB BANK BERHAD</td>
                                <td>63,512.00</td>
                                <td>Belum Selesai</td>
                                <td>NOORAZINI BINTI NAZIRUDDIN</td>
                                <td>10/01/2025</td>
                                <td>0</td>
                                <td>
                                    <a href="{{route('payment_report')}}" class="btn btn-success">@lang('app.view')</a><br><br>
                                    <div class="custom-dropdown" data-id="dropdown-1"> <!-- Unique ID for this row -->
                                        <button class="custom-dropdown-btn btn-primary" type="button">
                                            @lang('app.please_select')
                                        </button>
                                        <ul class="custom-dropdown-menu">
                                            <li><a class="custom-dropdown-item text-success" href="#" onclick="updateStatus(this, '@lang('app.accept')', 'btn-success')">@lang('app.accept')</a></li>
                                            <li><a class="custom-dropdown-item text-danger" href="#" onclick="updateStatus(this, '@lang('app.reject')', 'btn-danger')">@lang('app.reject')</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <!--<td>AR</td>-->
                                <td>Hantar</td>
                                <td>25CQPP050100008</td>
                                <td>25CQPP0500008</td>
                                <td>021000</td>
                                <td>PP0501 - PENYATA PEMUNGUT-AUTO</td>
                                <td>CIMB BANK BERHAD</td>
                                <td>7,286.00</td>
                                <td>Selesai</td>
                                <td>NOORAZINI BINTI NAZIRUDDIN</td>
                                <td>09/01/2025</td>
                                <td>1</td>
                                <td>
                                    <a href="{{route('payment_report')}}" class="btn btn-success">@lang('app.view')</a><br><br>
                                    <div class="custom-dropdown" data-id="dropdown-2"> <!-- Unique ID for second row -->
                                        <button class="custom-dropdown-btn btn-primary" type="button">
                                            @lang('app.please_select')
                                        </button>
                                        <ul class="custom-dropdown-menu">
                                            <li><a class="custom-dropdown-item text-success" href="#" onclick="updateStatus(this, '@lang('app.accept')', 'btn-success')">@lang('app.accept')</a></li>
                                            <li><a class="custom-dropdown-item text-danger" href="#" onclick="updateStatus(this, '@lang('app.reject')', 'btn-danger')">@lang('app.reject')</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                             
                        </tbody>
                    </table>
                </div>
            </div>
    </div>
</div>
</section> 
<script>
    function updateStatus(element, text, buttonColorClass) {
        let dropdown = element.closest('.custom-dropdown');
        let button = dropdown.querySelector('.custom-dropdown-btn');

        button.className = "custom-dropdown-btn " + buttonColorClass;
        button.innerText = text;

        // Save selection using a unique dropdown ID
        let dropdownId = dropdown.getAttribute("data-id");
        localStorage.setItem(dropdownId, JSON.stringify({ text, buttonColorClass }));

        // Close dropdown after selection
        dropdown.classList.remove('active');
    }

    function restoreSelection() {
        document.querySelectorAll('.custom-dropdown').forEach(dropdown => {
            let dropdownId = dropdown.getAttribute("data-id");
            let savedData = JSON.parse(localStorage.getItem(dropdownId));

            if (savedData) {
                let button = dropdown.querySelector('.custom-dropdown-btn');
                button.className = "custom-dropdown-btn " + savedData.buttonColorClass;
                button.innerText = savedData.text;
            }
        });
    }

    document.addEventListener("DOMContentLoaded", restoreSelection);

    document.querySelectorAll('.custom-dropdown-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            let dropdown = this.closest('.custom-dropdown');
            document.querySelectorAll('.custom-dropdown').forEach(d => { if (d !== dropdown) d.classList.remove('active'); });
            dropdown.classList.toggle('active');
            event.stopPropagation();
        });
    });

    document.addEventListener('click', function() {
        document.querySelectorAll('.custom-dropdown').forEach(dropdown => { dropdown.classList.remove('active'); });
    });
</script>                 

@endsection


