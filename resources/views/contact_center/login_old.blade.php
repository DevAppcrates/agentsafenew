@extends('contact_center.layout.default')
@section('content')
    <div class="container-fluid">
        <style type="text/css">
            .lock-form .btn {
                width: 92% !important;
            }
        </style>

        <div class="page-lock">
            <div class="page-logo">
                <a class="brand"><img width="200px" src="{{ asset('public/images/logo@3x.png') }}"></a>
            </div>
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h3><i class="fa fa-exclamation-triangle"></i> &nbsp;<small
                                class="text-white">{{ session('error') }}</small>
                    </h3>

                </div>
            @endif
            @if(session('success'))

                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h3><i class="fa fa-check"></i> &nbsp;<small class="text-white">{{ session('success') }}</small>
                    </h3>

                </div>
            @endif
            <div class="page-body">
                <div class="lock-head"><font color="white">Contact Center Log In</font></div>
                <div class="lock-body">
                    <div class="lock-cont">
                        <div class="lock-item lock-item-full">
                            <form role="form" action="" class="lock-form" id="contact_center_form" method="post">
                                <div class="form-group">
                                    <input autocomplete="off" type="text" class="form-control" placeholder="Email ..."
                                           name="email"><br/>
                                </div>
                                <div class="form-group">
                                    <input type="password" autocomplete="off" class="form-control"
                                           placeholder="Password ..."
                                           name="password"><br/>
                                </div>
                                <div class="form-actions">
                                    <button type="submit" class="btn btn-primary btn-block"
                                            id="logInContactCenterButton">Log In
                                    </button>
                                    <br/>
                                </div>
                            </form>
                            <a class="text-white pull-right" href="{{ url('forget/email') }}">Forget Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@endsection