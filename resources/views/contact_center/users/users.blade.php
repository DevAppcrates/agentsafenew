@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} | Users
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
                        {{-- <h1 class="page-title"> {{ session('contact_center_admin.0.name') }}
                            <small>All App Users</small>
                        </h1> --}}
                        <!-- END PAGE TITLE-->
<?php
if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$email = $user[0]['email'];
	$name = $user[0]['organization_name'];
	$organization_id = $user[0]['organization_id'];
	$user_type = $user[0]['type'];

}

?>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="users frst-bx">
                                    <span class="us">
                                        Total App Users
                                    </span>
                                    <span class="total">
                                        <?php $allUsersCount = App\Users::where('organization_id', $organization_id)->get();?>
                                        {{ count($allUsersCount) }}
                                    </span>
                                </div>
                                 <div class="users">
                                    <span class="us">
                                        Enabled Users
                                    </span>
                                    <span class="total">
                                        <?php $allUsersEnabledCount = App\Users::where('organization_id', $organization_id)->where('status', 'enabled')->get();?>
                                        {{ count($allUsersEnabledCount) }}
                                    </span>
                                </div>
                                 <div class="users">
                                    <span class="us">
                                       Disabled Users
                                    </span>
                                    <span class="total">
                                        <?php $allUsersDisabledCount = App\Users::where('organization_id', $organization_id)->where('status', '!=', 'enabled')->get();?>
                                        {{ count($allUsersDisabledCount) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="margin-top: 3%">
                            <div class="col-md-12">


                                <div class="portlet light bg-inverse">
                                    <div class="portlet-title">
                                        <div class="caption font-green-sharp">
                                            <i class="icon-speech font-green-sharp"></i>
                                            <span class="caption-subject">
                                            <?php
if (Request::url() == url('/enabled_users')) {
	echo 'All Enabled Users';
} elseif (Request::url() == url('/disabled_users')) {
	echo 'All Disabled Users';
} else {
	echo 'All App Users';
}

?>
                                            </span>
                                            {{-- <span class="caption-helper"></span> --}}
                                        </div>

                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div><br>

                                    </div>
                                    <div class="note note-success">
                                        <p> These are users who have installed the iFollow Alerts app at least once. (note that we have no way to determine if the user has uninstalled the app after the initial installation). </p>
                                    </div>
                                    <div class="portlet-body">
                                        {{-- <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd"> --}}
                                            <div class="table-responsive">
                                            <table id="example2" class="table table-striped table-bordered table-hover dt-responsive">
                                                <thead>
                                                    @php $i = 1; @endphp

                                                    <tr>
                                                        <th style="display: none">#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Contact Center</th>
                                                        <th>Phone</th>
                                                        <th style="width: 300px">Tags</th>
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
                                                        <th>Contact Center</th>
                                                        <th>Phone</th>
                                                        <th>Tags</th>
                                                        <th>Created At</th>
                                                        <th>Notes</th>
                                                        <th>Action</th>
                                                    </tr>
                                                    </tfoot>
                                                <tbody>


                                                    @foreach($users as $user)
                                                            <tr>
                                                                <td style="display: none">{{$i}}</td>
                                                                <td ><a onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number?$user->country_code."".$user->phone_number:'N/A'}}','{{date('m/d/Y',strtotime($user->date_of_birth))}}','{{$user->display_picture}}','{{$user->user_address->address_1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}','{{ $user->user_emergency_contacts }}')"
                                                                        class="waves-effect blue-grey-text ml-0" >{{$user->first_name.' '.$user->last_name}}</a></td>
                                                                <td >{{$user->email}}</td>
                                                                <td >{{$user->organization->organization_name}}</td>
                                                                <td >{{$user->phone_number?$user->country_code."".$user->phone_number:'N/A'}}</td>
                                                                <td style="min-width: 150px"  id="spantags">
                                                                    @if($user->user_tags->count()>0)
                                                                        @foreach($user->user_tags as $tag)
                                                                            <span class="badge badge-pill light-blue">{{$tag->tag->tag_name}}</span>
                                                                        @endforeach
                                                                    @endif

                                                                </td>
                                                                <td >{{$user->created_at}}</td>
                                                                <td>
                                                                    <a  tabindex="0"
                                                                        role="button"
                                                                        style="width: 90px; height: 16px; margin-top:6px;"
                                                                        data-trigger="focus"
                                                                        class="btn btn-info"
                                                                        data-toggle="popover"
                                                                        onclick="showUserPopUp(this)"
                                                                        data-placement="top"
                                                                        title="{{ $user->first_name }} Notes"
                                                                        data-content="{{ $user->notes?$user->notes:"N/A" }}">
                                                                        View Notes
                                                                    </a>
                                                                </td>
                                                                <td >
                                                                    <div class="">

                                                                        <button class="btn
                                                                         btn-info dropdown-toggle"
                                                                         style="width: 90px; height: 16px; margin-top:6px;"
                                                                          type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                                        <div class="dropdown-menu pull-right">
                                                                            <a class="dropdown-item" onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number?$user->country_code."".$user->phone_number:'N/A'}}','{{$user->date_of_birth}}','{{$user->display_picture}}','{{$user->user_address->address_1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}','{{ $user->user_emergency_contacts }}')"><i class="fa fa-expand"></i> View Detail</a>

                                                                            @if(session('contact_center_admin.0.type') != 2)
                                                                <a class="dropdown-item status_change_admin" onclick="change_status('{{$user->user_id}}','{{$user->status}}',this)">@if($user->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>
                                                                @endif
                                                                             @if(session('contact_center_admin.0.type') != 2)
                                                                            <a class="dropdown-item" onclick="delete_users('{{$user->id}}',this)"><i class="fa fa-trash"></i> Delete User </a>
                                                                            @endif
                                                                            @php
                                                                                $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($user->notes))))));

                                                                            @endphp
                                                                            <a class="dropdown-item" onclick="add_notes('{{$user->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                                                            <a class="dropdown-item" onclick="user_tags('{{$user->user_id}}')"><i class="fa fa-tags"></i> Add/Edit Tags</a>

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
                <div class="modal-body">
                    <form class="form-group" id="user-note" novalidate="novalidate">
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

 <div class="modal fade" id="user_detail" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">User Detail</h4>
            </div>
            <!--Body-->
            <div class="modal-body">
                <form class="form-group" id="user-detail"  novalidate="novalidate">
                    <div class="col-md-4">
                        <img id="image" src="{{url('/')}}/public/images/default.png" class="img-thumbnail img-responsive" alt="" style="width: 205px;height: 165px;">
                    </div>
                    <div class="col-md-8">
                        <label class="form-label">First Name</label>
                        <input class="form-control btn-circle" type="text" name="name" id="f_name" placeholder="First Name">
                        <br>
                        <label class="form-label">Last Name</label>
                        <input class="form-control btn-circle" type="text" name="name" id="l_name" placeholder="Last Name">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control btn-circle" type="text" name="name" id="email" placeholder="Email">
                        <br>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone No</label>
                        <input class="form-control btn-circle" type="text" id="phone" placeholder="Phone No">
                        <br>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"> Date of birth</label>
                        <input class="form-control btn-circle" type="text" id="dob" placeholder="Date of birth">
                        <br>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address 1</label>
                        <input class="form-control btn-circle" type="text" id="add1" placeholder="Address 1">
                        <br>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address 2</label>
                        <input class="form-control btn-circle" type="text" id="add2" placeholder="Address 2">
                        <br>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">City</label>
                        <input class="form-control btn-circle" type="text" id="city" placeholder="City">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">State</label>
                        <input class="form-control btn-circle" type="text" id="state" placeholder="State">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Zipcode</label>
                        <input class="form-control btn-circle" type="text" id="zipcode" placeholder="Zipcode">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Country</label>
                        <input class="form-control btn-circle" type="text" id="country" placeholder="Country">
                        <br>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Illness allergies</label>
                        <input class="form-control btn-circle" type="text" id="illness_allergies" placeholder="Illness allergies">
                        <br>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dr name</label>
                        <input class="form-control btn-circle" type="text" id="dr_name" placeholder="Dr name">

                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Dr phone</label>
                        <input class="form-control btn-circle" type="text" id="dr_phone" placeholder="Dr phone">
                        <br>
                    </div>
                    <div id="user_emergency_contacts">

                    </div>

                    <input class="form-control" type="text" name="address" placeholder="Address" style="opacity: 0">

                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
 </div>

