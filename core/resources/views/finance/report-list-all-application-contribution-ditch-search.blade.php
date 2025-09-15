@extends('app')
<style>
    .dropdownn {
       position: relative;
       display: inline-block;
       width: 100%;
   }

   .dropbtn {
   background-color: #fff;
   color: black;
   padding: 10px;
   width: 100%;
   border: 1px solid #ced4da;
   text-align: left;
   cursor: pointer;
   position: relative;
   }
   
   .dropbtn::after {
       content: "\25BC"; /* Unicode for a downward arrow */
       position: absolute;
       right: 10px;
       top: 50%;
       transform: translateY(-50%);
       font-size: 14px;
       color: #555;
   }


   .dropdown-content {
       display: none;
       position: absolute;
       background-color: white;
       width: 100%;
       max-height: 200px;
       overflow-y: auto;
       border: 1px solid #ddd;
       z-index: 10;
   }

   .dropdown-content a {
       padding: 10px;
       display: block;
       text-decoration: none;
       color: black;
   }

   .dropdown-content a:hover {
       background-color: #f1f1f1;
   }

   .dropdownn input {
       width: 100%;
       padding: 8px;
       border: none;
       outline: none;
       box-sizing: border-box;
   }

   .show {
       display: block;
   }
</style>

<title>{{$title}} | JPS</title>

@section('content')
<div class="col-md-12 content-header">
   <h5><i class="fa fa-file" aria-hidden="true"></i> {{$title}}</h5>
</div>

<section class="card p-5 m-5">
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-12">
                    <form id="filterForm" method="GET"
                        action="{{ route('report-list-all-application-contribution-ditch') }}">
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
                                    <td class="label">{{ trans('app.account_type') }} : </td>
                                    <td>
                                        <div class="dropdownn">
                                            <button type="button" onclick="toggleDropdown()" class="dropbtn form-control">
                                                @lang('app.select_account')
                                            </button>
                                            <div id="districtDropdown" class="dropdown-content">
                                                <input type="text" placeholder="Search.." id="districtSearch"
                                                    onkeyup="filterDistricts()" onclick="event.stopPropagation();">
                                                <a href="#" onclick="selectDistrict('Semua')">Semua</a>
                                                @foreach ($accountTypes as $accountType)
                                                    <a href="#"
                                                        onclick="selectDistrict('{{ $accountType->name }}', '{{ $accountType->id }}')">{{ $accountType->name }}</a>
                                                @endforeach
                                            </div>
                                        </div>
                                        <input type="hidden" id="selectedAccountTypeId" name="account_type_id"
                                            value="">
                                    </td>
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
                        <button type="submit" id="submitButton"
                            class="btn btn-primary float-right">@lang('app.next')</button>
                    </form>
                </div>
   </div>
 </div>
</section>
  <script>
        // Toggle account type dropdown
        function toggleDropdown() {
            document.getElementById("districtDropdown").classList.toggle("show");
        }

        // Filter account type dropdown items
        function filterDistricts() {
            const input = document.getElementById("districtSearch");
            const filter = input.value.toUpperCase();
            const div = document.getElementById("districtDropdown");
            const a = div.getElementsByTagName("a");

            for (let i = 0; i < a.length; i++) {
                const txtValue = a[i].textContent || a[i].innerText;
                a[i].style.display = txtValue.toUpperCase().indexOf(filter) > -1 ? "" : "none";
            }
        }

        // Select an account type
        function selectDistrict(accountTypeName, accountTypeId = null) {
            document.querySelector('.dropbtn').textContent = accountTypeName;

            // Store the ID in a hidden input for form submission
            document.getElementById('selectedAccountTypeId').value = accountTypeId || '';
            document.getElementById("districtDropdown").classList.remove("show");
            validateAccountTypeSelection();
        }

        // Close dropdown when clicking outside
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

        // Date validation
        function validateDates() {
            const startDate = document.querySelector('input[name="start_date"]').value;
            const endDate = document.querySelector('input[name="end_date"]').value;
            const submitButton = document.getElementById("submitButton");
            const errorDiv = document.getElementById("error-message");

            // Check if dates are selected
            if (!startDate || !endDate) {
                errorDiv.textContent = "Both start date and end date are required.";
                errorDiv.style.display = "block";
                submitButton.disabled = true;
                return false;
            }

            // Check date range
            const start = new Date(startDate);
            const end = new Date(endDate);

            if (end < start) {
                errorDiv.textContent = "End date cannot be earlier than start date.";
                errorDiv.style.display = "block";
                submitButton.disabled = true;
                return false;
            } else {
                // Only clear date-related errors
                if (errorDiv.textContent === "End date cannot be earlier than start date." ||
                    errorDiv.textContent === "Both start date and end date are required.") {
                    errorDiv.style.display = "none";
                    submitButton.disabled = false;
                }
                return true;
            }
        }

        function validateAccountTypeSelection() {
            const selectedAccountTypeId = document.getElementById('selectedAccountTypeId').value;
            const dropbtnText = document.querySelector('.dropbtn').textContent.trim();
            const errorDiv = document.getElementById("error-message");
            const submitButton = document.getElementById("submitButton");

            if ((selectedAccountTypeId === '' || selectedAccountTypeId === null) &&
                dropbtnText === '@lang('app.select_account')') {
                errorDiv.textContent = "Please select an account type.";
                errorDiv.style.display = "block";
                submitButton.disabled = true;
                return false;
            } else {
                if (errorDiv.textContent === "Please select an account type.") {
                    errorDiv.style.display = "none";
                    submitButton.disabled = false;
                }
                return true;
            }
        }

        
        document.getElementById('filterForm').addEventListener('submit', function(event) {
            const isAccountTypeValid = validateAccountTypeSelection();
            const areDatesValid = validateDates();

            if (!isAccountTypeValid || !areDatesValid) {
                event.preventDefault(); 
            }
        });

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