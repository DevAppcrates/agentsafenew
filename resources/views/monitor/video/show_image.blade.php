<!DOCTYPE html>
<html lang="en">
<head>
    <title>iFollow</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{url('/')}}/public/css/material.css" rel="stylesheet">
    <link rel="stylesheet" href="https://coolestguidesontheplanet.com/videodrome/mediaelementjs/build/mediaelementplayer.css"/>
    <script src="https://static.opentok.com/v2/js/opentok.js"></script>

    <script type="text/javascript" src="{{ url('/') }}/public/js/audio.js"></script>
    <!-- for Edige/FF/Chrome/Opera/etc. getUserMedia support -->
    <script src="https://cdn.webrtc-experiment.com/gumadapter.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="{{ url('/') }}/public/js/bootstrap.min.js"></script>

    <!-- Bootstrap Material Design JavaScript -->
    <script type="text/javascript" src="{{ url('/') }}/public/js/material.js"></script>
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>
        window.Laravel = '<?php echo json_encode([
	'csrfToken' => csrf_token(),
]); ?>'
    </script>
    <title>{{ config('app.name') }}</title>

    <meta name="description" content="{{ config('app.name') }} | High Tech Personal Security">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <style>
body {
background-color: #edf1f7;
}
body .h3 {
    color: #153854;
    font-weight: 600;
}


.white{
background-color: #fff;
}
.video-section{
 height: 345px;
 background-color: white;
    border-radius: 10px;
    border: 1px solid #2797bb;
 }
 .chat-section{
 height: 345px;
 background-color: white;
    border-radius: 10px;
    border: 1px solid #2797bb;
 }
.profile{
 height: 345px;
 border-radius: 10px;
 border: 1px solid #2797bb;
 background-color: #fff;
}
.location{
 height: 345px;
 border-radius: 10px;
 border: 1px solid #2797bb;
 background-color: #fff;
  overflow: hidden;
}



