@if(auth('user')->check())
    @extends('clientarea.app')
@else
    @extends('app')
@endif
@section('content')
    <section class="content">
        <div class="row">
            <div class="col-md-12" style="text-align:center; margin:100px 0">
                <section class="content" style="margin-top: 100px;padding: 30px;">
                    <div class="error-page message-box">
                        <h1 class="headline text-danger">{{$code}}</h1>
                        <div class="error-content text-center">
                            <h4>Oops! This action is unauthorized.</h4>
                            <p>Please contact administrator.</p>
                            <div class="buttons-con">
                                <div class="action-link-wrap">
                                    <a href="#" class="btn btn-custom btn-info waves-effect waves-light m-t-20">Go to Home Page</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </section>
@endsection