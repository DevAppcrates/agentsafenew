
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->
@if(session('contact_center_admin.0.type') != 1)
                  <?php $no_of_users = \App\Organizations::where('organization_id', session('contact_center_admin.0.organization_id'))->where('type', 1)->first(['no_of_users']);?>
                  @else
                  <?php $no_of_users = session('contact_center_admin.0.no_of_users')?>
                  @endif
<head id="head">
<meta charset="utf-8" />
<title>@yield('title')</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta content="width=device-width, initial-scale=1" name="viewport" />
<meta content="" name="description" />
<meta name="csrf_token" content="{{ csrf_token() }}">
<meta content="" name="author" />
<!-- BEGIN GLOBAL MANDATORY STYLES -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />


<link href="{{ asset('public/assets/global/plugins/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/simple-line-icons/simple-line-icons.min.css') }}"  rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/css/material.css') }}" rel="stylesheet" type="text/css">
<!-- END GLOBAL MANDATORY STYLES -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL STYLES -->
<link href="{{ asset('public/assets/global/css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
<link href="{{ asset('public/assets/global/css/plugins.min.css') }}" rel="stylesheet" type="text/css" />
<!-- END THEME GLOBAL STYLES -->
<!-- BEGIN THEME LAYOUT STYLES -->
<link href="{{ asset('public/assets/layouts/layout/css/layout.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/layouts/layout/css/themes/blue.min.css') }}" rel="stylesheet" type="text/css" id="style_color" />
<link href="{{ asset('public/assets/layouts/layout/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css') }}" rel="stylesheet" type="text/css" />
 <link href="{{ asset('public/assets/global/plugins/bootstrap-select/css/bootstrap-select.css') }}" rel="stylesheet" type="text/css" />
  {{-- <link href="{{ asset('public/scripts/css/darkblue.min.css') }}" rel="stylesheet"> --}}
<link href="{{ asset('public/scripts/css/toastr.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('public/css/custom-css.css') }}" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" type="text/css" media="screen" href="{{ url('/') }}/public/js/dropdown-ui/css/multi-select.css">

<style type="text/css">


</style>

@yield('css')
<!-- END THEME LAYOUT STYLES -->
{{-- <link rel="shortcut icon" href="favicon.ico" />  --}}
</head>
<!-- END HEAD -->

<body  class="page-header-fixed page-sidebar-closed-hide-logo page-content-white">

    <?php $url = url('/') . "";?>


    <div class="page-wrapper">
    <!-- BEGIN HEADER -->
    <div id="top-nav" class="page-header navbar navbar-fixed-top">
    <!-- BEGIN HEADER INNER -->
    <div class="page-header-inner ">
    <!-- BEGIN LOGO -->
    <div class="page-logo">
    <a href="{{$url}}/dashboard">
    <img src="{{ asset('public/images/logo@3x.png') }}" alt="logo" class="logo-default logo-css" />
    </a>
    <div class="menu-toggler sidebar-toggler " >
    <span></span>
    </div>
    </div>
    <!-- END LOGO -->
    <!-- BEGIN RESPONSIVE MENU TOGGLER -->
    <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
    <span></span>
    </a>
    <!-- END RESPONSIVE MENU TOGGLER -->
    <!-- BEGIN TOP NAVIGATION MENU -->
    <div class="top-menu">
        <span id="top-current-time">{{ session('contact_center_admin.0.time_zone.timezone').' ' }}<span id="current-time"></span></span>
    <ul class="nav navbar-nav pull-right">

    <li class="dropdown dropdown-user">

        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
            <i class="img-circle icon-user" ></i>
            <span class="username username-hide-on-mobile"> {{ session('contact_center_admin')[0]['name'] }}  </span>
            <i class="fa fa-angle-down"></i>
        </a>
        <ul id="dashboard-dropdown" class="dropdown-menu dropdown-menu-default">
            <li>
                <a href="javascript:void(0)" data-toggle="modal" id="editProfilelink" data-target="#editProfileModal">
                    <i class="icon-pencil"></i> Edit Profile </a>
            </li>
            <li class="divider"> </li>
                        <li>
                <a href="javascript:void(0)" data-toggle="modal" onclick="editSchedule()" id="edit_my_schedule_link">
                    <i class="icon-note"></i> Edit Schedule </a>
            </li>
            <li class="divider"> </li>

            <li>
                <a href="javascript:void(0)" data-toggle="modal" data-target="#changePasswordModal" >
                    <i class="icon-user"></i> Change Password </a>
            </li>
            <li class="divider"> </li>

            <li>
                <a href="javascript:void(0)" onclick="adminCCLogout()" >
                    <i class="icon-key"></i> Log Out </a>
            </li>
        </ul>
    </li>
    </ul>
    </div>
    <!-- END TOP NAVIGATION MENU -->
    </div>
    <!-- END HEADER INNER -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN HEADER & CONTENT DIVIDER -->
    <div class="clearfix"> </div>
    <!-- END HEADER & CONTENT DIVIDER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container">
                @include('contact_center.layout.sidebar')

                @yield('page-content')

    </div>
    <!-- END CONTAINER -->
    </div>



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
                          <?php $countries = \App\Countries::all();?>
                          @foreach($countries as $country)
                          <option value="{{ $country->id }}" @if($country->id ==  session('contact_center_admin.0.country_id')) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-7" id="col-six">
               <label class="form-label">Phone</label>
               <input class="form-control btn-circle-right" style="height: 29px" autocomplete="off" type="text" id="phone" name="phone" value="{{substr(session('contact_center_admin.0.phone_number'),-10)}}" placeholder="Enter Numbers Only-No Spaces">
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
                             <?php $days = \App\Days::all();?>
                        <div id="days-data">
                             <?php