.image img {
    margin: 40px 40px 0px;
}
.image {
   text-align: center;
}
.img-circle{
    border-radius: 100px;
    width: 150px;
    height: 150px;
}
.details h4 {
    color: #94a4c0;
}
.details {
    text-transform: uppercase;
}
.blue{
    background-color: #0096ff !important;
    border: none;
        height: 40px;
    width: 50%;
}
button.blue:hover {
    background-color: white !important;
    color: #0096ff;
    border: 1px #0096ff solid;
    transition: all 0.5s;
}
.logo-image{
    margin: 10px 0px 12px;
    width: 200px;
}
.page-title {
    margin: 37px 1px 30px;
}
.diolog-css{
    bottom: 25%;
    position: fixed;
    width: 100%;
    left: 30%;

}
  @media only screen
  and (min-device-width: 320px)
  and (max-device-width: 568px) {
    .diolog-css{
    bottom: 25%;
    position: fixed;
    width: 100%;
    left: 0%;

}

.location{
 height: auto!important;
}
    .speech-bubble {

            width: 100%!important;
        }

    .speech-bubble-right {
               width: 100%!important;
        }

    #btn-input{
        width: 61%!important;
    }

    #rec-link{
            padding: 0% 0% !important;

    }
    #send-link{
            padding: 0% 2% !important;

    }

}
.speech-bubble {
            position: relative;
            background: linear-gradient(#ebebeb,#cbcbcb);
            border-radius: .4em;
            float: left;
            width: 70%;
            margin: 15px;
            padding: 10px;
            color: black;
            word-wrap: break-word;
        }

        .speech-bubble:after {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            width: 0;
            height: 0;
            border: 0.75em solid transparent;
            border-right-color: #cbcbcb;
            border-left: 0;
            border-bottom: 0;
            margin-top: -0.375em;
            margin-left: -0.75em;
        }

        .speech-bubble-right {
            position: relative;
           background: linear-gradient(#65d6ff,#21a0cf);
            border-radius: .4em;
            float: right;
            width: 70%;
            margin: 15px;
            padding: 10px;
            color: #fff;
            word-wrap: break-word;
        }

        .speech-bubble-right:after {
            content: '';
            position: absolute;
            right: 0;
            top: 50%;
            width: 0;
            height: 0;
            border: 0.75em solid transparent;
            border-left-color: #21a0cf;
            border-right: 0;
            border-bottom: 0;
            margin-top: -0.375em;
            margin-right: -0.75em;
        }
        .mejs-container{
            height: 346px !important;
        }
        .mejs-overlay {
    height: 346px !important;
}
.panel-body {
      overflow-y: scroll;
    height: 300px;
    border: none;
    padding: 20px;
}

.chat-section {
    height: 345px;

    }

      audio{
          width: 100%;
      }
    #btn-input{
        width: 80%;
        margin:0;
        padding: 0px 0px;
    }

</style>

</head>
<body>

<div class="container-fluid white" style="margin-top: -10px;">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <img class="logo-image" src="{{ asset('public/images/logo-alert.png')}}">
            </div>

            <div class="col-md-6 col-sm-6" align="center" style="margin-top: -8px;">
               <h3 class="page-title">IDENTIFICATION DETAIL</strong></h3>
            </div>
            <div class="col-md-3" style="float:right;margin-top: 20px;">


            </div>
        </div>
        </div>
        </div>

<br>
<br>

        <div class="container">
        <!-- 1st Row -->

        <div class="row">
            <div @if($video->type == 'panic') class="col-md-7" @else class="col-md-6" @endif>
                @if($video->type != 'lost_person')
                <h3 class="h3">IMAGE</h3>
                    <div class="video-section">
                        <div id="videos">
                            <div id="soon" style="text-align: center">
                                <img src="{{$video->image_path? $video->image_path:'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/No_image_3x4.svg/1280px-No_image_3x4.svg.png'}}" class="img-responsive" style="margin-top: 19px;height: 292px;object-fit: cover;width: 95% !important;">
                            </div>
                        </div>
                    </div>
                @else
                <h3 class="h3">IMAGE</h3>
                    <div class="video-section">
                        <div id="videos">
                            <div id="soon" style="text-align: center">
                                <img src="{{$video->image_path? $video->image_path:'https://upload.wikimedia.org/wikipedia/commons/thumb/6/6c/No_image_3x4.svg/1280px-No_image_3x4.svg.png'}}" class="img-responsive" style="margin-top: 19px;height: 292px;object-fit: cover;width: 95% !important;">
                            </div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <h3 class="h3">Identification Detail:</h3>
                    @if(!empty($video->lost_person))
                        <div class="p-3 location" style="padding: 10px !important;height: auto;">
                            {{-- {{ $video->lost_person }} --}}

                             @if(isset($video->lost_person['agent_Phone']))
                                <label class="form-label">Agent Phone</label>
                                <input class="form-control" type="text" name="agent_Phone" id="l_name" value="<?php echo $video->lost_person['agent_Phone'] ?? '' ?>"><br/>
                             @endif

                             @if(isset($video->lost_person['address']))
                                <label class="form-label">Showing Address</label>
                                <input class="form-control" type="text" name="address" id="l_name"  value="<?php echo $video->lost_person['address'] ?? '' ?>"><br/>
                             @endif

                             @if(isset($video->lost_person['time']))
                                <label class="form-label">Showing Time</label>
                                <input class="form-control" type="text" name="time" id="l_name"  value="<?php echo $video->lost_person['time'] ?? '' ?>"><br/>
                             @endif

                              @if(isset($video->lost_person['message']))
                                <label class="form-label">Message body</label>
                                <textarea rows="4" class="form-control" type="text" name="message" id="l_name"><?php echo $video->lost_person['message'] ?? '' ?></textarea>
                                <br/>
                             @endif

                       </div>
                       @else
                       <div class="p-3 location text-center" style="padding: 10px !important;height: 200px;text-align: center;display: flex;justify-content: center;flex-direction: column;">
                            <i class="fa fa-4x fa-info-circle"></i>
                           <h3>Identification detail not found!</h3>
                       </div>
                   @endif
                @endif
            </div>
            @if($video->type != 'panic')
                <div class="col-md-3"></div>
            @endif
            @if($video->type=='panic')
            @php
                $user=\App\Users::with('user_emergency_contacts')->where('user_id',$video->user_id)->first();
            @endphp
            @endif
            <div class="col-md-5">
                <h3 class="h3">LOCATION</h3>
                <div class="location">
                    <div id="map" style="height:410px;width: 100%;"></div>
                </div>
            </div>
            @if($video->type == 'lost_person')
                <div class="col-md-5">
                    <br/><br/>
                    <h3 class="h3">User Detail:</h3>
                    <div class="p-3 location" style="padding: 10px !important;height: 500px;">
                            <label class="form-label">Name</label>
                            <input autocomplete="off"  class="form-control" type="text" name="name" id="l_name" value="<?php echo $user->first_name . ' ' . $user->last_name ?>"><br/>
                            <label class="form-label">Email</label>
                            <input autocomplete="off" class="form-control" type="text" name="name" id="l_name"  value="<?php echo $video->user->email ?>"><br/>
                            <label class="form-label">Phone</label>
                            <input autocomplete="off" class="form-control" type="text" name="name" id="l_name"  value="<?php echo $user->phone_number ?>"><br/>
                            <label class="form-label">Address</label>
                            <input autocomplete="off" class="form-control" type="text" name="name" id="l_name"  value="<?php echo $user->user_address->address_1 . ' ' . $user->user_address->address2_m ?>"><br/>
                   </div>
                </div>
            @else
                <div class="col-md-6">
                    <br/><br/>
                    <h3 class="h3">User Detail:</h3>
                    <div class="p-3 location" style="padding: 10px !important;height: auto;">


                         @if($video->messmessage['name']!=null)
                            <label class="form-label">Name</label>
                            <input class="form-control" type="text" name="name" id="l_name" value="<?php echo $video->message['name'] ?>"><br/>
                         @endif

                         @if($video->message['phone']!=null)
                            <label class="form-label">Phone</label>
                            <input class="form-control" type="text" name="name" id="l_name"  value="<?php echo $video->message['phone'] ?>"><br/>
                         @endif

                         @if($video->message['subject']!=null)
                            <label class="form-label">Subject</label>
                            <input class="form-control" type="text" name="name" id="l_name"  value="<?php echo $video->message['subject'] ?>"><br/>
                         @endif

                         @if($video->message['message']!=null)
                            <label class="form-label">Message</label>
                            <textarea class="form-control" style="min-height:150px"><?php echo $video->message['message'] ?></textarea>
                         @endif

                   </div>
                </div>
            @endif
        </div>
        <!-- 2nd Row -->
        <div class="row">
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
                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input class="form-control" type="text" name="name" id="email" placeholder="Email">
                        <br>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Phone No</label>
                        <input class="form-control" type="text" id="phone" placeholder="Phone No">
                        <br>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label"> Date of birth</label>
                        <input class="form-control" type="text" id="dob" placeholder="Date of birth">
                        <br>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Address 1</label>
                        <input class="form-control" type="text" id="add1" placeholder="Address 1">
                        <br>
                    </div>

                    <div class="col-md-6">
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
                    <div id="user_emergency_contacts">

                    </div>

                    <input class="form-control" type="text" name="address" placeholder="Address" style="opacity: 0">

                </form>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>



<?php
$locations = \App\VideoLocationTracking::where('video_id', $video->video_id)->get();
if (count($locations) > 0) {
	$lat = $locations[0]['latitude'];
	$long = $locations[0]['longitude'];
} else {
	$lat = '';
	$long = '';
}
?>
<script>

    function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>},
            mapTypeId: 'terrain'
        });

        var marker1 = new google.maps.Marker({
            position: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>},
            map: map,
            title: 'Hello World!',
            icon:"http://maps.google.com/mapfiles/ms/micons/blue.png"
        });

        var flightPlanCoordinates = [
                <?php foreach ($locations as $location) {?>
            {lat: <?php echo $location->latitude; ?>, lng: <?php echo $location->longitude; ?>},
            <?php }?>
        ];
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        for (var i = 0; i < flightPath.getPath().getLength(); i++) {
            var marker = new google.maps.Marker({
                icon: {
                    // use whatever icon you want for the "dots"
                    url: "http://maps.google.com/mapfiles/ms/micons/blue.png",
                    size: new google.maps.Size(7, 7),
                    anchor: new google.maps.Point(4, 4)
                },
                position: flightPath.getPath().getAt(i),
                title: flightPath.getPath().getAt(i).toUrlValue(6),
                map: map
            });
        }

        flightPath.setMap(map);

    }
    var intervalId= setInterval(function () {

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>},
            mapTypeId: 'terrain'
        });

        var marker1 = new google.maps.Marker({
            position: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>},
            map: map,
            title: 'Hello World!',
            icon:"http://maps.google.com/mapfiles/ms/micons/blue.png"
        });

        var flightPlanCoordinates = [
                <?php
$locations = \App\VideoLocationTracking::where('video_id', $video->video_id)->get();
foreach ($locations as $location) {?>
            {lat: <?php echo $location->latitude; ?>, lng: <?php echo $location->longitude; ?>},
            <?php }?>
        ];
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2
        });

        flightPath.setMap(map);
    },10000);
