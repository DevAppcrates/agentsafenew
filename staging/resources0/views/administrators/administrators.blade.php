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
                                <i class="fa fa-user"></i>Master Sub Admin</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-header-fixed responsive table-success" id="example_1">
                                @php $i = 1; @endphp
                                <thead>
                                <tr>
                                    <th style="display: none">Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Notes</th>
                                    @if(session('contact_center_admin.0.type') != 2)
                                    <th>Action</th>
                                    @endif
                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th style="display: none">Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Created At</th>
                                    <th>Notes</th>
                                    @if(session('contact_center_admin.0.type') != 2)
                                    <th>Action</th>
                                    @endif
                                </tr>
                                </tfoot>
                                <tbody>
                                @foreach($admins as $admin)
                                    <tr>
                                        <td style="display: none">{{$admin->id}}</td>
                                        <td >{{$admin->name}}</td>
                                        <td >{{$admin->email}}</td>
                                        <td >{{$admin->created_at}}</td>
                                         <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-circle-bottom panic-note btn-fb" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="{{ $admin->name }} Note" data-content="{{ $admin->notes?$admin->notes:"N/A" }}">View Notes</button></td>
                                        @if(session('contact_center_admin.0.type') != 2)
                                        <td >
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                    @php
                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($admin->notes))))));

                                                    @endphp
                                                        <a class="dropdown-item status_change_admin" onclick="change_status_admin('{{$admin->id}}','{{$admin->status}}',this)">@if($admin->status == 'enabled')<i class="fa fa-toggle-off"></i> Disable @else <i class="fa fa-toggle-on"></i> Enable @endif</a>
                                                    <a class="dropdown-item" onclick="add_notes('{{$admin->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                                      <a class="dropdown-item delete_admin" data-id='{{$admin->id}}'><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                        </td>
                                        @endif
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
                    <form class="form-group" id="admin-note" novalidate="novalidate">
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
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
        }
    </style>
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
                "aaSorting" : [],
            })
        });

        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 20
        });
        $('#users_filter input').addClass('form-control');
        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 10
        });
        $('#users_filter input').addClass('form-control');

        function add_notes(note_id,note) {
            $('#note_id').val(note_id);
            $('#note').val(note);
            $('#notes').modal('show');
        }

        $('#admin-note').validate({
            errorClass : "error_color",
            rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
            },

            submitHandler:function(form){
                $('#noteButton').attr('disabled',true);
                $('#noteButton').html('Loading ...');
                var formData = new FormData($("#admin-note")[0]);
                $.ajax({
                    url:"<?php echo url('/') ?>/contact_center/ajax/admin_note",
                    type:'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data: formData,
                    error:function(){
                        url='<?php echo url('/') ?>';
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

         //delete Admin
    $(document).on('click','.delete_admin',function(){
         current = $(this);
            id = $(this).data('id')
           bootbox.confirm("You are going to delete Admin Are you sure?", function (result) {

            if (result == true) {

        $.ajax({
            type : "POST",
            url : "{{url('ajax/delete_admin_for_master_control_center') }}",
            data : 'id='+id,
            success: function(data,status){
                toastr['success']('admin deleted successfully')
         table = $('#example_1').DataTable();
                    table.row($(current).parents('tr')).remove().draw()
                  window.location.reload();
    }
        })

            }
        })
    })


    function change_status_admin(id,status,current)
    {

        bootbox.confirm("Are you sure you want to change the user status?", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "GET",
                url : "{{url('/ajax/change_admin_status_for_master_control_center')}}",
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

    function showNote(current)
    {

    $(current).popover('toggle')

    }
    </script>
@endsection