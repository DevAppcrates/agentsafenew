<?php
$value= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (Session::has('admin')) {
    $user = Session::get('admin');
    $email=$user[0]['email'];
    $name=$user[0]['name'];
    $user_type=$user[0]['user_type'];
}
?>
<!--Double Navigation-->
<header>
   <!-- Sidebar navigation -->
   <ul id="slide-out" class="side-nav fixed custom-scrollbar m-0 p-0 ">
      <!-- Logo -->
      <li style="list-style-type: none">
         <div class="logo-wrapper sn-ad-avatar-wrapper">

            <div class="rgba-stylish-strong" style=" padding-left: 20px;">
               <p class="user white-text">{{'AgentSafeWalk Master Control Center'}}<br/>{{$name}}<br>{{$email}}
               </p>
            </div>
         </div>
      </li>
      <!--/. Logo -->
      <!-- Side navigation links -->
      <li>
         <ul class="collapsible collapsible-accordion m-0 p-0 p-t-1">
            <li><a href="<?php echo url('/')?>/master-hub/dashboard" class="collapsible-header waves-effect arrow-r <?php if($value=='dashboard') {?>active<?php } ?>"><i class="fa fa-home"></i> Dashboard</a></li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='organization') {?>active<?php } ?>"><i class="fa fa-globe"></i>Contact Centers<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                 
                     <li><a href="#" data-toggle="modal" data-target="#add_contact_center" class="waves-effect">Add Contact Centers</a> </li>
                     <li><a href="<?php echo url('/')?>/master-hub/organization"  class="waves-effect <?php if($value=='organization') {?>active<?php } ?>">List Of All Contact Centers</a> </li>
                     </ul>
               </div>
            </li>
        
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='administrators') {?>active<?php } ?>"><i class="fa fa-user"></i>Master Sub Admin<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="#" data-toggle="modal" data-target="#add_admin" class="waves-effect">Add Master Sub Admin</a> </li>
                     <li><a href="<?php echo url('/')?>/master-hub/administrators"  class="waves-effect <?php if($value=='administrators') {?>active<?php } ?>">List Of Master Sub Admin</a> </li>
                  </ul>
               </div>
            </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='organization') {?>active<?php } ?>"><i class="fa fa-globe"></i>Monitors<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                 
                     <li><a href="#" data-toggle="modal" data-target="#add_monitor" class="waves-effect">Add Monitor</a> </li>
                     <li><a href="<?php echo url('/')?>/master-hub/monitors"  class="waves-effect <?php if($value=='monitors') {?>active<?php } ?>">List Of All Monitors</a> </li>
                     </ul>
               </div>
            </li>
            <li><a href="#" class="collapsible-header waves-effect arrow-r" onclick="adminLogout()"><i class="fa fa-sign-out"></i> Logout</a> </li>
         </ul>
      </li>
      <!--/. Side navigation links -->
   </ul>
   <!--/. Sidebar navigation -->
   <nav class="navbar navbar-fixed-top scrolling-navbar double-nav bg-blue">
      <!-- SideNav slide-out button -->
      <div class="float-xs-left">
         <a href="#" data-activates="slide-out" class="button-collapse"><i class="fa fa-bars"></i></a>
      </div>
      <ul class="nav navbar-nav float-xs-right">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user"></i>My Profile</a>
            <div class="dropdown-menu dropdown-primary dd-right" aria-labelledby="dropdownMenu1" data-dropdown-in="fadeIn" data-dropdown-out="fadeOut">
               <a class="dropdown-item" data-toggle="modal" data-target="#changePasswordAdminModal" >Change Password</a>

               <a class="dropdown-item" href="#" onclick="adminLogout()">Logout</a>
            </div>
         </li>
      </ul>
   </nav>
   <!--/.Navbar-->
</header>
<!--/Double Navigation-->