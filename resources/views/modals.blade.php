<style type="text/css">
   .modal .modal-content {
   -webkit-border-radius: 17px;
   -moz-border-radius: 17px;
   -ms-border-radius: 17px;
   -o-border-radius: 17px;
   border-radius: 17px;
   border: 0;
   }
   .close{
   text-indent: unset;
   opacity: 1 !important;
   z-index: 100 !important;
   height: 30px;
   width: 33px;
   font-size: 25px !important;
   -webkit-height: 25px;
   -webkit-width: 32px;
   -webkit-font-size: 25px !important;
   -webkit-text-indent: 1;
   }
   #videoModal .close{
   font-size: 20px !important;
   }
   .btn:not(.btn-sm):not(.btn-lg) {
   line-height: 1;
   }
   .ms-container{
   width: 100% !important;
   }
   .toast .toast-close-button {
   text-indent: unset!important;
   -webkit-text-indent: 1;
   height: 20px!important;
   }
   .video-section {
    border-radius: 0px !important;
    border: 0px !important;
}
.location {
    border-radius: 0px !important;
    border: 0px !important;
}
</style>
<!-- Edit Admin -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Administrator</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="edit-admin" novalidate="novalidate">
               <div class="col-md-4 col-lg-4" style="margin-top: 2px" >
                  <input type="file" name="image" id="image" class="a" ><br/>
               </div>
               <div class="col-md-8">
                  <label class="form-label">Name <span class="form-asterick">&#42;</span></label>
                  <input class="form-control btn-circle" type="text" name="name" placeholder=" Name" value="">
                  <br>
                  <label class="form-label" >Email <span class="form-asterick">&#42;</span></label>
                  <input class="form-control btn-circle" type="text" name="email" placeholder="Email" value="">
                  <input class="form-control btn-circle" type="hidden" name="old_email" placeholder="Email" value="">
                  <br>
               </div>
               <button class="btn" id="editAdminButton" style="margin: auto;width: 95%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 15px;background-color: #0275d8;">Save Changes</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!-- Change Password -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Change Password</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="change-password" novalidate="novalidate">
               <label class="form-label">Old Password <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" name="old_password" autocomplete="off" placeholder="Old Password">
               <br>
               <label class="form-label" >New Password <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" name="new_password" autocomplete="off" placeholder="New Password" >
               <br>
               <div align="right">
               <button class="btn change-pswrd" id="changePasswordButton">Save Changes</button>
               </div>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!-- Change Password -->
<div class="modal fade" id="changePasswordAdminModal" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Change Password</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="change-password-admin" novalidate="novalidate">
               <label class="form-label">Old Password <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" name="old_password" autocomplete="off" placeholder="Old Password">
               <br>
               <label class="form-label" >New Password <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" name="new_password" autocomplete="off" placeholder="New Password" >
               <br>
               <button class="btn" id="changePasswordAdminButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Save Changes</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Video detail -->
<div class="modal fade in modal-fullscreen" id="videoModal" tabindex="-1" role="dialog" >
   <div class="modal-dialog modal-lg" role="document" style="height: auto;margin: 0px;">
      <!--Content-->
      <div class="modal-content" style="border-radius: 0;">
         <!--Header-->
         <div>
            <div class="col-md-3" style="float: right; margin-top: 20px; margin-right: 4%;z-index: 1000;">
               <a href="javascript:void(0)" onclick="javascript:window.location.reload()" class="close btn btn-circle" data-dismiss="modal" aria-label="Close">
                  <i class="fa fa-remove" style="font-size:24px;color:red"></i>
               {{-- <span aria-hidden="true">X</span> --}}
               </a>
            </div>
         </div>
         <!--Body-->
         <div class="modal-body" style="height: auto;">
            <iframe id="iframe" name="iframe1" frameborder="0" src="" style="
               width: 100%;
               height: 1200px;
               overflow: hidden;
               /* z-index: 1000 !important; */margin-top: -26px;"></iframe>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add contact center -->
