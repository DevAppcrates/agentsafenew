
@extends('monitor.layout.GuestLayout')
@section('content')
    <div class="container-fluid">
        <style type="text/css">
           .lock-form .btn{
               width: 92% !important;
           }
        </style>
                <div class="page-lock">
                    <div class="page-logo">
                        <a class="brand"><img width="200px" src="{{ asset('public/images/logo@3x.png') }}"></a>
                    </div>
                    <div class="page-body text-white">
                                <div class="lock-head"><font color="white">One Step Away!</font></div>
                                <div class="lock-body">
                                    <div class="lock-cont">
                                        <div class="lock-item lock-item-full">
                                            <form role="form" action="" class="lock-form" id="monitor_change_password_form" method="post">
                                                <input type="hidden" name="token" value="{{ $token }}">
                                                <div class="form-group">
                                                    <input id="password" autocomplete="off" type="password" class="form-control" placeholder="New Password..."
                                                           name="password"><br/>
                                                           <input autocomplete="off" type="password" class="form-control" placeholder="Confirm Password..."
                                                           name="password_confirmation"><br/>
                                                </div>
                                                <div class="form-actions">
                                                    <button type="submit" style="width: 100%!important;" class="btn btn-primary btn-block"
                                                            id="changepassMonitorButton">Change Password
                                                    </button>
                                                    <br/>
                                                </div>
                                            </form>
                                    </div>
                                </div>
                            </div>
                </div>
            </div>
        </div>

    @include('footer')
    <script type="text/javascript">
         //Contact center Forget
        $('#monitor_change_password_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true },password_confirmation :{equalTo : "#password",required: true}
            },


            submitHandler:function(form){

                $('#changepassMonitorButton').attr('disabled',true);
                $('#changepassMonitorButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/monitor-hub/ajax/change_password_monitor",
                    type:'post',
                    data: $("#monitor_change_password_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}/monitor-hub';
                    },
                    success:function(data)
                    {
                            url='{{ url('/') }}/monitor-hub';
                        $('#changepassMonitorButton').attr('disabled',false);
                        $('#changepassMonitorButton').html('Change Password');
                        if(data.response=='success')
                        {

                            var dialog = bootbox.dialog({
                            message: '<p class="text-center"><h3><i class="fa fa-check"></i> Password Changed Successfully</h3></p><h5>You are going to redirect at Login page</h5>',
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
                            toastr["error"]('there is an issue while changing password try with new request');
                            window.setTimeout(function() { window.location.href = url }, 6000)
                        }
                    }
                })
            }
        });
    </script>
@endsection