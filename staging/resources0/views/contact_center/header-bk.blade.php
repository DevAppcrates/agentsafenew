<?php
   $value= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (Session::has('contact_center_admin')) {
    $user = Session::get('contact_center_admin');
    $email=$user[0]['email'];
    $name=$user[0]['organization_name'];
     $organization_id=$user[0]['organization_id'];
    $user_type=$user[0]['type'];

}

$url='https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy=%22organizationId%22&equalTo=%22'.$organization_id.'%22';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$data = curl_exec ($ch);
curl_close ($ch);

$data=json_decode($data);
$data =  (array) $data;
$tips=$panic=0;

foreach ($data as $row){
   if($row->isActive==true and $row->type=='panic'){
       $panic++;
   }else if($row->isActive==true and $row->type!='panic'){
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
                  <?php $no_of_users =  \App\Organizations::where('organization_id',session('contact_center_admin.0.organization_id'))->where('type',1)->first(['no_of_users']); ?>
                  @else
                  <?php $no_of_users = session('contact_center_admin.0.no_of_users') ?>
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
            <li><a  style="color: black;" href="<?php echo url('/')?>/dashboard" class="collapsible-header waves-effect arrow-r <?php if($value=='dashboard') {?>active<?php } ?>"><i class="fa fa-home"></i> Dashboard</a></li>
           
         @if($user_type != 2)
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='administrators') {?>active<?php } ?>"><i class="fa fa-user"></i>Sub Administrators<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="#" data-toggle="modal" data-target="#add_sub_contact_center" class="waves-effect">Add Sub Administrator</a> </li>
                     <li><a href="<?php echo url('/')?>/administrators"  class="waves-effect <?php if($value=='administrators') {?>active<?php } ?>">List Of Sub Administrators</a> </li>
                  </ul>
               </div>
            </li>
            @endif
             <li class="">
                 <a class="collapsible-header waves-effect arrow-r <?php if($value=='tags') {?>active<?php } ?>"><i class="fa fa-tags"></i>Tags<i class="fa fa-angle-down rotate-icon"></i></a>
                 <div class="collapsible-body">
                     <ul class="m-0 p-0">
                         <li><a href="#" data-toggle="modal" data-target="#addTag" class="waves-effect">Add Single Tag</a> </li>
                         <li><a href="#" data-toggle="modal" data-target="#addMultipleTag" class="waves-effect">Add Tags</a> </li>
                         <li><a href="<?php echo url('/')?>/tags"  class="waves-effect <?php if($value=='tags') {?>active<?php } ?>">Tags List</a> </li>
                     </ul>
                 </div>
             </li>
            @if($user_type != 2)
               <li class="">
                  <a class="collapsible-header waves-effect arrow-r <?php if($value=='invitees') {?>active<?php } ?>"><i class="fa fa-bell-o"></i>Guests<i class="fa fa-angle-down rotate-icon"></i></a>
                  <div class="collapsible-body">
                     <ul class="m-0 p-0">
                        <li><a href="#" data-toggle="modal" data-target="#SingleInvitees" class="waves-effect">Add  Single Guest User</a> </li>
                        <li><a href="#" data-toggle="modal" data-target="#invitees" class="waves-effect">Add Guest Users</a> </li>
                        <li><a href="<?php echo url('/')?>/invitees"  class="waves-effect <?php if($value=='invitees') {?>active<?php } ?>">List Of Guest Users</a> </li>
                     </ul>
                  </div>
               </li>
            @endif
             <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='users' or $value=='enabled_users' or $value=='disabled_users') {?>active<?php } ?>"><i class="fa fa-users"></i>App Users<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="<?php echo url('/')?>/users"  class="waves-effect <?php if($value=='users') {?>active<?php } ?>">List Of All App Users</a> </li>
                     <li><a href="<?php echo url('/')?>/enabled_users"  class="waves-effect <?php if($value=='enabled_users') {?>active<?php } ?>">Enabled App Users</a> </li>
                     <li><a href="<?php echo url('/')?>/disabled_users"  class="waves-effect <?php if($value=='disabled_users') {?>active<?php } ?>">Disabled App Users</a> </li>
                  </ul>
               </div>
            </li>
             <li class="">
                 <a class="collapsible-header waves-effect arrow-r <?php if($value=='groups') {?>active<?php } ?>"><i class="fa fa-users"></i>Groups<i class="fa fa-angle-down rotate-icon"></i></a>
                 <div class="collapsible-body">
                     <ul class="m-0 p-0">
                         <li><a href="#" data-toggle="modal" data-target="#CreateGroup" class="waves-effect">Create Group</a> </li>
                         <li><a href="<?php echo url('/')?>/groups"  class="waves-effect <?php if($value=='groups') {?>active<?php } ?>">Group List</a> </li>
                     </ul>
                 </div>
             </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='panic' or $value=='pending_panic') {?>active<?php } ?>"><i class="fa fa-video-camera"></i>Panic @if($panic!=0)<span class="badge badge-danger" style="margin-left: 20px;">{{$panic}}</span>
                  @endif<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a  href="{{url('/')}}/panic" class="waves-effect arrow-r  <?php if($value=='panic') {?>active<?php } ?>">Completed Panics</a> </li>
                     <li><a  href="{{url('/')}}/pending_panic" class="waves-effect arrow-r  <?php if($value=='pending_panic') {?>active<?php } ?>" >Open Panics</a> </li>
                  </ul>
               </div>
            </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='anonymous_panic' or $value=='open_anonymous_panic') {?>active<?php } ?>"><i class="fa fa-video-camera"></i>Anonymous Panic @if($tips!=0) <span class="badge badge-danger" style="margin-left: 10px;">{{$tips}}</span>
                  @endif<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a  href="{{url('/')}}/anonymous_panic" class="waves-effect <?php if($value=='anonymous_panic') {?>active<?php } ?>" >Completed Anonymous Panics</a> </li>
                     <li><a  href="{{url('/')}}/open_anonymous_panic" class="waves-effect  <?php if($value=='open_anonymous_panic') {?>active<?php } ?>" >Open Anonymous Panics</a> </li>
                  </ul>
               </div>
            </li>
            <li class="">
               <a class="collapsible-header waves-effect arrow-r <?php if($value=='notifications') {?>active<?php } ?>"><i class="fa fa-bell-o"></i>Mass Notification<i class="fa fa-angle-down rotate-icon"></i></a>
               <div class="collapsible-body">
                  <ul class="m-0 p-0">
                     <li><a href="#" onclick="mass_notification('1')" class="waves-effect">Send Text Notification</a> </li>
                     <li><a href="#" onclick="mass_notification('2')" class="waves-effect">Send Voice Notification</a> </li>
                     <li><a href="<?php echo url('/')?>/notifications"  class="waves-effect <?php if($value=='notifications') {?>active<?php } ?>">List Of Notifications</a> </li>
                     @if(session('contact_center_admin.0.user_type') != 2)
                     <li><a href="<?php echo url('/')?>/archive/notifications"  class="waves-effect <?php if($value=='notifications') {?>active<?php } ?>">Archive Notifications</a> </li>
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
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" style="margin-top: -69px;">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="editProfile">Edit Profile</h4>
         </div>
         <!--Body-->
            <form class="form-group" id="edit-profile-contact-center">
         <div class="modal-body" style="height: auto;">
          
         
            <div id="form-column" class="col-sm-12">
               <label class="form-label">Name</label>
               <input class="form-control btn-circle" type="text" id="name" value="{{session('contact_center_admin.0.name')}}" name="name" placeholder="Organization Name">
               <br>
               <label class="form-label">Organization Name</label>
               <input class="form-control btn-circle" value="{{session('contact_center_admin.0.organization_name')}}" type="text" name="user_name" id="user_name"   placeholder="Name" readonly>
               <input class="form-control btn-circle" type="hidden" id="id" value="{{session('contact_center_admin.0.id')}}" name="id" placeholder="Organization Name">
               <br>
               <label class="form-label">Email</label>
               <input class="form-control btn-circle" type="text" id="email" value="{{session('contact_center_admin.0.email')}}"  placeholder="Organization Email" readonly>
               <br>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <label>Select Country code</label>
                        <select class="selectpicker form-control " data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                          <?php $countries = \App\Countries::all(); ?>
                          @foreach($countries as $country)
                          <option value="{{ $country->id }}" @if($country->id ==  session('contact_center_admin.0.country_id')) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-7" id="col-six">  
               <label class="form-label">Phone</label>
               <input class="form-control btn-circle-right" style="height: 29px" type="text" id="phone" name="phone" value="{{substr(session('contact_center_admin.0.phone_number'),-10)}}" placeholder="Enter Numbers Only-No Spaces">
                  </div>
               </div>
               <br>
               <label class="form-label">Code</label>
               <input class="form-control btn-circle" type="text" id="code" value="{{session('contact_center_admin.0.code')}}" placeholder="Organization Code" readonly>
               <br>
                <label class="form-label">No: Of Users</label>
               <input class="form-control btn-circle" type="text" id="code" value="{{(session('contact_center_admin.0.type') != 1)?$no_of_users->no_of_users : session('contact_center_admin.0.no_of_users')}}" placeholder="Organization Code" readonly>
               <br>
               <label class="form-label">Address</label>
               <input class="form-control btn-circle" type="text" name="address" value="{{session('contact_center_admin.0.address')}}" id="address" placeholder="Address">
               <br>
               <div class="form-group">
                  <label>Additional Note</label>
                  <textarea name="additional_detail" placeholder="Additional Note" class="form-control btn-circle">{{session('contact_center_admin.0.additional_detail')}}</textarea>
               </div>
               <div  class="form-group additional_field">
               </div>
                  </div>
         
          <div class="modal-footer">

               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning" style="float: right;"  id="edit_profile_contact_center_button">Update Profile</button>
      </div>
   </div>
            </form>
      </div>
      <!--/.Content-->
   </div>
