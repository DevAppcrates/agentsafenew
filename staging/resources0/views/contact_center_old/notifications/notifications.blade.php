@extends('contact_center.layout.default')
@section('content')
@include('contact_center.header')
<style type="text/css">
  tbody th, table.dataTable tbody td {

word-break: break-word;
}
table.dataTable tbody th, table.dataTable tbody td {
padding: 8px 2px;
}

table.dataTable.dtr-inline.collapsed>tbody>tr>td:first-child, table.dataTable.dtr-inline.collapsed>tbody>tr>th:first-child {
padding-left: 22px !important;
}
</style>
<!--Main layout-->

<main class="">
    <div class="container-fluid" style="height: 500px" >
        <div class="row">
            <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">

                            <i class="fa fa-bell-o"></i> @if(Request::url()  == url('/archive/notifications')) Archived Mass Notifications @else Mass Notifications History @endif</div>
                    </div>
                    <div class="portlet-body">
                        <table cellspacing="10" class="table table-striped table-hover responsive table-condensed"  id="example2">
                            <thead>
                            @php $i = 1; @endphp
                            <tr>
                                <th style="display: none">#</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Notification</th>
                                <th>Detail</th>
                                <th>Created At</th>
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
                                    <td class="text-lg-center">
                                        @if($notification->type==2)
                                            <video style="height: 150px;width: 200px;" width="180" height="200" class="img-responsive" controls>
                                                <source src="{{$notification->path}}" type="video/mp4">
                                                <source src="{{$notification->path}}" type="video/ogg">
                                                Your browser does not support the video tag.
                                            </video>
                                        @elseif($notification->type==1)
                                            <img src="{{$notification->path}}" width="180" height="80" class="img-responsive" style="object-fit: contain;height: 100px">
                                            @elseif($notification->type == 3)
                                                    <audio style="width: 241px;padding: 0px;margin: 0px;"  controls controlsList="nodownload">
                                                    <source src="{{ $notification->path }}" type="audio/wav">
                                                    Your browser does not support the audio tag.
                                                    </audio>
                                                    @else
                                                    <span style="text-align: center;">N/A</span>
                                        @endif
                                    </td>
                                    <td >{{$notification->created_at}}</td>
                                      <td><a tabindex="0" role="button" data-trigger="focus" class="btn btn-circle-bottom btn-primary btn-xs mn-popop" onclick="showMNpopup(this)" data-toggle="popover"  data-placement="top" title="{{ $notification->title }} Note" data-content="{{ $notification->notes?$notification->notes:"N/A" }}">View Notes</a></td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                            <div class="dropdown-menu">
                                                    <a href="{{ url('/notification/history',['notification_id'=>$notification->id]) }}" class="dropdown-item"><i class="fa fa-info-circle"></i> View Snapshot</a>
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
                </div>
                <br/><br/>
            </div>
            <br/><br/><br/><br/>
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
                <form class="form-group" id="notification-note" novalidate="novalidate">
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
<script>
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
     $(function () {
    $('#example2').DataTable({
        "aaSorting": [],
        "sPaginationType": "full_numbers",
        "DisplayLength" : 5,
        'paging'      : true,
        'searching'   : true,
        'ordering'    : true,
        'info'        : true,
        'autoWidth'   : false,
         "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

    })
    })

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
</script>
<style>
    table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
        display: none !important;
    }
</style>
@endsection