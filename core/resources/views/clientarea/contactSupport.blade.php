@extends('clientarea.app')

<style>
    .ag-format-container {
        width: 1020px;
        margin: 0 auto;
    }

    body {
        background-color: #000;
    }

    .ag-courses_box {
    display: flex;
    align-items: stretch; /* Ensure all child items have the same height */
    justify-content: center;
    
    padding: 50px 0;
    gap: 20px;
}

.row{
    justify-content: center;
    padding: 50px 0;
}

    .ag-courses_item {
    flex: 1;
    /*max-width: 30%;*/
    margin: 0;
    overflow: hidden;
    border-radius: 28px;
    display: flex;
    flex-direction: column; 
}

    .ag-courses-item_link {
    /* display: flex; */
    /* flex-direction: column; */
     /* Stack content vertically */
    /* justify-content: space-between; */
     /* Spread out content within the card */
    padding: 30px 20px;
    background-color: #fff;
    overflow: hidden;
    position: relative;
    height: 100%; /* Ensure the link fills the full height of the parent */
}


   .ag-courses-item_title {
    margin-bottom: auto; /* Push title upwards to maintain spacing */
    font-weight: bold;
    font-size: 24px;
    color: #000000;
    position: relative;
    z-index: 2;
}

    .ag-courses-item_date-box {
    font-size: 15px;
    color: #000000;
    position: relative;
    z-index: 2;
}

    .ag-courses-item_date {
        font-weight: bold;
        color: #1991EE;
        transition: color 0.5s ease;
    }

    .ag-courses-item_bg {
    height: 128px;
    width: 128px;
    background-color: #1991EE;
    position: absolute;
    top: -75px;
    right: -75px;
    border-radius: 50%;
    transition: all 0.5s ease;
    z-index: 1;
}

/* Show by default */
.hide-on-mobile {
  display: block; 
}

@media (max-width: 768px) {
  .hide-on-mobile {
    display: none;
  }
}



.mobile-view-only {
  display: none;
}

@media (max-width: 768px) {
  .mobile-view-only {
    display: block; 
  }
  
  .ag-courses_item {
          height: 267px;
  }
}

</style>

<title>@lang('app.contact_support') | JPS</title>

@section('content')
    <div class="col-md-12 content-header">
        <h5><i class="fa fa-phone nav-icon"></i> @lang('app.contact_support')</h5>
    </div>

<!--<div class="container">-->
<!--    <div class="row">-->
<!--        <div class="col-12">-->
<!--            <h2 class="text-center">@lang('app.get_in_touch')</h2>-->
<!--            <p class="text-center">@lang('app.we_are_always_open')</p>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

<div class="container mobile-view-only">
    <div class="row">
        <div class="col-md-4 mb-5">
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title mb-3">
                        <img src="{{asset('assets/images/icon/pin.png')}}" width="10%" >
                        @lang('app.address')
                    </div>
                    <div class="ag-courses-item_date-box">
                        @lang('app.address') - <br>
                        <span class="ag-courses-item_date">Jabatan Pengairan dan Saliran Negeri Selangor
                            <br>
                            Tingkat 5, Podium Selatan,<br>
                            Bangunan Sultan <br>
                            Salahuddin Abdul Aziz <br>
                            Shah, 40626 Shah Alam, Selangor.    
                        </span>
                    </div>
                </a>
            </div>
        </div>
        
        
        <div class="col-md-4 mb-5">
            <div class="ag-courses_item">
                <a href="mailto:contactsupport@jps.com" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title mb-3">
                        <img src="{{asset('assets/images/icon/mail.png')}}" width="10%" >
                        @lang('app.email')
                    </div>
                    <div class="ag-courses-item_date-box">
                        @lang('app.email_id') -
                        <a<span class="ag-courses-item_date">contactsupport@jps.com</span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-4 mb-5">
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                    <div class="ag-courses-item_bg"></div>
                    <div class="ag-courses-item_title mb-3"><img src="{{asset('assets/images/icon/support.png')}}" width="10%" >
                        @lang('app.contact_us')
                    </div>
                    <div class="ag-courses-item_date-box">
                        @lang('app.no_telephone_mobile') - <br>
                        <span class="ag-courses-item_date">603-5544 7376 / 7586 / 7381</span>
                        <span class="ag-courses-item_date">603-5521 2204 / 2205 / 2207</span>
                        {{-- <div class="col-12 px-5" style="display: flex;align-items: anchor-center;justify-content: left;"> --}}
                            <p>Isnin - Jumaat <br> 8:00AM - 4:30PM</p>
                        {{-- </div> --}}
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="ag-format-container hide-on-mobile">
    <div class="row">
        <div class="ag-courses_item col-sm-4">
            <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title mb-3">
                    <img src="{{asset('assets/images/icon/pin.png')}}" width="10%" >
                    @lang('app.address')
                </div>
                <div class="ag-courses-item_date-box">
                    @lang('app.address') - <br>
                    <span class="ag-courses-item_date">Jabatan Pengairan dan Saliran Negeri Selangor
                        <br>
                        Tingkat 5, Podium Selatan,<br>
                        Bangunan Sultan <br>
                        Salahuddin Abdul Aziz <br>
                        Shah, 40626 Shah Alam, Selangor.    
                    </span>
                </div>
            </a>
        </div>

        <div class="ag-courses_item col-sm-4">
            <a href="mailto:contactsupport@jps.com" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title mb-3">
                    <img src="{{asset('assets/images/icon/mail.png')}}" width="10%" >
                    @lang('app.email')
                </div>
                <div class="ag-courses-item_date-box">
                    @lang('app.email_id') -
                    <a<span class="ag-courses-item_date">contactsupport@jps.com</span>
                </div>
            </a>
        </div>

        <div class="ag-courses_item col-sm-4">
            <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>
                <div class="ag-courses-item_title mb-3"><img src="{{asset('assets/images/icon/support.png')}}" width="10%" >
                    @lang('app.contact_us')
                </div>
                <div class="ag-courses-item_date-box">
                    <!--@lang('app.no_telephone_mobile') - <br>-->
                    <span class="ag-courses-item_date">603-5544 7376 / 7586 / 7381</span>
                    <span class="ag-courses-item_date">603-5521 2204 / 2205 / 2207</span>
                    {{-- <div class="col-12 px-5" style="display: flex;align-items: anchor-center;justify-content: left;"> --}}
                        <p>Isnin - Jumaat <br> 8:00AM - 4:30PM</p>
                    {{-- </div> --}}
                </div>
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        {{-- <div class="col-12 px-5" style="display: flex;align-items: anchor-center;justify-content: left;">
            <img src="{{asset('assets/images/icon/support.png')}}" width="10%" >
            <p>Isnin - Jumaat <br> 8:00AM - 4:30PM</p>
        </div> --}}
        <div class="col-12 text-center mb-3">
            {{-- <h6>Map</h6> --}}
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d831.3055878343583!2d101.5151222!3d3.0835306999999985!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc527aecf7d7db%3A0x63f9c30732d0a1f9!2sBangunan%20Sultan%20Salahuddin%20Abdul%20Aziz%20Shah!5e1!3m2!1sen!2sin!4v1739774441278!5m2!1sen!2sin" width="960" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
    </div>
</div>
@endsection