{{-- @include('footer') --}}




<style>

     #spantags > span.badge.badge-pill.light-blue {
        margin-top: 3px !important;
        width: 100px !important;
        height: 13px !important;
    }

    ul.pagination li {
        display: inline;
        font-size: 12px;
        font-weight: bold;
    }

    ul.pagination li a {

        color: black;
        padding: 10px 15px;
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
@media screen and (max-width: 768px){

    .table div.dropdown-menu {
    width: 165px;
    right: 0px;
    z-index: 99999;
    position: relative;
    top: auto;
}
.table button.btn {
    margin-left: 80px;
    margin-top: -35px;
}
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

</style>


@stop

@section('scripts')
<script>

    $('#users_filter input').addClass('form-control');
    //Delete practice tip

    function change_status(id)
    {
        bootbox.confirm("Are you sure you want to change the user status?", function (result) {
            if (result == true) {
                $.get("<?php echo url('/'); ?>/ajax/user_status/"+id, function (result) {

                    toastr["success"]('Changes confirmed');

                    window.setTimeout(function() { location.reload(); }, 1000)

                });
            }
            else {

            }
        });
    }
     function delete_users(id,current){
        bootbox.confirm("“Are you sure? Deleting this User will also delete all Panic Alerts associated with this User.”", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "POST",
                url : "{{url('/contact_center/ajax/delete_user')}}",
                data : "id="+id,
                success : function(response,stat){

                    toastr["success"]('Deleted Successfully');
                    child_length = $(current).parents('tr.child').length;
                    if(child_length == 1){
                        newObj = current;
                        $(current).parents('tr.child').prev("tr.parent").remove()
                        $(newObj).parents('tr.child').remove()
                    }else{
                        $(current).parents('tr').remove()
                    }
                     window.setTimeout(function() { $('.toast-close-button').click(); }, 1200)

                },
            });



            }
            else {

            }
        });
    }
    function userDetail(fname,lname,email,phone,dob,image,add1,add2,city,state,country,zip,illergies,dr_name,dr_phone,user_emergency_contacts) {
    $('#user_detail #user_emergency_contacts').empty();
        contacts = JSON.parse(user_emergency_contacts);
        i = 1;
        markup = '';
        if(contacts.length != 0 )
        {

        $.each(contacts,function(k,v){
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+'</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_name" value="'+(v.name? v.name: "N/A")+'" placeholder="Dr phone">'
              markup += '<br></div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_relation" value="'+(v.relation? v.relation : "N/A")+'" placeholder="Contact phone No:">'
              markup += '<br></div>'
              markup += '<div class="col-md-12">'
              markup += '<label class="form-label">Emergency Contact '+i+' Phone</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_phone" value="'+(v.phone? v.phone : "N/A")+'" placeholder="Contact phone No:">'
              markup += '<br></div>'
    i++;

        })
    }else{
        for (var i = 1; i <= 2; i++) {

              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+'</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_name" placeholder="Emergency Contact name">'
              markup += '<br></div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_relation" placeholder="Emergency Contact\'\s Relation">'
              markup += '<br></div>'
              markup += '<div class="col-md-12">'
              markup += '<label class="form-label">Emergency Contact '+i+' Phone</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_phone" placeholder="Emergency Contact phone No:">'
              markup += '</div>'
        }
    }
    $('#user_emergency_contacts').append(markup);
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
        $('#user_detail #zipcode').val(zip);
        $('#user_detail #illness_allergies').val(illergies);
        $('#user_detail #dr_name').val(dr_name);
        $('#user_detail #dr_phone').val(dr_phone);
        $("#user_detail #image").attr("src",image);
        $('#user_detail').modal('show');
    }

    function add_notes(note_id,note)
    {
        $('#note_id').val(note_id);
        $('#note').val(note);
        $('#notes').modal('show');
    }

    $('#user-note').validate({
        rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
        },

        submitHandler:function(form){
            $('#noteButton').attr('disabled',true);
            $('#noteButton').html('Loading ...');
            var formData = new FormData($("#user-note")[0]);
            $.ajax({
                url:"<?php echo url('/') ?>/contact_center/ajax/user_note",
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
                    toastr["success"]('Saved Successfully');
                    window.setTimeout(function() { location.reload() }, 1000)
                }
            })


        }
    });

    function showUserPopUp(current)
    {
        $(current).popover('toggle')
    }

    function user_tags(id) {

        $.ajax({
            url: "{{url('/')}}/contact_center/ajax/user_tags/"+id+"/1",
            type: 'get',
            error: function() {
                setTimeout(function () {
                    $('.loader').hide();
                },500);
            },
            success: function(data) {
                $('#user_tags').html(data);
                $('#userTags').modal('show');
            }
        })
    }



</script>


<script type="text/javascript">

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
</script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

@stop
