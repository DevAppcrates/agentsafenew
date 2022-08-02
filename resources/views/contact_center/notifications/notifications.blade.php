@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} | Notifications
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
                       {{--  <h1 class="page-title"> {{ session('contact_center_admin.0.name') }}
                            <small>@if(Request::url()  == url('/archive/notifications')) Archived Mass Notifications @else Mass Notifications History @endif</small>
                        </h1> --}}
                        <!-- END PAGE TITLE-->

                        <div class="page-bar">
                        </div>


                         <div class="row" style="margin-top: 3%">
                            <div class="col-md-12">
                                <div class="portlet light bg-inverse">
                                    <div class="portlet-title">
                                        <div class="caption font-green-sharp">
                                            <i class="icon-speech font-green-sharp"></i>
                                            <span class="caption-subject"> @if(Request::url()  == url('/archive/notifications')) Archived Mass Notifications @else Mass Notifications History @endif </span>
                                            {{-- <span class="caption-helper"></span> --}}
                                        </div>

                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>

                                    </div>

                                        <div class="portlet-body">
                                            {{-- <div class="scroller"
                                                 data-rail-visible="1"
                                                 data-rail-color="yellow"
                                                 data-handle-color="#a1b2bd"> --}}

                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered table-hover">
                                                        @php $i = 1; @endphp
                                                            <thead>
                                                                @php $i = 1; @endphp
                                                                <tr>
                                                                    <th style="display: none">#</th>
                                                                    <th>Name</th>
                                                                    <th>Title</th>
                                                                    <th>Notification</th>
                                                                    {{-- <th>Detail</th> --}}
                                                                    <th>Date Sent</th>
                                                                    <th>Notes</th>
                                                                    <th>Action</th>
                                                                </tr>

                                                            </thead>

                                                            <tbody>
                                                                @foreach($notifications as $notification)
                                                                <tr>
                                                                    <td style="display: none">{{$i}}</td>
                                                                    <td >{{$notification->name}}</td>
                                                                    <td >{{$notification->title}}</td>
                                                                    <td >{{$notification->notification?str_limit($notification->notification,50):'N/A'}}</td>

                                                                    <td >{{$notification->created_at}}</td>
                                                                      <td><a tabindex="0" role="button" style="width: 90px; height: 16px; margin-top: 3px;" data-trigger="focus" class="btn btn-primary btn-xs mn-popop" onclick="showMNpopup(this)" data-toggle="popover"  data-placement="top" title="{{ $notification->title }} Note" data-content="{{ $notification->notes?$notification->notes:"N/A" }}">View Notes</a></td>
                                                                    <td>
                                                                        <div class="">
                                                                            <button class="btn btn-primary dropdown-toggle" style="width: 90px; height: 16px; margin-top: 3px;" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                                            <div class="dropdown-menu pull-right">
                                                                                    <a href="{{ url('notification/history',['notification_id'=>$notification->id]) }}" class="dropdown-item"><i class="fa fa-info-circle"></i> View Snapshot</a>
                                                                                @php
                                                                                    $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($notification->notes))))));

                                                                                @endphp
                                                                                <a class="dropdown-item" onclick="add_notes('{{$notification->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                                                                 @if(session('contact_center_admin.0.type') != 2)
                                                                                    @if($notification->is_archive)

                                                                                    <a data-id="{{ $notification->id }}" class="btnDelete dropdown-item"><i class="fa fa-trash"></i> Delete</a>
                                                                                    @else

                                                                                    <a data-id="{{ $notification->id }}" class="btnAddTOArchived dropdown-item"><i class="fa fa-archive"></i> Add to Archive</a>
                                                                                    @endif
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                @php $i++; @endphp
                                                            @endforeach
                                                            </tbody>

                                                </table>
                                            </div>
                    <!-- END CONTENT BODY -->
                                            {{-- </div> --}}
                                        </div>
                                </div>
                            </div>
                        </div>
                <!-- END CONTENT -->
            </div>
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
            <form id="notification-note" novalidate="novalidate">
                <div class="modal-body">
                        <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                        <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                        <input type="hidden" name="note_id" id="note_id">
                        <br>
                </div>
                <div class="modal-footer">
                        <button class="btn btn-primary waves-effect" id="noteButton">Save Changes</button>
                </div>
            </form>
            <!--/.Content-->
        </div>
    </div>