</div>

   <div class="modal fade" id="edit_my_schedule" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content" style="margin-top: 70px">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="edit_my_scheduleLabel">Edit Schedule</h4>
            </div>
            <!--Body-->
            <form id="edit-my-schedule">
            <div class="modal-body">
               <div class="row">
                 <div id="col-schedule" class="col-md-12 col-sm-12">
                     <br>
                             <?php $days = \App\Days::all(); ?>
                        <div id="days-data">
                             <?php
                              $hours = \App\Hours::orderBy('hour','asc')->get(); 
                              $schedules  = \App\Schedule::where('admin_id',session('contact_center_admin.0.id'))->get();
                              ?>
                        {{-- {{ dd($days) }} --}}

                        @foreach($days as $day)
                        <div class="row">
                        <div class="col-sm-4">
                        <label ><strong style="float:left;font-size: 20px!important;">{{ $day->name }}:</strong></label>                           
                        </div>
                        <div class="col-sm-3 pull-right">
                          <select class="form-control btn-circle" onchange="change_profile_schedule_status('{{ strtolower($day->name) }}',this)" data-style="red" name="{{ strtolower($day->name) }}_status">
                              <option value="active" @foreach($schedules as $schedule) @if($schedule['status'] == 'active' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Active</option>
                              <option value="inactive" @foreach($schedules as $schedule) @if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Inactive</option>
                           </select>
                        </div>
                        </div>
                        <div class="row">

                        
                          <div class="col-sm-3">
                             <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time">
                                <option value="" @foreach($schedules as $schedule)@if($schedule['open_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set start time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['open_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                          </div>
                          <div class="col-sm-3">
                             <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time_am_pm">
                                <option value="am" @foreach($schedules as $schedule)@if($schedule['open_time_format'] == "am" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> AM</option>
                                <option value="pm" @foreach($schedules as $schedule) @if($schedule['open_time_format'] == "pm" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> PM</option>
                             </select>
                             <br/>
                          </div>
                          <div class="col-sm-3">
                             <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time">
                                <option value="" @foreach($schedules as $schedule) @if($schedule['close_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set Close time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['close_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                          </div>
                          <div class="col-sm-3">
                            
                             <select class="form-control btn-circle" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time_am_pm">
                                <option value="am" @foreach($schedules as $schedule) @if($schedule['close_time_format'] == "am" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> AM</option>
                                <option value="pm" @foreach($schedules as $schedule) @if($schedule['close_time_format'] == "pm" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> PM</option>
                             </select>
                          </div>
                        </div>
                        <hr>
                        @endforeach
                        </div>
                        
                     
                   </div>
               </div>  
            </div>
             <div class="modal-footer">
               <button class="btn btn-lg btn-warning" style="float: right;"  id="edit-my-schedule-button">Update Schedule</button>
      </div>
      </form>
         </div>
        </div>
        <!--/.Content-->
    </div>



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