<div class="modal fade" id="add_contact_center" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Contact Center</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="add-contact-center"  novalidate="novalidate">
            <div class="modal-body">
               <label class="form-label">Name</label>
               <input class="form-control btn-circle" type="text" name="user_name" autocomplete="off" placeholder="Name">
               <br>
               <label class="form-label">Organization Name</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="name" placeholder="Organization Name">
               <br>
               <label class="form-label">Organization Email</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Organization Email">
               <br>
               <label class="form-label">Password</label>
               <input class="form-control btn-circle" type="text"  name="password" autocomplete="off" placeholder="Password">
               <br>
               <div class="row">
                  <div class="col-sm-5">
                     <div class="form-group">
                        <label>Select Country code</label>
                        <select class="selectpicker form-control" data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                        <?php $countries = \App\Countries::all();?>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" @if($country->id ==  233) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-7" id="col-six">
                     <label class="form-label">Organization Phone</label>
                     <input class="form-control btn-circle-right form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                  </div>
               </div>
               <br>
               <label class="form-label">Organization Code</label>
               <input class="form-control btn-circle code"  type="text" name="code" placeholder="Organization Code" readonly>
               <a id="generate" class="btn btn-warning font-weight-bold red-text" style="float: right">Click here for Code</a>
               <br>
               <label class="form-label">Address</label>
               <input class="form-control btn-circle" autocomplete="off" type="text" name="address" placeholder="Address">
               <br>
               <label class="form-label">No Of Users</label>
               <input class="form-control btn-circle" autocomplete="off" type="text" name="no_of_users" placeholder="No Of Users" >
               <br>
               <div class="form-group">
                  <label>Time Zone</label>
                  <select name="time_zone" class="form-control btn-circle">
                     <?php $time_zone = \App\TimeZone::get();?>
                     <option value="">select Time zone</option>
                     @foreach($time_zone as $time)
                     <option value="{{ $time->id }}">{{ $time->timezone.' '.$time->standard_time }}</option>
                     @endforeach
                  </select>
               </div>
               <div class="form-group">
                  <label>Additional Note</label>
                  <textarea name="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
               </div>
               <div class="additional_field"></div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning"  id="add_contact_center_button">Add Contact Center</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add contact center -->
<div class="modal fade" id="add_sub_contact_center" tabindex="-1" role="dialog" style="">
   <div id="modal-lg" class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Sub-Administrator</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="add-sub-contact-center"  novalidate="novalidate">
            <div class="modal-body" style="height: auto;">
               <div class="row">
                  <div id="form-column" class="col-md-12 col-sm-12">
                     <label class="form-label"> Name</label>
                     <input class="form-control btn-circle btn-circle" autocomplete="off" type="text" name="name" placeholder="Name">
                     <br>
                     <label class="form-label">Email</label>
                     <input class="form-control btn-circle btn-circle" autocomplete="off" type="text" name="email" placeholder="Email">
                     <br>
                     <label class="form-label">Password</label>
                     <input class="form-control btn-circle btn-circle" type="text" name="password" autocomplete="off" placeholder="Password">
                     <br>
                     <div class="row">
                        <div class="col-sm-5">
                           <div class="form-group set-no cntry-btn-set">
                              <label>Select Country Code/Enter Phone</label>
                              <select class="selectpicker form-control" disabled data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                              <?php $countries = \App\Countries::all();?>
                              @foreach($countries as $country)
                              <option value="{{ $country->id }}" @if($country->id ==  session('contact_center_admin.0.country_id')) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                              @endforeach
                              </select>
                           </div>
                        </div>
                        <div class="col-sm-7" id="col-six">
                           <label class="form-label">&nbsp; &nbsp;&nbsp;&nbsp;</label>
                           <input class="form-control form-control-lg btn-circle-right set-num" autocomplete="off" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                        </div>
                     </div>
                     <br>
                     <label class="form-label">Address</label>
                     <input class="form-control btn-circle" type="text" autocomplete="off" name="address" placeholder="Address">
                     <br>
                     <div class="form-group">
                        <label>Additional Note</label>
                        <textarea name="additional_detail"  placeholder="Additional Note" class="form-control btn-circle"></textarea>
                     </div>
                     <div  class="form-group additional_field">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning" style="float: right;"  id="add_sub_contact_center_button" >Add Sub-Administrator</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add Monitor -->
