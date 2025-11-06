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
       content: "\25BC";
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

   .error-field {
       border-color: #dc3545 !important;
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
                        action="{{ route('report-collection-by-method') }}">
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
                                    
                                    <!-- Payment Method Dropdown -->
                                    <tr>
                                        <td class="label">{{ trans('app.payment_method') }} : </td>
                                        <td>
                                            <div class="dropdownn">
                                                <button type="button" id="methodDropdownBtn" onclick="toggleMethodDropdown()" class="dropbtn form-control">
                                                    @lang('app.select_payment_method')
                                                </button>
                                                <div id="methodDropdown" class="dropdown-content">
                                                    <input type="text" placeholder="Search.." id="methodSearch"
                                                        onkeyup="filterMethods()" onclick="event.stopPropagation();">
                                                    <a href="#" onclick="selectMethod('Semua', '')">Semua</a>
                                                    <a href="#" onclick="selectMethod('EFT', 'EFT')">EFT</a>
                                                    <a href="#" onclick="selectMethod('FPX B2B', 'FPX_B2B')">FPX B2B</a>
                                                    <a href="#" onclick="selectMethod('FPX B2C', 'FPX_B2C')">FPX B2C</a>
                                                    <a href="#" onclick="selectMethod('Kad Kredit', 'kad_kredit')">Kad Kredit</a>
                                                    <a href="#" onclick="selectMethod('Kad Debit', 'kad_debit')">Kad Debit</a>
                                                    <a href="#" onclick="selectMethod('Baucar Bayaran Agensi Kerajaan', 'EFT')">Baucar Bayaran Agensi Kerajaan</a>
                                                </div>
                                            </div>
                                            <input type="hidden" id="selectedMethodValue" name="payment_method" value="">
                                        </td>
                                    </tr>

                                    <!-- Payment Status Dropdown -->
                                    <tr>
                                        <td class="label">{{ trans('app.payment_status') }} : </td>
                                        <td>
                                            <div class="dropdownn">
                                                <button type="button" id="statusDropdownBtn" onclick="toggleStatusDropdown()" class="dropbtn form-control">
                                                    @lang('app.select_status')
                                                </button>
                                                <div id="statusDropdown" class="dropdown-content">
                                                    <input type="text" placeholder="Search.." id="statusSearch"
                                                        onkeyup="filterStatus()" onclick="event.stopPropagation();">
                                                    <a href="#" onclick="selectStatus('Semua', '')">Semua</a>
                                                    <a href="#" onclick="selectStatus('Completed', 'completed')">Selesai</a>
                                                    <a href="#" onclick="selectStatus('Pending', 'pending')">Belum Bayar</a>
                                                    <a href="#" onclick="selectStatus('Failed', 'failed')">Pembayaran Gagal</a>
                                                </div>
                                            </div>
                                            <input type="hidden" id="selectedStatusValue" name="payment_status" value="">
                                        </td>
                                    </tr>

                                    <tr>
                                        <td class="label">{{ trans('app.start_date') }} : </td>
                                        <td><input type="date" id="start_date" class="form-control" name="start_date" value="" required
                                                onchange="validateDates()"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">{{ trans('app.until_date') }} : </td>
                                        <td><input type="date" id="end_date" class="form-control" name="end_date" value="" required
                                                onchange="validateDates()"></td>
                                    </tr>
                                    <tr>
                                        <td class="label">{{ trans('app.print_type') }} :</td>
                                        <td>
                                            <select class="form-select w-100" name="print_type"
                                                style="border: 1px solid #ced4da;">
                                                <option value="PDF" selected>PDF</option>
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
// Payment Method Dropdown Functions
function toggleMethodDropdown() {
    const dropdown = document.getElementById("methodDropdown");
    dropdown.classList.toggle("show");
    document.getElementById("statusDropdown").classList.remove("show");
}

function selectMethod(displayText, value) {
    document.getElementById('methodDropdownBtn').textContent = displayText;
    document.getElementById("selectedMethodValue").value = value;
    document.getElementById("methodDropdown").classList.remove("show");
    validatePaymentMethod();
}

function filterMethods() {
    const input = document.getElementById("methodSearch");
    const filter = input.value.toUpperCase();
    const dropdown = document.getElementById("methodDropdown");
    const links = dropdown.getElementsByTagName("a");
    
    for (let i = 0; i < links.length; i++) {
        const txtValue = links[i].textContent || links[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            links[i].style.display = "";
        } else {
            links[i].style.display = "none";
        }
    }
}

// Payment Status Dropdown Functions
function toggleStatusDropdown() {
    const dropdown = document.getElementById("statusDropdown");
    dropdown.classList.toggle("show");
    document.getElementById("methodDropdown").classList.remove("show");
}

function selectStatus(displayText, value) {
    document.getElementById('statusDropdownBtn').textContent = displayText;
    document.getElementById("selectedStatusValue").value = value;
    document.getElementById("statusDropdown").classList.remove("show");
    validatePaymentStatus();
}

function filterStatus() {
    const input = document.getElementById("statusSearch");
    const filter = input.value.toUpperCase();
    const dropdown = document.getElementById("statusDropdown");
    const links = dropdown.getElementsByTagName("a");
    
    for (let i = 0; i < links.length; i++) {
        const txtValue = links[i].textContent || links[i].innerText;
        if (txtValue.toUpperCase().indexOf(filter) > -1) {
            links[i].style.display = "";
        } else {
            links[i].style.display = "none";
        }
    }
}

// Validation Functions
function validatePaymentMethod() {
    const methodBtn = document.getElementById('methodDropdownBtn');
    const methodBtnText = methodBtn.textContent.trim();
    const errorDiv = document.getElementById("error-message");
    
    if (methodBtnText === '@lang('app.select_payment_method')') {
        methodBtn.classList.add('error-field');
        showError("Please select a payment method.");
        return false;
    } else {
        methodBtn.classList.remove('error-field');
        clearError();
        return true;
    }
}

function validatePaymentStatus() {
    const statusBtn = document.getElementById('statusDropdownBtn');
    const statusBtnText = statusBtn.textContent.trim();
    const errorDiv = document.getElementById("error-message");
    
    if (statusBtnText === '@lang('app.select_status')') {
        statusBtn.classList.add('error-field');
        showError("Please select a payment status.");
        return false;
    } else {
        statusBtn.classList.remove('error-field');
        clearError();
        return true;
    }
}

function validateDates() {
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const startDate = startDateInput.value;
    const endDate = endDateInput.value;
    
    // Remove error styling first
    startDateInput.classList.remove('error-field');
    endDateInput.classList.remove('error-field');

    // Check if dates are selected
    if (!startDate || !endDate) {
        if (!startDate) startDateInput.classList.add('error-field');
        if (!endDate) endDateInput.classList.add('error-field');
        showError("Both start date and end date are required.");
        return false;
    }

    // Check date range
    const start = new Date(startDate);
    const end = new Date(endDate);

    if (end < start) {
        endDateInput.classList.add('error-field');
        showError("End date cannot be earlier than start date.");
        return false;
    }

    // Check if date range is not too large (optional - max 1 year)
    const daysDifference = Math.ceil((end - start) / (1000 * 60 * 60 * 24));
    if (daysDifference > 365) {
        endDateInput.classList.add('error-field');
        showError("Date range cannot exceed 1 year.");
        return false;
    }

    clearError();
    return true;
}

function showError(message) {
    const errorDiv = document.getElementById("error-message");
    const submitButton = document.getElementById("submitButton");
    errorDiv.textContent = message;
    errorDiv.style.display = "block";
    submitButton.disabled = true;
}

function clearError() {
    const errorDiv = document.getElementById("error-message");
    const submitButton = document.getElementById("submitButton");
    errorDiv.style.display = "none";
    submitButton.disabled = false;
}

// Form submission validation
document.getElementById('filterForm').addEventListener('submit', function(event) {
    const isMethodValid = validatePaymentMethod();
    const isStatusValid = validatePaymentStatus();
    const areDatesValid = validateDates();

    if (!isMethodValid || !isStatusValid || !areDatesValid) {
        event.preventDefault();
        
        // Show which field is invalid
        if (!isMethodValid) {
            showError("Please select a payment method.");
        } else if (!isStatusValid) {
            showError("Please select a payment status.");
        } else if (!areDatesValid) {
            // Error already shown by validateDates()
        }
        
        return false;
    }
    
    return true;
});

// Close dropdowns when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn') && !event.target.matches('input[type="text"]')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.remove('show');
        }
    }
}

// Set default dates to today on page load
document.addEventListener("DOMContentLoaded", function() {
    const today = new Date().toISOString().split('T')[0];
    
    if (!document.getElementById('start_date').value) {
        document.getElementById('start_date').value = today;
    }

    if (!document.getElementById('end_date').value) {
        document.getElementById('end_date').value = today;
    }

    // Initial validation
    validateDates();
});

// Prevent form submission with Enter key in dropdowns
document.getElementById('methodSearch').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});

document.getElementById('statusSearch').addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        event.preventDefault();
    }
});
</script>

@endsection