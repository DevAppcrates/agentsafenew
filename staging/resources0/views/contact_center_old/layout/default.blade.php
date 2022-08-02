<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
    config(['app.timezone' => session('contact_center_admin.0.time_zone.timezone_code')]);
    ini_set('date.timezone', session('contact_center_admin.0.time_zone.timezone_code'));
    // dd(session('contact_center_admin'));
     @endphp
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>iFollow Admin Panel</title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="{{url('/')}}/public/css/bootstrap.min.css" rel="stylesheet">
  <!-- Material Design Bootstrap -->
    <link href="{{url('/')}}/public/css/material.css" rel="stylesheet">
    <!-- Data Table-->
    <link href="{{url('/')}}/public/css/dataTables.min.css" rel="stylesheet">
    <!-- Component-->
    <link href="{{url('/')}}/public/css/component.css" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- EZDZ CSS -->
    <link href="{{url('/')}}/public/css/jquery.ezdz.min.css" rel="stylesheet">
    <!-- Tag CSS -->
    <link href="{{url('/')}}/public/css/tag-input.css" rel="stylesheet">
    <!-- Tag CSS -->
    <link href="{{url('/')}}/public/css/datepicker.css" rel="stylesheet">
    <!-- Jasny Css-->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/css/jasny-bootstrap.min.css" rel="stylesheet">

    <link href="{{ asset('public/scripts/css/bootstrap-switch.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/daterangepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/morris.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/fullcalendar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/jqvmap.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/components-md.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/plugins-md.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/layout.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/darkblue.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/custom.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/scripts/css/lock.min.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('public/scripts/css/favicon.ico') }}" />
    <link href="{{ asset('public/scripts/css/datatables.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/scripts/css/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/scripts/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/scripts/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" type="text/css" media="screen" href="{{ url('/') }}/public/js/dropdown-ui/css/multi-select.css">
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">

    <style type="text/css">
        .container-fluid{
             margin-top: -30px;
        }
        div.dataTables_wrapper div.dataTables_paginate{
        white-space: normal!important;
    }

   .badge {
    text-transform: uppercase;
    padding: 2px 6px 2px!important;
}

.table a[data-toggle='popover'] {
    width: 38px;
    height: 24px;
}
.dropdown-menu {
   font-family: inherit!important;
   width: 0px !important;
       min-width: max-content!important;
}
a.dropdown-item {
    width: auto!important;
    height: 25px!important;
}
.dropdown-item {

    padding: 3px 7px !important;

}
.modal-lg {
     max-width: 100% !important;
}
     @media only screen
  and (min-device-width: 320px)
  and (max-device-width: 568px)  {

  #iframe{
    width: 100%;
    height: 2000px !important;
    margin-top: 0px!important;
}


.cstm-picker {
   padding: 0.75rem 0.0rem !important;
    width: 88% !important;
}
.cstm-form {
     padding: .75rem 0.2rem !important;
}
}
.cstm-picker {
    width: 116%;
    border: #c1c1c1 1px solid;
    border-radius: 0px;
}
.cstm-form {
    border-radius: 0px;
    padding: .75rem 4rem;
}
    .rgba-stylish-strong {
    background-color: #3597dd!important;
}

     li.active > a {
    background: #0275d8 !important;
    color: #fff !important;
    font-size: 200px;
}
.side-nav .collapsible a {
    color: #333;
    font-weight: 600;
}
.side-nav .collapsible a:hover {
     background: #0275d8 !important;
      color: #fff !important;
    font-weight: 600;
}

.side-nav {
    width: 280px !important;
}

li > a{
        color: black;
}

        .table a{
        width: 135px;
        height: 25px;
        }
