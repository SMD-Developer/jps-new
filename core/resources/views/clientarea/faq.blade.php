@extends('clientarea.app')

<style>
    .accordion-title:before {
    float: right !important;
    font-family: FontAwesome;
    content:"\f068";
    padding-right: 5px;
}
.accordion-title.collapsed:before {
    float: right !important;
    content:"\f067";
}
</style>
<title>@lang('app.faq') | JPS</title>
@section('content')

<div class="col-md-12 content-header">
        <h6><i class="fa fa-question-circle nav-icon"></i> @lang('app.faq')</h6>
    </div>
<section class="pb-5">
    <div class="container" style="width: 99%;">
        <div id="accordion" class="mb-5">

            <div class="card">
    <div class="card-header">
      <a class="card-link accordion-title" data-toggle="collapse" href="#collapseOne">
        <h6>1. @lang('app.what_is_online_contribution_payment_system?')</h6>
      </a>
    </div>
    <div id="collapseOne" class="collapse show" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.the_online_ditch_contribution_payment_system')</p>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseTwo">
        <h6>2. @lang('app.how_can_make_an_online_contribution_payment')</h6>
      </a>
    </div>
    <div id="collapseTwo" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.to_make_a_payment')</p>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseThree">
       <h6>3. @lang('app.do_i_need_to_register_an_account')</h6> 
      </a>
    </div>
    <div id="collapseThree" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.yes_to_make_a_payment')</p>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseFour">
       <h6>4. @lang('app.what_if_i_forget_the_password')</h6> 
      </a>
    </div>
    <div id="collapseFour" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.if_you_have_forgotten_your_password')</p>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseFive">
       <h6>5. @lang('app.are_there_additional_fees_for_making_payments_online')</h6> 
      </a>
    </div>
    <div id="collapseFive" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.additional_fees_depend_on_the_payment_method_selected')</p>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseSix">
       <h6>6. @lang('app.is_my_transaction_safe')</h6> 
      </a>
    </div>
    <div id="collapseSix" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.yes_this_system_uses_ssl_encryption_technology')</p>
      </div>
    </div>
  </div>

 <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseSeven">
       <h6>7. @lang('app.i_have_made_a_payment')</h6> 
      </a>
    </div>
    <div id="collapseSeven" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.once_the_payment_is_complete')</p>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseEight">
       <h6>8. @lang('app.how_can_i_contact')</h6> 
      </a>
    </div>
    <div id="collapseEight" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.if_you_face_any_problems')</p>
      </div>
    </div>
  </div>

<div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseNine">
       <h6>9. @lang('app.how_do_i_update_my_account_information')</h6> 
      </a>
    </div>
    <div id="collapseNine" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.you_can_update_account')</p>
      </div>
    </div>
  </div>
  
  <div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseTen">
       <h6>10. @lang('app.will_i_receive_the_receipt')</h6> 
      </a>
    </div>
    <div id="collapseTen" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.yes_after_successful_payment')</p>
      </div>
    </div>
  </div>

<div class="card">
    <div class="card-header">
      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseEleven">
       <h6>11. @lang('app.how_can_i_amount_to_be_paid')</h6> 
      </a>
    </div>
    <div id="collapseEleven" class="collapse" data-parent="#accordion">
      <div class="card-body">
        <p>@lang('app.the_amount_of_contribution')</p>
      </div>
    </div>
  </div>

<!--<div class="card">-->
<!--    <div class="card-header">-->
<!--      <a class="collapsed card-link accordion-title" data-toggle="collapse" href="#collapseTwelve">-->
<!--       <h6>Collapsible Group Item #3</h6> -->
<!--      </a>-->
<!--    </div>-->
<!--    <div id="collapseTwelve" class="collapse" data-parent="#accordion">-->
<!--      <div class="card-body">-->
<!--        <p>Lorem ipsum..</p>-->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->

<!--</div>-->
</div>
</section>
@endsection