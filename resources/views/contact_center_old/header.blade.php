<?php
$value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$email = $user[0]['email'];
	$name = $user[0]['organization_name'];
	$organization_id = $user[0]['organization_id'];
	$user_type = $user[0]['type'];

}

$url = 'https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy=%22organizationId%22&equalTo=%22' . $organization_id . '%22';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec($ch);
curl_close($ch);

$data = json_decode($data);
$data = (array) $data;
$tips = $panic = 0;

foreach ($data as $row) {
	if ($row->isActive == true and $row->type == 'panic') {
		$panic++;
	} else if ($row->isActive == true and $row->type != 'panic') {
		$tips++;
	}
}

?>
<!--Double Navigation-->
<header>


      <!--/. Sidebar navigation -->
   <nav class="navbar navbar-fixed-top scrolling-navbar double-nav bg-blue">
      <!-- SideNav slide-out button -->
      <div class="float-xs-left">
         <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav float-xs-right lead">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>My Profile</a>
            <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
               <a class="dropdown-item" data-toggle="modal" id="editProfilelink" data-target="#editProfileModal" >Edit Profile</a>
               <a class="dropdown-item" data-toggle="modal" onclick="editSchedule()" id="edit_my_schedule_link" >Edit Schedule</a>

               <a class="dropdown-item" data-toggle="modal" data-target="#changePasswordModal" >Change Password</a>
               <a class="dropdown-item" href="#" onclick="adminCCLogout()">Logout</a>
            </div>
         </li>
      </ul>
   </nav>
   <!--/.Navbar-->
   <!-- Sidebar navigation -->
   <ul id="slide-out" class="side-nav fixed custom-scrollbar m-0 p-0">
      <!-- Logo -->
      <li style="list-style-type: none">
         <div class="logo-wrapper sn-ad-avatar-wrapper bg-primary">
            <div class="rgba-stylish-strong" style=" padding-left: 20px;">
               <p class="user white-text">
                <img src="{{ asset('public/images/logo@3x.png') }}">
                  <br>
                {{$name}}<br>{{$email}}
                  <br>
                  @if(session('contact_center_admin.0.type') != 1)
                  <?php $no_of_users = \App\Organizations::where('organization_id', session('contact_center_admin.0.organization_id'))->where('type', 1)->first(['no_of_users']);?>
                  @else
                  <?php $no_of_users = session('contact_center_admin.0.no_of_users')?>
                  @endif
                  {{ session('contact_center_admin.0.time_zone.timezone').' ' }}				   <br>
				   <span id="current-time"></span>
               </p>
            </div>
         </div>
      </li>
      <!--/. Logo -->
      <!-- Side navigation links -->
      <li>
         <ul class="collapsible collapsible-accordion m-0 p-0 p-t-1">
            <li><a  style="color: black;" href="<?php echo url('/') ?>/dashboard" class="collapsible-header waves-effect arrow-r <?php if ($value == 'dashboard') {?>active<?php }?>"><i class="fa fa-home"></i> Dashboard</a></li>

         @if($user_type != 2)
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'administrators') {?>active<?php }?>"><i class="fa fa-user"></i>Sub Administrators<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="#" data-toggle="modal" data-target="#add_sub_contact_center" class="waves-effect">Add Sub Administrator</a> </li>
                     <li><a href="<?php echo url('/') ?>/administrators"  class="waves-effect <?php if ($value == 'administrators') {?>active<?php }?>">List Of Sub Administrators</a> </li>
                  </ul>
               </div>
            </li>
            @endif
             <li class="">
                 <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'tags') {?>active<?php }?>"><i class="fa fa-tags"></i>Tags<i class="fa fa-angle-down rotate-icon"></i></a>
                 <div class="collapsible-body">
                     <ul class="m-0 p-0">
                         <li><a href="#" data-toggle="modal" data-target="#addTag" class="waves-effect">Add Single Tag</a> </li>
                         <li><a href="#" data-toggle="modal" data-target="#addMultipleTag" class="waves-effect">Add Tags</a> </li>
                         <li><a href="<?php echo url('/') ?>/tags"  class="waves-effect <?php if ($value == 'tags') {?>active<?php }?>">Tags List</a> </li>
                     </ul>
                 </div>
             </li>
            @if($user_type != 2)
               <li class="">
                  <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'invitees') {?>active<?php }?>"><i class="fa fa-bell-o"></i>Guests<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                     <ul class="m-0 p-0">
                        <li><a href="#" data-toggle="modal" data-target="#SingleInvitees" class="waves-effect">Add  Single Guest User</a> </li>
                        <li><a href="#" data-toggle="modal" data-target="#invitees" class="waves-effect">Add Guest Users</a> </li>
                        <li><a href="<?php echo url('/') ?>/invitees"  class="waves-effect <?php if ($value == 'invitees') {?>active<?php }?>">List Of Guest Users</a> </li>
                     </ul>
                  </div>
               </li>
            @endif
             <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'users' or $value == 'enabled_users' or $value == 'disabled_users') {?>active<?php }?>"><i class="fa fa-users"></i>App Users<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="<?php echo url('/') ?>/users"  class="waves-effect <?php if ($value == 'users') {?>active<?php }?>">List Of All App Users</a> </li>
                     <li><a href="<?php echo url('/') ?>/enabled_users"  class="waves-effect <?php if ($value == 'enabled_users') {?>active<?php }?>">Enabled App Users</a> </li>
                     <li><a href="<?php echo url('/') ?>/disabled_users"  class="waves-effect <?php if ($value == 'disabled_users') {?>active<?php }?>">Disabled App Users</a> </li>
                  </ul>
               </div>
            </li>
             <li class="">
                 <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'groups') {?>active<?php }?>"><i class="fa fa-users"></i>Groups<i class="fa fa-angle-down rotate-icon"></i></a>
                 <div class="collapsible-body">
                     <ul class="m-0 p-0">
                         <li><a href="#" data-toggle="modal" data-target="#CreateGroup" class="waves-effect">Create Group</a> </li>
                         <li><a href="<?php echo url('/') ?>/groups"  class="waves-effect <?php if ($value == 'groups') {?>active<?php }?>">Group List</a> </li>
                     </ul>
                 </div>
             </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'panic' or $value == 'pending_panic') {?>active<?php }?>"><i class="fa fa-video-camera"></i>Panic @if($panic!=0)<span class="badge badge-danger" style="margin-left: 20px;">{{$panic}}</span>
                  @endif<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a  href="{{url('/')}}/panic" class="waves-effect arrow-r  <?php if ($value == 'panic') {?>active<?php }?>">Completed Panics</a> </li>
                     <li><a  href="{{url('/')}}/pending_panic" class="waves-effect arrow-r  <?php if ($value == 'pending_panic') {?>active<?php }?>" >Open Panics</a> </li>
                  </ul>
               </div>
            </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'report_tip' or $value == 'open_report_tip') {?>active<?php }?>"><i class="fa fa-video-camera"></i>Report Tip @if($tips!=0) <span class="badge badge-danger" style="margin-left: 10px;">{{$tips}}</span>
                  @endif<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a  href="{{url('/')}}/report_tip" class="waves-effect <?php if ($value == 'report_tip') {?>active<?php }?>" >Completed Report Tips</a> </li>
                  </ul>
               </div>
            </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if ($value == 'notifications') {?>active<?php }?>"><i class="fa fa-bell-o"></i>Mass Notification<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="#" onclick="mass_notification('1')" class="waves-effect">Send Text Notification</a> </li>
                     <li><a href="#" onclick="mass_notification('2')" class="waves-effect">Send Voice Notification</a> </li>
                     <li><a href="<?php echo url('/') ?>/notifications"  class="waves-effect <?php if ($value == 'notifications') {?>active<?php }?>">List Of Notifications</a> </li>
                     <li><a href="<?php echo url('/') ?>/notification-templates"  class="waves-effect <?php if ($value == 'notifications') {?>active<?php }?>">Notifications Templates</a> </li>
                     @if(session('contact_center_admin.0.user_type') != 2)
                     <li><a href="<?php echo url('/') ?>/archive/notifications"  class="waves-effect <?php if ($value == 'notifications') {?>active<?php }?>">Archive Notifications</a> </li>
                     @endif
                  </ul>
               </div>
            </li>
            <li><a href="#" class="collapsible-header waves-effect arrow-r" onclick="adminCCLogout()"><i class="fa fa-sign-out"></i> Logout</a> </li>
         </ul>
      </li>
      <!--/. Side navigation links -->
   </ul>