<div class="modal fade" id="add_monitor" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Monitor</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="add-monitor"  novalidate="novalidate">
            <div class="modal-body">
               <label class="form-label">Monitor Name</label>
               <input class="form-control btn-circle" type="text" name="user_name" autocomplete="off" placeholder="Name">
               <br>
               <label class="form-label">Monitor Email</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Monitor Email">
               <br>
               <label class="form-label">Password</label>
               <input class="form-control btn-circle" type="text"  name="password" autocomplete="off" placeholder="Password">
               <br>
               <div class="row">
                  <div class="col-sm-5">
                     <div class="form-group">
                        <label>Select Country code</label>
                        <select class="selectpicker form-control" data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                        <?php $countries = \App\Countries::all();?>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}" @if($country->id ==  233) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-7" id="col-six">
                     <label class="form-label">Monitor Phone</label>
                     <input class="form-control btn-circle-right form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                  </div>
               </div>
               <br>
               <label class="form-label">Address</label>
               <input class="form-control btn-circle" autocomplete="off" type="text" name="address" placeholder="Address">
               <br>
               <div class="form-group">
                        <label class="form-label">Contact Centers</label>
                        <select class="selectpicker form-control" data-size='auto' data-style='btn' multiple data-live-search="true" name="contact_centers[]">
                        <?php $contactCenters = \App\Organizations::where('type', 1)->get();?>
                        @foreach($contactCenters as $contactCenter)
                        <option value="{{ $contactCenter->organization_id }}">{{ $contactCenter->organization_name }}</option>
                        @endforeach
                        </select>
                     </div>
               <br>
               <div class="form-group">
                  <label>Additional Note</label>
                  <textarea name="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
               </div>
               <div class="additional_field"></div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning"  id="add_monitor_button">Add Monitor</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>

<!--Edit Monitor -->
<div class="modal fade" id="edit_monitor" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Monitor</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="edit-monitor"  novalidate="novalidate">
            <div class="modal-body">
               <input type="hidden" name="id">
               <label class="form-label">Monitor Name</label>
               <input class="form-control btn-circle" type="text" name="user_name" autocomplete="off" placeholder="Name">
               <br>
               <label class="form-label">Monitor Email</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Monitor Email">
               <br>
               <div class="row">
                  <div class="col-sm-5">
                     <div class="form-group">
                        <label>Select Country code</label>
                        <select class="selectpicker form-control" data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                        <?php $countries = \App\Countries::all();?>
                        @foreach($countries as $country)
                        <option value="{{ $country->id }}">{{ $country->name }} (+{{ $country->phone_code }})</option>
                        @endforeach
                        </select>
                     </div>
                  </div>
                  <div class="col-sm-7" id="col-six">
                     <label class="form-label">Monitor Phone</label>
                     <input class="form-control btn-circle-right form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                  </div>
               </div>
               <br>
               <label class="form-label">Address</label>
               <input class="form-control btn-circle" autocomplete="off" type="text" name="address" placeholder="Address">
               <br>
               <div class="form-group">
                        <label class="form-label">Contact Centers</label>
                        <select class="selectpicker form-control" data-size='auto' data-style='btn' multiple data-live-search="true" name="contact_centers[]">
                        <?php $contactCenters = \App\Organizations::where('type', 1)->get();?>
                        @foreach($contactCenters as $contactCenter)
                        <option value="{{ $contactCenter->organization_id }}">{{ $contactCenter->organization_name }}</option>
                        @endforeach
                        </select>
                     </div>
               <br>
               <div class="form-group">
                  <label>Additional Note</label>
                  <textarea name="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
               </div>
               <div class="additional_field"></div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning"  id="edit_monitor_button">Update Monitor</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add admin -->
