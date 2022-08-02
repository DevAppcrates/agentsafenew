<!DOCTYPE html>
<html lang="en">
<head>
    <title>iFollow</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{url('/')}}/public/css/material.css" rel="stylesheet">
    <link rel="stylesheet" href="https://coolestguidesontheplanet.com/videodrome/mediaelementjs/build/mediaelementplayer.css"/>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css">

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
    <!--begin::Web font -->
  <style>
 .collapsing, .embed-responsive, .media, .media-body, .modal, .modal-open, .navbar-divider {
    overflow: hidden !important;
}
body {
background-color: #edf1f7;
}
body .h3 {
    color: #153854;
    font-weight: 600;
}
.modal .modal-content {
          -webkit-border-radius: 17px;
          -moz-border-radius: 17px;
          -ms-border-radius: 17px;
          -o-border-radius: 17px;
          border-radius: 17px;
          border: 0;
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
.col-md-5, .col-md-7{
    margin-top: 5%;
}
 .profile {
    height: auto!important;
    }
.location{
 height: auto!important;
}

.mejs-container-fullscreen {
     position: static!important;

}
#myvideo2{
           width: 100%!important;height:346px !important;margin-top: 0px !important;border:5px solid #dedad3 !important;border: unset;
    }
    .mejs-mediaelement {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.mejs-overlay-button {
    left: 50% !important;
}

.mejs-container .mejs-controls {
    height: 50px!important;
    width: 100%!important;
}
.mejs-time-loaded {
    width: 100%!important;
}
.mejs-overlay, .mejs-layer, .mejs-overlay-play {
  width: 100% !important;
}

.mejs-container {
       height: 348px !important;
}
.mejs-time-rail{
              width: 145px!important;
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

.mejs-container-fullscreen .mejs-mediaelement, .mejs-container-fullscreen #myvideo2 {
    width: 100% !important;
    height: 100% !important;
    object-fit: cover;
         border: unset;
}


.mejs-controls div.mejs-time-rail {
    direction: ltr;
    width: auto!important;
    min-width: 55%!important;
}

.mejs-time-total, .mejs-time-slider {
    width: 50%!important;
}

.mejs-container .mejs-controls .mejs-time {
    padding: 10px 2px 0 !important;
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
       .mejs-container {
    height: 100% !important;
    width: 100% !important;
}
.mejs-container-fullscreen {
    width: 100% !important;
    height: 100% !important;
}
 .mejs-overlay {
    height: 100% !important;
    width: 100% !important;
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
        width: 84%;
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
                <img class="logo-image" src="{{ asset('public/images/logo.png')}}">
            </div>

            <div class="col-md-6 col-sm-6" align="center" style="margin-top: -8px;">
                <h3 class="page-title"> @if($video->type=='panic')<strong>PANIC @else ANONYMOUS PANIC @endif ALERT DETAILS</strong></h3>
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
            @if($video->type != 'panic')
            <div class="col-md-3">

            </div>
            @endif
            <div  @if($video->type!='panic')class="col-md-6"@else class="col-md-7" @endif>
            <h3 class="h3"> <img style="margin-top: -15px;margin-left: -10px;" height="40px" width="40px" src="{{ asset('public/images/replay-icon.png') }}"> VIDEO</h3>
                <div class="video-section">
               <video id="myvideo2" style="width:100%;height:346px !important;margin-top: 0px;border:5px solid #dedad3" controls="controls" >
                <source src="{{$archive_url}}" type="video/mp4"/>
            </video>
                </div>
            </div>
            @if($video->type !='panic')
            <div class="col-md-3">

            </div>
            @endif
            @if($video->type=='panic')
            @php
                $user=\App\Users::with('user_emergency_contacts')->where('user_id',$video->user_id)->first();
            @endphp
           {{--  {{ dd($user) }} --}}

            <div class="col-md-5">
            <h3 class="h3">PROFILE</h3>
                <div class="profile">
                    <div class="image">

                    <!-- USER PROFILE -->

                        <img class="img-circle" src="{{$user->display_picture}}">
                    </div>
                    <div class="details" align="center">

                        <!-- USER NAME -->

                        <h3><b>{{$user->first_name}} {{$user->last_name}}</b></h3>
                        <h4>User<h4>

                        <button type="button" class="btn btn-primary blue" onclick="userDetail('{{$user->first_name}}','{{$user->last_name}}','{{$user->email}}','{{$user->phone_number}}','{{date('m/d/Y',strtotime($user->date_of_birth))}}','{{$user->display_picture}}','{{$user->user_address->address_1}}','{{$user->user_address->address_2}}','{{$user->user_address->city}}','{{$user->user_address->state}}','{{$user->user_address->country}}','{{$user->user_address->zipcode}}','{{$user->user_medical_info->illness_allergies}}','{{$user->user_medical_info->dr_name}}','{{$user->user_medical_info->dr_phone}}','{{ $user->user_emergency_contacts }}')">VIEW PROFILE</button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <br>
        <!-- 2nd Row -->

        <div class="row">
            <div class="col-md-7">
            <h3 class="h3">MESSAGES</h3>
                <div class="chat-section">

                     <div class="panel-body">
                <div class="chating" ></div>
            </div>
                </div>
            </div>


            <div class="col-md-5">
            <h3 class="h3">LOCATION</h3>
                <div class="location">
                    <div id="map" style="height: 360px;width: 100%;"></div>
                </div>
            </div>
        </div>


        </div>




{{-- <div class="container-fluid " style="background-color: #fff;">

    <div class="col-sm-6" style="color: #fff;">
        <div class="videocontent videocontent2" style="margin-top: 27px">
            <video id="myvideo2" style="width:100%;height:400px;margin-top: 0px;border:5px solid #dedad3" controls="controls" >
                <source src="{{$archive_url}}" type="video/mp4"/>
            </video>
            <br/>
        </div>

    </div>
    <div class="col-sm-6">

        <div class="panel panel-primary">
            <div class="panel-body">


            </div>
            <div class="panel-footer">

            </div>
        </div>

    </div>
    <div class="row responsive">
        <div class="col-sm-12">

        </div>

    </div>
</div>
 --}}
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
<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<script src="https://static.opentok.com/v2.14/js/opentok.js"></script>

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
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript" src="{{ url('/') }}/public/js/bootstrap.min.js"></script>

<!-- Bootstrap Material Design JavaScript -->
<script type="text/javascript" src="{{ url('/') }}/public/js/material.js"></script>
<script>

    function initMap() {
        @if(!empty($lat) && !empty($long))

        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: {lat: {{ $lat }}, lng: {{ $long }} },
            mapTypeId: 'terrain'
        });

        var marker = new google.maps.Marker({
            position: {lat: <?php echo $lat; ?>, lng: <?php echo $long; ?>},
            map: map,
            title: 'Hello World!',
            icon:"http://maps.google.com/mapfiles/ms/micons/blue.png"
        });

        @endif

        // Define the symbol, using one of the predefined paths ('CIRCLE')
        // supplied by the Google Maps JavaScript API.
        var lineSymbol = {
            path: google.maps.SymbolPath.CIRCLE,
            scale: 3,
            strokeColor: '#393'
        };

        var flightPlanCoordinates = [
            @foreach ($locations as $location)
            {lat: {{ $location->latitude }}, lng: {{ $location->longitude }} },
            @endforeach
        ];
        var flightPath = new google.maps.Polyline({
            path: flightPlanCoordinates,
            icons: [{
                icon: lineSymbol,
                offset: '100%'
            }],
            geodesic: true,
            strokeColor: '#FF0000',
            strokeOpacity: 1.0,
            strokeWeight: 2,
            map: map
        });


        animateCircle(flightPath);
        //flightPath.setMap(map);



    }

    // Use the DOM setInterval() function to change the offset of the symbol
    // at fixed intervals.
    function animateCircle(line) {
        var count = 0;
        window.setInterval(function() {
            count = (count + 1) % 200;

            var icons = line.get('icons');
            icons[0].offset = (count / 2) + '%';
            line.set('icons', icons);
        }, 300);
    }

</script>



<script src="//maps.google.com/maps/api/js?key=AIzaSyCjAnICAKNpJvPuLbcLAD0Ar5S2R5QKkpo&callback=initMap" type="text/javascript"></script>

<script src="https://coolestguidesontheplanet.com/videodrome/mediaelementjs/build/mediaelement-and-player.min.js"></script>
<script>
    $(document).ready(function(){$('video, audio').mediaelementplayer();});
</script>
<script>
   var config = {
    apiKey: "AIzaSyCBjADBb4XRMa207yYz5iWqNIbZ3NzEods",
    authDomain: "ifollow-cc-3f29a.firebaseapp.com",
    databaseURL: "https://ifollow-cc-3f29a.firebaseio.com",
    projectId: "ifollow-cc-3f29a",
    storageBucket: "ifollow-cc-3f29a.appspot.com",
    messagingSenderId: "897644458314"
  };
  firebase.initializeApp(config);

    var VideoRef = firebase.database().ref('{{$video->video_id}}');
   var VideoRefMsg= firebase.database().ref('{{$video->video_id}}/messages');
    const  messages =VideoRef.child('messages').orderByChild('timestamp');
   var input = $('input.message');

    messages.on("child_added", function(snapshot) {
            <?php
if ($video->type == 'panic') {
    ?>
                 name = snapshot.val().name;
                <?php

} else {
    ?>
                name = 'Anonymous';
                <?php
}

?>
          if(snapshot.val().isUserMessage==true) {
            if(snapshot.val().type=="2"){
                var html='<p class="speech-bubble msg"><audio controls controlsList="nodownload"> <source src="' +snapshot.val().message +'" type="audio/mpeg"><source src="' +snapshot.val().message+ '" type="audio/wav"></audio></p><p style="float: right;margin-top: 23px">'+name+'</p>';

            }else{
                   var html='<p class="speech-bubble msg"> '+snapshot.val().message +' </p><p style="float: right;margin-top: 23px">'+name+'</p>';
            }

        }
        else{
             if(snapshot.val().type=="2"){
                 var html='<p class="speech-bubble-right msg"><audio controls controlsList="nodownload"> <source src="' +snapshot.val().message +'" type="audio/mpeg"><source src="' +snapshot.val().message+ '" type="audio/wav"></audio></p><p style="float: right;margin-top: 23px">'+name+'</p>';

            }else{
                   var html='<p class="speech-bubble-right msg"> '+snapshot.val().message +' </p><p style="float: left;margin-top: 23px">'+snapshot.val().name +'</p>';
            }

        }

        $('.chating').append(html);
        $('.panel-body').scrollTop( $('.panel-body')[0].scrollHeight+100 );

        console.log(snapshot.val().message);
         console.log(snapshot.val().type);
        console.log(snapshot.val().timestamp);

    }, function (error) {
        console.log("Error: " + error.code);
    });


   input.on('keyup', function(e) {
       if (e.keyCode === 13 && input.val().length > 0) {
           var getTxt = input.val();
           VideoRefMsg.push ({
               isUserMessage: false,
               message: getTxt,
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



</script>
</body>
</html>
