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
                    <div class="page-body text-white">
                                <div class="lock-head"><font color="white">One Step Away!</font></div>
                                <div class="lock-body">
                                    <div class="lock-cont">
                                        <div class="lock-item lock-item-full">
                                            <form role="form" action="" class="lock-form" id="master_hub_change_password_form" method="post">
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <div class="form-group">
                                                    <input id="password" autocomplete="off" type="password" class="form-control" placeholder="New Password..."
                                                           name="password"><br/>
                                                           <input autocomplete="off" type="password" class="form-control" placeholder="Confirm Password..."
                                                           name="password_confirmation"><br/>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" class="btn btn-primary btn-block"
                                                            id="changepassMasterHubButton">Change Password
                                                    </button>
                                                    <br/>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>
    @include('footer')
@endsection