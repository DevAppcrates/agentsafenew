@extends('layout.default')
@section('content')
    @include('header')
    <!--Main layout-->

    <main class="">
        <div class="container" style="height: 500px" >
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <br>
                    <br>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-users"></i>Users</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-header-fixed responsive table-success" id="example_1">
                                @php $i = 1; @endphp
                                <thead>
                                <tr>
                                    <th style="display: none">Id</th>
                                    <th>Contact Center</th>
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
                                    <th style="display: none">Id</th>
                                    <th>Contact Center</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Created At</th>
                                    <th>notes</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td style="display: none">{{$user->id}}</td>
                                        <td >{{$user->organization->organization_name}}</td>
                                        <td ><a onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number}}','{{$user->date_of_birth}}','{{$user->display_picture}}','{{$user->user_address->address_1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}')"
                                                class="waves-effect blue-grey-text ml-0" >{{$user->first_name.' '.$user->last_name}}</a></td>
                                        <td >{{$user->email}}</td>
                                        <td >{{$user->phone_number}}</td>

                                        <td >{{$user->created_at}}</td>
                                          <td><button type="button" class="btn btn-circle-bottom btn-info" data-toggle="popover"  data-placement="top" title="{{ $user->first_name }} Notes" data-content="{{ $user->notes?$user->notes:"N/A" }}">View Notes</button></td>
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number}}','{{$user->date_of_birth}}','{{$user->display_picture}}','{{$user->user_address->address_1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}')"><i class="fa fa-expand"></i>  View Detail</a>
                                                    @if(session('contact_center_admin.0.type') != 2)
                                                    <a class="dropdown-item status_change_admin" onclick="change_status('{{$user->user_id}}','{{$user->status}}',this)">@if($user->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>
                                                    @endif
                                                    @if(!empty($user->notes))

                                                        <button type="button" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="{{$user->notes}}">
                                                            <i class="fa fa-sticky-note"></i> View Notes
                                                        </button>
                                                    @endif
                                                    @php
                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($user->notes))))));

                                                    @endphp
                                                    <a class="dropdown-item" onclick="add_notes('{{$user->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>

                                                </div>
                                            </div>
                                        </td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

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
                    <form class="form-group" id="add-sub-contact-center"  novalidate="novalidate">
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
                            <input class="form-control" type="text" id="phone" placeholder="Phone No">
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

    <!--/Main layout-->
    @include('footer')
    <script>
        var oTable = $('#example1').dataTable(
            {
                "sScrollY":  "100%",
                "bPaginate": true,
                "bJQueryUI": true,
                "bScrollCollapse": false,
                "bLengthChange": true,
                "bAutoWidth": false,
                "sScrollX": "100%",

            });

        $(document).ready(function() {
            $('#example_1').DataTable({
                "binfo": true,
                'paging'      : true,
                'searching'   : true,
                'ordering'    : true,
                'LengthChange' : true,
                'info'        : true,
                'autoWidth'   : false,
                "DisplayLength": 5,
                "LengthMenu": [[1, 25, 50, -1], [1, 25, 50, "All"]],
                "bPaginate": true,
            })
        });

        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 20
        });
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

        function userDetail(fname,lname,email,phone,dob,image,add1,add2,city,state,country,zip,illergies,dr_name,dr_phone) {
            $('#f_name').val(fname);
            $('#l_name').val(lname);
            $('#email').val(email);
            $('#phone').val(phone);
            $('#dob').val(dob);
            $('#add1').val(add1);
            $('#add2').val(add2);
            $('#city').val(city);
            $('#state').val(state);
            $('#country').val(country);
            $('#zipcode').val(zip);
            $('#illness_allergies').val(illergies);
            $('#dr_name').val(dr_name);
            $('#dr_phone').val(dr_phone);
            $("#image").attr("src",image);

            $('#user_detail').modal('show');
        }

        function add_notes(note_id,note) {
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
                    url:"<?php echo url('/')?>/contact_center/ajax/user_note",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/')?>/contact_center/';
                    },
                    success:function(data)
                    {
                        $('#noteButton').attr('disabled',false);
                        $('#noteButton').html('Save Changes');
                        toastr["success"]('Saved Successfully');
                        window.setTimeout(function() { location.reload() }, 100)
                    }
                })


            }
        });
    </script>
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
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
            margin: 4px;
        }

        ul.pagination li a.active {
            background-color: #047dc4;
            padding: 10px 15px;
            margin: 4px;
            color: white;
            border: 1px solid #047dc4;
        }

        ul.pagination li.active {
            /*background-color: #4CAF50;*/
            background-color: #047dc4;
            padding: 10px 15px;
            margin: 4px;
            color: white;
            border: 1px solid #047dc4;
        }

        /*ul.pagination li a:hover:not(.active) {background-color: #ddd;}*/
        ul.pagination li a:hover {background-color: #999999;}

        ul.pagination li.disabled {
            /*background-color: #cccccc;*/
            color: #ddd;
            padding: 10px 15px;
            border: 1px solid #ddd;
            margin: 4px;
        }
    </style>
@endsection