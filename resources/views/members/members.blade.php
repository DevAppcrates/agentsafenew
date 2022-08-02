@extends('layout.default')
@section('content')
    @include('header')
    <!--Main layout-->

    <main class="">
        <div class="container-fluid" style="height: 500px" >
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <br>
                    <br>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>Contact Centers</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-header-fixed responsive table-success" id="example2">
                                @php $i = 1; @endphp
                                <thead>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Organization Name</th>
                                    <th>Code</th>
                                    <th>No of users</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Organization Name</th>
                                    <th>Code</th>
                                    <th>No of users</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody>
                                    @php $i =1;  @endphp 
                                @foreach($users as $user)
                                    <tr>
                                        <td style="display: none">{{$i}}</td>
                                        <td >{{$user->name}}</td>
                                        <td >{{$user->organization_name}}</td>
                                        <td >{{$user->code}}</td>
                                        <td >{{$user->no_of_users}}</td>
                                              <td><a tabindex="0" role="button" data-trigger="focus" onclick="showNote(this)" class="btn btn-circle-bottom btn-primary btn-xs" data-toggle="popover"  data-placement="top" title="{{ $user->organization_name }} Note" data-content="{{ $user->notes?$user->notes:"N/A" }}">View Notes</button></td>
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                  
                                                     <a class="dropdown-item" href="{{ route('contact-center-detail',['org_id'=>$user->organization_id]) }}"><i class="fa fa-expand"></i> View Detail</a>
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
                    <form class="form-group" id="sub-admin-note" novalidate="novalidate">
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
    <!--/Main layout-->
    @include('footer')

    <!--/Main layout-->
   
    <!-- * edit Details * -->
  <div class="modal fade" id="contact_center_detail_2" tabindex="-1" role="dialog">
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
                 
                        <label class="form-label">Name</label>
                        <input class="form-control" type="text" readonly="readonly" name="user_name" id="user_name"  placeholder="Name">
                        <br>
                        <label class="form-label">Organization Name</label>
                        <input class="form-control" type="text" readonly="readonly" id="name" name="name" placeholder="Organization Name">
                        <input class="form-control" readonly="readonly" type="hidden" id="id" name="id" placeholder="Organization Name">
                        <br>
                        <label class="form-label">Organization Email</label>
                        <input readonly="readonly" class="form-control" type="text" id="email"  placeholder="Organization Email" readonly>
                        <br>
                        <label class="form-label">Organization Phone</label>
                        <input readonly="readonly" class="form-control" type="text" id="phone" name="phone" placeholder="Organization Phone">
                        <br>
                        <label class="form-label">Organization Code</label>
                        <input readonly="readonly" class="form-control" type="text" id="code" placeholder="Organization Code" readonly>
                        <br>
                        <label class="form-label">Address</label>
                        <input readonly="readonly" class="form-control" type="text" name="address" id="address" placeholder="Address">
                        <br>
                        <label class="form-label">No Of Users</label>
                        <input readonly="readonly" class="form-control" type="text" name="no_of_users" id="no_of_users" placeholder="No Of Users">
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

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
            $('#example2').DataTable({
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
                'aaSorting' : [],
            })
        });

        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 20
        });
        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 10
        });
        $('#users_filter input').addClass('form-control');

      

        function  view_detail_readonly(id,u_name,name,email,phone,code,address,no_of_users) {
            $('#contact_center_detail_2 #id').val(id);
            $('#contact_center_detail_2 #name').val(name);
            $('#contact_center_detail_2 #user_name').val(u_name);
            $('#contact_center_detail_2 #email').val(email);
            $('#contact_center_detail_2 #phone').val(phone);
            $('#contact_center_detail_2 #code').val(code);
            $('#contact_center_detail_2 #address').val(address);
            $('#contact_center_detail_2 #no_of_users').val(no_of_users);
            $('#contact_center_detail_2').modal('show')
        }

        function add_notes(note_id,note) {
            $('#note_id').val(note_id);
            $('#note').val(note);
            $('#notes').modal('show');
        }

        $('#sub-admin-note').validate({
            rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
            },

            submitHandler:function(form){
                $('#noteButton').attr('disabled',true);
                $('#noteButton').html('Loading ...');
                var formData = new FormData($("#sub-admin-note")[0]);
                $.ajax({
                    url:"<?php echo url('/')?>/contact_center/ajax/organization_note",
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
                        toastr["success"]('Saved successfully');
                        window.setTimeout(function() { location.reload() }, 100)
                    }
                })


            }
        });
        
        function showNote(current)
        {   

        $(current).popover('toggle')

        }
    </script>

    <!--detail -->
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
        }
    </style>
@endsection