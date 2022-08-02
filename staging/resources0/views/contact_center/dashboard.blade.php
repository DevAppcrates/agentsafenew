@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} - Admin Panel
@stop
@section('page-content')

<?php
// set url
$url = url('/') . "";

$value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$email = $user[0]['email'];
	$name = $user[0]['organization_name'];
	$organization_id = $user[0]['organization_id'];
	$user_type = $user[0]['type'];

}

?>
<!-- BEGIN CONTENT -->
<!-- BEGIN CONTENT -->




<div class="page-content-wrapper">
    <!-- BEGIN CONTENT BODY -->
    <div class="page-content">
        <!-- BEGIN PAGE HEADER-->

        <!-- BEGIN PAGE BAR -->
        <div class="page-bar">
            <ul class="page-breadcrumb ">
                <li>
                    <a href="{{$url}}/dashboard">Home</a>
                    <i class="fa fa-circle"></i>
                </li>
                <li>
                    <span>Dashboard</span>
                </li>
            </ul>
        </div>
         <div class="account-details">
                  <p class="user">

                <span id="usr-nm">{{ $name }}</span><span id="usr-ml">{{ $email }}</span>
               </p>
                </div>
        <!-- END PAGE BAR -->
        <!-- BEGIN PAGE TITLE-->
        <div class="row" >
            <div class="col-lg-10 col-md-3 col-sm-6 col-xs-12">

        <h1 class="page-title" style="height: 10px"> </h1>

            </div>
            <div class="col-lg-2 col-md-3 col-sm-6 col-xs-12 pull-right">
            {{-- <img src="{{ asset('public/images/logo.png') }}" style="width: 140px; height: 60px; margin-top: 4px"> --}}

            </div>
        </div>
        <!-- END PAGE TITLE-->
        <!-- END PAGE HEADER-->
        <!-- BEGIN DASHBOARD STATS 1-->
        @php
            if (Session::has('contact_center_admin')) {
                $user = Session::get('contact_center_admin');
                $organization_id=$user[0]['organization_id'];
            }
            $admins=\App\Organizations::where('organization_id',$organization_id)->where('type',2)->count();
            $users = \App\Users::where('organization_id',$organization_id)->count();
            $inviteesCount = App\Invitees::where('organization_id',$organization_id)->count();
            $userCount = $users+$inviteesCount;
            $contact_centers=\App\Organizations::count();
            $user_ids=\App\Users::where('organization_id',$organization_id)->pluck('user_id')->all();
            $panic=\App\Videos::with('user')->where('archive_id','!=','')->where('type','=','panic')->whereIn('user_id',$user_ids)->where('created_at', '>=', \Carbon\Carbon::now()->subDays(30))->count();
            $anonymous=\App\Videos::with('user')->where('archive_id','!=','')->where('type','!=','panic')->whereIn('user_id',$user_ids)->count();
            $massNotification = \App\Notifications::where('is_archive', 0)->count();

        @endphp


        <div class="row">

            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 blue" href="{{$url}}/panic">
                    <div class="visual">
                        <i class="icon-camcorder"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?=$panic?>">0</span>
                        </div>

                        <div class="desc uppercase"> Panic Alerts Past 30 Days </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red new-orange" href="{{$url}}/report_tip">
                    <div class="visual">
                        <i class="icon-camera"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?=$anonymous?>">0</span></div>
                        <div class="desc uppercase"> Reported Tips Past 30 Days </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 red new-red" href="{{$url}}/notifications">
                    <div class="visual">
                        <i class="icon-bell"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?=$massNotification?>">0</span></div>
                        <div class="desc uppercase"> Notifications Sent</div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
                <a class="dashboard-stat dashboard-stat-v2 purple" href="{{$url}}/users">
                    <div class="visual">
                        <i class="icon-users"></i>
                    </div>
                    <div class="details">
                        <div class="number">
                            <span data-counter="counterup" data-value="<?=$userCount?>"></span></div>
                        <div class="desc uppercase"> Number Of Active Users </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="clearfix"></div>
        <!-- END DASHBOARD STATS 1-->


    </div>
    <!-- END CONTENT BODY -->
</div>

<!-- END CONTENT -->
 <!-- BEGIN PAGE LEVEL SCRIPTS -->
@stop