</header>
<!--/Double Navigation-->

    @include('scripts_2')

<script type="text/javascript">
   function change_profile_schedule_status(name,current)
    {
        value = $("#edit_my_schedule select[name='"+name+"_status']").val();

        if(value == 'inactive')
        {

        $("#edit_my_schedule select[name='"+name+"_start_time']").attr('disabled',true);
        $("#edit_my_schedule select[name='"+name+"_close_time']").attr('disabled',true);
        $("#edit_my_schedule select[name='"+name+"_start_time_am_pm']").attr('disabled',true);
        $("#edit_my_schedule select[name='"+name+"_close_time_am_pm']").attr('disabled',true);
        // $(".selectpicker").selectpicker('refresh');

        }else{

        $("#edit_my_schedule select[name='"+name+"_start_time']").attr('disabled',false);
        $("#edit_my_schedule select[name='"+name+"_close_time']").attr('disabled',false);
        $("#edit_my_schedule select[name='"+name+"_start_time_am_pm']").attr('disabled',false);
        $("#edit_my_schedule select[name='"+name+"_close_time_am_pm']").attr('disabled',false);
        // $(".selectpicker").selectelectpicker('refresh');

        }



    }




</script>

<script>
var myVar = setInterval(myTimer, 1000);

function myTimer() {
    var d = new Date();
    var t = d.toLocaleTimeString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}'});
    document.getElementById("current-time").innerHTML = t;
}


</script>
