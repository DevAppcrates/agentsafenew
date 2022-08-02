@extends('contact_center.layout.default')
@section('title')
{{ config('app.name') }} | Sub Administrator
@stop
@section('css')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<link href="{{ url('/public') }}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
<link href="{{ url('/public') }}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
<!-- END PAGE LEVEL PLUGINS -->
@stop
@section('page-content')
<!-- BEGIN CONTENT -->
<div class="page-content-wrapper">
   <!-- BEGIN CONTENT BODY -->
   <div class="page-content">
      <!-- BEGIN PAGE TITLE-->
      {{--
      <h1 class="page-title">
         <small></small>
      </h1>
      --}}
      <!-- END PAGE TITLE-->
      <div class="page-bar">
      </div>
      <div class="row" style="margin-top: 3%">
         <div class="col-md-12">
            <!-- BEGIN Portlet PORTLET-->
            <div class="portlet light bg-inverse">
               <div class="portlet-title">
                  <div class="caption font-green-sharp">
                     <i class="icon-speech font-green-sharp"></i>
                     <span class="caption-subject"> Sub Administrators </span>
                     {{-- <span class="caption-helper"></span> --}}
                  </div>
                  <div class="actions">
                     <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                  </div>
               </div>
               <div class="portlet-body">
                  {{-- <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd"> --}}
                     <div class="table-responsive">
                        <table id="example2" class="table table-striped table-bordered table-hover dt-responsive display">
                           <thead>
                              <tr>
                                 <th style="display: none">#</th>
                                 <th>Name</th>
                                 <th>Email</th>
                                 <th>Phone</th>
                                 <th>Address</th>
                                 <th>Additional Note</th>
                                 <th>Additonal Info</th>
                                 <th>Notes</th>
                                 <th>Action</th>
                              </tr>
                           </thead>
                           <tbody>
                              @php $i = 1; @endphp
                              @foreach($admins as $admin)
                              <tr>
                                 <td style="display: none">{{$i}}</td>
                                 <td >{{$admin->name}}</td>
                                 <td >{{$admin->email}}</td>
                                 <td >{{$admin->phone_number}}</td>
                                 <td >{{$admin->address}}</td>
                                 <td >@if($admin->additional_detail != null){{ $admin->additional_detail }} @else {{ "N/A" }} @endif
                                 </td>
                                 <td >
                                    @if($admin->additional_fields)
                                    <ol>
                                       @foreach($admin['additional_fields'] as $fields)
                                       <li>{{ $fields }}</li>
                                       @endforeach
                                    </ol>
                                    @else {{ "N/A" }} @endif
                                 </td>
                                 <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-primary panic-note" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="{{ $admin->name }} Note" data-content="{{ $admin->notes?$admin->notes:"N/A" }}">View Notes</button></td>
                                 <td >
                                    <div class="">
                                          <button  class="btn btn-primary dropdown-toggle"
                                                   id="action"
                                                   type="button"
                                                   data-toggle="dropdown"
                                                   aria-haspopup="true"
                                                   aria-expanded="false">
                                                   Actions
                                          </button>

                                       <div class="dropdown-menu pull-right">


                                          <a data-id='{{$admin->id}}' onclick="see_admin_schedule('{{$admin->schedule}}',this)" class="dropdown-item">

                                             <i class="icon-docs"></i> Schedule Details
                                          </a>

                                          <a data-toggle='modal' data-target='#edit_admin_schedule' onclick="adminscheduleid('{{$admin->id}}','{{ $admin->schedule }}')" class="dropdown-item">

                                             <i class="icon-docs"></i> Edit Schedule
                                          </a>
                                          <a onclick="edit_admin('{{$admin->id}}','{{$admin->name}}','{{$admin->email}}','{{substr($admin->phone_number,-10)}}','{{$admin->address}}','{{$admin->additional_detail}}')" class="dropdown-item">

                                             <i class="icon-docs"></i> Edit Info
                                          </a>
                                          @php
                                          $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($admin->notes))))));
                                          @endphp
                                          <a onclick="add_notes('{{$admin->id}}','{{$clear}}')" class="dropdown-item">

                                             <i class="icon-docs"></i>
                                             Add/Edit Note

                                          </a>
                                          <a onclick="change_status_admin('{{$admin->id}}','{{$admin->status}}',this)" class="dropdown-item">

                                             @if($admin->status == 'enabled')
                                             <i class="fa fa-toggle-off"></i>
                                             Disable
                                             @else
                                             <i class="fa fa-toggle-on"></i>
                                             Enable
                                             @endif

                                          </a>
                                          <a data-id='{{$admin->id}}'
                                             onclick="delete_admin('{{$admin->id}}',this)" class="dropdown-item">

                                             <i class="fa fa-trash"></i>
                                             Delete

                                          </a>


                                       </div>
                                    </div>
                                 </td>
                              </tr>
                              @php $i++; @endphp
                              @endforeach
                           </tbody>
                        </table>
                     </div>
                  {{-- </div> --}}
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- END CONTENT BODY -->
</div>
<!-- END CONTENT -->
<div class="modal fade" id="edit_sub_contact_center" tabindex="-1" role="dialog" style="margin-top: -70px;">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Edit Administrator</h4>
         </div>
         <!--Body-->
         <form class="form-group" id="edit-sub-contact-center"  novalidate="novalidate">
            <div class="modal-body">
               <div class="row">
                  <div id="form-column" class="col-md-12 col-sm-12">
                     <label class="form-label">Name</label>
                     <input class="form-control btn-circle" autocomplete="off" type="text" name="name" id="name" placeholder="Name">
                     <br>
                     <label class="form-label">Email</label>
                     <input class="form-control btn-circle" autocomplete="off" type="text" name="email" id="email" placeholder="Email" disabled>
                     <input class="form-control" type="hidden" name="id" id="id" placeholder="Email">
                     <br>
                     <div class="row edit-adminstrator">
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
                           <label class="form-label">Phone</label>
                           <input class="form-control form-control-lg btn-circle-right" autocomplete="off" type="text" name="phone" id="phone" placeholder="Enter Numbers Only-No Spaces">
                        </div>
                     </div>
                     <br>
                     <label class="form-label">Address</label>
                     <input autocomplete="off" class="form-control btn-circle" type="text" name="address" id="address" placeholder="Address">
                     <br>
                     {{-- <label for="input_starttime">Start Time</label>
                     <input placeholder="Start Time" name="start_time" type="text" id="input_starttime" class="form-control timepicker">
                     <br/>
                     <label for="input_starttime1">End Time</label>
                     <input placeholder="End Time" name="end_time" type="text" id="input_starttime1" class="form-control timepicker"> --}}
                     <br/>
                     <div class="form-group">
                        <label>Additional Note</label>
                        <textarea name="additional_detail" id="additional_detail" placeholder="Additional Note" class="form-control btn-circle"></textarea>
                     </div>
                     <div  class="form-group additional_field">
                     </div>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-warning btn-outline btn-lg"  id="edit_sub_contact_center_button">Save Administrator</button>
            </div>
         </form>
      </div>
      <!--/.Content-->
   </div>