<div class="modal fade" id="add_admin" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Admin</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="add-admin"  novalidate="novalidate">
               <label class="form-label">Name</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="name" placeholder="Name">
               <br>
               <label class="form-label">Email</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Email">
               <br>
               <label class="form-label">Password</label>
               <input class="form-control btn-circle" type="text" name="password" autocomplete="off" placeholder="Password">
               <br>
               <button class="btn btn-block btn-warning"  id="add_admin_button">Add Admin</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add Code -->
<div class="modal fade" id="add_code" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Code</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="add-code"  novalidate="novalidate">
               <label class="form-label">Organization Name</label>
               <input class="form-control btn-circle" autocomplete="off" type="text" name="name" placeholder="Organization Name">
               <br>
               <label class="form-label">Code</label>
               <input class="form-control btn-circle code" type="text" autocomplete="off" name="code" placeholder="Code" readonly="">
               <br>
               <button class="btn btn-block btn-warning"  id="add_code_button">Add Code</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<!--Add monitoring official -->
<div class="modal fade" id="add_monitoring_official" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Monitoring Official</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="add-monitoring-official"  novalidate="novalidate">
               <label class="form-label">Name</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="name" placeholder="Name">
               <br>
               <label class="form-label">Email</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="email" placeholder="Email">
               <br>
               <label class="form-label">Password</label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="password" placeholder="Password">
               <br>
               <label class="form-label">Phone</label>
               <input class="form-control btn-circle-right" type="text" autocomplete="off" name="phone" placeholder="Enter Numbers Only-No Spaces">
               <br>
               <button class="btn btn-block btn-warning"  id="add_monitoring_official_button">Add Monitoring Official</button>
            </form>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<div class="modal fade" id="recording" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true"></span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Recording</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <section class="experiment recordrtc" style="text-align: center">
               <h2 class="header" >
                  <select class="recording-media" style="display: none">
                     <option value="record-audio">Audio</option>
                     <option value="record-screen">Screen</option>
                  </select>
                  <select class="media-container-format" style="display: none">
                     <option>WAV</option>
                  </select>
                  <p style="margin: auto"><img src="{{url('/')}}/public/images/rec.gif" id="rec" style="width: 100px;height:100px;display: none"></p>
                  <button style="background: #0275d8;color: white;border: 2px solid #efefef;margin: 5px">Start Recording</button>
               </h2>
               <div style="text-align: center; display: none;">
                  <button id="save-to-disk">Save To Disk</button>
                  <button id="open-new-tab">Open New Tab</button>
                  <button id="upload-to-server">Upload To Server</button>
               </div>
               <br>
               <audio controls muted id="audio-player" style="display: none"></audio>
            </section>
         </div>
      </div>
      <!--/.Content-->
   </div>
