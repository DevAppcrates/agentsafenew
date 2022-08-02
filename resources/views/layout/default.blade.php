<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags always come first -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }} Admin Panel</title>

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
    <!-- Custom CSS -->
    <!-- EZDZ CSS -->
    <link href="{{url('/')}}/public/css/jquery.ezdz.min.css" rel="stylesheet">
    <!-- Table responsive CSS -->
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
    {{-- <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" type="text/css"> --}}

    <link href="{{ asset('public/scripts/css/select2.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('public/scripts/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <style type="text/css">
        table.dataTable tbody th, table.dataTable tbody td {
            padding: 5px 10px;
        }
        td, th {
            width: 0px;
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
        li.active > a {

     font-size: medium!important;
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
  }
  #col-six {
    margin-left: -30px

}
    </style>
</head>

<body class="fixed-sn page-header-fixed page-sidebar-closed-hide-logo page-content-white page-md @if(Request::url() == url('/master-hub') || Request::url() == url('/master-hub/forget/email') || Request::segment(3) == 'change') @else bg-white @endif" style="font-family:'Source Sans Pro', sans-serif;">

@yield('content')
@include('modals')
@include('scripts')

</body>

</html>