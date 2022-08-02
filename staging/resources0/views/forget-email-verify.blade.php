
@extends('layout.default')
@section('content')
    <div class="container-fluid">
        <style type="text/css">
           .lock-form .btn{
               width: 92% !important;
           }
        </style>
                <div class="page-lock">
                    <div class="page-logo">
                        <a class="brand"><img width="200px" src="{{ asset('public/images/logo@3x.png') }}"></a>
                    </div>
                    <div class="page-body">
                                <div class="lock-head"><font color="white">Verify Yourself!</font></div>
                                <div class="lock-body">
                                    <div class="lock-cont">
                                        <div class="lock-item lock-item-full">
                                            <form role="form" action="" class="lock-form" id="master_hub_forget_form" method="post">
                                                <div class="form-group">
                                                    <input autocomplete="off" type="text" class="form-control" placeholder="Email ..." name="email"><br/>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary btn-block"
                                                            id="forgetMasterHubButton">Verify
                                                    </button>
                                                    <br/>
                                                </div>
                                            </form>
                                            <a class="text-white pull-right" href="{{ url('/master-hub') }}">Back to Login!</a>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    @include('footer')
@endsection