</div>
<div class="modal fade" id="send_push" data-backdrop="static"
data-show="true" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="send_pushModalLabel">Create Text Notification</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <form class="form-group" id="send-push" novalidate="novalidate">
               <div class="form-group" id="form-group">
                  <label class="form-label">Template Notifications</label>
                  <select id="getTemplateDropdown" onchange="getTemplate(this)" class="form-control" name="">
                     <option value="">None</option>
                     <?php $templates = \App\Templates::where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 1)->get();?>
                     @foreach($templates as $template)
                     <option value="{{ $template->id }}">{{ $template->title }}</option>
                     @endforeach
                  </select>
               </div>
               <label class="form-label">Title <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title"><br/>
               <div id="file-push">
                  <label class="form-label">Notification <span class="form-asterick">&#42;</span></label>
                  <textarea class="form-control  btn-circle" name="notification" placeholder="Notification" style="min-height: 100px"></textarea>
                  <br>
                  <label class="form-label">Image or Video</label>
                  <div class="fileinput fileinput-new input-group btn-circle" data-provides="fileinput" style="width: 100%">
                     <div class="form-control btn-circle-left" data-trigger="fileinput"> <span class="fileinput-filename"></span></div>
                     <span class="input-group-addon btn btn-warning btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                     <input type="file" name="file" accept="image/*,video/*"> </span> <a href="#" class="input-group-addon btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
                  </div>
               </div>
               <input type="hidden" id="audio_src" name="audio_src" >
               <section class="experiment recordrtcpush" style="text-align: center;display: none;">
                  <h2 class="header" >
                     <select class="recording-media-push" style="display: none">
                        <option value="record-audio">Audio</option>
                        <option value="record-screen">Screen</option>
                     </select>
                     <select class="media-container-format-push" style="display: none">
                        <option>WAV</option>
                     </select>
                     <p style="margin: auto"><img src="{{url('/')}}/public/images/rec.gif" id="rec-push" style="width: 100px;height:100px;display: none"></p>
                     <button type="button" id="button" style="background: #0275d8;color: white;border: 2px solid #efefef;margin: 5px">Start Recording</button>
                  </h2>
                  <div style="text-align: center; display: none;">
                     <button id="save-to-disk">Save To Disk</button>
                     <button id="open-new-tab">Open New Tab</button>
                     <button id="upload-to-server">Upload To Server</button>
                  </div>
                  <br>
                  <audio controls muted id="audio-player-push" controlsList="nodownload" style="display: none" ></audio>
                  <audio controls id="hear-audio" controlsList="nodownload" style="display: none;">
                     {{-- <pre>&lt;video controls controlsList="nodownload"&gt;</pre> --}}
                     <source src="" id="hear-audio-src" type="audio/wav">
                  </audio>
               </section>
               <br/>
               <div class="form-group" id="form-group">
                  <label class="form-label">Groups <span class="form-asterick">&#42;</span></label>
                  <select class="mdb-select" name="groups[]" multiple searchable="Search here..">
                     <option value="" disabled>Select Group(s)</option>
                     <?php $groups = \App\Groups::withCount('members')->where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 1)->get();
?>
                     <?php $invitees = \App\Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->count();
?>
                     @foreach($groups as $group)
                     @if($group->title == 'Invited Users')
                     <option value="{{ $group->id }}" @if($invitees == 0) disabled @endif>{{ $group->title }} ({{ $invitees }})</option>
                     @else
                     <option value="{{ $group->id }}" @if($group->members_count == 0) disabled @endif>{{ $group->title }} ({{ $group->members_count }})</option>
                     @endif
                     @endforeach
                  </select>
               </div>
               {{-- Low, Moderate, High, Informational --}}
               <div id="groups-error"></div>
               <div class="form-group">
                  <label class="form-label"> Priority<span class="form-asterick">&#42;</span></label>
                  <select class="mdb-select" name="priority">
                     <option value="" disabled selected>Set Priority</option>
                     <option value="Low">Low</option>
                     <option value="Moderate">Moderate</option>
                     <option value="High">High</option>
                     <option value="Informational">Informational</option>
                     {{-- <option value="Critical">Critical</option> --}}
                     {{-- <option value="Active Shooter">Active Shooter</option> --}}
                     {{-- <option value="Medical Emergency">Medical Emergency</option> --}}
                  </select>
               </div>
               <br>
               <div class="form-group" id="form-group">
                  <select class="form-control c-option btn-circle" id="schedule_dropdown" name="schedule">
                     <option class="width-set" value="0">Send Now</option>
                     <option value="1">Schedule For Later</option>
                  </select>
               </div>
               <div id="add-MN-schedule" style="display: none;">
                  <div class="row">
                     <div class="col-sm-4">
                        <div class="form-group">
                           <label class="form-label">Select Date <span class="form-asterick">&#42;</span></label>
                           <br>
                           <input type="text" name="date" class="form-text form-control btn-circle" placeholder="select date" id="datepicker" autocomplete="off">
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <div class="form-group" style="margin-top: 2px;">
                           <label>Select A Send Time</label>
                           <br>
                           <select name="time" class="form-control btn-circle" style="display: unset;">
                              <?php $hours = \App\Hours::orderBy('hour', 'asc')->get();?>
                              <option value="">Set Time</option>
                              @foreach($hours as $hour)
                              <option value="{{ $hour->id }}">{{ $hour->hour }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-4">
                        <label>Select AM/PM</label>
                        <select name="am_pm" class="form-control btn-circle"  style="display: unset;">
                           <option value="am">AM</option>
                           <option value="pm">PM</option>
                        </select>
                     </div>
                  </div>
               </div>
               <div class="form-group" style="text-align: center">
                  <label class="form-label"> Check Box To Activate Notification Receipts.</label>
                  <!-- Default inline 1-->
                  <div class="custom-control custom-radio custom-control-inline">
                     <input type="checkbox" class="custom-control-input" id="defaultInline1" name="is_report">
                     <label class="custom-control-label" for="defaultInline1">Yes</label>
                  </div>
               </div>
               <button class="btn" id="notificationButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Send Notification</button>
            </form>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="add-template" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Notification Template</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div class="row">
               <form id="add-template-form" novalidate="novalidate">
                  <div class="col-md-12 form-group">
                     <label class="form-label">Title <span class="form-asterick">&#42;</span></label>
                     <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title">
                  </div>
                  <div class="col-md-12 form-group">
                     <label class="form-label">Notification <span class="form-asterick">&#42;</span></label>
                     <textarea class="form-control  btn-circle" name="notification" placeholder="Notification" style="min-height: 100px"></textarea>
                     <br>
                  </div>
                  <div class="col-md-12">
                     <button class="btn btn-primary waves-effect" id="add-template-btn">Save</button>
                  </div>
               </form>
            </div>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="edit-template" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Notification Template</h4>
         </div>
         <!--Body-->
               <div class="modal-body">
                  <div class="row">
                     <form class="form-group" id="edit-template-form" novalidate="novalidate">
                           <input class="form-control btn-circle" type="hidden" autocomplete="off" name="template_id" id="template_id" placeholder="Title">
                           <div class="col-md-12 form-group">
                              <label class="form-label">Title <span class="form-asterick">&#42;</span></label>
                              <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title">
                           </div>
                           <div class="col-md-12 form-group">
                              <label class="form-label">Notification <span class="form-asterick">&#42;</span></label>
                              <textarea class="form-control  btn-circle" name="notification" placeholder="Notification" style="min-height: 100px"></textarea>
                              <br>
                           </div>
                           <div class="col-md-12">

                           </div>
                           </div>
                  </div>
                  <div class="modal-footer">

                        <button class="btn btn-primary waves-effect waves-light" id="edit-template-btn" >Update</button>
                  </div>
               </form>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="CreateGroup" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="CreateGroupLabel">Create A Group</h4>
         </div>
         <!--Body-->
            <form class="form-group" id="create-group" novalidate="novalidate">
                  <div class="modal-body">
                     <div class="note note-success">
                           <p> Groups can only be created one at a time. There is no limit on the number of groups which can be created. </p>
                     </div>
                        <label class="form-label">Group Name<span class="form-asterick">&#42;</span></label>
                        <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title"><br/>
                        <br>
                        <div class="form-group">

                           <select id="users" class="ms form-control" name="group_users[]" multiple="multiple">
                              <?php $users = \App\Users::with('user_tags.tag')->where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 'enabled')->get();?>
                              <?php $invitees = \App\Invitees::with('user_tags.tag')->where('organization_id', session('contact_center_admin.0.organization_id'))->get();?>
                              @foreach($users as $user)
                              @php $tags=''; @endphp
                              @if($user->user_tags->count()>0)
                              @foreach($user->user_tags as $tag)
                              @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                              @endforeach
                              @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                              @endif
                              <option  value="{{'1,'.  $user->user_id }}">
                                 {{ $user->first_name.' '.$user->last_name . $tags}}
                              </option>
                              @endforeach
                              @foreach($invitees as $invite)
                              @php $tags=''; @endphp
                              @if($invite->user_tags->count()>0)
                              @foreach($invite->user_tags as $tag)
                              @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                              @endforeach
                              @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                              @endif
                              <option  value="{{'2,'.  $invite->id }}" >
                                 {{$invite->name. $tags}}
                              </option>
                              @endforeach
                           </select>
                           <br/>
                           <div id="error_group_user"></div>
                        </div>
                  </div>
                  <div class="modal-footer">
                        <button class="btn btn-lg btn-primary waves-effect" id="GroupButton">Create Group</button>

                  </div>
            </form>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="assignTag" tabindex="-1" role="dialog">
   <div class="modal-dialog modal-lg" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="CreateGroupLabel">Assig Tag</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div id="tag_html"></div>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="userTags" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="CreateGroupLabel">User Tags</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div id="user_tags"></div>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="invitees" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">New User Request Form</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div class="note note-success">
               <p>Suggested when adding a large number of users, and adding individually isn't convenient.</p>
            </div>
            <form class="form-group" id="invite" novalidate="novalidate">
               <label>Subject:</label>
               <input type="text" autocomplete="off" name="subject" placeholder="Subject..." class="form-control btn-circle" /><br/>
               {{-- <label class="form-label">Message <span class="form-asterick">&#42;</span></label>
               <textarea class="form-control btn-circle" name="message" placeholder="Message" style="min-height: 100px"></textarea>
               <br> --}}
               <label class="form-label">Upload CSV</label>
               <div class="fileinput fileinput-new input-group btn-circle" data-provides="fileinput" style="width: 100%">
                  <div class="form-control btn-circle-left" data-trigger="fileinput"> <span class="fileinput-filename"></span></div>
                  <span class="input-group-addon btn btn-warning btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                  <input type="file" name="csv" accept=".csv"> </span> <a href="#" class="input-group-addon btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
               </div>
               <a class="download-sample" style="float: right;font-weight: bold" href="{{url('/')}}/public/sample.csv" download>Download Sample</a>
               <br/> <br/>
               <div align="right">
               <button class="btn" id="inviteesButton" style="color: #222;">Add Users</button>
               </div>
            </form>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="addTag" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add A Tag</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div class="note note-success">
               <p> Tags are search terms which are assigned to users to designate the user to groups. A user may be assigned more than one tag and assigned to more than one group. </p>
            </div>
            <form class="form-group" id="add_tag" novalidate="novalidate">
               <label class="form-label">Add A Tag <span class="form-asterick">&#42;</span></label>
               <input class="form-control btn-circle" type="text" autocomplete="off" name="tag" placeholder="Tag">
               <br>
               <div align="right">
               <button class="btn btn-block btn-md ad-btn" id="addTagButton" style="color: #222;margin-left: 2px;padding: 10px;">Add A Tag</button>
               </div>
            </form>
         </div>
         <!--/.Content-->
      </div>
   </div>
</div>
<div class="modal fade" id="addMultipleTag" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Multiple Tags</h4>
         </div>
         <!--Body-->
         <div class="modal-body">
            <div class="note note-success">
               <p>For your convenience, you can use this feature to add multiple tags at once. They must be on an excel spreadsheet format. This feature is best used if uploading more then 25 tags at a time. </p>
            </div>
            <form class="form-group" id="add_multiple_tag" novalidate="novalidate">
               <label class="form-label">Upload CSV</label>
               <div class="fileinput fileinput-new input-group btn-circle" data-provides="fileinput" style="width: 100%">
                  <div class="form-control btn-circle-left" data-trigger="fileinput"> <span class="fileinput-filename"></span></div>
                  <span class="input-group-addon btn btn-warning btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                  <input type="file" name="csv" accept=".csv"> </span> <a href="#" class="input-group-addon btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
               </div>
               <a style="float: right;font-weight: bold" href="{{url('/')}}/public/tags.csv" id="sampleanchor" download>Download Sample</a>
               <br/>


               <button class="btn btn-block btn-md" id="addMultipleTagButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;padding: 12px;">Add Multiple Tags</button>
            </form>
         </div>
         <!--/.Content-->
      </div>
REPORT TIP ALERT DETAILS   </div>
</div>
{{--ADD SINGLE INVITEES--}}
<div class="modal fade" id="SingleInvitees" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <form method="post" id="SingleInvitees_form">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal"><span> &times;</span></button>
               <h4 class="modal-title">Add An Individual User</h4>
            </div>
            <div class="modal-body">
               <div class="form-group">


                  <input type="hidden" name="organization_id" value="{{ session('contact_center_admin.0.organization_id') }}">
                  <div class="form-group">
                        <label>Name:</label>
                        <input type="text" autocomplete="off"  name="name" placeholder="Name..." class="form-control btn-circle" />
                  </div>

                  <div class="form-group">
                        <label>Email:</label>
                        <input type="email" autocomplete="off" name="email" placeholder="Email..." class="form-control btn-circle" />
                  </div>


                  <div class="row">
                     <div class="col-sm-5">
                        <div class="form-group">
                           <label>Select Country code</label>
                           <select class="selectpicker form-control" disabled data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                           <?php $countries = \App\Countries::all();?>
                           @foreach($countries as $country)
                           <option value="{{ $country->id }}" @if($country->id ==  session('contact_center_admin.0.country_id')) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                           @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-sm-7" id="col-six">
                        <div class="form-group">
                              <label>Contact Number:</label>
                              <input class="form-control btn-circle-right form-control-lg" autocomplete="off" minlength="9" maxlength="11" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                        </div>
                     </div>
                  </div>

                  <div class="form-group">
                        <label>Subject:</label>
                        <input type="text" autocomplete="off" name="subject" placeholder="Subject..." class="form-control btn-circle" /><br/>
                  </div>

                        <label class="form-label">Click on a Tag to Add to this User <span class="form-asterick">&#42;</span></label>
                  @php     $tags=\App\Tags::where('organization_id',session('contact_center_admin.0.organization_id'))->get(); @endphp
                     <select id="tag_invitees" class="ms form-control" name="tag_ids[]" multiple="multiple">
                        @foreach($tags as $tag)
                        <option value="{{ $tag->tag_id }}"> {{ $tag->tag_name }} </option>
                        @endforeach
                     </select>

               </div>
            </div>
            <div class="modal-footer">
               <div class="col-sm-4" style="float: right;">
                  <button type="submit" id="SingleInviteesbtn" class="btn btn-lg btn-primary btn-block  waves-effect">Add User</button>
               </div>
            </div>
         </div>
      </form>
   </div>
</div>
<script>
   $(document).ready(function(){

       $('#tag_invitees').multiSelect({
           selectableOptgroup: true,

           selectableHeader: "<a href='#' id='select-all3'>Select All</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Tag'>",
           selectionHeader: "<a href='#' id='deselect-all3'>Deselect All</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to Deselect'>",
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
   $(document).on('click','#select-all3',function(){
       $('#tag_invitees').multiSelect('select_all');
       return false;
   });
   $(document).on('click','#deselect-all3',function(){
       $('#tag_invitees').multiSelect('deselect_all');
       return false;
   });

</script>