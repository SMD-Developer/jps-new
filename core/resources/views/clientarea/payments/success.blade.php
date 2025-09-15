<!DOCTYPE html>
<html>
<head>
  <title>Payment Status</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <style>
    .transaction-box {
      border: 1px solid #eee;
      border-radius: 15px;
      padding: 20px;
      display: inline-block;
      margin: 20px auto;
      text-align: left;
      background: white;
    }
    .btn-outline-primary {
      border-width: 2px;
      font-weight: 500;
      border-radius: 50px;
      padding: 10px 25px;
    }
    .btn-primary {
      border-radius: 50px;
      padding: 10px 25px;
    }
    .small-text {
      font-size: 14px;
      color: #666;
    }
    .text-dark{
      color: #090909;
    }
    .infoBelow {
      font-family: Arial, sans-serif;
    }
    .normal {
      font-size: 16px;
      margin-bottom: 15px;
    }
    .main {
      font-size: 14px;
      padding: 5px 0;
    }
    .status-image {
      max-width: 150px;
      height: auto;
      margin-bottom: 20px;
    }
  </style>
</head>
<body>
  @if(auth('user')->check())
    <input type="hidden" id="client_uuid" value="{{ auth('user')->user()->uuid }}">
  @endif

  <div class="container text-center py-4">
    <!--<div class="mb-4">-->
    <!--  <img src="{{ asset('assets/images/uploads/client_images/image (1).png') }}" -->
    <!--       class="img-fluid" alt="JPS Logo" width="111px">-->
    <!--</div>-->
    
    @php
        // Determine transaction status for image display
        $transactionStatus = '';
        if($val == "00") {
            if($fpx_debitAuthCode == '00') {
                $transactionStatus = 'SUCCESSFUL';
            } elseif($fpx_debitAuthCode == '99') {
                $transactionStatus = 'PENDING';
            } else {
                $transactionStatus = 'UNSUCCESSFUL';
            }
        } else {
            $transactionStatus = 'UNSUCCESSFUL';
        }
    @endphp
    
    <!-- Conditional Status Image -->
    <div class="mb-3">
        @if($transactionStatus == 'SUCCESSFUL')
            <!-- Success Image -->
            <img src="{{ asset('assets/images/uploads/client_images/image (1).png') }}" 
           class="img-fluid" alt="JPS Logo" width="111px">
        @elseif($transactionStatus == 'PENDING')
            <!-- Pending Image -->
            <img src="{{ asset('assets/images/uploads/client_images/pending-icon.png') }}" 
                 class="img-fluid status-image" alt="Pending" width="120px">
        @else
            <!-- Unsuccessful Image (Your new image goes here) -->
            <img src="{{ asset('assets/images/remove.png') }}" 
                 class="img-fluid status-image" alt="Failed" width="120px">
        @endif
    </div>
    
    <h1 class="fw-bold pb-3">Payment Status</h1>
    <p class="fw-bold">
        @if($transactionStatus == 'SUCCESSFUL')
            Your payment has been received. Please wait while your account is updated.
        @elseif($transactionStatus == 'PENDING')
            Your payment is pending approval. Please wait for confirmation.
        @else
            Payment was unsuccessful. Please try again or contact support.
        @endif
    </p>
    
    @if($transactionStatus == 'SUCCESSFUL')
        <p class="fw-bold">Invoices/receipts will be sent via email.</p>
    @endif
    
    <div class="transaction-box shadow-sm" style="max-width: 800px;">
      <table width="100%" align="center" class="infoBelow">
        @if($val == "00")
          <tr>
            <td width="44%" align="left" class="main">Transaction Status</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">
              <strong style="color: 
                @if($fpx_debitAuthCode == '00') green 
                @elseif($fpx_debitAuthCode == '99') orange 
                @else red @endif">
                @if($fpx_debitAuthCode == '00')
                  SUCCESSFUL
                @elseif($fpx_debitAuthCode == '99')
                  PENDING FOR AUTHORIZER TO APPROVE
                @else
                  UNSUCCESSFUL
                @endif
              </strong>
            </td>
          </tr>
          <tr>
            <td width="44%" align="left" class="main">FPX Txn ID</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">{{ $fpx_fpxTxnId }}</td>
          </tr>
          <tr>
            <td width="44%" align="left" class="main">Seller Order Number</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">{{ $fpx_sellerOrderNo }}</td>
          </tr>
          <tr>
            <td width="44%" align="left" class="main">Buyer Bank</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">{{ $fpx_buyerBankBranch }}</td>
          </tr>
          <tr>
            <td width="44%" align="left" class="main">Transaction Amount</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">RM {{ number_format($fpx_txnAmount, 2) }}</td>
          </tr>
          <tr>
            <td width="44%" align="left" class="main">Transaction Time</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">{{ date('d M Y h:i:s A', strtotime($fpx_sellerTxnTime)) }}</td>
          </tr>
        @else
          <tr>
            <td colspan="3" align="center" class="main">{{ $ErrorCode }}</td>
          </tr>
        @endif
      </table>
    </div>
    
    <div class="mt-4">
        @php
            // Get the application_id from the payments table using fpx_sellerOrderNo
            $paymentRecord = DB::table('payments')
                              ->where('seller_order_no', $fpx_sellerOrderNo)
                              ->first();
            
            $application_id = $paymentRecord->application_id ?? null;
        @endphp
        
      @if($transactionStatus == 'SUCCESSFUL')
        <a href="{{ route('pay.status') }}" class="btn btn-primary me-2">Check Status</a>
        <a href="{{ route('user_copy_receipt', ['id' => $application_id]) }}" 
           class="btn btn-outline-primary me-2 rounded-pill px-5">
            @lang('app.view_receipts')
        </a>
        <a href="{{ route('client_application_status') }}" class="btn btn-primary rounded-pill px-5">
            @lang('app.dashboard')
        </a>
      @elseif($transactionStatus == 'PENDING')
        <a href="{{ route('pay.status') }}" class="btn btn-warning me-2">Check Status</a>
        <a href="{{ route('clients.home') }}" class="btn btn-primary rounded-pill px-5">
            @lang('app.dashboard')
        </a>
      @else
        <!-- Unsuccessful - Show retry options -->
        <a href="{{ route('clients.home') }}" class="btn btn-outline-primary rounded-pill px-5">
            @lang('app.dashboard')
        </a>
      @endif
    </div>
    
  </div>

  <script>
    // You can use the client_uuid in JavaScript if needed
    const clientUuid = document.getElementById('client_uuid')?.value;
    if (clientUuid) {
      console.log('Client UUID:', clientUuid);
      // Additional client-specific JavaScript can go here
    }
  </script>
</body>
</html>