.table div.dropdown-menu {
        width: 165px;
        right: 0px;
        }
    .btn-pin {
        background-color: #ec2e2e;
        color: white !important;
        margin-left: 42px !important;
        margin-top: 6px !important;
        width: 0px !important;
        height: 27px !important;
    }
    .nav>li>a:hover {
        background: #fdfdfd !important;
        color: black !important;
    }
    .btn:not(.md-skip):not(.bs-select-all):not(.bs-deselect-all).btn-sm {
        font-size: 11px;
        padding: 0px 13px;
    }

    [type=radio]:checked, [type=radio]:not(:checked) {
    position: unset!important;
    visibility: unset!important;
}

    .modal-backdrop, .modal-backdrop.fade.in {
    opacity: 0.9!important;
}

 @media only screen
  and (min-device-width: 320px)
  and (max-device-width: 568px) {
        #col-six{
            margin-left: -0%!important;
        }
        input[name='phone']{
                width: 100%!important;
        }
  }
  li.active > a {

     font-size: medium!important;
}
  #col-six {
    margin-left: -30px

}
input[name='phone']{
                width: 109%;
        }

select[name='groups[]'], select[name='priority'] {
    visibility: hidden;
    display: block;
    position: absolute;
}
.side-nav .sn-ad-avatar-wrapper img {
    max-width: 118px !important;
    padding: 20px 10px;
    float: left;
    object-fit: contain;
}
.chat-box-close {
    display: block;
    position: fixed;
    right: 39px;
    background: #3597dc;
    width: auto;
    min-width: 290px;
    height: 40px;
    bottom: 0;
    z-index: 100000;
}
.chat-box {
    display: none;
    position: fixed;
    right: 39px;
    background: #3597dc;
    width: 225px;
    min-width: 290px;
    height: 50%;
    bottom: 0;
    z-index: 100000;
}
.chat-head {
    padding: 10px 15px 10px;
}
.chat-head h3{
        font-size: 16px;
}
.chat-box-close .chat-head {
    padding: 10px;
}
.msg-section{
    background: #ffffff;
}
    </style>
      <style>

button.blue{
    background-color: #0096ff !important;
    border: none;
    height: 40px;
    width: 50%;
}
button.blue:hover {
    background-color: white !important;
    color: #0096ff;
    border: 1px #0096ff solid;
    transition: all 0.5s;
}
.chating{
    position: relative;
}
/*html,body{ -webkit-overflow-scrolling : touch !important; overflow: auto !important; height: 100% !important; }*/
  @media only screen
  and (min-device-width: 320px)
  and (max-device-width: 568px) {

    .admin-speech-bubble {

            width: 100%!important;
        }

    .admin-speech-bubble-right {
               width: 100%!important;
        }

#admin-btn-input {
    width: 85%!important;
}
    #send-chat-link{
            padding: 0% 2% !important;

    }


}
.admin-speech-bubble {
            position: relative;
            background: linear-gradient(#ebebeb,#cbcbcb);
            border-radius: .8em;
            float: left;
            width: auto;
            max-width: 70%;
            min-width: 65%;
            margin: 15px;
             padding: 4px 7px;
            color: black;
            word-wrap: break-word;
        }

        .admin-speech-bubble:after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 9px;
            width: 0;
            height: 0;
            border: 0.75em solid transparent;
            border-right-color: #cbcbcb;
            border-left: 0;
            border-bottom: 0;
            margin-top: -0.375em;
            margin-left: -0.75em;
        }

        .admin-speech-bubble-right {
            position: relative;
            background: linear-gradient(#65d6ff,#21a0cf);
            border-radius: .8em;
            float: right;
            width: auto;
            max-width: 70%;
            min-width: 65%;
            margin: 15px;
            padding: 4px 7px;
            color: #fff;
            word-wrap: break-word;
        }

        .admin-speech-bubble-right:after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 9px;
            width: 0;
            height: 0;
            border: 0.75em solid transparent;
            border-left-color: #21a0cf;
            border-right: 0;
            border-bottom: 0;
            margin-top: -0.375em;
            margin-right: -0.75em;
        }
