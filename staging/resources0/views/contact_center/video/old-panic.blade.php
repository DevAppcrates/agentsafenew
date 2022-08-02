@extends('contact_center.layout.default')
@section('content')
    @include('contact_center.header')
    <!--Main layout-->
    <?php
    if (Session::has('contact_center_admin')) {
        $user = Session::get('contact_center_admin');
        $organization_id=$user[0]['organization_id'];
        $user_ids=\App\Users::where('organization_id',$organization_id)->pluck('user_id')->all();
        $values= basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
        if($values=='panic'){
            $url='https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy="isActive"&equalTo=true';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $keys = curl_exec ($ch);
            curl_close ($ch);

            $keys=json_decode($keys);
            $video_ids = array_keys((array)$keys);
            $videos=\App\Videos::with('user.user_emergency_contacts')->where('archive_id','!=','')->where('type','=','panic')->whereIn('user_id',$user_ids)->whereNotIn('video_id',$video_ids)->orderBy('id','desc')->get();

        }else{
            $url='https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy="isActive"&equalTo=true';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $keys = curl_exec ($ch);
            curl_close ($ch);

            $keys=json_decode($keys);
            $video_ids = array_keys((array)$keys);
            $videos=\App\Videos::with('user')->where('archive_id','!=','')->where('type','=','panic')->whereIn('user_id',$user_ids)->whereIn('video_id',$video_ids)->orderBy('id','desc')->get();

        }

    }
    ?>
    <main class="">
        <div class="container-fluid" style="height: 500px" >
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12" style="padding: 0px;margin-top: 50px">
                     @php $i = 1; @endphp 
                    <br>
                    <br>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class=""></i>{{ $values == 'panic'?'Panics':'Open Panics' }}</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped responsive"  id="example_1">
                                <thead>
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Status</th>
                                    <th>View Snapshot</th>
                                    <th>Detail</th>
                                    <th>Date</th>

                                    <th>Panic Time</th>
                                    <th>Notes</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($videos as $video)
                                    <tr class="row">
                                        <td style="display: none">{{$i}}</td>
                                        <td >{{$video->user->first_name.' '.$video->user->last_name}}</td>
                                        <td >{{$video->user->email}}</td>
                                        <td >{{$video->user->phone_number?$video->user->country_code.''.$video->user->phone_number:"N/A"}}</td>

                                        @if($values!='panic')
                                            <td ><button class="btn btn-xs btn-danger">Running</button></td>
                                        @else
                                            <td ><button class="btn btn-xs btn-success">Completed</button></td>
                                        @endif
                                        <td>
                                            <a class="teal-text btn btn-fb btn-xs" target="_blank" onclick="viewVideo('{{$video->video_id}}')"><i class="fa fa-film"></i>View Snapshot</a>
                                        </td>
                                        <td ><a onclick="userDetail('{{$video->user->first_name}}','{{$video->user->last_name}}','{{$video->user->email}}','{{$video->user->phone_number?$video->user->country_code.''.$video->user->phone_number:"N/A"}}','{{date('m/d/Y',strtotime($video->user->date_of_birth))}}','{{$video->user->display_picture}}','{{$video->user->user_address->address_1}}','{{$video->user->user_address->address_2}}','{{$video->user->user_address->city}}','{{$video->user->user_address->state}}','{{$video->user->user_address->country}}','{{$video->user->user_address->zipcode}}','{{$video->user->user_medical_info->illness_allergies}}','{{$video->user->user_medical_info->dr_name}}','{{$video->user->user_medical_info->dr_phone}}','{{ $video->user->user_emergency_contacts }}')"
                                                class="waves-effect btn btn-fb btn-xs" ><i class="fa fa-user"></i>User Detail</a></td>
                                        <td >{{$video->created_at}}</td>
                                        <td>
                                            @php
                                            $hours = floor($video->video_time / 3600);
                                            $minutes = floor(($video->video_time / 60) % 60);
                                            $seconds = $video->video_time % 60;
                                            echo "$hours:$minutes:$seconds";
                                            @endphp 
                                        </td>
                                          <td><button tabindex="0" role="button" data-trigger="focus" type="button" class="btn btn-circle-bottom panic-note btn-fb" data-toggle="popover" onclick="showNote(this)"  data-placement="top" title="{{ $video->user->first_name }} Notes" data-content="{{ $video->notes?$video->notes:"N/A" }}">View Notes</button></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-fb dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                                <div class="dropdown-menu">
                                                    @php
                                                        $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($video->notes))))));

                                                    @endphp
                                                    <a class="dropdown-item" onclick="add_notes('{{$video->video_id}}','{{$clear}}')"><i class="fa fa-pencil"></i>Add/Edit Note</a>
                                                    @if(session('contact_center_admin.0.type') != 2)
                                                     <a class="dropdown-item" onclick="delete_panic('{{$video->video_id}}',this)"><i class="fa fa-trash"></i>Delete</a>
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

                        <div class="pagination" style="margin: -1px;float: right;">
                             {{-- urldecode($videos->links()) --}}
                        </div>
                    <br/><br/>
                </div>
                <br/><br/><br/><br/>
            </div>
        </div>
    </main>
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
              markup += '</div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_relation" value="'+(v.relation? v.relation : "N/A")+'" placeholder="Contact phone No:">'
              markup += '</div>'
              markup += '<div class="col-md-12">'
              markup += '<label class="form-label">Emergency Contact '+i+' Phone</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_phone" value="'+(v.phone? v.phone : "N/A")+'" placeholder="Contact phone No:">'
              markup += '</div>'
    i++;
              
        })
    }else{
        for (var i = 1; i <= 2; i++) {

              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+'</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_name" placeholder="Emergency Contact name">'
              markup += '</div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control btn-circle" type="text" id="emergency_contact_'+i+'_relation" placeholder="Emergency Contact\'\s Relation">'
              markup += '</div>'
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
                        toastr["success"]('Saved successfully');
                        window.setTimeout(function() { window.location.reload() }, 1000)
                    }
                })


            }
        });
$(function () {

    $('#example_1').DataTable({
        "aaSorting": [],
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
        })
function showNote(current)
{   

    $(current).popover('toggle')
    
}
        function delete_panic(id,current){
        bootbox.confirm("Are you sure do you want to delete panic?", function (result) {
            if (result == true) {
                  $.ajax({
                "method" : "POST",
                url : "{{url('/contact_center/ajax/delete_panic')}}",
                data : "id="+id,
                success : function(response,stat){
                    
                    toastr["success"]('Deleted Successfully');
                    child_length = $(current).parents('tr.child').length;
                    if(child_length == 1){
                        newObj = current;
                        $(current).parents('tr.child').prev("tr.parent").remove()
                        $(newObj).parents('tr.child').remove()
                    }
                     window.setTimeout(function() { $('.toast-close-button').click(); }, 1200)
                     
                },
            });


               
            }
            else {

            }
        });
    }   
/*$(function () {
    $('.panic-note').popover()
})*/
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