$hours = \App\Hours::orderBy('hour', 'asc')->get();
$schedules = \App\Schedule::where('admin_id', session('contact_center_admin.0.id'))->get();
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

<div class="bg-light border chat-box-close white">

            <a href="javascript:void(0)" class="arrow-r">
                    <div class="chat-head ">
                        <h3 class="text-white d-inline"><i class="fa fa-comments text-white"></i> Admin Chat</h3>
                        &nbsp;<span style="display: none;" id="chat-badge" class="badge badge-danger" style="margin-left: 20px;"></span>
                         <i class="fa fa-angle-up fa-2x pull-right rotate-icon text-white"></i>
                    </div>
            </a>
        </div>
        <div class="bg-light border  chat-box white">
            <a href="javascript:void(0)" class="arrow-r">

                <div class="chat-head">
                    <h3 class="d-inline text-white"><i class="fa fa-comments text-white"></i> Admin Chat</h3>
                <i class="fa fa-angle-down fa-2x pull-right rotate-icon text-white"></i>
                </div>
            </a>
            <div class="msg-section chat-section h-100">
                    <div class="admin-panel-body">
                        <div class="admin-chating" ></div>
                        <div class="panel-footer" style="background: white">
                            <div class="input-group m-t-1" style="position: absolute;bottom: 11px;width: 75%;">
                                    <input aria-hidden="true" id="admin-btn-input" type="text" class="form-control message input-sm" placeholder="Type your message here..." style="margin: 0 0;padding: 0px 5px !important;">
                                    <a class=""  id="send-chat-link" style="margin: 0px;padding: 0% 1%;right: -11px;bottom: -7px;"><img src="{{ url('/public/images/icons/send.png') }}" style="width: 40px;"></a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <!-- Bootstrap Material Design JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>
<!-- Bootbox -->
<script type="text/javascript" src="{{url('/')}}/public/js/bootbox.js"></script>

<!-- ezdz -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/jquery.ezdz.min.js"></script>
<script type="text/javascript" src="{{url('/')}}/public/js/jquery.min.js"></script>

<!-- tag -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/tag-input.min.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/jquery.quicksearch.js"></script>