</div>
<!-- Modal -->
<div class="modal fade" id="schedule-modal" tabindex="-1" role="dialog" aria-labelledby="schedule-modalLabel" aria-hidden="true">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <h4 class="modal-title text-md-center" id="schedule-modal-Label">Admin Schedule</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-sm-12">
                  <table  style="width: 100%" class="table table-bordered table-sm">
                     <thead id="schedule-thead">
                        <th>Day</th>
                        <th>Start Time</th>
                        <th>Close Time</th>
                     </thead>
                     <tbody id="schedule-tbody">
                     </tbody>
                  </table>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal fade" id="edit_admin_schedule" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title"  id="edit_admin_scheduleLabel">Edit Schedule</h4>
         </div>
         <!--Body-->
         <form id="edit-admin-schedule">
            <input type="hidden" name="admin_id" id="admin_id">
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
                              <label ><strong style="float:left;font-size: 17px!important;">{{ $day->name }}:</strong></label>
                           </div>
                           <div class="col-sm-3 pull-right">
                              <select class="form-control btn-circle" onchange="change_edit_schedule_status2('{{ strtolower($day->name) }}',this)" data-style="red" name="{{ strtolower($day->name) }}_status">
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
               <button class="btn btn-lg btn-warning" style="float: right;"  id="edit-admin-schedule-button">Update Schedule</button>
            </div>
         </form>
      </div>
   </div>
   <!--/.Content-->