</div>

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

<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->
         <script>
             $.fn.dataTable.ext.errMode = 'none';

        $(document).ready(function() {
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
        });

        function edit_tag(id,name) {
            $('#tag_id').val(id);
            $('#edit_tag_name').val(name);
            $('#editTag').modal('show');
        }

        function assign_tag(id) {

            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/tag_members/"+id,
                type: 'get',
                error: function() {
                    setTimeout(function () {
                        $('.loader').hide();
                    },500);
                },
                success: function(data) {
                    $('#tag_html').html(data);
                    $('#assignTag').modal('show');
                }
            })
        }

    </script>

    <script>
  // $(document).ready(function(){
    $("#users").dataTable({
       "aaSorting": [],
        "sPaginationType": "full_numbers",
        "iDisplayLength" : 20
    });
    $('#users_filter input').addClass('form-control');
    //Delete practice tip

    function change_status(id)
    {
        bootbox.confirm("Are you sure you want to change the user status?", function (result) {
            if (result == true) {
                $.get("{{ e(url('/'))  }}/ajax/user_status/"+id, function (result) {

                    toastr["success"]('Changes confirmed');

                    window.setTimeout(function() { location.reload(); }, 1000)

                });
            }
            else {

            }
        });
    }

    function add_notes(note_id,note) {
        $('#note_id').val(note_id);
        $('#note').val(note);
        $('#notes').modal('show');
    }

    $('#notification-note').validate({
        rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
        },

        submitHandler:function(form){
            $('#noteButton').attr('disabled',true);
            $('#noteButton').html('Loading ...');
            var formData = new FormData($("#notification-note")[0]);
            $.ajax({
                url:"{{ url('/') }}/contact_center/ajax/notification_note",
                type:'post',
                cache: "false",
                contentType: false,
                processData: false,
                data: formData,
                error:function(){
                    url='{{ url('/') }}/';
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
    $(document).on('click','.btnDelete',function(){
        notification_id = $(this).data('id');
        btnDelete = $(this);
          bootbox.confirm("You are going to delete mass notification! Are you sure?", function (result) {

        $.ajax({
            type : "GET",
            url :"{{ url('/contact_center/ajax/delete_notification') }}",
            data : "notification_id="+notification_id,
            success : function(data,status)
            {
                table = $("#example2").DataTable();
                $(btnDelete).parents('tr').remove();
            }
        })

      })
    });


    $(document).on('click','.btnAddTOArchived',function(){
        // alert('test');
        notification_id  = $(this).data('id');
        current = $(this);

        bootbox.confirm("You are going to archive mass notification! Are you sure?", function (result) {
            if (result == true) {

        $.ajax({
            type: "POST",
            url: "{{url('/contact_center/ajax/add_archive')}}",
            data: "notification_id="+notification_id,
            success : function(data,status){
                table = $('#example2').DataTable();
                if(data.response == 'success')
                {
                toastr["success"]('Successfully Archived');

                }else{

                toastr["error"]('There is an issue while proccessing');
                }
                 window.setTimeout(function() { $('.toast-close-button').click(); }, 2000)
                child_length = $(current).parents('tr.child').length;
                if(child_length == 1){
                    newObj = current;
                    $(current).parents('tr.child').prev("tr.parent").remove()
                    $(newObj).parents('tr.child').remove()
                }else{

                $(current).parents('tr').remove();
                }
            }
        });
    }
    });
        });

    function showMNpopup(current)
    {
         $(current).popover('toggle')
    }

  // });
</script>
@stop