<!-- Jasny  js  -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jasny-bootstrap/3.1.3/js/jasny-bootstrap.min.js"></script>
<script src="{{ url('public/') }}/assets/global/plugins/counterup/jquery.waypoints.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/global/plugins/counterup/jquery.counterup.min.js" type="text/javascript"></script>
<!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('public/') }}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
 <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <script src="{{ url('public/') }}/assets/layouts/layout/scripts/layout.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/layout/scripts/demo.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/global/scripts/quick-sidebar.min.js" type="text/javascript"></script>
        <script src="{{ url('public/') }}/assets/layouts/global/scripts/quick-nav.min.js" type="text/javascript"></script>
        <!-- END THEME LAYOUT SCRIPTS -->
        @include('modals')
        @include('scripts')
        <script type="text/javascript">
          $(document).ready(function(){

    $('#users').multiSelect({
          selectableOptgroup: true,

      selectableHeader: "<a href='#' id='select-all'>Select All</a><br/><span><small style='padding-left:2px; color:#2d5f8b;'>Click A User To Add To This Group Above.</small></span><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
  selectionHeader: "<a href='#' id='deselect-all'>Deselect All</a><br/><span><small style='padding-left:2px; color:#2d5f8b;'>Click A User To Delete From This Group.</small></span><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to Deselect'>",
          afterInit: function(ms){

              var that = this,

                  $selectableSearch = that.$selectableUl.prev(),
                  $selectionSearch = that.$selectionUl.prev(),
                  selectableSearchString = '#'+that.$container.attr('id')+'  .ms-elem-selectable:not(.ms-selected)',
                  selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

              that.qs1 = $selectableSearch.quicksearch(selectableSearchString,{
                  'show': function () {
                     // alert('show');
                      $(this).prev(".ms-optgroup-label").show();
                      $(this).show();
                  },
                  'hide': function () {
                  //    alert('hide');
                      $(this).prev(".ms-optgroup-label").hide();
                      $(this).hide();
                  }
              })
                  .on('keydown', function(e){
                      if (e.which === 40){
                          that.$selectableUl.focus();
                          return false;
                      }
                  });

              that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                  .on('keydown', function(e){
                      if (e.which == 40){
                          that.$selectionUl.focus();
                          return false;
                      }
                  });
          },


  afterSelect: function(){
    this.qs1.cache();
    this.qs2.cache();
  },
  afterDeselect: function(){
    this.qs1.cache();
    this.qs2.cache();
  }
    });
  })
  $(document).on('click','#select-all',function(){
  $('#users').multiSelect('select_all');
  return false;
});
$(document).on('click','#deselect-all',function(){
  $('#users').multiSelect('deselect_all');
  return false;
});
// Custom scrollbar init
var el = document.querySelector('.custom-scrollbar');
Ps.initialize(el);
</script>

<!-- Toastr Script -->
<script>
toastr.options = {
"closeButton": true, // true/false
"debug": false, // true/false
"newestOnTop": false, // true/false
"progressBar": false, // true/false
"positionClass": "toast-top-right", // toast-top-right / toast-top-left / toast-bottom-right / toast-bottom-left
"preventDuplicates": false,
"onclick": null,
"showDuration": "2000", // in milliseconds
"hideDuration": "1000", // in milliseconds
"timeOut": 0, // in milliseconds
"extendedTimeOut": 0, // in milliseconds
"showEasing": "swing",
"hideEasing": "linear",
"showMethod": "fadeIn",
"hideMethod": "fadeOut"
}
</script>
<script src="{{ asset('public/scripts/js/select2.full.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/scripts/js/components-select2.min.js') }}" type="text/javascript"></script>
<!-- Latest compiled and minified JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/js/jquery.multi-select.js"></script>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/dropdown-ui/jquery.quicksearch.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
 <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
@yield('scripts')
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN" : $('meta[name="csrf_token"]').attr('content'),
        },
        cache: false
    });

    $(document).ready(function(){
        $( "#datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $( "#edit_datepicker" ).datepicker({
          showButtonPanel: true,
           "showAnim" : 'slideDown',
           "dateFormat":'mm/dd/yy',
        });
        $('#send_push #schedule_dropdown').change(function(){
          $('#add-MN-schedule').toggle();
        });
        $('#edit_push #schedule_dropdown').change(function(){
          $('#schedule').toggle();
        });
    });
    function updateTemplate(){
            title = $('input[name="title"]').val()
            notification = $('textarea[name="notification"]').val()
            if(title == '' && notification == ''){
              $('#getTemplateDropdown').val($("#getTemplateDropdown option:first").val());
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

    </body>

    </html>