</div>
<div class="modal fade" id="notes" tabindex="-1" role="dialog">
   <div class="modal-dialog " role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Notes</h4>
         </div>
         <!--Body-->
            <form class="form-group" id="sub-admin-note" novalidate="novalidate">
               <div class="modal-body">
                     <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                     <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                     <input type="hidden" name="note_id" id="note_id">
                     <br>
               </div>
               <div class="modal-footer">
                     <button class="btn btn-lg btn-primary  waves-effect" id="noteButton">Save Changes</button>

               </div>
            </form>
         <!--/.Content-->
      </div>
   </div>
</div>
@stop
@section('scripts')
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
<script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
<script type="text/javascript">
   $(document).ready(function(){
        $.fn.dataTable.ext.errMode = 'none';
       // var table = $('#sample_2').dataTable();
       // table.buttons('.buttonsToHide').nodes().css("display", "none");
   })
</script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<!-- END PAGE LEVEL SCRIPTS -->
<script>
    function edit_admin(id,name,email,phone,address,additional_detail,schedule)
   {
       $.ajax({
               type : 'GET',
               url : '{{ url('/ajax/get_additional_fields') }}',
               data : 'id='+id,
               success : function(data,status){
                   if(data.additional_fields != null)
                   {
                       $('#edit_sub_contact_center .additional_field').empty();
                       $.each(data.additional_fields,function(k,v){
                               $('#edit_sub_contact_center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" value="'+v+'" placeholder="Add Some Additional" name="additional_fields[]"></div>');
                       })
                   }else{
                       $('#edit_sub_contact_center .additional_field').empty();
                   }
               },
           });

       $('#edit_sub_contact_center #id').val(id);
       $('#edit_sub_contact_center #name').val(name);
       $('#edit_sub_contact_center #email').val(email);
       $('#edit_sub_contact_center #phone').val(phone);
       $('#edit_sub_contact_center #address').val(address);
      /* $('#edit_sub_contact_center #input_starttime').val(start_time);
       $('#edit_sub_contact_center #input_starttime1').val(end_time);*/
       $('#edit_sub_contact_center #additional_detail').val(additional_detail);

       $('#edit_sub_contact_center').modal('show');

   }

   function add_notes(note_id,note) {
       $('#note_id').val(note_id);
       $('#note').val(note);
       $('#notes').modal('show');
   }
   $(document).ready(function(e){


       $('#edit-sub-contact-center').validate({
           rules: {
               name: {required: true},start_time: {required: true},end_time: {required: true},
               email: {required: true,email:true},
               phone: {required: true,number:true,minlength:10,maxlength:11},
           },

           submitHandler: function(form) {

               $('#edit_sub_contact_center_button').attr('disabled', true);
               $('#edit_sub_contact_center_button').html('Loading ...');
                formData = new FormData($("#edit-sub-contact-center")[0]);
               $.ajax({
                   url: "{{url('/')}}/contact_center/ajax/edit_organization",
                   type: 'post',
                   cache: "false",
                   contentType: false,
                   processData: false,
                   data:formData,
                   error: function(errors) {
                      $('#edit_sub_contact_center_button').attr('disabled', false);
                           $('#edit_sub_contact_center_button').html('Edit Administrator');
                           error = $.parseJSON(errors.responseText);
                           $.each(error,function(key,value){
                                   if(typeof value.monday_start_time != 'undefined')
                           {
                               toastr['error'](value.monday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                           }
                           if(typeof value.monday_close_time != 'undefined')
                           {
                               toastr['error'](value.monday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                           }
                           if(typeof value.tuesday_start_time != 'undefined')
                           {
                               toastr['error'](value.tuesday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.tuesday_close_time != 'undefined')
                           {
                               toastr['error'](value.tuesday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }

                           if(typeof value.wednesday_start_time != 'undefined')
                           {
                               toastr['error'](value.wednesday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.wednesday_close_time != 'undefined')
                           {
                               toastr['error'](value.wednesday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }

                           if(typeof value.thursday_start_time != 'undefined')
                           {
                               toastr['error'](value.thursday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.thursday_close_time != 'undefined')
                           {
                               toastr['error'](value.thursday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.friday_start_time != 'undefined')
                           {
                               toastr['error'](value.friday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.friday_close_time != 'undefined')
                           {
                               toastr['error'](value.friday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }

                           if(typeof value.saturday_start_time != 'undefined')
                           {
                               toastr['error'](value.saturday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.saturday_close_time != 'undefined')
                           {
                               toastr['error'](value.saturday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }

                           if(typeof value.sunday_start_time != 'undefined')
                           {
                               toastr['error'](value.sunday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           if(typeof value.sunday_close_time != 'undefined')
                           {
                               toastr['error'](value.sunday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                           }
                           })

                   },
                   success: function(data) {
                       $('#add_sub_contact_center_button').attr('disabled', false);
                       $('#add_sub_contact_center_button').html('Save Administrator');
                       if (data == 'success') {
                           toastr["success"]('Changes confirmed');
                           window.setTimeout(function() {
                               location.reload();
                           }, 500)
                       } else {
                           toastr["error"](data);
                       }
                   }
               })
           }
       });

       $('#sub-admin-note').validate({
           rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
           },

           submitHandler:function(form){
               $('#noteButton').attr('disabled',true);
               $('#noteButton').html('Loading ...');
               var formData = new FormData($("#sub-admin-note")[0]);
               $.ajax({
                   url:"<?php echo url('/') ?>/contact_center/ajax/organization_note",
                   type:'post',
                   cache: "false",
                   contentType: false,
                   processData: false,
                   data: formData,
                   error:function(){
                       url='<?php echo url('/') ?>/contact_center/';
                   },
                   success:function(data)
                   {
                       $('#noteButton').attr('disabled',false);
                       $('#noteButton').html('Save Changes');
                       toastr["success"]('Saved successfully');
                       window.setTimeout(function() { location.reload() }, 100)
                   }
               })


           }
       });
   })

</script>
<script>

     $(function () {
       $('#example2').DataTable({
           "aaSorting": [],
           "sPaginationType": "full_numbers",
           "DisplayLength" : 20,
           'paging'      : true,
           'searching'   : true,
           'ordering'    : true,
           'info'        : true,
           'autoWidth'   : false,
           "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "language": {
                            "sLengthMenu": "_MENU_ Records",
                            "search": "Search  ",
                        }

       })
       })

   function change_status_admin(id,status,current)
   {

       bootbox.confirm("Are you sure you want to change the Admin status?", function (result) {
           if (result == true) {
                 $.ajax({
               "method" : "GET",
               url : "{{url('contact_center/ajax/change_admin_status')}}",
               data : "id="+id+"&status="+status,
               success : function(response,stat){

                   toastr["success"]('Changes confirmed');
                   if(response.status == 'enabled')
                   {
                       status_data = "Disable";
                       $(current).html(' <a href="javascript:;"><i class="fa fa-toggle-off"></i>'+' '+status_data+'</a>')

                   }else
                   {
                       status_data = "Enable"

                       $(current).html(' <a href="javascript:;"><i class="fa fa-toggle-on"></i>'+' '+status_data+'</a>')
                   }
                    window.setTimeout(function() { $('.toast-close-button').click(); }, 1000)
               },
           });



           }
           else {

           }
       });
   }

   function change_edit_schedule_status2(name,current)
   {
       value = $("#edit-admin-schedule select[name='"+name+"_status']").val();
       if(value == 'inactive')
       {

       $("#edit-admin-schedule select[name='"+name+"_start_time']").attr('disabled',true);
       $("#edit-admin-schedule select[name='"+name+"_close_time']").attr('disabled',true);
       $("#edit-admin-schedule select[name='"+name+"_start_time_am_pm']").attr('disabled',true);
       $("#edit-admin-schedule select[name='"+name+"_close_time_am_pm']").attr('disabled',true);
       // $("#edit-sub-contact-center .selectpicker").selectpicker('refresh');

       }else{

       $("#edit-admin-schedule select[name='"+name+"_start_time']").attr('disabled',false);
       $("#edit-admin-schedule select[name='"+name+"_close_time']").attr('disabled',false);
       $("#edit-admin-schedule select[name='"+name+"_start_time_am_pm']").attr('disabled',false);
       $("#edit-admin-schedule select[name='"+name+"_close_time_am_pm']").attr('disabled',false);
       // $(".selectpicker").selectpicker('refresh');

       }


   }

   function delete_admin(id,current)
   {
       table = $('#example2').DataTable();
       bootbox.confirm("Are you sure you want to delete this Admin?", function (result) {
           if (result == true) {
               $.ajax({
               "method" : "post",
               url : "{{url('contact_center/ajax/delete_admin')}}",
               data : "id="+id,
               success : function(response,stat){

                   toastr["success"]('Deleted successfully');

                    child_length = $(current).parents('tr.child').length;
                    window.setTimeout(function() { location.reload(); }, 1000)
               },
           });



           }
           else {

           }
       });
   }
   $(document).on('click','#edit_sub_contact_center  #add_additional',function(e){
   $('#edit_sub_contact_center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" placeholder="Add Some Additional" name="additional_fields[]"></div>')
   })



    function see_admin_schedule(schedule,current)
    {

                   $('#schedule-thead').show();
          <?php $days = \App\Days::all();
$days = json_encode($days);
?>
       days = '<?php echo $days ?>'

       schedule = JSON.parse(schedule)
       days = JSON.parse(days)
       tr = '';
               if(schedule.length != 0 )
               {
       schedule.sort();
                $.each(schedule,function(k,v){

                  tr += '<tr>'
                  tr += '<td style="font-size: 15px;">'+v.days.name+'</td>'
                  if(v.status === 'active')
                  {
                  tr += '<td style="font-size: 15px;">'+v.start_time.hour+' '+v.open_time_format+'</td>'

                  }else{

                  tr += '<td style="font-size: 15px;">'+v.status+'</td>'
                  }

                  if(v.status === 'active')
                  {
                  tr += '<td style="font-size: 15px;">'+v.close_time.hour+' '+v.close_time_format+'</td>'

                  }else{

                  tr += '<td style="font-size: 15px;">'+v.status+'</td>'
                  }

                  tr += '<tr>'
            })
               }else
               {
                   $('#schedule-thead').hide();
                  tr += "<div class='row'>"
                  tr += "<div class='col-sm-12 flex-center' >"
                  tr += '<h1 style="font-size: 20px;"> No Schedule Set Yet!</h1>'
                  tr += "</div>"

               }
               $('#schedule-tbody').html(tr);
               $('#schedule-modal').modal('show')
    }

       function adminscheduleid(id,schedule){
           $('#edit_admin_schedule #admin_id').val(id)
            <?php $days = \App\Days::all();
$days = json_encode($days);
?>
       days = '<?php echo $days ?>'

       schedule = JSON.parse(schedule)
       days = JSON.parse(days)
       $("#edit_admin_schedule select").attr('disabled',false);
       $("option:selected").prop("selected", false)
        $.each(days,function(key,value){

                $.each(schedule,function(k,v){
                   if(v.status == 'inactive' && value.id == v.day_id)
                   {

                   // inactive days selection
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_status'] > option[value='"+v.status+"']").prop('selected',true);
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time'] > option[value='"+v.open_time+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time'] > option[value='"+v.close_time.id+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time_am_pm'] > option[value='"+v.open_time_format+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time_am_pm'] > option[value='"+v.close_time_format+"']").prop('selected',true)[0];


                   // inactive days selection disabling
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time']").prop('disabled',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time']").prop('disabled',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time_am_pm']").prop('disabled',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time_am_pm']").prop('disabled',true)[0];
                   }else if(v.status == 'active' && value.id == v.day_id){

                   // active days dropdown selection


                       $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_status'] > option[value='"+v.status+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time'] > option[value='"+v.open_time+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time'] > option[value='"+v.close_time.id+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_start_time_am_pm'] > option[value='"+v.open_time_format+"']").prop('selected',true)[0];
                   $("#edit_admin_schedule select[name='"+value.name.toLowerCase()+"_close_time_am_pm'] > option[value='"+v.close_time_format+"']").prop('selected',true)[0];
                   }
            })
        })
       }

       $(document).on('submit','#edit-admin-schedule',function(e){
                       $('#edit-admin-schedule-button').attr('disabled', true);
                       $('#edit-admin-schedule-button').html('Loading...');
     e.preventDefault();
     var fd = new FormData($('#edit-admin-schedule')[0]);
       $.ajax({
       type : "post",
       url : '{{ url('contact_center/ajax/edit_admin_schedule') }}',
       contentType :false,
       processData : false,
       data : fd,
       success : function(data,status)
       {
           toastr['success']('schedule updated successfully')
           window.setTimeout(function(){ location.reload();},1000);

       }, error: function(errors) {
                       $('#edit-admin-schedule-button').attr('disabled', false);
                       $('#edit-admin-schedule-button').html('Update Schedule');
                       error = $.parseJSON(errors.responseText);
                       $.each(error,function(key,value){
                               if(typeof value.monday_start_time != 'undefined')
                       {
                           toastr['error'](value.monday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                       }
                       if(typeof value.monday_close_time != 'undefined')
                       {
                           toastr['error'](value.monday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                       }
                       if(typeof value.tuesday_start_time != 'undefined')
                       {
                           toastr['error'](value.tuesday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.tuesday_close_time != 'undefined')
                       {
                           toastr['error'](value.tuesday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }

                       if(typeof value.wednesday_start_time != 'undefined')
                       {
                           toastr['error'](value.wednesday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.wednesday_close_time != 'undefined')
                       {
                           toastr['error'](value.wednesday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }

                       if(typeof value.thursday_start_time != 'undefined')
                       {
                           toastr['error'](value.thursday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.thursday_close_time != 'undefined')
                       {
                           toastr['error'](value.thursday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.friday_start_time != 'undefined')
                       {
                           toastr['error'](value.friday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.friday_close_time != 'undefined')
                       {
                           toastr['error'](value.friday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }

                       if(typeof value.saturday_start_time != 'undefined')
                       {
                           toastr['error'](value.saturday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.saturday_close_time != 'undefined')
                       {
                           toastr['error'](value.saturday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }

                       if(typeof value.sunday_start_time != 'undefined')
                       {
                           toastr['error'](value.sunday_start_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }
                       if(typeof value.sunday_close_time != 'undefined')
                       {
                           toastr['error'](value.sunday_close_time);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                       }

                       })


                   },
                   })

   })

   function showNote(current)
   {

   $(current).popover('toggle')

   }
</script>
<style>
    ul.pagination li {
        display: inline;
        font-size: 12px;
        font-weight: bold;
    }

    ul.pagination li a {

        color: black;
        text-decoration: none;
        transition: background-color .3s;
        border: 1px solid #ddd;
            margin: 0;
    }

    ul.pagination li a.active {
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    ul.pagination li.active {
        /*background-color: #4CAF50;*/
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    /*ul.pagination li a:hover:not(.active) {background-color: #ddd;}*/
    ul.pagination li a:hover {background-color: #999999;}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 0;
}
 #example2_paginate > ul > li.paginate_button.active:hover {
    background: transparent !important;
    border: none !important;
}
    ul.pagination li.disabled {
        /*background-color: #cccccc;*/
        color: #ddd;
        padding: 10px 15px;
        border: 1px solid #ddd;
        margin: 4px;
    }
     table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
         display: none !important;
     }
     .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 !important;
        margin: 2px;
    }

@media screen and (max-width: 768px){

    .table div.dropdown-menu {
    width: 165px;
    right: 0px;
    z-index: 99999;
    position: relative;
    top: auto;
}
 .table button#action {
    margin-left: 80px;
    margin-top: -35px;
}
}


</style>

@stop