.admin-panel-body {
    overflow-y: scroll;
    height: 100%;
    max-height: 245px;
    border: none;
    padding: 0px 20px;
}
#admin-btn-input {
    width: 82%;
    margin: 0;
    padding: 0px 0px;
    border-radius: 16px;
    padding: 0px 0px !important;
}
.left-single-chat .time-span {
    position: absolute;
    left: 18px;
    bottom: -5px;
    font-size: 12px;
}
.right-single-chat {
    position: relative;
    display: inline-block;
    width: 100%;
        margin: 10px;
}

.right-single-chat .time-span {
    position: absolute;
    right: 22px;
    bottom: -5px;
    font-size: 12px;
}
.left-single-chat {
    position: relative;
    display: inline-block;
    width: 100%;
    margin: 10px;
}
span.name-span {
    font-weight: bold;
}
a#send-chat-link {
    position: absolute;
    right: 0;
}
.chat-section {
    height: 450px;
}
.chat-section:hover {
    box-shadow: 2px 4px 3px #555;
}

.right-single-chat span.name-span {
    font-weight: bold;
    color: black;
    position: absolute;
    top: -2px;
    font-size: 12px;
    right: 25px;
}

.left-single-chat span.name-span {
    font-weight: bold;
    color: black;
    position: absolute;
    top: -2px;
    font-size: 12px;
    left: 25px;
}
@media screen and (max-width: 768px){
    .chat-box {
    right: 0;
    width: auto;
    margin: auto;
    min-width: 100%;
    height: 100%;
}

.chat-box-close {
    right: 0;
    width: auto;
    min-width: 100%;
    height: 40px;
}
.admin-panel-body {
    max-height: 85%;
    margin-bottom: 35px;
}
}
</style>
</head>

<body onunload="return unloadFunc()" class="fixed-sn page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md @if(Request::url() == url('/') || Request::url() == url('/forget/email') || Request::segment(2) == 'change') @else bg-white @endif"  style="<?php
if (Request::url() == url('/')) {echo 'background:#d2d2d2!important';}?>font-family:'Source Sans Pro', sans-serif;">


@yield('content')
    @if(Request::url() !== url('/'))

        <div class="bg-light border border-blue chat-box-close white">

            <a href="javascript:void(0)" class="arrow-r">
                    <div class="chat-head blue">
                        <h3 class="text-white d-inline"><i class="fa fa-comments text-white"></i> Admin Chat</h3>
                        &nbsp;<span style="display: none;" id="chat-badge" class="badge badge-danger" style="margin-left: 20px;"></span>
                         <i class="fa fa-angle-up fa-2x pull-right rotate-icon text-white"></i>
                    </div>
            </a>
        </div>
        <div class="bg-light border border-blue chat-box white">
            <a href="javascript:void(0)" class="arrow-r">

                <div class="chat-head blue">
                    <h3 class="d-inline text-white"><i class="fa fa-comments text-white"></i> Admin Chat</h3>
                <i class="fa fa-angle-down fa-2x pull-right rotate-icon text-white"></i>
                </div>
            </a>
            <div class="msg-section chat-section h-100">
                    <div class="admin-panel-body">
                        <div class="admin-chating" ></div>
                        <div class="panel-footer" style="background: white">
                            <div class="input-group m-t-1" style="position: absolute;bottom: 3px;width: 95%;margin: 0 -10px;">
                                    <input aria-hidden="true" id="admin-btn-input" type="text" class="form-control message input-sm" placeholder="Type your message here..." style="margin: 0 0;padding: 0px 5px !important;">
                                    <a class=""  id="send-chat-link" style="margin: 0px;padding: 0% 1%;"><img src="{{ url('/public/images/icons/send.png') }}" style="width: 40px;"></a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    @endif
@include('modals')
@include('scripts')
<script type="text/javascript">

</script>
</body>

</html>