</script>

<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/bootstrap.min.js"></script>

<!-- Bootstrap Material Design JavaScript -->
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>

<script src="//maps.google.com/maps/api/js?key=AIzaSyCjAnICAKNpJvPuLbcLAD0Ar5S2R5QKkpo&callback=initMap" type="text/javascript"></script>


<script>
    // Initialize Firebase


</script>
<script>
    // Initialize Firebase
   var firebaseConfig = {
    // apiKey: "AIzaSyDeobLtUrut0FpZL9fGdrGFSVI0AxXxq1c",
    // authDomain: "ifollow-themeparkalert.firebaseapp.com",
    // databaseURL: "https://ifollow-themeparkalert.firebaseio.com",
    // projectId: "ifollow-themeparkalert",
    // storageBucket: "ifollow-themeparkalert.appspot.com",
    // messagingSenderId: "618015420343",
    // appId: "1:618015420343:web:3f34792069ac5cfc330232",
    // measurementId: "G-8TJ8RKZZMV"


    apiKey: "AIzaSyCBq7Eyh6Bzfpfn28m1xi3d5CjQaH_syoc",
    authDomain: "ifollow-realtorsafewalk.firebaseapp.com",
    databaseURL: "https://ifollow-realtorsafewalk.firebaseio.com",
    projectId: "ifollow-realtorsafewalk",
    storageBucket: "ifollow-realtorsafewalk.appspot.com",
    messagingSenderId: "479657899808",
    appId: "1:479657899808:web:0e83598e122d368fbe8945",
    measurementId: "G-D8FMBG2F9V"

  };

  firebase.initializeApp(firebaseConfig);

    var VideoRef = firebase.database().ref('{{$video->video_id}}');
    const  messages =VideoRef.child('messages').orderByChild('timestamp');
    var input = $('input.message');
    var VideoRefMsg= firebase.database().ref('{{$video->video_id}}/messages');

    <?php

