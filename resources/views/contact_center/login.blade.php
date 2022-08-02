<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
        <meta charset="utf-8" />
        <title>{{ config('app.name') }} Control-Hub Login</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta content="width=device-width, initial-scale=1" name="viewport" />
        <meta content="AgentSafeWalk - Login" name="description" />
        <meta content="" name="author" />
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
        <!-- END GLOBAL MANDATORY STYLES -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('/public') }}/assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL STYLES -->
        <link href="{{ url('/public') }}/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
        <!-- END THEME GLOBAL STYLES -->
        <!-- BEGIN PAGE LEVEL STYLES -->
        <link href="{{ url('/public') }}/assets/pages/css/login-2.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/scripts/css/toastr.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL STYLES -->
        <!-- BEGIN THEME LAYOUT STYLES -->
        <!-- END THEME LAYOUT STYLES -->
        <link rel="shortcut icon" href="favicon.ico" />



         </head>
    <!-- END HEAD -->

    <body class=" login">
        <!-- BEGIN LOGO -->
        <div class="logo">
            <a href="javascript:void(0);">
                <img src="{{ url('/public') }}/images/logo@3x.png" style="height: 70px;" alt="" /> </a>
        </div>




        <!-- END LOGO -->
        <!-- BEGIN LOGIN -->
        <div class="content">
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h3><i class="fa fa-exclamation-triangle"></i> &nbsp;<small
                                class="text-white">{{ session('error') }}</small>
                    </h3>
                </div>
            @endif

            @if(session('success'))

                <div class="alert alert-danger alert-dismissible">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <h3><i class="fa fa-check"></i> &nbsp;<small class="text-white">{{ session('success') }}</small>
                    </h3>

                </div>
            @endif

<?php
if (Session::has('contact_center_admin')) {
	?>

            <script type="text/javascript">
                url='{{ url('/') }}/dashboard';
                window.setTimeout(function() { window.location.href = url }, 500)
            </script>

            <?php

}
?>


            <!-- BEGIN LOGIN FORM -->
            <form class="login-form" id="contact_center_form">
                <div class="form-title">
                    <span class="form-title">Welcome to Contact Center</span><br/>
                    <span class="form-subtitle" style="margin-left: -10px">Please login.</span>
                </div>
                <div class="alert alert-danger display-hide">
                    <button class="close" data-close="alert"></button>
                    <span> Enter any email and password. </span>
                </div>
                <div class="form-group">
                    <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
                    <label class="control-label visible-ie8 visible-ie9">Email</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-group">
                    <label class="control-label visible-ie8 visible-ie9">Password</label>
                    <input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Password" name="password" /> </div>
                <div class="form-actions">
                    <button  id="logInContactCenterButton" class="btn red btn-block uppercase">Log In</button>
                </div>

                <div class="form-actions">

                    <div class="pull-right forget-password-block">
                        <a href="javascript:;" id="forget-password" class="forget-password">Forgot Password?</a>
                    </div>
                </div>



            </form>
            <!-- END LOGIN FORM -->
            <!-- BEGIN FORGOT PASSWORD FORM -->
            <form class="forget-form" action="" id="contact_center_forget_form" method="post">
                <div class="form-title">
                    <span class="form-title">Forget Password ?</span><br/>
                    <span class="form-subtitle" style="margin-left: -10px">Enter your e-mail to Verify Yourself!</span>
                </div>
                <div class="form-group">
                    <input class="form-control placeholder-no-fix" type="text" autocomplete="off" placeholder="Email" name="email" /> </div>
                <div class="form-actions">
                    <button type="button" id="back-btn" class="btn btn-default">Back To Login</button>
                    <button type="submit" class="btn btn-primary uppercase pull-right" id="forgetContactCenterButton">Verify</button>
                </div>
            </form>
            <!-- END FORGOT PASSWORD FORM -->
        </div>
<script type="text/javascript" src="<?php echo url('/') ?>/public/js/material.js"></script>

        <!-- jquery validation -->
        <script type="text/javascript" src="{{url('/')}}/public/js/jquery.min.js"></script>

        <script src="{{ url('/public') }}/assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
        <!-- END CORE PLUGINS -->
        <!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{ url('/public') }}/assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
        <script src="{{ url('/public') }}/assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN THEME GLOBAL SCRIPTS -->
        <script src="{{ url('/public') }}/assets/global/scripts/app.min.js" type="text/javascript"></script>
        <!-- END THEME GLOBAL SCRIPTS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{ url('/public') }}/assets/pages/scripts/login.min.js" type="text/javascript"></script>
        <script type="text/javascript" src="{{url('/')}}/public/js/bootbox.js"></script>

        <!-- END PAGE LEVEL SCRIPTS -->
        <!-- BEGIN THEME LAYOUT SCRIPTS -->
        <!-- END THEME LAYOUT SCRIPTS -->
        <script>
            $(document).ready(function()
            {
                $('#clickmewow').click(function()
                {
                    $('#radio1003').attr('checked', 'checked');
                });




            })
                       //Contact center Login
        $('#contact_center_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },

            submitHandler:function(form){

                $('#logInContactCenterButton').attr('disabled',true);
                $('#logInContactCenterButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/contact_center/ajax/login",
                    type:'post',
                    data: $("#contact_center_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                    },
                    success:function(data)
                    {
                        $('#logInContactCenterButton').attr('disabled',false);
                        $('#logInContactCenterButton').html('Log In');
                        if(data=='login successful')
                        {
                            toastr["success"](data);
                            url='{{ url('/') }}/dashboard';
                            window.setTimeout(function() { window.location.href = url }, 1000)
                        }
                        else
                        {
                            toastr["error"](data);
                        }
                    }
                })
            }
        });

         //Contact center Forget
        $('#contact_center_forget_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },

            submitHandler:function(form){

                $('#forgetContactCenterButton').attr('disabled',true);
                $('#forgetContactCenterButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/contact_center/ajax/forget",
                    type:'post',
                    data: $("#contact_center_forget_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                    },
                    success:function(data)
                    {
                         url='{{ url('/') }}/dashboard';
                        $('#forgetContactCenterButton').attr('disabled',false);
                        $('#forgetContactCenterButton').html('Verify');
                        if(data.response =='success')
                        {
                            var dialog = bootbox.dialog({
                            message: '<p class="text-center"><h3>password Verification Link has been sent to your email address kindly. check it out & change the password safely... </h3></p>',
                            closeButton: false
                            });


                            window.setTimeout(function() { dialog.modal('hide'); }, 5000)
                            window.setTimeout(function() { window.location.href = url }, 6000)
                        }
                        else
                        {
                        toastr.options = {
                            "closeButton": true,
                            "debug": false,
                            "newestOnTop": false,
                            "progressBar": false,
                            "positionClass": "toast-top-center",
                            "preventDuplicates": false,
                            "onclick": null,
                            "showDuration": "300",
                            "hideDuration": "1000",
                            "timeOut": "5000",
                            "extendedTimeOut": "1000",
                            "showEasing": "swing",
                            "hideEasing": "linear",
                            "showMethod": "fadeIn",
                            "hideMethod": "fadeOut"
                        }
                            toastr["error"](data);
                        }
                    }
                })
            }
        });
        </script>


    </body>

</html>