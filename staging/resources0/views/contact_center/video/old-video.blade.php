@extends('contact_center.layout.default')
@section('content')
@include('contact_center.header')
<!--Main layout-->

<?php
if (Session::has('contact_center_admin')) {
$user = Session::get('contact_center_admin');
$organization_id=$user[0]['organization_id'];
$user_ids=\App\Users::where('organization_id',$organization_id)->pluck('user_id')->all();

}
$values= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if($values=='report_tip'){
$url='https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy="isActive"&equalTo=true';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$keys = curl_exec ($ch);
curl_close ($ch);

$keys=json_decode($keys);
$video_ids = array_keys((array)$keys);
$videos=\App\Videos::with('user')->where('archive_id','!=','')->where('type','!=','panic')->whereIn('user_id',$user_ids)->whereNotIn('video_id',$video_ids)->orderBy('id','desc')->paginate(20);
}else{
$url='https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy="isActive"&equalTo=true';
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,$url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$keys = curl_exec ($ch);
curl_close ($ch);

$keys=json_decode($keys);

$video_ids = array_keys((array)$keys);
$videos=\App\Videos::with('user')->where('archive_id','!=','')->where('type','!=','panic')->whereIn('user_id',$user_ids)->whereIn('video_id',$video_ids)->paginate(20);

}
?>
<main class="">
<div class="container-fluid" style="height: 500px" >
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12" style="padding: 0px;margin-top: 30px">
            <br>
            <br>
            <div class="portlet box blue">
                <div class="portlet-title">
                    <div class="caption">
                        <i class=""></i>{{ $values == 'report_tip'?'Report Tips':'Open Report Tips' }}</div>
                </div>
                <div class="portlet-body">
                    <table class="table table-striped responsive"  id="example_1">
                        <thead>
                        <tr>
                            <th style="display: none">Id</th>
                            <th>Name</th>
                            <th>Date</th>
                            {{-- <th>Report Tip's Time</th> --}}
                            <th>Status</th>
                            <th>View Snapshot</th>
                            <th>Notes</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($videos as $video)
                            <tr>
                                <td style="display: none">{{$video->id}}</td>
                                <td >
                                    @if(isset($video->message['name']))
                                    {{  'Reported' }}
                                    @else
                                    {{ 'Not Reported' }}
                                    @endif
                                </td>
                                <td >{{$video->created_at}}</td>
                               {{--  <td>
                                       @php
                                    $hours = floor($video->video_time / 3600);
                                    $minutes = floor(($video->video_time / 60) % 60);
                                    $seconds = $video->video_time % 60;
                                    echo "$hours:$minutes:$seconds";
                                    @endphp 
                                </td> --}}
                                @if($values!='report_tip')
                                    <td ><button class="btn btn-sm btn-danger">Running</button></td>
                                @else
                                    <td ><button class="btn btn-sm btn-success">Completed</button></td>
                                @endif
                                <td>
                                    <a class="teal-text btn btn-fb btn-sm" target="_blank" onclick="viewVideo('{{$video->video_id}}')"><i class="fa fa-film"></i>View Stream</a>
                                </td>
                                <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-circle-bottom panic-note btn-fb" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="User Notes" data-content="{{ $video->notes?$video->notes:"N/A" }}">View Notes</button></td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-fb dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                        <div class="dropdown-menu">
                                            @php
                                                $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($video->notes))))));

                                            @endphp
                                            <a class="dropdown-item" onclick="add_notes('{{$video->video_id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                             @if(session('contact_center_admin.0.type') != 2)
                                        @if($values!='open_report_tip')
                                    <a class="dropdown-item" onclick="delete_tip('{{$video->video_id}}',this)"><i class="fa fa-trash"></i>Delete</a>

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
            </div>
            <div class="pagination" style="margin: -1px;float: right;">
                <?php echo urldecode($videos->links()); ?>
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
            <form class="form-group" id="video-note" novalidate="novalidate">
                <label class="form-label">Notes <span class="form-asterick">&#42;</span></label>
                <textarea class="form-control" id="note" name="notes" placeholder="Notes" style="min-height: 100px"></textarea>
                <input type="hidden" name="video_id" id="video_id">
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
            url:"<?php echo url('/')?>/contact_center/ajax/video_note",
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
                toastr["success"]('Send successfully');
                window.setTimeout(function() { location.reload() }, 100)
            }
        })
    }
});

$(function () {
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
        "aaSorting": [],

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
     table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
         display: none !important;
     }
    </style>
@endsection