if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$name = $user[0]['organization_name'];
	$admin_name = $user[0]['name'];
} else {
	$name = $admin_name = '';
}
?>
    VideoRef.update ({
        isAdminActive: true,
        name: '{{$name}}',

    });

     VideoRef.on("child_changed", function(snapshot) {
        if(snapshot.val()==false) {
			$('#subscriber').hide();
            $('#soon').show();
            $("input").attr('disabled','disabled');

        }

    }, function (error) {
        console.log("Error: " + error.code);
    });

    messages.on("child_added", function(snapshot) {
        if(snapshot.val().isUserMessage==true) {
            if(snapshot.val().type=="2"){
                var html='<p class="speech-bubble msg"><audio controls controlsList="nodownload"> <source src="' +snapshot.val().message +'" type="audio/mpeg"><source src="' +snapshot.val().message+ '" type="audio/wav"></audio></p>';

            }else{
                   var html='<p class="speech-bubble msg"> '+snapshot.val().message +' </p><p style="float: right;margin-top: 23px">'+snapshot.val().name +'</p>';
            }

        }
        else{
             if(snapshot.val().type=="2"){
                 var html='<p class="speech-bubble-right msg"><audio controls controlsList="nodownload"> <source src="' +snapshot.val().message +'" type="audio/mpeg"><source src="' +snapshot.val().message+ '" type="audio/wav"></audio></p>';

            }else{
                   var html='<p class="speech-bubble-right msg"> '+snapshot.val().message +' </p><p style="float: left;margin-top: 23px">'+snapshot.val().name +'</p>';
            }

        }

        $('.chating').append(html);
        $('.panel-body').scrollTop( $('.panel-body')[0].scrollHeight);
        console.log(snapshot.val().message);
        console.log(snapshot.val().type);
        console.log(snapshot.val().timestamp);

    }, function (error) {
        console.log("Error: " + error.code);
    });

    $(document).on('click','#send-link', function(e) {
            input = $('#btn-input')
        if (input.val().length > 0) {
            var getTxt = input.val();
            VideoRefMsg.push ({
                isUserMessage: false,
                message: getTxt,
                type:"1",
                name: '{{$admin_name}}',
                timestamp:firebase.database.ServerValue.TIMESTAMP

            });
            $('.panel-body').scrollTop( $('.panel-body')[0].scrollHeight);

            input.val('');
        }
    });

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
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_name" value="'+(v.name? v.name: "N/A")+'" placeholder="Dr phone">'
              markup += '</div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_relation" value="'+(v.relation? v.relation : "N/A")+'" placeholder="Contact phone No:">'
              markup += '</div>'
              markup += '<div class="col-md-12">'
              markup += '<label class="form-label">Emergency Contact '+i+' Phone</label>'
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_phone" value="'+(v.phone? v.phone : "N/A")+'" placeholder="Contact phone No:">'
              markup += '</div>'
    i++;

        })
    }else{
        for (var i = 1; i <= 2; i++) {

              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+'</label>'
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_name" placeholder="Emergency Contact name">'
              markup += '</div>'
              markup += '<div class="col-md-6">'
              markup += '<label class="form-label">Emergency Contact '+i+' Relation</label>'
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_relation" placeholder="Emergency Contact\'\s Relation">'
              markup += '</div>'
              markup += '<div class="col-md-12">'
              markup += '<label class="form-label">Emergency Contact '+i+' Phone</label>'
              markup += '<input class="form-control" type="text" id="emergency_contact_'+i+'_phone" placeholder="Emergency Contact phone No:">'
              markup += '</div>'
        }
    }
    $('#user_emergency_contacts').append(markup);
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

    function record() {

        // $('#recording').modal();
        $('#recording').modal('show');
    }


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
    var recordingDIV = document.querySelector('.recordrtc');
    var recordingMedia = recordingDIV.querySelector('.recording-media');
    var recordingPlayer = recordingDIV.querySelector('audio');
    var mediaContainerFormat = recordingDIV.querySelector('.media-container-format');

    recordingDIV.querySelector('button').onclick = function() {
        var button = this;

        if(button.innerHTML === 'Stop Recording') {
            button.disabled = true;
            button.disableStateWaiting = true;
            setTimeout(function() {
                button.disabled = false;
                button.disableStateWaiting = false;
            }, 2 * 1000);
            $('#rec').hide();
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
                $('#rec').show();
                button.innerHTML = 'Stop Recording';
                button.disabled = false;
            },
            onMediaStopped: function() {
                button.innerHTML = 'Start Recording';
                $('#rec').hide();
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
        setMediaContainerFormat(['WAV', /*'Mp4',*/ 'Gif']);
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

            if(progress === 'ended') {
                button.disabled = false;
                button.innerHTML = 'Click to download from server';
                var link = document.getElementById('audio-player');
                link.style.display = 'none'; //or
                link.style.visibility = 'hidden';

                VideoRefMsg.push ({
                    isUserMessage: false,
                    message: fileURL,
                    type:"2",
                    name: '{{$admin_name}}',
                    timestamp:firebase.database.ServerValue.TIMESTAMP

                });
                $('.panel-body').scrollTop( $('.panel-body')[0].scrollHeight);
                $('#recording').modal('hide');
                $('#rec').hide();
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
        console.log(blob);
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
            callback('progress-ended');
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
</script>

</body>
</html>
