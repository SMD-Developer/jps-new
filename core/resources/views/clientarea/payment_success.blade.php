@extends('clientarea.app')
  <title>Payment Success</title>
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
    .transaction-box {
  /*max-width: 500px;*/
  /*width: 100%;*/
}

  </style>
<title>@lang('app.successful_payment') | JPS</title>
@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-check-circle nav-icon"></i> @lang('app.successful_payment') </h5>
    </div>
    <section class="content d-flex flex-column align-items-center text-center">
        <div class="mb-4">
            <img src="{{asset('assets/images/uploads/client_images/image (1).png')}}" 
                 class="img-fluid" alt="..." width="111px">
        </div>
        <p class="fw-bold pb-3">@lang('app.successful_payment')</p>
        <p class="fw-bold">@lang('app.your_payment_has_been_received_Please_wait_while_your_account_is_updated')</p>
        <p class="fw-bold">@lang('app.invoices_receipts_will_be_sent_via_email')</p>
        
        <div class="transaction-box shadow-sm">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-dark fw-bold">FPX Txn ID</div>
                    <div class="text-muted">20250811M00086558610BW00000610</div>
                    <div class="text-dark fw-bold mt-3">@lang('app.total_payment')</div>
                    <div class="text-muted">RM 6.00</div>
                </div>
                <div class="col-md-6 text-md-end mt-3 mt-md-0">
                    <div class="text-dark fw-bold">@lang('app.date') &amp; @lang('app.transaction_time')</div>
                    <div class="text-muted">11 Aug 2025 02:54:57 PM</div>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <a href="#" class="btn btn-outline-primary me-2 rounded-pill px-5">@lang('app.view_receipts')</a>
            <a href="https://jpsmy.smddeveloper.com/clientarea/application-status" class="btn btn-primary rounded-pill px-5">@lang('app.dashboard')</a>
        </div>
    </section>
@endsection








