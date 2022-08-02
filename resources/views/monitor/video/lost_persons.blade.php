@extends('monitor.layout.default')
@section('title')
    {{ config('app.name') }} | Identification Detail
@stop
@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
@stop
@section('page-content')


<?php
if (Session::has('monitor_admin')) {
	$user = Session::get('monitor_admin');
	$organization_ids = data_get($user[0]['organizations'],'*.organization_id');
	$user_ids = \App\Users::whereIn('organization_id', $organization_ids)->pluck('user_id')->all();
}
$values = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$url = 'https://ifollow-realtorsafewalk.firebaseio.com/.json?orderBy="isActive"&equalTo=true';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$keys = curl_exec($ch);
curl_close($ch);
$keys = json_decode($keys);
$video_ids = array_keys((array) $keys);
$videos = \App\Videos::with('user.organization.time_zone')->where('archive_id', '!=', '')->where('type', '=', 'lost_person')->whereIn('user_id', $user_ids)->whereIn('video_id', $video_ids)->paginate(20);
?>

<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">

                       <!-- BEGIN PAGE TITLE-->
                       {{--  <h1 class="page-title"> {{ session('contact_center_admin.0.name') }}
                            <small>@if(Request::url()  == url('/pending_panic')) Open Panic @else Completed Panic @endif</small>
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
                                            <span class="caption-subject">Identification detail</span>
                                            {{-- <span class="caption-helper"></span> --}}
                                        </div>

                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>

                                    </div>

                                        <div class="portlet-body">

                                          {{--   <div class="scroller"
                                                 data-rail-visible="1"
                                                 data-rail-color="yellow"
                                                 data-handle-color="#a1b2bd"> --}}

                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered table-hover">
                                                        @php $i = 1; @endphp
                                                            <thead>
                                                                <tr>
                                                                    <th style="display: none">Id</th>
                                                                    <th>Uploaded By</th>
                                                                    <th>Date</th>
                                                                    <th>Status</th>
                                                                    <th>View Snapshot</th>
                                                                    <th>Contact Center</th>
                                                                    <th>Timezone</th>
                                                                    <th>Notes</th>
                                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>

                                                            <tbody>
                                                                @foreach($videos as $video)
                                                                    <tr>
                                                                        <td style="display: none">{{$video->id}}</td>
                                                                        <td >
                                                                        {{ $video->user->first_name }} {{ $video->user->last_name }}
                                                                        </td>
                                                                        <td >{{$video->created_at}}</td>
                                                                        <td ><span class="btn green" style="padding: 5px; width: 100px;">Completed</span></td>
                                                                        <td>
                                                                            <a onclick="viewVideo('{{$video->video_id}}')">
                                                                                <button style="width: 120px" class="btn btn-primary" type="button"><i class="fa fa-film"></i>View Stream</button>
                                                                            </a>
                                                                        </td>
                                                                        <td>{{ $video->user->organization->organization_name }}</td>
                                                                        <td>{{ $video->user->organization->time_zone->timezone_code }}</td>
                                                                        <td><button style="width: 120px" tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-fb panic-note btn-fb" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="User Notes" data-content="{{ $video->notes?$video->notes:"N/A" }}">View Notes</button></td>
                                                                        <td>
                                                                            <div class="">
                                                                                <button style="width: 120px" class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                                                <div class="dropdown-menu pull-right">
                                                                                    @php
                                                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($video->notes))))));

                                                                                    @endphp
                                                                                    <a class="dropdown-item" onclick="add_notes('{{$video->video_id}}','{{$clear}}')">
                                                                                        <i class="fa fa-pencil"></i>
                                                                                         Add/Edit Note
                                                                                     </a>
                                                                                     @if(session('contact_center_admin.0.type') != 2)
                                                                                            @if($values!='open_report_tip')
                                                                                                {{-- <a class="dropdown-item" onclick="delete_tip('{{$video->video_id}}',this)"><i class="fa fa-trash"></i>      Delete --}}
                                                                                                {{-- </a> --}}
                                                                                            @endif
                                                                                      @endif
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>
                                                </table>
                                            </div>
                                            <!-- END CONTENT BODY -->
                                            {{-- </div> --}}

                                        <div class="pagination" style="margin: -1px;float: right;">
                                            <?php echo urldecode($videos->links()); ?>
                                        </div>
                                        <br/><br/>

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
            <form id="video-note" novalidate="novalidate">
                    <div class="modal-body">
                            <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                            <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                            <input type="hidden" name="video_id" id="video_id">
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

    #example2 .dataTables_wrapper .dataTables_paginate .paginate_button {
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
.table button.btn {
    /*margin-left: 80px;
    margin-top: -35px;*/
}
}


</style>


@endsection
@section('scripts')
<script type="text/javascript">

$(document).ready(function(){
     $.fn.dataTable.ext.errMode = 'none';
    const table = $('#sample_2').DataTable();
    table.buttons('.buttonsToHide').nodes().css("display", "none");
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
<script>
 function delete_tip(id,current){
bootbox.confirm("Are you sure do you want to delete this Tip?", function (result) {
    if (result == true) {
          $.ajax({
        "method" : "POST",
        url : "{{url('/contact_center/ajax/delete_panic')}}",
        data : "id="+id,
        success : function(response,stat){
            tr = $('#example_1').DataTable()
            toastr["success"]('Deleted Successfully');
            child_length = $(current).parents('tr.child').length;
            if(child_length == 1){
                newObj = current;
              /*  $(current).parents('tr.child').prev("tr.parent").remove()
                $(newObj).parents('tr.child').remove()*/

             window.setTimeout(function() { location.reload(); }, 1000)
            }else
            {
                tr.row($(current).parents('tr')).remove().draw();
            }
        },
    });



    }
    else {

    }
});
}


$("#videos").dataTable({
    "aaSorting": [[ 0, "desc" ]],
    "sPaginationType": "full_numbers",
    "iDisplayLength" : 20
});
$('#videos_filter input').addClass('form-control');

function add_notes(video_id,note) {
    $('#video_id').val(video_id);
    $('#note').val(note);
    $('#notes').modal('show');
}

$('#video-note').validate({
    rules: { message: { minlength: 5,maxlength:140,required: true },csv:{required:true}
    },

    submitHandler:function(form){
        $('#noteButton').attr('disabled',true);
        $('#noteButton').html('Loading ...');
        var formData = new FormData($("#video-note")[0]);
        $.ajax({
            url:"<?php echo url('/') ?>/contact_center/ajax/video_note",
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
                toastr["success"]('Send successfully');
                window.setTimeout(function() { location.reload() }, 100)
            }
        })
    }
});

$(function () {
    $('#example2').DataTable({
                "aaSorting": [[ 0, "desc" ]],
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
function showNote(current)
{

    $(current).popover('toggle')

    }
</script>
@stop