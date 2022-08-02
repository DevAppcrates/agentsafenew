@extends('layout.default')
@section('content')
@include('header')
<style type="text/css">
    .display-4 {
    font-size: 2.5rem;

}
table#example1 tbody th, table#example1 tbody td {
    padding: 5px 26px !important;
}
table.dataTable tbody th, table.dataTable tbody td {
    padding: 5px 13px !important;
}

p.lead:hover {
    background: linear-gradient(#ebebeb,#cbcbcb);
}
p.lead {
    border: 1px solid black; 
    box-shadow: 3px 5px grey;
    border-radius: 5px;

}
textarea.lead{
    border: 1px solid black; 
    box-shadow: 3px 5px grey;
    border-radius: 5px;
    min-height: 100px;
}
</style>
 <main class="">
        <div class="container-fluid" >
            <div class="row">
                <div class="col-xs-12 col-md-8 col-sm-6">
                    <br>
                    <br>
                    <div id="info_box" style="display: none;" class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>{{ $contact_detail->organization_name }} Information</div>
                        </div>
                        <div class="portlet-body" >
                            <div class="row">
                                <div class="col-sm-6">
                                    <h2><small class="text-muted">Organization Name:</small></h2>
                                <h1 style="float: left; font-family: cursive;" class="display-4">{{$contact_detail->organization_name}}</h1>
                                </div>
                                <div style="float: right;" class="col-sm-5 col-xs-8">
                                <h2><small class="text-muted">Organization Code:</small></h2><h2 class="display-4">{!! $contact_detail->code !!}</h2>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-sm-6">
                                     <label><b>Email:</b></label>
                                <br>
                                <p class="lead" style="text-align: center;">{{ $contact_detail->email  }}</p>
                                </div>
                                <div class="col-sm-6">
                                     <label><b>Phone Number:</b></label>
                                <br>
                                <p class="lead" style="text-align: center;">{{ $contact_detail->phone_number }}</p>
                                </div>
                            </div>
                            <div class="row">
                                
                                <div class="col-sm-5">
                                     <label><b>Address:</b></label>
                                <p class="lead" style="text-align: center;">{{ $contact_detail->address }}</p>
                                     <label><b>Additional Field:</b></label>
                                <ol>
                            @if(is_array($contact_detail->additional_fields ) && count($contact_detail->additional_fields))
                                @foreach($contact_detail->additional_fields as $detail) <li>{{ $detail }}</li> @endforeach @else <li>{{ "N/A" }} </li>
                                @endif
                                </ol>
                                </div>
                                <div class="col-sm-2">

                                       <label><b>No Of Users:</b></label>
                                       <p class="lead" style="text-align: center;">{{ $contact_detail->no_of_users  }}</p>

                                   </div>
                                   <div class="col-sm-5">
                                    <label><b>Note:</b></label>
                                    <br>
                                     <textarea class="lead">@if($contact_detail->additional_detail != NULL){{ $contact_detail->additional_detail }}@else{{ "N/A" }}@endif</textarea>
                                </div>
                            </div>
                               
                           
                        <div class="row">
                            <div class="col-sm-5">
                                       <label><b>Timezone Information:</b></label>
                                <p class="lead">
                                       {{ $contact_detail['time_zone']['timezone'] }}
                                       {{ $contact_detail['time_zone']['standard_time'] }}
                                </p>

                                       <label><b> Timezone Identifier:</b></label>
                                <p class="lead" style="text-align: center;">
                                       {{ $contact_detail['time_zone']['timezone_code'] }}
                                </p>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-4 col-sm-6">
                    <br>
                    <br>
                    <div id="manage_box" style="display: none;" class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Manage</div>
                        </div>
                            <div class="list-group">
                               
  <a href="javascript:void(0);" data-value="{{ $contact_detail->status }}" id="status" class="list-group-item list-group-item-action @if($contact_detail->status == 'enabled') {{ 'bg-success' }} @else {{ 'bg-danger' }} @endif"><b>
        @if($contact_detail->status == 'enabled'){{ "Enabled" }}
        @else
        {{ "Disabled" }}
        @endif
    </b></a>
    <a href="javascript:void(0);" class="list-group-item list-group-item-action delete_cc" onclick="delete_cc('{{ $contact_detail->organization_id }}',this)"><b>Delete Contact Center</b></a>
  <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="view_detail('{{$contact_detail->id}}','{{$contact_detail->name}}','{{$contact_detail->organization_name}}','{{$contact_detail->email}}','{{substr($contact_detail->phone_number, -10)}}','{{$contact_detail->code}}','{{$contact_detail->address}}','{{$contact_detail->no_of_users}}','{{ $contact_detail->additional_detail }}','{{ $contact_detail->timezone_id }}')">
    <b>Edit Contact Center</b></a>
                               
  <a href="javascript:void(0);" id="view-admin" class="list-group-item list-group-item-action"><b>{{ $contact_detail->organization_name." Admins" }}</b></a>
<a href="javascript:void(0);" id="view-users" class="list-group-item list-group-item-action"><b>{{ $contact_detail->organization_name." Users" }}</b></a>
    
   
<a href="javascript:void(0);" id="add_contact_center_admin" data-id="{{ $contact_detail->organization_id }}" data-toggle="modal" data-target="#add_sub_contact_center2" class="list-group-item list-group-item-action"><b>Add New Admin</b></a>
   
        </div>
    </div>
                    
                </div>
            </div>
             <div class="row scrollSection" id="admin_details"  style="display: none;">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <br>
                    <br>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Sub Admins Of {{ $contact_detail->organization_name }}</div>
                        </div>
                        <div class="portlet-body">
                             <table class="table table-scrollable table-striped table-bordered table-success responsive"  id="example2">
                                <thead>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Type</th>
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
                                        <td >
                                         @if($admin->type == '3')
                                        {{"Super Admin"}}
                                        @else
                                        {{ 'Sub Admin' }}
                                        @endif
                                    </td>
                                <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-circle-bottom panic-note btn-info" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="{{ $admin->name }} Note" data-content="{{ $admin->notes?$admin->notes:"N/A" }}">View Notes</button></td>
                                  
                            <td >
                                <div class="btn-group">
                                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                    <div class="dropdown-menu">
                                        <a class="dropdown-item status_change_admin" onclick="change_status_admin('{{$admin->id}}','{{$admin->status}}',this)">@if($admin->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>

                                        <a class="dropdown-item" onclick="edit_admin('{{$admin->id}}','{{$admin->name}}','{{$admin->email}}','{{substr($admin->phone_number,-10)}}','{{$admin->address}}','{{$admin->start_time}}','{{$admin->end_time}}')"><i class="fa fa-pencil"></i>Edit Info</a>
                                        
                                        @php
                                            $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($admin->notes))))));
                                        @endphp
                                        <a class="dropdown-item" onclick="add_admin_notes('{{$admin->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                         <a class="dropdown-item delete_admin" data-id='{{$admin->id}}'><i class="fa fa-trash"></i> Delete</a>
                                         <a class="dropdown-item" data-toggle='modal' data-target='#edit_admin_schedule2' onclick="adminscheduleid('{{$admin->id}}','{{ $admin->schedule }}')"><i class="fa fa-edit"></i> Edit Schedule</a>
                                    </div>
                                </div>
                            </td>
                                       
                        </tr>
                                    @php $i++; @endphp
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
         <div class="row scrollSection2" id="users_detail" style="display: none;">
            <div class="col-xs-12 col-md-12 col-sm-12">
                <br>
                <br>
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-globe"></i>Users Of {{ $contact_detail->organization_name }}</div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-scrollable table-striped table-hover table-header-fixed responsive table-success" id="example1">
                                        @php $i = 1; @endphp
                                <thead>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                   
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                   <th>Notes</th>
                                    <th>Action</th>

                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($users as $user)
                                <tr>
                                <td style="display: none">{{$i}}</td>
                                <td ><a onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number}}','{{$user->date_of_birth}}','{{$user->display_picture}}','{{$user->user_address->address1}}','{{$user->user_address->address2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}')"
                                        class="waves-effect blue-grey-text ml-0" >{{$user->first_name.' '.$user->last_name}}</a></td>
                                <td >{{$user->email}}</td>
                                <td >{{$user->phone_number}}</td>
                                <td >{{$user->created_at}}</td>
                                <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-circle-bottom panic-note btn-info" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="{{ $user->first_name }} Note" data-content="{{ $user->notes?$user->notes:"N/A" }}">View Notes</button></td>
                                <td >
                                <div class="btn-group">
                                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                    <div class="dropdown-menu">
                                       
                                       
                                       <a class="dropdown-item status_change_user" onclick="change_status('{{$user->id}}',this)">@if($user->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>
                                        <a class="dropdown-item" onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number}}','{{$user->date_of_birth}}','{{$user->display_picture}}','{{$user->user_address->address1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}')"><i class="fa fa-expand"></i> View Detail</a>
                            @php
                                $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($user->notes))))));

                            @endphp
                            <a class="dropdown-item" onclick="add_notes('{{$user->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>

                        </div>
                    </div>
                </td>
                
            </tr>
                @php $i++; @endphp
            @endforeach
            </tbody>
        </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
