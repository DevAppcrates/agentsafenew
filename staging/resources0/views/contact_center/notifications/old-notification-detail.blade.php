@extends('contact_center.layout.default')
@section('content')
    @include('contact_center.header')
    <style type="text/css">
        .display-4 {
            font-size: 2.5rem;

        }

        @media only screen
        and (min-device-width: 320px)
        and (max-device-width: 568px) {
            audio {
                   width: 255px!important;
                height: 54px!important;
            }
        }

      table#example{

            width: 100%;

}

@media screen and (max-width: 768px) and (orientation: portrait) {
#group_members .modal-dialog {

    width: 100%;
    margin: 0px;
}
#group_members .modal-body {
    padding: 0px;
}

table#example{
        word-break: break-all;
            width: 95% !important;

}

table#example td:first-child, th:first-child {
    display: none !important;
}


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
                <div class="col-md-7 col-sm-12">
                    <br>
                    <br>
                    <div id="info_box" style="display: none;" class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-globe"></i>{{ "Mass Notification" }} Snapshot
                        </div>

                            </div>
                            <div class="portlet-body" >
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h2><small class="text-muted">Notification Title:</small></h2>
                                        <h3 style="float: left;">{{$notification_detail->title}}</h3>
                                    </div>
                                    <div style="float: right;" class="col-sm-5 col-xs-8">
                                        <h2><small class="text-muted">Initiated By:</small></h2><h3 >{!! $notification_detail['sent_by']['name']?$notification_detail['sent_by']['name']:$notification_detail['name'] !!}</h3>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <label><b>Message:</b></label>
                                                <br>
                                                    <textarea class="lead" @if($notification_detail->type == 0)
                                                                style="min-height: 330px;" @endif>{{ $notification_detail->notification?$notification_detail->notification:'N/A' }}
                                                    </textarea>
                                            </div>

                                            @if($notification_detail->type != 0)
                                                <div class="col-sm-12 pull-left">
                                                    @if($notification_detail->type==2)
                                                        <b>Video:</b>
                                                            <video style="width: 320px;height: 420px;object-fit: contain;"       width="180" height="200" class="img-thumbnail
                                                                   img-responsive" controlsList="nodownload" controls >
                                                                <source src="{{$notification_detail->path}}"
                                                                        type="video/mp4">
                                                                <source src="{{$notification_detail->path}}"
                                                                        type="video/ogg">
                                                                    Your browser does not support the video tag.
                                                            </video>
                                                    @elseif($notification_detail->type==3)
                                                        <b>Audio:</b>
                                                            <audio style="width: 100%;" controls controlsList="nodownload">
                                                                <source src="{{ $notification_detail->path }}"
                                                                        type="audio/wav">
                                                                    Your browser does not support the audio tag.
                                                            </audio>
                                                    @elseif($notification_detail->type==1)

                                                        <a onclick="view_media('{{ $notification_detail->path}}')">
                                                            <figure class="figure">
                                                                <b>Image:</b>

                                                                <img src="{{$notification_detail->path}}" class="img-responsive img-thumbnail figure-img" style="object-fit: contain;height: 10%;width: 100%;">
                                                            </figure>
                                                        </a>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-sm-6">

                                        <div class="col-sm-12">
                                            <label><b>Priority:</b></label>
                                                <p class="lead" style="text-align: center;">
                                                    @if($notification_detail->priority == '[ Critical Alert ]')
                                                            <i class="fa fa-ambulance"></i>
                                                            @elseif($notification_detail->priority == "[ High Alert ]")
                                                            <i class="fa fa-exclamation-triangle"></i>
                                                            @elseif($notification_detail->priority == "[ Moderate Alert]")
                                                            <i class="fa fa-bullhorn"></i>
                                                            @elseif($notification_detail->priority == "[ Low Alert]")
                                                            <i class="fa fa-comment"></i>
                                                            @elseif($notification_detail->priority == "[ Informational Alert ]")
                                                            <i class="fa fa-exclamation-circle"></i>
                                                            @elseif($notification_detail->priority == "[ Active Shooter Alert ]")
                                                               <i class="fa fa-exclamation-circle"></i>
                                                            @elseif($notification_detail->priority == "[ Medical Emergency Alert ]")
                                                               <i class="fa fa-exclamation-circle"></i>

                                                        @endif

                                                    {{ $notification_detail->priority?$notification_detail->priority .'':"N/A"  }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <label><b># Of Groups Transmitted To:</b></label>
                                            <p class="lead" style="text-align: center;"><i class="fa fa-users"></i> {{ $notification_detail['groups_count'].' Group(s)'  }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <label><b># Of Users Transmitted To:</b></label>
                                            <p class="lead" style="text-align: center;"><i class="fa fa-users"></i> {{ count($user_ids).' Users(s)'  }}</p>

                                        </div>

                                        <div class="col-sm-12">
                                            <label><b>Date/Time Created:</b></label>
                                            <p class="lead" style="text-align: center;"><i class="fa fa-clock-o"></i>{{ $notification_detail['created_at']  }}</p>

                                        </div>
                                        <div class="col-sm-12">
                                            <label><b>Mass Notification(MN) Type:</b></label>
                                            @if($notification_detail['published_at'] == null)
                                                <p class="lead" style="text-align: center;">Immediate</p>
                                            @else
                                                <p class="lead" style="text-align: center;">Scheduled</p>
                                            @endif
                                        </div>
                                        @if($notification_detail['published_at'] != null)
                                            <div class="col-sm-12">
                                                <label><b>Scheduled Date/Time:</b></label>
                                                <p class="lead"><i class="fa fa-calendar"></i> {{ $notification_detail['published_at']  }}</p>
                                            </div>
                                        @endif
                                        <div class="col-sm-12">
                                            <label><b>Status:</b></label>
                                            <p class="lead"  style="text-align: center; background: #F9E79F"> {!! $notification_detail['status'] == "Sent"?"<i class='fa fa-check-circle'></i>" :"<i class='fa fa-minus-circle'></i>" !!} {{ $notification_detail['status']  }}</p>
                                        </div>
                                        <div class="col-sm-12">
                                            <label><b>Archived:</b></label>
                                            @if($notification_detail->is_archive)
                                                <p class="lead" style="text-align: center;"><i class="fa fa-archive"></i> {{ 'Yes'  }}</p>
                                            @else
                                                <p class="lead" style="text-align: center;"><i class="fa fa-archive"></i> {{ 'No'  }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-12">
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-sm-4">
                            <br>
                            <br>
                            <div class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>Group List</div>
                                </div>
                                <div class="portlet-body responsive">
                                    <table class="table-striped table-bordered table-success responsive table-condensed"  id="example2">
                                        <thead>
                                        @php $i = 1; @endphp
                                        <tr>
                                            <th style="display: none">#</th>
                                            <th>Title</th>
                                            <th>Total Members</th>

                                        </tr>
                                        </thead>
                                        <tbody>

                                        @foreach($notification_detail->groups as $group)
                                            <tr>
                                                <td style="display: none">{{$i}}</td>
                                                <td >{{$group->title}}</td>
                                                <td ><a data-id='{{ $group->id }}' style="padding-top: 10px;" class="btn btn-sm btn-outline red" onclick="view_members('{{ $group->id }}',this)">
                                                    @if($group->title == 'Invited Users')
                                                    {{ $inviteesCount }}
                                                    @else
                                                    {{count($group->members)}}
                                                    @endif
                                                    Members
                                                </a>
                                                </td>


                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <br>
                                    <br>
                                </div>
                            </div>
                        </div>
                        @if(session('contact_center_admin.0.type') != 2)
                        <div class="col-xs-12 col-md-12 col-sm-6">
                            <br>
                            <br>
                            <div id="manage_box" style="display: none;" class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>Manage</div>
                                </div>
                                <div class="list-group">
                                    @if(session('contact_center_admin.0.type') != 2)
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action btnDelete" data-id='{{ $notification_detail->id }}'><i class="fa fa-trash"></i> <b>Delete Mass Notification</b></a>
                                        @if($notification_detail->is_archive == 0)
                                            <a href="javascript:void(0);" class="list-group-item list-group-item-action btnAddTOArchived" data-id='{{ $notification_detail->id }}'><i class="fa fa-archive"></i> <b>Archive Mass Notification</b></a>
                                        @endif
                                    @endif
                                    @if($notification_detail->status == 'Pending')
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="edit_notification('{{  $notification_detail->id}}','{{ $notification_detail->title }}','{{ $notification_detail->notification }}','{{ date('m/d/y',strtotime($notification_detail->published_at)) }}','{{ $notification_detail->groups }}','{{ date('h:i:s',strtotime($notification_detail->published_at)) }}','{{ date('A',strtotime($notification_detail->published_at)) }}',this)"><i class="fa fa-edit"></i><b>Edit</b></a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @elseif(session('contact_center_admin.0.type') == 2 && $notification_detail->status == 'Pending')
                         <div class="col-xs-12 col-md-12 col-sm-6">
                            <br>
                            <br>
                            <div id="manage_box" style="display: none;" class="portlet box blue">
                                <div class="portlet-title">
                                    <div class="caption">
                                        <i class="fa fa-globe"></i>Manage</div>
                                </div>
                                <div class="list-group">

                                    @if($notification_detail->status == 'Pending')
                                        <a href="javascript:void(0);" class="list-group-item list-group-item-action" onclick="edit_notification('{{  $notification_detail->id}}','{{ $notification_detail->title }}','{{ $notification_detail->notification }}','{{ date('m/d/y',strtotime($notification_detail->published_at)) }}','{{ $notification_detail->groups }}','{{ date('h:i:s',strtotime($notification_detail->published_at)) }}','{{ date('A',strtotime($notification_detail->published_at)) }}',this)"><i class="fa fa-edit"></i> <b>Edit</b></a>
                                    @endif
                                </div>
                            </div>

                        </div>
                        @endif
                    </div>

                </div>
                </div>
              </div>
            </div>


    </main>

    <div class="modal fade" id="group_members" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <!--Content-->
            <div class="modal-content" style="margin-top: 70px">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="GroupMembersLabel">Group Members</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="example" class="display responsive table-condensed">
                            <thead>
                            <tr>
                                <th>Image</th>
                                <th>name</th>
                                <th>Type</th>
                                @if($notification_detail->is_report)
                                <th>SMS</th>
                                <th>Email</th>
                                <th>Notification</th>
                                @endif
                            </tr>

                            </thead>
                        </table>
                    </div>
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
                    <h4 class="modal-title" id="myModalLabel">Media View</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <img id="img-media" src="{{$notification_detail->path}}" onclick="view_media('{{ $notification_detail->path}}')" width="320" height="220" class="img-responsive img-thumbnail" style="object-fit: contain;height: 100%;width: 100%;">
                </div>
            </div>
            <!--/.Content-->
        </div>
    </div>

    <div class="modal fade" id="edit_push" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <!--Content-->
            <div class="modal-content" style="margin-top: 70px">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Mass Notification</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <form class="form-group" id="edit-push" novalidate="novalidate">
                        <div class="form-group" id="form-group">
                          <label class="form-label">Pre-Stored Notifications</label>
                          <select id="getTemplateDropdown" onchange="getTemplate(this)" class="form-control" name="">
                             <option value="">Pre-Stored Notifications</option>
                             <?php $templates = \App\Templates::where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 1)->get();?>
                             @foreach($templates as $template)
                             <option value="{{ $template->id }}">{{ $template->title }}</option>
                             @endforeach
                          </select>
                       </div>
                        <input type="hidden" name="id">
                        <label class="form-label">Title <span class="form-asterick">&#42;</span></label>
                        <input class="form-control btn-circle" autocomplete="off" type="text" name="title" placeholder="Title"><br/>
                        <label class="form-label">Notification <span class="form-asterick">&#42;</span></label>
                        <input type="radio" name="type" value="1" @if($notification_detail->type != 3)checked @endif>Text/File MN
                        <input type="radio" name="type" value="2" @if($notification_detail->type == 3)checked @endif>Voice MN
                        <div @if($notification_detail->type !=3) style="display: block;" @else style="display: none;" @endif id="file_edit-push">

                        <textarea class="form-control btn-circle" name="notification" placeholder="Notification" style="min-height: 100px"></textarea>
                        <br>
                        <label class="form-label">Image or Video</label>
                        <div class="fileinput fileinput-new input-group btn-circle" data-provides="fileinput" style="width: 100%">
                  <div class="form-control btn-circle-left" data-trigger="fileinput"> <span class="fileinput-filename"></span></div>
                  <span class="input-group-addon btn btn-warning btn-file"><span class="fileinput-new">Select file</span> <span class="fileinput-exists">Change</span>
                  <input type="file" name="file" accept="image/*,video/*"> </span> <a href="#" class="input-group-addon btn btn-warning fileinput-exists" data-dismiss="fileinput">Remove</a>
                        </div>
                      </div>

                         <input type="hidden" id="audio_src" name="audio_src" >
                  <section class="experiment edit-push-recordrtc" @if($notification_detail->type != 3)style="text-align: center;display: none;" @else style="text-align: center;display: block;" @endif >
                      <h2 class="header" >
                          <select class="recording-media-edit-push" style="display: none">
                              <option value="record-audio">Audio</option>
                              <option value="record-screen">Screen</option>
                          </select>

                          <select class="media-container-format-edit-push" style="display: none">
                              <option>WAV</option>
                          </select>
                          <p style="margin: auto"><img src="{{url('/')}}/public/images/rec.gif" id="rec-edit-push" style="width: 100px;height:100px;display: none"></p>
                          <button type="button" id="button" style="background: #0275d8;color: white;border: 2px solid #efefef;margin: 5px">Start Recording</button>
                      </h2>

                      <div style="text-align: center; display: none;">
                          <button id="save-to-disk">Save To Disk</button>
                          <button id="open-new-tab">Open New Tab</button>
                          <button id="upload-to-server">Upload To Server</button>
                      </div>
                      <br>
                      <audio controls muted id="audio-player-edit-push" style="display: none"></audio>
                  </section>
                   <audio controls id="edit-hear-audio" style="display: none;">
                        <source src="" id="edit-hear-audio-src" controlsList="nodownload" type="audio/wav">
                      </audio>
                        <br/>
                        <div class="form-group" id="form-group">
                            <label class="form-label">Groups <span class="form-asterick">&#42;</span></label>
                            <select class="mdb-select" data-style='btn-primary' name="groups[]" multiple>
                              <option value="" disabled>Select Group(s)</option>
                                <?php $groups = \App\Groups::withCount('members')->where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 1)->get();?>
                                <?php $invitees = \App\Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->count();
?>

                                @foreach($groups as $group)
                                    @if($group->title == 'Invited Users')
                                    <option value="{{ $group->id }}" @if($invitees == 0) disabled='disabled' @endif @foreach($notification_detail['groups'] as  $group_notification) @if($group_notification['pivot']['group_id'] == $group->id) selected @endif @endforeach>{{ $group->title }} ({{ $invitees }})</option>
                                    @else
                                    <option value="{{ $group->id }}" @if($group->members_count == 0) disabled='disabled' @endif @foreach($notification_detail['groups'] as  $group_notification) @if($group_notification['pivot']['group_id'] == $group->id) selected @endif @endforeach>{{ $group->title }} ({{ $group->members_count }})</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div id="edit-groups-error"></div>
                        <div class="form-group">
                   <label class="form-label"> Priority<span class="form-asterick">&#42;</span></label>
                 <select class="mdb-select" name="priority">
                    <option value="" disabled>Set Priority</option>
                    {{ $notification_detail->priority }}
                    <option value="Critical" @if($notification_detail->priority == "[ Critical Alert ]") selected @endif>Critical</option>
                    <option value="High" @if(trim($notification_detail->priority) == "[ High Alert ]") selected @endif>High</option>
                    <option value="Moderate" @if($notification_detail->priority == "[ Moderate Alert ]") selected @endif>Moderate</option>
                    <option value="Low" @if($notification_detail->priority == "[ Low Alert ]") selected @endif>Low</option>
                    <option value="Informational" @if($notification_detail->priority == "[ Informational Alert ]") selected @endif>Informational</option>
                     <option value="Active Shooter" @if($notification_detail->priority == "[ Active Shooter Alert ]") selected @endif>Active Shooter</option>
                            <option value="Medical Emergency" @if($notification_detail->priority == "[ Medical Emergency Alert ]") selected @endif>Medical Emergency</option>
                  </select>
                </div>
                        <br>
                        <div class="form-group" id="form-group">
                            {{-- <label class="form-label"><span class="form-asterick">&#42;</span></label> --}}
                            <select class="form-control btn-circle c-option" id="schedule_dropdown" name="schedule">
                                <option class="width-set" value="0">Send Now</option>
                                <option value="1" selected>Schedule For Later</option>
                            </select>
                        </div>
                        <div id="schedule" style="display: block;">
                            <div class="row">
                                <div class="col-sm-4">

                                    <div class="form-group">
                                        <label class="form-label">Select Date <span class="form-asterick">&#42;</span></label>
                                        <br>
                                        <input type="text" name="date" class="form-text form-control btn-circle" placeholder="select date" id="edit_datepicker" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <div class="form-group" style="margin-top: 2px;">
                                        <label>Select A Send Time</label>
                                        <br>
                                        <select name="time" class="form-control btn-circle" style="display: unset;">
                                            <?php $hours = \App\Hours::orderBy('hour', 'asc')->get();?>
                                            <option value="">Set Time</option>
                                            @foreach($hours as $hour)
                                                <option value="{{ $hour->id }}">{{ $hour->hour }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">

                                    <label>Select AM/PM</label>
                                    <select name="am_pm" class="form-control btn-circle"  style="display: unset;">
                                        <option value="am">AM</option>
                                        <option value="pm">PM</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <br>
                        <button class="btn" id="editnotificationButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Update Notification</button>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>

    @include('footer')

    <script type="text/javascript">
        function edit_notification(id,title,notification,published_at,groups,time,am_pm,current)
        {
            $('#edit_push input[name="id"]').val(id);
            $('#edit_push input[name="title"]').val(title);
            $('#edit_push textarea[name="notification"]').val(notification);
            $('#edit_push #edit_datepicker').datepicker("setDate", new Date(published_at));
            $('#edit_push select[name="am_pm"] > option[value="'+am_pm.toLowerCase()+'"]').attr("selected", true);

            $.each($('#edit_push select[name="time"] > option'),function(k,v){
                var times = $(v).text();
                if(times.trim() === time)
                {
                    $(v).attr('selected',true);
                }
            });
            /*groups = JSON.parse(groups);
            $.each(groups,function(key,val){
                $.each($('#edit_push .mdb-select > option'),function(k,v){
                    if($(v).attr('value') == val.pivot.group_id)
                    {
                      alert(val.pivot.group_id);
                      $('#edit_push .select-dropdown li:contains("'+$(v).attr('value')+'")').trigger('click');
                        $(v).attr('selected',true);
                    }

                })
            })*/
            $('#edit_push').modal('show');
        }

        $(function () {
            $('#example2').DataTable({
                "responsive" : true,
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


        function view_members(group_id,current)
        {
            tr = $('#example').DataTable({   'autoWidth'   : true,});
              var group_name = $(current).parents('tr').children('td').eq(1).text();
            if(group_name === 'Invited Users')
            {

               $.ajax({
                type : 'GET',
                url : "{{ url('contact_center_2/ajax/get_group_members_with_notification') }}/"+group_id+'/'+'{{$notification_detail->id}}'+'/'+group_name,
                success : function(data,status)
                {
                   $("#GroupMembersLabel").html(data.group.title+" Members");

                        $.each(data.response,function(key,value){
                          var sms=0,email=0,notification=0;
                          if(value.notification!=null){
                              sms=value.notification.sms;

                              email=value.notification.email;

                              notification=value.notification.notification;

                          }
                            if(sms!=0 && sms!=null){
                                sms='<a href="#" data-toggle="tooltip" title="'+sms+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                            }else{
                                sms='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                            }
                            if(email!=0 && email!=null){
                                email='<a href="#" data-toggle="tooltip" title="'+email+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                            }else{
                                email='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                            }
                            if(notification!=0 && notification!=null){
                                notification='<a href="#" data-toggle="tooltip" title="'+notification+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                            }else{
                                notification='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                            }

                          if(data.group.is_default != 0)
                          {
                            button = '<button disabled="disabled" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                          }else{
                            button = '<button class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                          }
                          if('{{$notification_detail->is_report}}'==1){
                              tr.row.add( [
                                  'N/A',
                                  value.name,
                                  'Guest User',
                                  sms,
                                  email,
                                  notification

                              ] ).draw( false );
                          }else{
                              tr.row.add( [
                                  'N/A',
                                  value.name,
                                  'Guest User'

                              ] ).draw( false );
                          }


                        })
                    $('#group_members').modal('show');
                }
            })
            }else{

            $.ajax({
                type : 'GET',
                url : "{{ url('contact_center_2/ajax/get_group_members_with_notification') }}/"+group_id+'/'+'{{$notification_detail->id}}',
                success : function(data,status)
                {
                    $("#GroupMembersLabel").html(data.group.title+" Members");
                    $.each(data.response,function(key,value){
                        var sms=0,email=0,notification=0;
                        console.log(value.notification);
                        if(value.notification!=null){
                            sms=value.notification.sms;

                            email=value.notification.email;

                            notification=value.notification.notification;

                        }
                        if(sms!=0 && sms!=null){
                            sms='<a href="#" data-toggle="tooltip" title="'+sms+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            sms='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        if(email!=0 && email!=null){
                            email='<a href="#" data-toggle="tooltip" title="'+email+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            email='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        if(notification!=0 && notification!=null){
                            notification='<a href="#" data-toggle="tooltip" title="'+notification+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            notification='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        remove_member = "remove_members('"+value.user_id+"','"+group_id+"',this)"
                        if('{{$notification_detail->is_report}}'==1){
                            tr.row.add( [
                                '<img class="img-rounded" width="50px" height="50px" src="'+value.display_picture+'">',
                                value.first_name+" "+value.last_name,
                                'App User',
                                sms,
                                email,
                                notification
                            ] ).draw( false );
                        }else{
                            tr.row.add( [
                                '<img class="img-rounded" width="50px" height="50px" src="'+value.display_picture+'">',
                                value.first_name+" "+value.last_name,
                                'App User'

                            ] ).draw( false );
                        }

                    });
                    $.each(data.invitees,function(key,value){
                        var sms=0,email=0,notification=0;
                        console.log(value.notification);
                        if(value.notification!=null){
                            sms=value.notification.sms;

                            email=value.notification.email;

                            notification=value.notification.notification;

                        }
                        if(sms!=0 && sms!=null){
                            sms='<a href="#" data-toggle="tooltip" title="'+sms+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            sms='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        if(email!=0 && email!=null){
                            email='<a href="#" data-toggle="tooltip" title="'+email+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            email='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        if(notification!=0 && notification!=null){
                            notification='<a href="#" data-toggle="tooltip" title="'+notification+'"><img src="{{url('/')}}/public/images/check.png" style="width: 30px"></a>';
                        }else{
                            notification='<img src="{{url('/')}}/public/images/cross.png" style="width: 30px">';
                        }
                        remove_member = "remove_members('"+value.id+"','"+group_id+"',this)"
                        if(data.group.is_default != 0)
                        {
                            button = '<button disabled="disabled" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                        }else{
                            button = '<button onclick="'+remove_member+'" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                        }
                        if('{{$notification_detail->is_report}}'==1){
                            tr.row.add( [
                                'N/A',
                                value.name,
                                'Guest User',
                                sms,
                                email,
                                notification

                            ] ).draw( false );
                        }else{
                            tr.row.add( [
                                'N/A',
                                value.name,
                                'Guest User'

                            ] ).draw( false );
                        }


                    })
                    $('#group_members').modal('show');

                }
            })
            }
        }

        $(document).on('hide.bs.modal','.modal', function () {
            tr = $('#example').DataTable();
            tr.clear().draw();
             tr.destroy();

        })

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })


        $(document).on('click','#status',function(e){
            statusbtn = $(this);
            id = "{{$notification_detail->id}}";
            status = $(this).data('value');
            $.ajax({
                "method" : "GET",
                url : "{{url('change_sadorganization_status')}}",
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
        })

        $(document).on('click','#view-users',function(){
            $("#users_detail").toggle();
            $("#admin_details").hide();
        })

        //Add Contact Center
        $('#add-sub-contact-center2').validate({
            rules: {
                name: {required: true},start_time: {required: true},end_time: {required: true},
                email: {required: true,email:true},
                phone: {required: true,number:true},
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
                        url = '{{ url('/') }}';
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

        function view_media(path) {
            $('#img-media').attr('src',path);
            $('#user_detail').modal('show');
        }

        $(document).ready(function(){

            $("#info_box").fadeIn(3000)
            $("#manage_box").fadeIn(3000)

            $('#edit-push').validate({
                rules: { title: { minlength: 5,maxlength:50,required: true }, notification: { minlength: 5,maxlength:140,required: true },'groups[]' :{required : true},
                },

                submitHandler:function(form){
                    schedule_dropdown = $('#schedule_dropdown').val()
                     window.onbeforeunload = null;
                    if(schedule_dropdown != 0)
                    {
                        $('#edit_push #editnotificationButton').attr('disabled',true);
                        $('#edit_push #editnotificationButton').html('Loading ...');
                        var formData = new FormData($("#edit-push")[0]);
                        $.ajax({
                            url:"{{ url('/') }}/contact_center_2/ajax/edit_notification",
                            type:'post',
                            cache: "false",
                            contentType: false,
                            processData: false,
                            data: formData,
                            error:function(error){
                                $('#edit_push #editnotificationButton').attr('disabled',false);
                                $('#edit_push #editnotificationButton').html('Update Notification');
                                errors = $.parseJSON(error.responseText)

                                $.each(errors,function(key,val){
                                    if(typeof val.date != 'undefined')
                                    {
                                        toastr["error"](val.date);

                                    }
                                    if(typeof val.time != 'undefined')
                                    {
                                        toastr["error"](val.time);
                                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                                    }

                                });

                            },
                            success:function(data)
                            {
                                $('#edit_push #notificationButton').attr('disabled',false);
                                $('#edit_push #notificationButton').html('Update Notification');
                                toastr["success"]('Updated successfully');
                                window.setTimeout(function() { location.reload() }, 1000)
                            }
                        })

                    }else{

                         if(!$("#edit_push select[name='groups[]']").val())
                            {
                                $('#edit_push #edit-groups-error').empty('')
                                $('#edit_push #edit-groups-error').html('<div style="color:red">groups are required</div>')

                            }else
                            {
                                $('#edit_push #edit-groups-error').empty('')
                            $('#edit_push').modal('hide');

                        bootbox.confirm("You are about to send a Mass Notification. Are you sure?", function (result) {
                            if (result == true) {
                                $('#edit_push #editnotificationButton').attr('disabled',true);
                                $('#edit_push #editnotificationButton').html('Loading ...');
                                var formData = new FormData($("#edit-push")[0]);
                                toastr["success"]('Sending ....');
                                $.ajax({
                                    url:"{{ url('/') }}/contact_center_2/ajax/edit_notification",
                                    type:'post',
                                    cache: "false",
                                    contentType: false,
                                    processData: false,
                                    data: formData,
                                    error:function(error){

                                        errors = $.parseJSON(error.responseText)

                                        $.each(errors,function(key,val){
                                            if(typeof val.date != 'undefined')
                                            {
                                                toastr["error"](val.date);

                                            }
                                            if(typeof val.time != 'undefined')
                                            {
                                                toastr["error"](val.time);
                                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                                            }

                                        });

                                    },
                                    success:function(data)
                                    {
                                        $('#edit_push #editnotificationButton').attr('disabled',false);
                                        $('#edit_push #editnotificationButton').html('Update Notification');
                                        toastr["success"]('Sent successfully');
                                        window.setTimeout(function() { location.reload() }, 1000)
                                    }
                                })
                            }
                            else {

                            }
                        });
                    }
                }
                }
            });
        })

        $(document).on('click','.btnDelete',function(){
            notification_id = $(this).data('id');
            btnDelete = $(this);
            bootbox.confirm("You are going to Delete a Mass Notification. Are you sure?", function (result) {
                if (result == true) {

                    $.ajax({
                        type : "GET",
                        url :"{{ url('/contact_center_2/ajax/delete_notification') }}",
                        data : "notification_id="+notification_id,
                        success : function(data,status)
                        {
                            table = $("#example2").DataTable();
                            window.setTimeout(function() {
                                toastr["success"]('Successfully Deleted');
                                window.location.href = '{{ url('contact_center_2/notifications') }}'
                            }, 2000)
                        }
                    })
                }
            });
        })


        $(document).on('click','.btnAddTOArchived',function(){
            notification_id  = $(this).data('id');
            current = $(this);
            bootbox.confirm("You are going to archive a Mass Notification. Are you sure?", function (result) {
                if (result == true) {

                    $.ajax({
                        type: "POST",
                        url: "{{url('/contact_center_2/ajax/add_archive')}}",
                        data: "notification_id="+notification_id,
                        success : function(data,status){
                            table = $('#example2').DataTable();
                            if(data.response == 'success')
                            {
                                toastr["success"]('Successfully Archived');

                            }else{

                                toastr["error"]('There is an issue while proccessing');
                            }
                            window.setTimeout(function() {
                                window.location.href = '{{ url('/contact_center_2/notifications') }}'
                            }, 2000)

                        }
                    });
                }
            });
        })


        $(document).ready(function(){
    // alert($('#send-push > #form-group btn.dropdown-toggle.bs-placeholder.btn-default').addClass('blue'))
            $('#edit-push input[name="type"]').change(function(){
                $('.edit-push-recordrtc').toggle();
                $('#file_edit-push').toggle();
            })
        })

    </script>

    <script>

    (function() {
        var params = {},
            r = /([^&=]+)=?([^&]*)/g;

        function d(s) {
            return decodeURIComponent(s.replace(/\+/g, ' '));
        }

        var match, search = window.location.search;
        while (match = r.exec(search.substring(1))) {
            params[d(match[1])] = d(match[2]);

            if(d(match[2]) === 'true' || d(match[2]) === 'false') {
                params[d(match[1])] = d(match[2]) === 'true' ? true : false;
            }
        }

        window.params = params;
    })();
</script>
<script>
    var recordingDIV = document.querySelector('.edit-push-recordrtc');
    var recordingMedia = recordingDIV.querySelector('.recording-media-edit-push');
    var recordingPlayer = recordingDIV.querySelector('#audio-player-edit-push');
    var mediaContainerFormat = recordingDIV.querySelector('.media-container-format-edit-push');
    var buttonNotification =  document.querySelector('#editnotificationButton');
    var recPush =  $('#rec-edit-push');
    recordingDIV.querySelector('button').onclick = function() {
        var button = this;
        if(button.innerHTML === 'Stop Recording') {
            button.disabled = true;
            button.disableStateWaiting = true;
            setTimeout(function() {
                button.disabled = false;
                button.disableStateWaiting = false;
            }, 2 * 1000);
            $('#rec-edit-push').hide();
            button.innerHTML = 'Start Recording';

            function stopStream() {
                if(button.stream && button.stream.stop) {
                    button.stream.stop();
                    button.stream = null;
                }
            }

            if(button.recordRTC) {
                if(button.recordRTC.length) {
                    button.recordRTC[0].stopRecording(function(url) {
                        if(!button.recordRTC[1]) {
                            button.recordingEndedCallback(url);
                            stopStream();

                            saveToDiskOrOpenNewTab(button.recordRTC[0]);
                            return;
                        }

                        button.recordRTC[1].stopRecording(function(url) {
                            button.recordingEndedCallback(url);
                            stopStream();
                        });
                    });
                }
                else {
                    button.recordRTC.stopRecording(function(url) {
                        button.recordingEndedCallback(url);
                        stopStream();

                        saveToDiskOrOpenNewTab(button.recordRTC);
                    });
                }
            }

            return;
        }

        button.disabled = true;

        var commonConfig = {
            onMediaCaptured: function(stream) {
                button.stream = stream;
                if(button.mediaCapturedCallback) {
                    button.mediaCapturedCallback();
                }
                $(buttonNotification).attr('disabled',true);
                $('#rec-edit-push').show();
                button.innerHTML = 'Stop Recording';
                button.disabled = false;
            },
            onMediaStopped: function() {
                button.innerHTML = 'Start Recording';
                $('#rec-edit-push').hide();
                if(!button.disableStateWaiting) {
                    button.disabled = false;
                }
            },
            onMediaCapturingFailed: function(error) {
                if(error.name === 'PermissionDeniedError' && !!navigator.mozGetUserMedia) {
                    InstallTrigger.install({
                        'Foo': {
                            // https://addons.mozilla.org/firefox/downloads/latest/655146/addon-655146-latest.xpi?src=dp-btn-primary
                            URL: 'https://addons.mozilla.org/en-US/firefox/addon/enable-screen-capturing/',
                            toString: function () {
                                return this.URL;
                            }
                        }
                    });
                }

                commonConfig.onMediaStopped();
            }
        };

        if(recordingMedia.value === 'record-video') {
            captureVideo(commonConfig);

            button.mediaCapturedCallback = function() {
                button.recordRTC = RecordRTC(button.stream, {
                    type: mediaContainerFormat.value === 'Gif' ? 'gif' : 'video',
                    disableLogs: params.disableLogs || false,
                    canvas: {
                        width: params.canvas_width || 320,
                        height: params.canvas_height || 240
                    },
                    frameInterval: typeof params.frameInterval !== 'undefined' ? parseInt(params.frameInterval) : 20 // minimum time between pushing frames to Whammy (in milliseconds)
                });

                button.recordingEndedCallback = function(url) {
                    recordingPlayer.src = null;
                    recordingPlayer.srcObject = null;

                    if(mediaContainerFormat.value === 'Gif') {
                        recordingPlayer.pause();
                        recordingPlayer.poster = url;

                        recordingPlayer.onended = function() {
                            recordingPlayer.pause();
                            recordingPlayer.poster = URL.createObjectURL(button.recordRTC.blob);
                        };
                        return;
                    }

                    recordingPlayer.src = url;
                    recordingPlayer.play();

                    recordingPlayer.onended = function() {
                        recordingPlayer.pause();
                        recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                    };
                };

                button.recordRTC.startRecording();
            };
        }

        if(recordingMedia.value === 'record-audio') {
            captureAudio(commonConfig);

            button.mediaCapturedCallback = function() {
                button.recordRTC = RecordRTC(button.stream, {
                    type: 'audio',
                    bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                    sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                    leftChannel: params.leftChannel || false,
                    disableLogs: params.disableLogs || false,
                    recorderType: webrtcDetectedBrowser === 'edge' ? StereoAudioRecorder : null
                });

                button.recordingEndedCallback = function(url) {

                };

                button.recordRTC.startRecording();
            };
        }

        if(recordingMedia.value === 'record-audio-plus-video') {
            captureAudioPlusVideo(commonConfig);

            button.mediaCapturedCallback = function() {

                if(webrtcDetectedBrowser !== 'firefox') { // opera or chrome etc.
                    button.recordRTC = [];

                    if(!params.bufferSize) {
                        // it fixes audio issues whilst recording 720p
                        params.bufferSize = 16384;
                    }

                    var audioRecorder = RecordRTC(button.stream, {
                        type: 'audio',
                        bufferSize: typeof params.bufferSize == 'undefined' ? 0 : parseInt(params.bufferSize),
                        sampleRate: typeof params.sampleRate == 'undefined' ? 44100 : parseInt(params.sampleRate),
                        leftChannel: params.leftChannel || false,
                        disableLogs: params.disableLogs || false,
                        recorderType: webrtcDetectedBrowser === 'edge' ? StereoAudioRecorder : null
                    });

                    var videoRecorder = RecordRTC(button.stream, {
                        type: 'video',
                        disableLogs: params.disableLogs || false,
                        canvas: {
                            width: params.canvas_width || 320,
                            height: params.canvas_height || 240
                        },
                        frameInterval: typeof params.frameInterval !== 'undefined' ? parseInt(params.frameInterval) : 20 // minimum time between pushing frames to Whammy (in milliseconds)
                    });

                    // to sync audio/video playbacks in browser!
                    videoRecorder.initRecorder(function() {
                        audioRecorder.initRecorder(function() {
                            audioRecorder.startRecording();
                            videoRecorder.startRecording();
                        });
                    });

                    button.recordRTC.push(audioRecorder, videoRecorder);

                    button.recordingEndedCallback = function() {
                        var audio = new Audio();
                        audio.src = audioRecorder.toURL();
                        audio.controls = true;
                        audio.autoplay = true;

                        audio.onloadedmetadata = function() {
                            recordingPlayer.src = videoRecorder.toURL();
                            recordingPlayer.play();
                        };

                        recordingPlayer.parentNode.appendChild(document.createElement('hr'));
                        recordingPlayer.parentNode.appendChild(audio);

                        if(audio.paused) audio.play();
                    };
                    return;
                }

                button.recordRTC = RecordRTC(button.stream, {
                    type: 'video',
                    disableLogs: params.disableLogs || false,
                    // we can't pass bitrates or framerates here
                    // Firefox MediaRecorder API lakes these features
                });

                button.recordingEndedCallback = function(url) {
                    recordingPlayer.srcObject = null;
                    recordingPlayer.muted = false;
                    recordingPlayer.src = url;
                    recordingPlayer.play();

                    recordingPlayer.onended = function() {
                        recordingPlayer.pause();
                        recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                    };
                };

                button.recordRTC.startRecording();
            };
        }

        if(recordingMedia.value === 'record-screen') {
            captureScreen(commonConfig);

            button.mediaCapturedCallback = function() {
                button.recordRTC = RecordRTC(button.stream, {
                    type: mediaContainerFormat.value === 'Gif' ? 'gif' : 'video',
                    disableLogs: params.disableLogs || false,
                    canvas: {
                        width: params.canvas_width || 320,
                        height: params.canvas_height || 240
                    }
                });

                button.recordingEndedCallback = function(url) {
                    recordingPlayer.src = null;
                    recordingPlayer.srcObject = null;

                    if(mediaContainerFormat.value === 'Gif') {
                        recordingPlayer.pause();
                        recordingPlayer.poster = url;
                        recordingPlayer.onended = function() {
                            recordingPlayer.pause();
                            recordingPlayer.poster = URL.createObjectURL(button.recordRTC.blob);
                        };
                        return;
                    }

                    recordingPlayer.src = url;
                    recordingPlayer.play();
                };

                button.recordRTC.startRecording();
            };
        }

        if(recordingMedia.value === 'record-audio-plus-screen') {
            captureAudioPlusScreen(commonConfig);

            button.mediaCapturedCallback = function() {
                button.recordRTC = RecordRTC(button.stream, {
                    type: 'video',
                    disableLogs: params.disableLogs || false,
                    // we can't pass bitrates or framerates here
                    // Firefox MediaRecorder API lakes these features
                });

                button.recordingEndedCallback = function(url) {
                    recordingPlayer.srcObject = null;
                    recordingPlayer.muted = false;
                    recordingPlayer.src = url;
                    recordingPlayer.play();

                    recordingPlayer.onended = function() {
                        recordingPlayer.pause();
                        recordingPlayer.src = URL.createObjectURL(button.recordRTC.blob);
                    };
                };

                button.recordRTC.startRecording();
            };
        }
    };

    function captureVideo(config) {
        captureUserMedia({video: true}, function(videoStream) {
            recordingPlayer.srcObject = videoStream;
            recordingPlayer.play();

            config.onMediaCaptured(videoStream);

            videoStream.onended = function() {
                config.onMediaStopped();
            };
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    function captureAudio(config) {
        captureUserMedia({audio: true}, function(audioStream) {
            recordingPlayer.srcObject = audioStream;
            recordingPlayer.play();

            config.onMediaCaptured(audioStream);

            audioStream.onended = function() {
                config.onMediaStopped();
            };
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    function captureAudioPlusVideo(config) {
        captureUserMedia({video: true, audio: true}, function(audioVideoStream) {
            recordingPlayer.srcObject = audioVideoStream;
            recordingPlayer.play();

            config.onMediaCaptured(audioVideoStream);

            audioVideoStream.onended = function() {
                config.onMediaStopped();
            };
        }, function(error) {
            config.onMediaCapturingFailed(error);
        });
    }

    function captureScreen(config) {
        getScreenId(function(error, sourceId, screenConstraints) {
            if (error === 'not-installed') {
                document.write('<h1><a target="_blank" href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk">Please install this chrome extension then reload the page.</a></h1>');
            }

            if (error === 'permission-denied') {
                alert('Screen capturing permission is denied.');
            }

            if (error === 'installed-disabled') {
                alert('Please enable chrome screen capturing extension.');
            }

            if(error) {
                config.onMediaCapturingFailed(error);
                return;
            }

            captureUserMedia(screenConstraints, function(screenStream) {
                recordingPlayer.srcObject = screenStream;
                recordingPlayer.play();

                config.onMediaCaptured(screenStream);

                screenStream.onended = function() {
                    config.onMediaStopped();
                };
            }, function(error) {
                config.onMediaCapturingFailed(error);
            });
        });
    }

    function captureAudioPlusScreen(config) {
        getScreenId(function(error, sourceId, screenConstraints) {
            if (error === 'not-installed') {
                document.write('<h1><a target="_blank" href="https://chrome.google.com/webstore/detail/screen-capturing/ajhifddimkapgcifgcodmmfdlknahffk">Please install this chrome extension then reload the page.</a></h1>');
            }

            if (error === 'permission-denied') {
                alert('Screen capturing permission is denied.');
            }

            if (error === 'installed-disabled') {
                alert('Please enable chrome screen capturing extension.');
            }

            if(error) {
                config.onMediaCapturingFailed(error);
                return;
            }

            screenConstraints.audio = true;

            captureUserMedia(screenConstraints, function(screenStream) {
                recordingPlayer.srcObject = screenStream;
                recordingPlayer.play();

                config.onMediaCaptured(screenStream);

                screenStream.onended = function() {
                    config.onMediaStopped();
                };
            }, function(error) {
                config.onMediaCapturingFailed(error);
            });
        });
    }

    function captureUserMedia(mediaConstraints, successCallback, errorCallback) {
        navigator.mediaDevices.getUserMedia(mediaConstraints).then(successCallback).catch(errorCallback);
    }

    function setMediaContainerFormat(arrayOfOptionsSupported) {
        var options = Array.prototype.slice.call(
            mediaContainerFormat.querySelectorAll('option')
        );

        var selectedItem;
        options.forEach(function(option) {
            option.disabled = true;

            if(arrayOfOptionsSupported.indexOf(option.value) !== -1) {
                option.disabled = false;

                if(!selectedItem) {
                    option.selected = true;
                    selectedItem = option;
                }
            }
        });
    }

    recordingMedia.onchange = function() {
        if(this.value === 'record-audio') {
            setMediaContainerFormat(['WAV', 'Ogg']);
            return;
        }
        setMediaContainerFormat(['WebM', /*'Mp4',*/ 'Gif']);
    };

    if(webrtcDetectedBrowser === 'edge') {
        // webp isn't supported in Microsoft Edge
        // neither MediaRecorder API
        // so lets disable both video/screen recording options

        console.warn('Neither MediaRecorder API nor webp is supported in Microsoft Edge. You cam merely record audio.');

        recordingMedia.innerHTML = '<option value="record-audio">Audio</option>';
        setMediaContainerFormat(['WAV']);
    }

    if(webrtcDetectedBrowser === 'firefox') {
        // Firefox implemented both MediaRecorder API as well as WebAudio API
        // Their MediaRecorder implementation supports both audio/video recording in single container format
        // Remember, we can't currently pass bit-rates or frame-rates values over MediaRecorder API (their implementation lakes these features)

        recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>'
            + '<option value="record-audio-plus-screen">Audio+Screen</option>'
            + recordingMedia.innerHTML;
    }

    // disabling this option because currently this demo
    // doesn't supports publishing two blobs.
    // todo: add support of uploading both WAV/WebM to server.
    if(false && webrtcDetectedBrowser === 'chrome') {
        recordingMedia.innerHTML = '<option value="record-audio-plus-video">Audio+Video</option>'
            + recordingMedia.innerHTML;
        console.info('This RecordRTC demo merely tries to playback recorded audio/video sync inside the browser. It still generates two separate files (WAV/WebM).');
    }

    function saveToDiskOrOpenNewTab(recordRTC) {
        // alert(recordRTC.toURL());
        if(!recordRTC) return alert('No recording found.');
        this.disabled = true;

        var button = this;

        uploadToServer(recordRTC, function(progress, fileURL) {
                    // alert(progress)
            if(progress === 'ended') {
                button.disabled = false;
                button.innerHTML = 'Click to download from server';
                var link = document.getElementById('audio-player-edit-push');
                var audio_src = $('#edit_push #audio_src');
                link.style.display = 'none'; //or
                link.style.visibility = 'hidden';
                alert(fileURL)
                if(typeof fileURL != 'undefined')
                {
                  audio_src.value = fileURL;
                  alert(audio_src.value);
                $(".toast-close-button:first").click();
                toastr['success']('Recorded Successfully')
                    $(buttonNotification).remove()
                listOfFilesUploaded = [];
                }else{

                toastr['success']('Loading...')
                }
                $('#rec-edit-push').hide();
                return;
            }
            button.innerHTML = progress;
        });
        //alert(url);
        return false;

        recordingDIV.querySelector('#save-to-disk').parentNode.style.display = 'block';
        recordingDIV.querySelector('#save-to-disk').onclick = function() {
            if(!recordRTC) return alert('No recording found.');

            recordRTC.save();
        };

        recordingDIV.querySelector('#open-new-tab').onclick = function() {
            if(!recordRTC) return alert('No recording found.');

            window.open(recordRTC.toURL());
        };

        recordingDIV.querySelector('#upload-to-server').disabled = false;
        recordingDIV.querySelector('#upload-to-server').onclick = function() {
            if(!recordRTC) return alert('No recording found.');
            this.disabled = true;

            var button = this;
            uploadToServer(recordRTC, function(progress, fileURL) {
                if(progress === 'ended') {
                    button.disabled = false;
                    button.innerHTML = 'Click to download from server';
                    button.onclick = function() {
                        window.open(fileURL);
                    };
                    return;
                }
                button.innerHTML = progress;
            });
        };
    }

    var listOfFilesUploaded = [];

    function uploadToServer(recordRTC, callback) {
        var blob = recordRTC instanceof Blob ? recordRTC : recordRTC.blob;
        var fileType = blob.type.split('/')[0] || 'audio';
        var fileName = (Math.random() * 1000).toString().replace('.', '');

        if (fileType === 'audio') {
            fileName += '.' + (!!navigator.mozGetUserMedia ? 'ogg' : 'wav');
        } else {
            fileName += '.webm';
        }

        // create FormData
        var formData = new FormData();
        formData.append(fileType + '-filename', fileName);
        formData.append(fileType + '-blob', blob);

        callback('Uploading ' + fileType + ' recording to server.');

        makeXMLHttpRequest('{{url('/')}}'+'/upload', formData, function(progress) {
            if (progress !== 'upload-ended') {
                callback(progress);
                return;
            }

            var initialURL = 'https://s3-us-west-1.amazonaws.com/i-follow/Audios/';

            callback('ended', initialURL + fileName);

            // to make sure we can delete as soon as visitor leaves
            listOfFilesUploaded.push(initialURL + fileName);
        });
    }

    function makeXMLHttpRequest(url, data, callback) {
        var request = new XMLHttpRequest();
        request.onreadystatechange = function() {
            if (request.readyState == 4 && request.status == 200) {
                callback('upload-ended');
            }
        };

        request.upload.onloadstart = function() {
            callback('Upload started...');
        };

        request.upload.onprogress = function(event) {
            callback('Upload Progress ' + Math.round(event.loaded / event.total * 100) + "%");
        };

        request.upload.onload = function() {
            callback('progress-about-to-end');
        };

        request.upload.onload = function() {
            // alert('working')
            callback('ended');
        };

        request.upload.onerror = function(error) {
            callback('Failed to upload to server');
            console.error('XMLHttpRequest failed', error);
        };

        request.upload.onabort = function(error) {
            callback('Upload aborted.');
            console.error('XMLHttpRequest aborted', error);
        };

        request.open('POST', url);
        request.send(data);
    }

    window.onbeforeunload = function() {
        recordingDIV.querySelector('button').disabled = false;
        recordingMedia.disabled = false;
        mediaContainerFormat.disabled = false;

        if(!listOfFilesUploaded.length) return;

        listOfFilesUploaded.forEach(function(fileURL) {
            var request = new XMLHttpRequest();
            request.onreadystatechange = function() {
                if (request.readyState == 4 && request.status == 200) {
                    if(this.responseText === ' problem deleting files.') {
                        alert('Failed to delete ' + fileURL + ' from the server.');
                        return;
                    }

                    listOfFilesUploaded = [];
                    alert('You can leave now. Your files are removed from the server.');
                }
            };
//                request.open('POST', 'https://webrtcweb.com/RecordRTC/delete.php');
//
//                var formData = new FormData();
//                formData.append('delete-file', fileURL.split('/').pop());
//                request.send(formData);
        });

        return 'Please wait few seconds before your recordings are deleted from the server.';
    };

    function change(sourceUrl) {
      alert('')
    var audio = $("#edit-push #new-audio");
    $("#edit_push audio > #new-audio-src").attr("src", sourceUrl);
    /****************/
    audio[0].pause();
    audio[0].load();//suspends and restores all audio element

    //audio[0].play(); changed based on Sprachprofi's comment below
    audio[0].oncanplaythrough = audio[0].play();
    /****************/
}


  </script>
    <script>
        var dateFormat = function () {
            var	token = /d{1,4}|m{1,4}|yy(?:yy)?|([HhMsTt])\1?|[LloSZ]|"[^"]*"|'[^']*'/g,
                timezone = /\b(?:[PMCEA][SDP]T|(?:Pacific|Mountain|Central|Eastern|Atlantic) (?:Standard|Daylight|Prevailing) Time|(?:GMT|UTC)(?:[-+]\d{4})?)\b/g,
                timezoneClip = /[^-+\dA-Z]/g,
                pad = function (val, len) {
                    val = String(val);
                    len = len || 2;
                    while (val.length < len) val = "0" + val;
                    return val;
                };

            // Regexes and supporting functions are cached through closure
            return function (date, mask, utc) {
                var dF = dateFormat;

                // You can't provide utc if you skip other args (use the "UTC:" mask prefix)
                if (arguments.length == 1 && Object.prototype.toString.call(date) == "[object String]" && !/\d/.test(date)) {
                    mask = date;
                    date = undefined;
                }

                // Passing date through Date applies Date.parse, if necessary
                date = date ? new Date(date) : new Date;
                if (isNaN(date)) throw SyntaxError("invalid date");

                mask = String(dF.masks[mask] || mask || dF.masks["default"]);

                // Allow setting the utc argument via the mask
                if (mask.slice(0, 4) == "UTC:") {
                    mask = mask.slice(4);
                    utc = true;
                }

                var	_ = utc ? "getUTC" : "get",
                    d = date[_ + "Date"](),
                    D = date[_ + "Day"](),
                    m = date[_ + "Month"](),
                    y = date[_ + "FullYear"](),
                    H = date[_ + "Hours"](),
                    M = date[_ + "Minutes"](),
                    s = date[_ + "Seconds"](),
                    L = date[_ + "Milliseconds"](),
                    o = utc ? 0 : date.getTimezoneOffset(),
                    flags = {
                        d:    d,
                        dd:   pad(d),
                        ddd:  dF.i18n.dayNames[D],
                        dddd: dF.i18n.dayNames[D + 7],
                        m:    m + 1,
                        mm:   pad(m + 1),
                        mmm:  dF.i18n.monthNames[m],
                        mmmm: dF.i18n.monthNames[m + 12],
                        yy:   String(y).slice(2),
                        yyyy: y,
                        h:    H % 12 || 12,
                        hh:   pad(H % 12 || 12),
                        H:    H,
                        HH:   pad(H),
                        M:    M,
                        MM:   pad(M),
                        s:    s,
                        ss:   pad(s),
                        l:    pad(L, 3),
                        L:    pad(L > 99 ? Math.round(L / 10) : L),
                        t:    H < 12 ? "a"  : "p",
                        tt:   H < 12 ? "am" : "pm",
                        T:    H < 12 ? "A"  : "P",
                        TT:   H < 12 ? "AM" : "PM",
                        Z:    utc ? "UTC" : (String(date).match(timezone) || [""]).pop().replace(timezoneClip, ""),
                        o:    (o > 0 ? "-" : "+") + pad(Math.floor(Math.abs(o) / 60) * 100 + Math.abs(o) % 60, 4),
                        S:    ["th", "st", "nd", "rd"][d % 10 > 3 ? 0 : (d % 100 - d % 10 != 10) * d % 10]
                    };

                return mask.replace(token, function ($0) {
                    return $0 in flags ? flags[$0] : $0.slice(1, $0.length - 1);
                });
            };
        }();

        // Some common format strings
        dateFormat.masks = {
            "default":      "ddd mmm dd yyyy HH:MM:ss",
            shortDate:      "m/d/yy",
            mediumDate:     "mmm d, yyyy",
            longDate:       "mmmm d, yyyy",
            fullDate:       "dddd, mmmm d, yyyy",
            shortTime:      "h:MM TT",
            mediumTime:     "h:MM:ss TT",
            longTime:       "h:MM:ss TT Z",
            isoDate:        "yyyy-mm-dd",
            isoTime:        "HH:MM:ss",
            isoDateTime:    "yyyy-mm-dd'T'HH:MM:ss",
            isoUtcDateTime: "UTC:yyyy-mm-dd'T'HH:MM:ss'Z'"
        };

        // Internationalization strings
        dateFormat.i18n = {
            dayNames: [
                "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat",
                "Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"
            ],
            monthNames: [
                "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec",
                "January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"
            ]
        };

        // For convenience...
        Date.prototype.format = function (mask, utc) {
            return dateFormat(this, mask, utc);
        };
    </script>
@stop

