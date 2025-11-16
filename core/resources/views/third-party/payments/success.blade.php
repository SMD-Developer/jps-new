<!DOCTYPE html>
<html>
<head>
  <title>Payment Status - Third Party</title>
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
  @if(auth('third_party')->check())
    <input type="hidden" id="third_party_id" value="{{ auth('third_party')->user()->id }}">
  @endif

  <div class="container text-center py-4">
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
            <img src="{{ asset('assets/images/pending-icon.png') }}" 
                 class="img-fluid status-image" alt="Pending" width="120px">
        @else
            <!-- Unsuccessful Image -->
            <img src="{{ asset('assets/images/remove.png') }}" 
                 class="img-fluid status-image" alt="Failed" width="120px">
        @endif
    </div>
    
    <h1 class="fw-bold pb-3">Payment Status - Third Party</h1>
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
                  UNSUCCESSFUL (Error Code: {{ $fpx_debitAuthCode }})
                @endif
              </strong>
            </td>
          </tr>
          @if(!empty($fpx_fpxTxnId))
          <tr>
            <td width="44%" align="left" class="main">FPX Txn ID</td>
            <td width="7%" align="center" class="main">:</td>
            <td width="49%" align="left" class="main">{{ $fpx_fpxTxnId }}</td>
          </tr>
          @endif
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
            <td width="49%" align="left" class="main">
              {{ \Carbon\Carbon::createFromFormat('YmdHis', $fpx_sellerTxnTime)->format('d M Y h:i:s A') }}
            </td>
          </tr>
        @else
          <tr>
            <td colspan="3" align="center" class="main">
              <div class="alert alert-danger">{{ $ErrorCode ?? 'Signature verification failed' }}</div>
            </td>
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
            
            // Get the application to check if it's legacy
            $application = null;
            $isLegacy = false;
            if ($application_id) {
                $application = DB::table('applications')
                                ->where('id', $application_id)
                                ->first();
                
                // Check if legacy (before 16 Nov 2024)
                if ($application) {
                    $isLegacy = \Carbon\Carbon::parse($application->created_at)->lt('2025-11-16');
                }
            }
        @endphp
        
        @if($transactionStatus == 'SUCCESSFUL')
            @if($isLegacy)
                {{-- Legacy Application - Show Submit Request Button --}}
                <button class="btn btn-primary me-2 submit-request-after-payment"
                        data-application-id="{{ $application_id }}"
                        style="border-radius: 50px; padding: 10px 25px;">
                    <i class="fa fa-paper-plane"></i> Hantar Permohonan Resit
                </button>
                
                <a href="{{ route('third.party.dashboard') }}" 
                  class="btn btn-secondary me-2"
                  style="border-radius: 50px; padding: 10px 25px;">
                    <i class="fa fa-home"></i> Dashboard
                </a>
                
                <p class="mt-3 text-muted fw-semibold" style="font-size: 14px;">
                    <strong>Nota:</strong> Sila klik butang "Hantar Permohonan Resit" untuk mengemukakan permohonan anda kepada pentadbir. 
                    Resit akan diproses dalam masa 1-3 hari bekerja.
                </p>
            @else
                {{-- New Application - Show View Receipt Button --}}
                <a href="{{ route('third.party.receipt.copy', $application_id) }}" 
                  class="btn btn-outline-primary me-2" 
                  target="_blank"
                  style="border-radius: 50px; padding: 10px 25px;">
                    <i class="fa fa-file-pdf-o"></i> Lihat Resit
                </a>
                
                <a href="{{ route('third.party.dashboard') }}" 
                  class="btn btn-secondary me-2"
                  style="border-radius: 50px; padding: 10px 25px;">
                    <i class="fa fa-home"></i> Dashboard
                </a>
                
                <p class="mt-3 text-muted fw-semibold" style="font-size: 14px;">
                    <strong>Nota:</strong> Sila klik 'Lihat Resit' untuk cetak resit.
                </p>
            @endif
            
        @elseif($transactionStatus == 'PENDING')
            <!-- Dashboard Button -->
            <a href="{{ route('third.party.dashboard') }}" 
              class="btn btn-secondary me-2">
                <i class="fa fa-home"></i> Dashboard
            </a>
            
            <p class="mt-3 text-muted fw-semibold" style="font-size: 14px;">
                <strong>Nota:</strong> Pembayaran anda sedang menunggu kelulusan. Sila semak status kemudian.
            </p>
            
        @else
            <!-- Dashboard Button -->
            <a href="{{ route('third.party.dashboard') }}" 
              class="btn btn-secondary me-2">
                <i class="fa fa-home"></i> Dashboard
            </a>
            
            <p class="mt-3 text-muted fw-semibold" style="font-size: 14px;">
                <strong>Nota:</strong> Pembayaran tidak berjaya. Sila cuba semula atau hubungi sokongan dengan nombor pesanan: <strong>{{ $fpx_sellerOrderNo }}</strong>
            </p>
        @endif
    </div>
    
  </div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const thirdPartyId = document.getElementById('third_party_id')?.value;
    if (thirdPartyId) {
      console.log('Third Party ID:', thirdPartyId);
      console.log('Transaction Status:', '{{ $transactionStatus }}');
      console.log('Order Number:', '{{ $fpx_sellerOrderNo }}');
      
      // You can add additional third-party specific tracking here
      @if($transactionStatus == 'SUCCESSFUL')
        console.log('Payment successful for third-party user');
      @elseif($transactionStatus == 'PENDING')
        console.log('Payment pending authorization');
      @else
        console.log('Payment failed with code:', '{{ $fpx_debitAuthCode }}');
      @endif
    }
  </script>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitBtn = document.querySelector('.submit-request-after-payment');
        
        if (submitBtn) {
            submitBtn.addEventListener('click', function() {
                const applicationId = this.getAttribute('data-application-id');
                
                Swal.fire({
                    title: 'Hantar Permohonan',
                    html: `
                        <div class="text-center">
                            <p>Permohonan anda akan dihantar kepada pentadbir untuk kelulusan.</p>
                            <p><strong>Tempoh pemprosesan: 1-3 hari bekerja</strong></p>
                        </div>
                    `,
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#17a2b8',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Hantar',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit request
                        fetch('{{ route("third.party.submit.request") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                application_id: applicationId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: 'Berjaya!',
                                    html: `
                                        <p>Permohonan anda telah dihantar.</p>
                                        <p>Anda akan dimaklumkan melalui email apabila resit sudah sedia.</p>
                                    `,
                                    icon: 'success',
                                    confirmButtonText: 'OK'
                                }).then(() => {
                                    window.location.href = '{{ route("third.party.dashboard") }}';
                                });
                            } else {
                                Swal.fire('Ralat!', data.message, 'error');
                            }
                        })
                        .catch(error => {
                            Swal.fire('Ralat!', 'Sila cuba lagi.', 'error');
                        });
                    }
                });
            });
        }
    });
</script>
</body>
</html>