<div class="modal fade" id="contact_center_detail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content" style="margin-top: 70px">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">Contact Center Detail</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
                <form class="form-group" id="edit-contact-center">
                    <label class="form-label">Name</label>
                    <input class="form-control" type="text" name="user_name" id="user_name"  placeholder="Name">
                    <br>
                    <label class="form-label">Organization Name</label>
                    <input class="form-control" type="text" id="name" name="name" placeholder="Organization Name">
                    <input class="form-control" type="hidden" id="id" name="id" placeholder="Organization Name">
                    <br>
                    <label class="form-label">Organization Email</label>
                    <input class="form-control" type="text" name="email" id="email"  placeholder="Organization Email">
                    <br>
                     <div class="row">
                <div class="col-sm-5">
                  <div class="form-group">
                  <label>Select Country code</label>
                <select class="selectpicker form-control" data-style='btn-circle-left'  data-live-search="true" name="phone_code">
                  <?php $countries = \App\Countries::all(); ?>
                  @foreach($countries as $country)
                  <option value="{{ $country->id }}" @if($country->id ==  $contact_detail->country_id) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                  @endforeach
                </select>
               </div>
                </div>
                 <div class="col-sm-7" id="col-six">
                   
               <label class="form-label">Organization Phone</label>
               <input class="form-control form-control-lg" autocomplete="off" style="height: 40px;" type="text" name="phone" id="phone" placeholder="Enter Numbers Only-No Spaces">
                 </div>
               </div>
                    <br>
                    <label class="form-label">Organization Code</label>
                    <input class="form-control" type="text" id="code" placeholder="Organization Code" readonly>
                    <br>
                    <label class="form-label">Address</label>
                    <input class="form-control" type="text" name="address" id="address" placeholder="Address">
                    <br>
                    <label class="form-label">No Of Users</label>
                    <input class="form-control" type="text" name="no_of_users" id="no_of_users" placeholder="No Of Users">
                    <br>
                      <div class="form-group">
                <label>Time Zone</label>
                   <select name="time_zone" class="form-control">
                      <?php $time_zone = \App\TimeZone::get(); ?>
                      <option value="">select Time zone</option>
                      @foreach($time_zone as $time)
                      <option value="{{ $time->id }}" @if($time->id == $contact_detail->timezone_id)selected @endif>{{ $time->timezone.' '.$time->standard_time }}</option>
                      @endforeach
                   </select>
               </div>
                     <div class="form-group">
                <label>Additional Note</label>
                   <textarea name="additional_detail" id="additional_note" placeholder="Additional Note" class="form-control"></textarea>
               </div>
                     <div  class="form-group additional_field">
               </div>
               <div class="col-sm-4" style="float: right;">
               <button type="button" id="add_additional" class="btn btn-primary waves-effect">Add Additional Field</button>
               </div>
                    <button class="btn btn-block btn-warning"  id="edit_contact_center_button">Edit Contact Center</button>
                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<div class="modal fade" id="add_sub_contact_center2" tabindex="-1" role="dialog">
   <div class="modal-dialog" role="document">
      <!--Content-->
      <div class="modal-content" style="margin-top: 70px">
         <!--Header-->
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">Add Administrator</h4>
         </div>
         <!--Body-->
            <form class="form-group" id="add-sub-contact-center2"  novalidate="novalidate">
         <div class="modal-body">
                <input type="hidden" name="organization_id">
               <label class="form-label"> Name</label>
               <input class="form-control" type="text" name="name" placeholder="Name">
               <br>
               <label class="form-label">Email</label>
               <input class="form-control" type="text" name="email" placeholder="Email">
               <br>
               <label class="form-label">Password</label>
               <input class="form-control" type="text" name="password" placeholder="Password">
               <br>
                <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <label>Select Country code</label>
                        <select class="selectpicker form-control" disabled data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                          <?php $countries = \App\Countries::all(); ?>
                          @foreach($countries as $country)
                          <option value="{{ $country->id }}" @if($country->id ==  $contact_detail->country_id) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                <div class="col-sm-7" id="col-six">  
                   <label class="form-label">Phone</label>
                   <input class="form-control form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" placeholder="Enter Numbers Only-No Spaces">
                </div>
               </div>
               <br>
               <br/>
               <label class="form-label">Address</label>
               <input class="form-control" type="text" name="address" placeholder="Address">
               <br>
               <div class="form-group">
                <label>Additional Note</label>
                   <textarea name="additional_detail" placeholder="Additional Note" class="form-control"></textarea>
               </div>
               <div  class="form-group additional_field"></div>
         </div>
          <div class="modal-footer">     
                        <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
               <button class="btn btn-lg btn-warning"  id="add_sub_contact_center_button2">Add Administrator</button>
      </div>
            </form>
      </div>
      <!--/.Content-->
   </div>
