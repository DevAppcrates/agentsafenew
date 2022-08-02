@extends('contact_center_2.layout.default')
@section('page-content')
      <style>
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
        overflow: hidden;
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
    height: 38px;
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
.right-name {
    position: absolute;
    right: 125px;
    top: 115px;
}
.chating{
	position: relative;
}
/*html,body{ -webkit-overflow-scrolling : touch !important; overflow: auto !important; height: 100% !important; }*/
  @media only screen
  and (min-device-width: 320px)
  and (max-device-width: 568px) {
    .diolog-css{
    bottom: 25%;
    position: fixed;
    width: 100%;
    left: 0%;

}

    .profile {
    height: auto!important;
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

	#btn-input {
	    width: 80%!important;
	}

    #rec-link{
            padding: 0% 0% !important;

    }
    #send-chat-link{
            padding: 0% 2% !important;

    }

}
.speech-bubble {
            position: relative;
            background: linear-gradient(#ebebeb,#cbcbcb);
            border-radius: .8em;
            float: left;
            width: auto;
            max-width: 70%;
            min-width: 20%;
            margin: 15px;
             padding: 4px 7px;
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
            border-radius: .8em;
            float: right;
            width: auto;
            max-width: 70%;
            min-width: 20%;
            margin: 15px;
            padding: 4px 7px;
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
    height: 400px;
    border: none;
    padding: 20px;
}

      audio{
          width: 100%;
      }
#btn-input {
    width: 90%;
    margin: 0;
    padding: 0px 0px;
    border-radius: 16px;
    padding: 0px 10px !important;
}
.left-single-chat .time-span {
    position: absolute;
    left: 18px;
    bottom: -5px;
    font-size: 12px;
}
.right-single-chat {
    position: relative;
    display: inline-block;
    width: 100%;
        margin: 10px;
}

.right-single-chat .time-span {
    position: absolute;
    right: 22px;
    bottom: -5px;
    font-size: 12px;
}
.left-single-chat {
    position: relative;
    display: inline-block;
    width: 100%;
    margin: 10px;
}
span.name-span {
    font-weight: bold;
}
a#send-chat-link {
    position: absolute;
    right: 0;
}
.chat-section {
    height: 450px;
}
.chat-section:hover {
    box-shadow: 2px 4px 3px #555;
}

.right-single-chat span.name-span {
    font-weight: bold;
    color: black;
    position: absolute;
    top: -2px;
    font-size: 12px;
    right: 25px;
}

.left-single-chat span.name-span {
    font-weight: bold;
    color: black;
    position: absolute;
    top: -2px;
    font-size: 12px;
    left: 25px;
}

</style>
@include('contact_center.header')
<input type="hidden" class="is-chat-close" name="chat-state" value="close">
<main class="">
    <div class="container-fluid" style="height: 500px" >
        <div class="row">
            <div class="col-xs-12 col-lg-1" style=""></div>
            <div class="col-xs-12 col-lg-10 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
            	<h3 class="h3 text-uppercase">Admin chat</h3>
                <div class="chat-section">
                     <div class="panel-body">
                <div class="admin-chating" ></div>
                      <div class="panel-footer">
                <div class="input-group m-t-1" style=" position: absolute;bottom: 55px;width: 92%;">
                    <input id="btn-input" type="text" class="form-control message input-sm" placeholder="Type your message here..." style=";margin:0;padding: 0px 0px;">
                    <a class="" id="send-chat-link" style="margin: 0px;padding: 0% 1%;"><img src="{{ url('/public/images/icons/send.png') }}" style="width: 40px;"></a>

                </div>
            </div>
                </div>
            </div>
                <br/><br/>
            </div>
            <br/><br/><br/><br/>
        </div>
    </div>
</main>
@include('footer')
<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript">

    // Initialize Firebase
    var config = {
    apiKey: "AIzaSyCBjADBb4XRMa207yYz5iWqNIbZ3NzEods",
    authDomain: "ifollow-cc-3f29a.firebaseapp.com",
    databaseURL: "https://ifollow-cc-3f29a.firebaseio.com",
    projectId: "ifollow-cc-3f29a",
    storageBucket: "ifollow-cc-3f29a.appspot.com",
    messagingSenderId: "897644458314"
  };
  firebase.initializeApp(config);

    <?php

if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$name = $user[0]['organization_name'];
	$admin_id = $user[0]['id'];
	$organization_id = $user[0]['organization_id'];
	$admin_name = $user[0]['name'];
} else {
	$name = '';
	$admin_name = '';
	$admin_id = '';
}
$segment = \Request::segment(1);
?>
    var VideoRef = firebase.database().ref('AdminChat/{{ $organization_id }}');
    window.messages = VideoRef.child('messages').orderByChild('timestamp');
    const messages  = window.messages
    // const  NotViewedmessages = VideoRef.child('messages');
    var UserTimestamp = VideoRef.child('admins');
    const VideoRefMsg= firebase.database().ref('AdminChat/{{ $organization_id }}/messages');
    var admin = firebase.database().ref('AdminChat/{{ $organization_id }}/admins/{{ $admin_id }}');
    admin.update({
      "timestamp": firebase.database.ServerValue.TIMESTAMP
    });
        messages.on("child_added", function(snapshot) {
           if ('{{ $segment }}' == 'admin-chat') {
            var time = new Date(snapshot.val().timestamp).toLocaleTimeString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}'});
            var date = new Date(snapshot.val().timestamp).toLocaleDateString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}',month:'long',day:'2-digit',year :"numeric"});
            var name = snapshot.val().name;
            var message = snapshot.val().message
        if( snapshot.val().adminId == {{$admin_id}}) {

               var html='<div class="right-single-chat"><span class="name-span">'+name+'</span><span class="speech-bubble-right msg">'+message +'</span><span class="time-span"> &nbsp;'+time+' '+date+'</span></div>';
        }
        else{

               var html ='<div class="left-single-chat"><span class="name-span">'+name+'</span><p class="speech-bubble msg">'+message+'</p><span class="time-span"> &nbsp;'+time+' '+date+'</span></div>';
        }
        $('.admin-chating').append(html);
        $('.panel-body').animate({scrollTop : $('.panel-body')[0].scrollHeight},10);
        admin = UserTimestamp.child('{{ $admin_id }}');
        admin.update({
          "timestamp": firebase.database.ServerValue.TIMESTAMP
        });
           } else {
            UserTimestamp.child('{{ $admin_id }}').once('value',function(snapshot){
                timestamp = snapshot.val().timestamp;
            }).then(function(){
                messages.startAt(timestamp).once('value',function(snapshot){
                    Usermessages = snapshot.val();
                    if(Usermessages != null){
                    if(Object.keys(Usermessages).length > 0){
                        $('#chat-badge').html(Object.keys(Usermessages).length);
                        $('#chat-badge').show();

                    }else{

                        $('#chat-badge').hide();
                    }
                    }
                });
            })
            }
    }, function (error) {
        console.log("Error: " + error.code);
    });
var input = $('input.message');
    $(document).on('click','#send-chat-link', function(e) {
            input = $('#btn-input')
        if (input.val().length > 0) {
            var getTxt = input.val();
            VideoRefMsg.push ({
                message: getTxt,
                name : '{{$admin_name}}',
                adminId : '{{$admin_id}}',
                timestamp:firebase.database.ServerValue.TIMESTAMP
            });
            $('.panel-body').scrollTop( $('.panel-body')[0].scrollHeight,100);

            input.val('');
        }
    });
</script>
@stop