</div>
 <div class="modal fade" id="edit_sub_contact_center2" tabindex="-1" role="dialog">
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
                    <form class="form-group" id="edit-sub-contact-center2"  novalidate="novalidate">
                <div class="modal-body">
                        <label class="form-label">Name</label>
                        <input class="form-control" type="text" name="name" id="name" placeholder="Name">
                        <br>
                        <label class="form-label">Email</label>
                        <input class="form-control" type="text" name="email" id="email" placeholder="Email" disabled>
                        <input class="form-control" type="hidden" name="id" id="id" placeholder="Email">
                        <br>
                    <div class="row">
                    <div class="col-sm-5">
                        <div class="form-group">
                          <label>Select Country code</label>
                        <select class="selectpicker form-control" disabled data-size='auto' data-style='btn-circle-left btn-xs'  data-live-search="true" name="phone_code">
                          <?php $countries = \App\Countries::all(); ?>
                          @foreach($countries as $country)
                          <option value="{{ $country->id }}" @if($country->id ==  $contact_detail->country_id) selected @endif>{{ $country->name }} (+{{ $country->phone_code }})</option>
                          @endforeach
                        </select>
                    </div>
                  </div>
                <div class="col-sm-7" id="col-six">  
                   <label class="form-label">Phone</label>
                   <input class="form-control form-control-lg" autocomplete="off" style="height: 29px;" type="text" name="phone" id="phone" placeholder="Enter Numbers Only-No Spaces">
                </div>
               </div>
                        <br>
                        <label class="form-label">Address</label>
                        <input class="form-control" type="text" name="address" id="address" placeholder="Address">
                        <br>
                        <div class="form-group">
                <label>Additional Note</label>
                   <textarea name="additional_detail" placeholder="Additional Note" class="form-control"></textarea>
               </div>
                        <div class="additional_field"></div>
                </div>
                 <div class="modal-footer">     
                        <button type="button" id="add_additional" class="btn btn-primary btn-lg waves-effect">Add Additional Field</button>
                        <button class="btn btn-lg btn-warning"  id="edit_sub_contact_center_button">Edit Administrator</button>
      </div>
                    </form>
            </div>
            <!--/.Content-->
        </div>
    </div>
    <div class="modal fade" id="user_detail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content" style="margin-top: 70px">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">User Detail</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
                <form class="form-group" id="add-sub-contact-center_user"  novalidate="novalidate">
                    <div class="col-md-4">
                        <img id="image" src="{{url('/')}}/public/images/default.png" class="img-thumbnail img-responsive" alt="" style="width: 205px;height: 165px;">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">First Name</label>
                        <input class="form-control" type="text" name="name" id="f_name" placeholder="First Name">
                        <br>
                        <label class="form-label">Last Name</label>
                        <input class="form-control" type="text" name="name" id="l_name" placeholder="Last Name">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="text" name="name" id="email" placeholder="Email">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Phone No</label>
                        <input class="form-control" type="text" id="phone" placeholder="Enter Numbers Only-No Spaces">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"> Date of birth</label>
                        <input class="form-control" type="text" id="dob" placeholder="Date of birth">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Address 1</label>
                        <input class="form-control" type="text" id="add1" placeholder="Address 1">
                        <br>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label">Address 2</label>
                        <input class="form-control" type="text" id="add2" placeholder="Address 2">
                        <br>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input class="form-control" type="text" id="city" placeholder="City">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input class="form-control" type="text" id="state" placeholder="State">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Zipcode</label>
                        <input class="form-control" type="text" id="zipcode" placeholder="Zipcode">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input class="form-control" type="text" id="country" placeholder="Country">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Illness allergies</label>
                        <input class="form-control" type="text" id="illness_allergies" placeholder="Illness allergies">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dr name</label>
                        <input class="form-control" type="text" id="dr_name" placeholder="Dr name">

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dr phone</label>
                        <input class="form-control" type="text" id="dr_phone" placeholder="Dr phone">
                        <br>
                    </div>

                    <input class="form-control" type="text" name="address" placeholder="Address" style="opacity: 0">

                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
 <div class="modal fade" id="admin-notes" tabindex="-1" role="dialog">
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
                <div class="modal-body">
                    <form class="form-group" id="sub-admin-note" novalidate="novalidate">
                        <input type="hidden" name="id" >
                        <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                        <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                        <input type="hidden" name="note_id" id="note_id">
                        <br>
                        <button class="btn" id="noteButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Save Changes</button>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>
    <div class="modal fade" id="user-note" tabindex="-1" role="dialog">
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
                <div class="modal-body">
                    <form class="form-group" id="user-notes" novalidate="novalidate">
                        <input type="hidden" name="id" >
                        <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                        <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                        <input type="hidden" name="note_id" id="note_id">
                        <br>
                        <button class="btn" id="noteButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Save Changes</button>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_admin_schedule2" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content" style="margin-top: 70px">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><h5>X</h5></span>
                </button>
                <h4 class="modal-title"  id="edit_admin_schedule2Label">Edit Schedule</h4>
            </div>
            <!--Body-->
            <form id="edit-admin-schedule">
                <input type="hidden" name="admin_id" id="admin_id">
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
                          <select class="form-control" onchange="change_edit_schedule_status('{{ strtolower($day->name) }}',this)" data-style="red" name="{{ strtolower($day->name) }}_status">
                              <option value="active" @foreach($schedules as $schedule) @if($schedule['status'] == 'active' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Active</option>
                              <option value="inactive" @foreach($schedules as $schedule) @if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) selected @endif @endforeach>Inactive</option>
                           </select>
                        </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-3">
                             <select class="form-control" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time">
                                <option value="" @foreach($schedules as $schedule)@if($schedule['open_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set start time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['open_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                          </div>
                          <div class="col-sm-3">
                             <select class="form-control" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_start_time_am_pm">
                                <option value="am" @foreach($schedules as $schedule)@if($schedule['open_time_format'] == "am" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> AM</option>
                                <option value="pm" @foreach($schedules as $schedule) @if($schedule['open_time_format'] == "pm" && $schedule['day_id'] == $day['id']) selected @endif @endforeach> PM</option>
                             </select>
                             <br/>
                          </div>
                          <div class="col-sm-3">
                             <select class="form-control" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time">
                                <option value="" @foreach($schedules as $schedule) @if($schedule['close_time'] == '' && $schedule['day_id'] == $day['id']) selected @endif @endforeach> Set Close time</option>
                                 @foreach($hours as $hour)
                                    <option value="{{ $hour->id }}" @foreach($schedules as $schedule) @if($schedule['close_time'] == $hour->id && $schedule['day_id'] == $day['id']) selected @endif @endforeach>{{ $hour->hour }}</option>
                                 @endforeach
                             </select>
                          </div>
                          <div class="col-sm-3">
                            
                             <select class="form-control" @foreach($schedules as $schedule)@if($schedule['status'] == 'inactive' && $schedule['day_id'] == $day['id']) disabled @endif @endforeach data-style="red" name="{{ strtolower($day->name) }}_close_time_am_pm">
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

    @include('footer')
<script type="text/javascript">
     $('#sub-admin-note').validate({
            errorClass : "error_color",
            rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
            },

            submitHandler:function(form){
                $('#sub-admin-note #noteButton').attr('disabled',true);
                $('#sub-admin-note #noteButton').html('Loading ...');
                var formData = new FormData($("#sub-admin-note")[0]);
                $.ajax({
                    url:"<?php echo url('/')?>/ajax/cc_admin_note",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/')?>';
                    },
                    success:function(data)
                    {
                      $('#sub-admin-note #noteButton').attr('disabled',false);
                $('#sub-admin-note #noteButton').html('Save Changes ...');
                        toastr["success"]('Saved Successfully');
                        window.setTimeout(function() { location.reload() }, 100)
                    }
                })


            }
        });

       $('#user-notes').validate({
            errorClass : "error_color",
            rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
            },

            submitHandler:function(form){
                $('#user-note #noteButton').attr('disabled',true);
                $('#user-note #noteButton').html('Loading ...');
                var formData = new FormData($("#user-notes")[0]);
                $.ajax({
                    url:"<?php echo url('/')?>/ajax/cc_user_note",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/')?>';
                    },
                    success:function(data)
                    {
                      $('#user-note #noteButton').attr('disabled',false);
                $('#user-note #noteButton').html('Save Changes ...');
                        toastr["success"]('Saved Successfully');
                        window.setTimeout(function() { location.reload() }, 100)
                    }
                })


            }
        });

    $(function () {
        $('#example2').DataTable({
            "aaSorting": [[ 0, "asc" ]],
            "sPaginationType": "full_numbers",
            "DisplayLength" : 20,
            'paging'      : true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,
             "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

        })
        $('#example1').DataTable({
            "aaSorting": [[ 0, "asc" ]],
            "sPaginationType": "full_numbers",
            "DisplayLength" : 10,
            'paging'      : true,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false,

             "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

        })
        })

    function  view_detail(id,u_name,name,email,phone,code,address,no_of_users,additional_note,time_zone) {

         $.ajax({
            type : 'GET',
            url : '{{ url('ajax/get_additional_fields') }}',
            data : 'id='+id,
            success : function(data,status){
                if(data.additional_fields != null)
                {
                    $('#edit-contact-center .additional_field').empty();
                    $.each(data.additional_fields,function(k,v){

                            $('#edit-contact-center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" value="'+v+'" placeholder="Add Some Additional" name="additional_fields[]"></div>');
                    })
                }else{
                    $('#edit-contact-center .additional_field').empty();
                }
            },
        })

        $('#edit-contact-center #id').val(id);
        $('#edit-contact-center #name').val(name);
        $('#edit-contact-center #user_name').val(u_name);
        $('#edit-contact-center #email').val(email);
        $('#edit-contact-center #phone').val(phone);
        $('#edit-contact-center #code').val(code);
        $('#edit-contact-center #address').val(address);
        $('#edit-contact-center #no_of_users').val(no_of_users);
        $('#edit-contact-center #additional_note').val(additional_note);
        $('#edit-contact-center select[name="time_zone"] > option[value="'+time_zone+'"]').attr('selected',true);
        $('#contact_center_detail').modal('show')
    }

    //edit Contact Center
    $('#edit-contact-center').validate({
        rules: {
            name: {required: true},user_name: {required: true},
            email: {required: true,email:true},
            phone: {required: true,number:true,minlength:10,maxlength:11},
            code: {required: true},no_of_users: {required: true},
            time_zone: {required: true},
        },

        submitHandler: function(form) {

            $('#edit_contact_center_button').attr('disabled', true);
            $('#edit_contact_center_button').html('Loading ...');
            var formData = new FormData($("#edit-contact-center")[0]);
            $.ajax({
                url: "{{url('/')}}/ajax/edit_organization",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                error: function() {
                    url = '<?php echo url('/master-hub')?>';
                },
                success: function(data) {
                    $('#edit_contact_center_button').attr('disabled', false);
                    $('#edit_contact_center_button').html('Edit Contact Center');
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
    $(document).on('click','#status',function(e){
            statusbtn = $(this);
         id = "{{$contact_detail->id}}";
         status = $(this).data('value');
            $.ajax({
                "method" : "GET",
                url : "{{url('ajax/change_organization_status')}}",
                data : "id="+id+"&status="+status,
                success : function(response,stat){
                    if(response.status == 'enabled')
                    {
                     $(statusbtn).replaceWith('<a href="javascript:void(0);" data-value="enabled" id="status" class="list-group-item list-group-item-action  bg-success "><b>Enabled</b></a>');
                    
                    }else if(response.status == "disabled")
                    {
                    $(statusbtn).replaceWith('<a href="javascript:void(0);" data-value="disabled" id="status" class="list-group-item list-group-item-action  bg-danger "><b>Disabled</b></a>');
                    
                    }
                }
            });
    })
    $(document).on('click','#view-admin',function(){
        $("#admin_details").toggle();
        $("#users_detail").hide();
        $('html, body').animate({
        scrollTop: $(".scrollSection").offset().top
    }, 200);

    })
    $(document).on('click','#view-users',function(){
        
        $("#users_detail").toggle();
        $("#admin_details").hide();
$('html, body').animate({
        scrollTop: $(".scrollSection2").offset().top
    }, 200);
    })
     //Add Contact Center
        $('#add-sub-contact-center2').validate({
            rules: {
                name: {required: true},email: {required: true,email:true},
                phone: {required: true,number:true,maxlength:11,minlength:10},
                password: {minlength: 6,required: true,pwcheck:true},
            },
            messages: {

                password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },

            },

            submitHandler: function(form) {

                $('#add_sub_contact_center_button2').attr('disabled', true);
                $('#add_sub_contact_center_button2').html('Loading ...');
                var formData = new FormData($("#add-sub-contact-center2")[0]);
                $.ajax({
                    url: "{{url('/')}}/ajax/add_admin_for_contact_center",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function() {
                        url = '{{ url('/master-hub') }}';
                    },
                    success: function(data) {
                        $('#add_sub_contact_center_button2').attr('disabled', false);
                        $('#add_sub_contact_center_button2').html('Add Administrator');
                        if (data == 'success') {
                            toastr["success"]('Added successfully');
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

         // for cloning the additional fields for add sub-admin 
    $(document).on('click','#add-sub-contact-center2 #add_additional',function(e){
    $('#add-sub-contact-center2 .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })  
   
      $(document).on('click','#edit-sub-contact-center2 #add_additional',function(e){
    $('#edit-sub-contact-center2 .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })  
         $(document).on('click','#edit-contact-center #add_additional',function(e){
    $('#edit-contact-center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })  
    //for adding organization id in hidden oganization_id field 
    $(document).on("click",'#add_contact_center_admin',function(){
            organization_id = $(this).data('id');
            $("#add-sub-contact-center2 input[name='organization_id']").val(organization_id);
    });

      function edit_admin(id,name,email,phone,address,start_time,end_time)
    {
        $.ajax({
            type : 'GET',
            url : '{{ url('ajax/get_additional_fields') }}',
            data : 'id='+id,
            success : function(data,status){
                if(data.additional_fields != null)
                {
                    $('#edit_sub_contact_center2 .additional_field').empty();
                    $.each(data.additional_fields,function(k,v){
                            $('#edit_sub_contact_center2 .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control" value="'+v+'" placeholder="Add Some Additional" name="additional_fields[]"></div>');
                    })
                }else{
                    $('#edit_sub_contact_center2 .additional_field').empty();
                }
            },
        })
        $('#edit_sub_contact_center2 #id').val(id);
        $('#edit_sub_contact_center2 #name').val(name);
        $('#edit_sub_contact_center2 #email').val(email);
        $('#edit_sub_contact_center2 #phone').val(phone);
        $('#edit_sub_contact_center2 #address').val(address);
       /* $('#edit_sub_contact_center2 #input_starttime').val(start_time);
        $('#edit_sub_contact_center2 #input_starttime1').val(end_time);*/
        $('#edit_sub_contact_center2').modal('show');

    }
    $('#edit-sub-contact-center2').validate({
        rules: {
            name: {required: true},start_time: {required: true},end_time: {required: true},
            email: {required: true,email:true},
            phone: {required: true,number:true,maxlength:11,minlength:10},
        },

        submitHandler: function(form) {

            $('#edit_sub_contact_center_button2').attr('disabled', true);
            $('#edit_sub_contact_center_button2').html('Loading ...');
            var formData = new FormData($("#edit-sub-contact-center2")[0]);
            $.ajax({
                url: "{{url('/')}}/ajax/edit_admin_for_contact_center",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                error: function() {
                    url = '<?php echo url('/master-hub')?>';
                },
                success: function(data) {
                    $('#add_sub_contact_center_button').attr('disabled', false);
                    $('#add_sub_contact_center_button').html('Edit Administrator');
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


        function adminscheduleid(id,schedule){
            $('#edit_admin_schedule2 #admin_id').val(id)
             <?php $days = \App\Days::all(); 
        $days = json_encode($days);
        ?>
        days = '<?php echo $days ?>'
        
        schedule = JSON.parse(schedule)
        days = JSON.parse(days)
        $("#edit_admin_schedule2 select").attr('disabled',false);
        
        $("option:selected").prop("selected", false)
         $.each(days,function(key,value){

                 $.each(schedule,function(k,v){
                    // alert(value.name.toLowerCase())
                    if(v.status == 'inactive' && value.id == v.day_id)
                    {
                        // alert(v.day_id+" "+v.status)
                        // alert(value.name.toLowerCase());
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_status'] > option[value='"+v.status+"']").prop('selected',true);
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_start_time']").prop('disabled',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_close_time']").prop('disabled',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_start_time_am_pm']").prop('disabled',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_close_time_am_pm']").prop('disabled',true)[0];
                    }else if(v.status == 'active' && value.id == v.day_id){

                        $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_status'] > option[value='"+v.status+"']").prop('selected',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_start_time'] > option[value='"+v.open_time+"']").prop('selected',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_close_time'] > option[value='"+v.close_time.id+"']").prop('selected',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_start_time_am_pm'] > option[value='"+v.open_time_format+"']").prop('selected',true)[0];
                    $("#edit_admin_schedule2 select[name='"+value.name.toLowerCase()+"_close_time_am_pm'] > option[value='"+v.close_time_format+"']").prop('selected',true)[0];
                    }
                    // $('#edit_admin_schedule2 .selectpicker').selectpicker('refresh')

             })
         })
        }


     function userDetail(fname,lname,email,phone,dob,image,add1,add2,city,state,country,zip,illergies,dr_name,dr_phone) {
        $('#user_detail #f_name').val(fname);
        $('#user_detail #l_name').val(lname);
        $('#user_detail #email').val(email);
        $('#user_detail #phone').val(phone);
        $('#user_detail #dob').val(dob);
        $('#user_detail #add1').val(add1);
        $('#user_detail #add2').val(add2);
        $('#user_detail #city').val(city);
        $('#user_detail #state').val(state);
        $('#user_detail #country').val(country);
        $('#user_detail #zip').val(zip);
        $('#user_detail #illness_allergies').val(illergies);
        $('#user_detail #dr_name').val(dr_name);
        $('#user_detail #dr_phone').val(dr_phone);
        $("#user_detail #image").attr("src",image);

        $('#user_detail').modal('show');
    }

     function add_notes(note_id,note) {
        $('#user-note #note_id').val(note_id);
        $('#user-note #note').val(note);
        $('#user-note').modal('show');
    }

    function add_admin_notes(note_id,note) {
        $('#admin-notes input[name="id"]').val(note_id);
        $('#admin-notes #note').val(note);
        $('#admin-notes').modal('show');
    }

    $(document).ready(function(){

        $("#info_box").fadeIn(3000)
        $("#manage_box").fadeIn(3000)

    })


    //delete Admin
    $(document).on('click','.delete_admin',function(){
         deleteAdmin = $(this);
            id = $(this).data('id')
              bootbox.confirm("You are going to delete Admin Are you sure?", function (result) {

            if (result == true) {

        $.ajax({
            type : "POST",
            url : "{{url('ajax/delete_admin_for_contact_center') }}",
            data : 'id='+id,
            success: function(data,status){
                toastr['success']('admin deleted successfully') 
                table = $('#example2').DataTable();
                table.row($(deleteAdmin).parents('tr')).remove().draw();
                 // tr.row($(current).parents('tr')).remove().draw();
            }
        })
            }
              })
    })
   function change_status(id,curr)
    {
        bootbox.confirm("Are you sure you want to change the user status?", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "GET",
                url : "{{url('ajax/change_user_status')}}",
                data : "id="+id,
                success : function(response,stat){
                    
                    toastr["success"]('Changes confirmed');
                    if(response.status == 'enabled')
                    {
                        status_data = "Disable";
                        $(curr).html('<i class="fa fa-toggle-off"></i>'+' '+status_data)
                    }else
                    {
                        status_data = "Enable"

                        $(curr).html('<i class="fa fa-toggle-on"></i>'+' '+status_data)
                    }

                     window.setTimeout(function() { $('.toast-close-button').click(); }, 1000)
                },
            });
            }
            else {

            }
        });
    }
    function change_status_admin(id,status,current)
    {

        bootbox.confirm("Are you sure you want to change the admin status?", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "GET",
                url : "{{url('ajax/change_organization_status')}}",
                data : "id="+id+"&status="+status,
                success : function(response,stat){
                    
                    toastr["success"]('Changes confirmed');
                    if(response.status == 'enabled')
                    {
                        status_data = "Disable";
                        $(current).html('<i class="fa fa-toggle-off"></i>'+' '+status_data)
                    }else
                    {
                        status_data = "Enable"

                        $(current).html('<i class="fa fa-toggle-on"></i>'+' '+status_data)
                    }
                     window.setTimeout(function() { $('.toast-close-button').click(); }, 1000)
                },
            });


               
            }
            else {

            }
        });
    }


function delete_cc(id,current)
    {

        bootbox.confirm(" “Are you sure? Deleting this Contact Center will also delete all Users & their Panic Alerts associated with those Users.”", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "POST",
                url : "{{url('ajax/delete_cc')}}",
                data : "org_id="+id,
                success : function(response,stat){
                    
                    toastr["success"]('Deleted Successfully');
                    
                     window.setTimeout(function() { window.location.href = "{{ url('master-hub/organization') }}" }, 1000)
                },
            });
               
            }
            else {

            }
        });
    }

     $(document).on('submit','#edit-admin-schedule',function(e){
                        $('#edit-admin-schedule-button').attr('disabled', true);
                        $('#edit-admin-schedule-button').html('Update Schedule');
      e.preventDefault();
      var fd = new FormData($('#edit-admin-schedule')[0]);
        $.ajax({
        type : "post",
        url : '{{ url('ajax/edit_admin_schedule') }}',
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
    
    function change_edit_schedule_status(name,current)
    {
        value = $("#edit_admin_schedule2 select[name='"+name+"_status']").val();
        if(value == 'inactive')
        {
            
        $("#edit_admin_schedule2 select[name='"+name+"_start_time']").attr('disabled',true);
        $("#edit_admin_schedule2 select[name='"+name+"_close_time']").attr('disabled',true);
        $("#edit_admin_schedule2 select[name='"+name+"_start_time_am_pm']").attr('disabled',true);
        $("#edit_admin_schedule2 select[name='"+name+"_close_time_am_pm']").attr('disabled',true);
        // $("#edit-sub-contact-center .selectpicker").selectpicker('refresh');

        }else{
            
        $("#edit_admin_schedule2 select[name='"+name+"_start_time']").attr('disabled',false);
        $("#edit_admin_schedule2 select[name='"+name+"_close_time']").attr('disabled',false);
        $("#edit_admin_schedule2 select[name='"+name+"_start_time_am_pm']").attr('disabled',false);
        $("#edit_admin_schedule2 select[name='"+name+"_close_time_am_pm']").attr('disabled',false);
        // $(".selectpicker").selectpicker('refresh');

        }


    }
    function showNote(current)
    {   

    $(current).popover('toggle')

    }
</script>

@stop

