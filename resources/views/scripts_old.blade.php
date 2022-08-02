<script>


    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    // popovers Initialization
    $(function () {
        $('[data-toggle="popover"]').popover({
            trigger : "focus"
        })
    })

</script>


<!-- Material select -->

<!-- Ezdz plugin -->
<script>
    $('[class^=a][type="file"]').ezdz({
        text:"<img src=''/>"
    }  );
</script>


<!-- Validations -->
<script type="text/javascript">



    $(document).ready(function(){
        // alert($('#send-push > #form-group btn.dropdown-toggle.bs-placeholder.btn-default').addClass('blue'))
        $('input[name="type"]').change(function(){
            $('.recordrtcpush').toggle();
            $('#file-push').toggle();
        })
        $('.mdb-select').material_select();

        setTimeout(function(){
            <?php
if (Request::has('type') && Request::has('video_id')): ?>
                id = "{{ Request::get('video_id') }}"
            viewVideo(id)
            <?php endif;?>
        })


        //Add Contact Center
        $('#add-sub-contact-center').validate({
            errorClass : 'text-danger',
            rules: {
                name: {required: true},start_time: {required: true},end_time: {required: true},
                email: {required: true,email:true},
                phone: {required: true,number:true,minlength:10,maxlength:11},
                password: {minlength: 6,required: true,pwcheck:true},
            },
            messages: {

                password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                }

            },
            submitHandler: function(form) {

                $('#add_sub_contact_center_button').attr('disabled', true);
                $('#add_sub_contact_center_button').html('Loading ...');
                var formData = new FormData($("#add-sub-contact-center")[0]);
                $.ajax({
                    url: "{{url('/')}}/contact_center/ajax/add_organization",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function(errors) {
                        $('#add_sub_contact_center_button').attr('disabled', false);
                        $('#add_sub_contact_center_button').html('Add Administrator');
                        error = $.parseJSON(errors.responseText);
                        $.each(error,function(key,value){
                            if(typeof value.monday_start_time != 'undefined')
                            {
                                toastr['error'](value.monday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                            }
                            if(typeof value.monday_close_time != 'undefined')
                            {
                                toastr['error'](value.monday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                            }
                            if(typeof value.tuesday_start_time != 'undefined')
                            {
                                toastr['error'](value.tuesday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.tuesday_close_time != 'undefined')
                            {
                                toastr['error'](value.tuesday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }

                            if(typeof value.wednesday_start_time != 'undefined')
                            {
                                toastr['error'](value.wednesday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.wednesday_close_time != 'undefined')
                            {
                                toastr['error'](value.wednesday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }

                            if(typeof value.thursday_start_time != 'undefined')
                            {
                                toastr['error'](value.thursday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.thursday_close_time != 'undefined')
                            {
                                toastr['error'](value.thursday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.friday_start_time != 'undefined')
                            {
                                toastr['error'](value.friday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.friday_close_time != 'undefined')
                            {
                                toastr['error'](value.friday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }

                            if(typeof value.saturday_start_time != 'undefined')
                            {
                                toastr['error'](value.saturday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.saturday_close_time != 'undefined')
                            {
                                toastr['error'](value.saturday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }

                            if(typeof value.sunday_start_time != 'undefined')
                            {
                                toastr['error'](value.sunday_start_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                            if(typeof value.sunday_close_time != 'undefined')
                            {
                                toastr['error'](value.sunday_close_time);
                                window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                            }
                        })


                    },
                    success: function(data) {
                        $('#add_sub_contact_center_button').attr('disabled', false);
                        $('#add_sub_contact_center_button').html('Add Administrator');
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
        })

        $('#form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },
            submitHandler:function(form){

                $('#logInButton').attr('disabled',true);
                $('#logInButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/ajax/login",
                    type:'post',
                    data: $("#form").serialize(),
                    error:function(){
                        url='{{ url('/') }}/ajax/login';
                    },
                    success:function(data)
                    {
                        $('#logInButton').attr('disabled',false);
                        $('#logInButton').html('Log In');
                        if(data=='login successful')
                        {
                            toastr["success"](data);
                            url='{{ url('/') }}/master-hub/dashboard';
                            window.setTimeout(function() { window.location.href = url }, 100)
                        }
                        else
                        {
                            toastr["error"](data);
                        }
                    }
                })
            }
        });





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
                         url='{{ url('/') }}';
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


        //Contact center Forget
        $('#contact_center_change_password_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true },password_confirmation :{equalTo : "#password",required: true}
            },


            submitHandler:function(form){

                $('#changepassContactCenterButton').attr('disabled',true);
                $('#changepassContactCenterButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/contact_center/ajax/change_password_cc",
                    type:'post',
                    data: $("#contact_center_change_password_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                    },
                    success:function(data)
                    {
                            url='{{ url('/') }}';
                        $('#changepassContactCenterButton').attr('disabled',false);
                        $('#changepassContactCenterButton').html('Change Password');
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



         //Master Hub Forget
        $('#master_hub_forget_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },

            submitHandler:function(form){

                $('#forgetMasterHubButton').attr('disabled',true);
                $('#forgetMasterHubButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/ajax/forget",
                    type:'post',
                    data: $("#master_hub_forget_form").serialize(),
                    error:function(){
                        url='{{ url('/master-hub') }}';
                    },
                    success:function(data)
                    {
                         url='{{ url('/master-hub') }}';
                        $('#forgetMasterHubButton').attr('disabled',false);
                        $('#forgetMasterHubButton').html('Verify');
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


        //Master HUb Forget
        $('#master_hub_change_password_form').validate({
            errorClass : 'text-danger',
            rules: { password: { minlength: 6,required: true },password_confirmation :{equalTo : "#password",required: true}
            },


            submitHandler:function(form){

                $('#changepassMasterHubButton').attr('disabled',true);
                $('#changepassMasterHubButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/ajax/change_password_master_hub",
                    type:'post',
                    data: $("#master_hub_change_password_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                    },
                    success:function(data)
                    {
                            url='{{ url('/master-hub') }}';
                        $('#changepassMasterHubButton').attr('disabled',false);
                        $('#changepassMasterHubButton').html('Change Password');
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


        //Monitoring Login
        $('#monitoring_form').validate({
            rules: { password: { minlength: 6,required: true }, email: {required: true}
            },

            submitHandler:function(form){

                $('#logInMonitoringButton').attr('disabled',true);
                $('#logInMonitoringButton').html('Loading ...');
                $.ajax({
                    url:"{{ url('/') }}/monitoring/ajax/login",
                    type:'post',
                    data: $("#monitoring_form").serialize(),
                    error:function(){
                        url='{{ url('/') }}/monitoring';
                    },
                    success:function(data)
                    {
                        $('#logInMonitoringButton').attr('disabled',false);
                        $('#logInMonitoringButton').html('Log In');
                        if(data=='login successful')
                        {
                            toastr["success"](data);
                            url='{{ url('/') }}/monitoring/dashboard';
                            window.setTimeout(function() { window.location = url }, 100)
                        }
                        else
                        {
                            toastr["error"](data);
                        }
                    }
                })
            }
        });

        //Change Password admin
        $('#change-password').validate({
            errorClass : 'text-danger',
            rules: { old_password: { minlength: 6,required: true, pwcheck: true, }, new_password: { minlength: 6,required: true,pwcheck: true,}},
            messages: {

                old_password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },
                new_password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },

            },

            submitHandler:function(form){

                $('#changePasswordButton').attr('disabled',true);
                $('#changePasswordButton').html('Loading ...');
                $.ajax({
                    url:"{{url('/')}}/contact_center/ajax/change_password",
                    type:'post',
                    data: $("#change-password").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                        window.setTimeout(function() { window.location = url }, 100)
                    },
                    success:function(data)
                    {
                        $('#changePasswordButton').attr('disabled',false);
                        $('#changePasswordButton').html('Save Changes');
                        if(data=='success')
                        {
                            toastr["success"]('Changes confirmed');

                            window.setTimeout(function() {location.reload() }, 100)
                        }
                        else
                        {
                            toastr["error"](data);
                        }
                    }
                })
            }
        });

        //Change Password admin
        $('#change-password-admin').validate({
            errorClass : 'text-danger',
            rules: { old_password: { minlength: 6,required: true , pwcheck: true,}, new_password: { minlength: 6,required: true, pwcheck: true,}},
            messages: {

                old_password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },
                new_password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },

            },

            submitHandler:function(form){

                $('#changePasswordAdminButton').attr('disabled',true);
                $('#changePasswordAdminButton').html('Loading ...');
                $.ajax({
                    url:"{{url('/')}}/ajax/change_password",
                    type:'post',
                    data: $("#change-password-admin").serialize(),
                    error:function(){
                        url='{{ url('/') }}';
                        window.setTimeout(function() { window.location.href = url }, 100)
                    },
                    success:function(data)
                    {
                        $('#changePasswordAdminButton').attr('disabled',false);
                        $('#changePasswordAdminButton').html('Save Changes');
                        if(data=='success')
                        {
                            toastr["success"]('Changes confirmed');

                            window.setTimeout(function() {location.reload() }, 100)
                        }
                        else
                        {
                            toastr["error"](data);
                        }
                    }
                })
            }
        });

        //Add Contact Center
        $('#add-contact-center').validate({
            errorClass : 'text-danger',
            rules: {
                name: {required: true}, user_name: {required: true},
                email: {required: true,email:true},
                phone: {required: true,number:true,minlength:10,maxlength:11},
                password: {minlength: 6,required: true,pwcheck:true},
                code: {required: true}, no_of_users: {required: true},
                time_zone: {required: true},
            },
            messages: {

                password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },
                new_password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                },

            },
            submitHandler: function(form) {

                $('#add_contact_center_button').attr('disabled', true);
                $('#add_contact_center_button').html('Loading ...');
                var formData = new FormData($("#add-contact-center")[0]);
                $.ajax({
                    url: "{{url('/')}}/ajax/add_organization",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function(error) {
                        error = $.parseJSON(error.responseText);
                        toastr['error'](error.message)
                    },
                    success: function(data) {
                        $('#add_contact_center_button').attr('disabled', false);
                        $('#add_contact_center_button').html('Add Contact Center');
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


        $('#add-admin').validate({
            rules: {
                name: {required: true},
                email: {required: true,email:true},
                password: {minlength: 6,required: true,pwcheck:true}
            },

            messages: {

                password: {
                    pwcheck: "Password at-least 6 characters long and a combination of number and letter",
                }

            },
            errorClass : 'text-danger',
            submitHandler: function(form) {

                $('#add_admin_button').attr('disabled', true);
                $('#add_admin_button').html('Loading ...');
                var formData = new FormData($("#add-admin")[0]);
                $.ajax({
                    url: "{{url('/')}}/ajax/add_admin",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function(errors) {
                        url = '{{ url('/') }}';
                    },
                    success: function(data) {
                        $('#add_admin_button').attr('disabled', false);
                        $('#add_admin_button').html('Add Admin');
                        if (data == 'Account already exists') {
                            toastr["error"](data);

                        } else {
                            toastr["success"](data);
                            window.setTimeout(function() {
                                location.reload();
                            }, 500)
                        }
                    }
                })
            }
        });


        //Add Admin
        $('#add-code').validate({
            rules: {
                name: {required: true},
                code: {required: true}
            },

            submitHandler: function(form) {

                $('#add_code_button').attr('disabled', true);
                $('#add_code_button').html('Loading ...');
                var formData = new FormData($("#add-code")[0]);
                $.ajax({
                    url: "{{url('/')}}/ajax/add_code",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function() {
                        url = '{{ url('/') }}';
                    },
                    success: function(data) {
                        $('#add_admin_button').attr('disabled', false);
                        $('#add_admin_button').html('Add Admin');
                        if (data == 'Code already exists') {
                            toastr["error"](data);

                        } else {
                            toastr["success"](data);
                            window.setTimeout(function() {
                                location.reload();
                            }, 500)
                        }
                    }
                })
            }
        });

        //Add Monitoring Center
        $('#add-monitoring-official').validate({
            rules: {
                name: {required: true},
                email: {required: true,email:true},
                phone: {required: true,number:true},
                password: {required: true}
            },

            submitHandler: function(form) {

                $('#add_monitoring_official_button').attr('disabled', true);
                $('#add_monitoring_official_button').html('Loading ...');
                var formData = new FormData($("#add-monitoring-official")[0]);
                $.ajax({
                    url: "{{url('/')}}/ajax/add_monitoring_official",
                    type: 'post',
                    cache: "false",
                    contentType: false,
                    processData: false,
                    data:formData,
                    error: function() {
                        url = '{{ url('/') }}';
                    },
                    success: function(data) {
                        $('#add_monitoring_official_button').attr('disabled', false);
                        $('#add_monitoring_official_button').html('Add Monitoring Official');
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
        })

    });
</script>

<script>
    var startDate = new Date('01-01-2012');
    var FromEndDate = new Date('');
    var ToEndDate = new Date('');

    ToEndDate.setDate(ToEndDate.getDate()+365);

    $('.from_date').datepicker({

        weekStart: 1,
        startDate: '01/01/2012',
        endDate: FromEndDate,
        language: 'pt-BR'

//    format: ' yyyy',
//    viewMode: 'years',
//    minViewMode: 'years'
    })
        .on('changeDate', function(selected){
            startDate = new Date(selected.date.valueOf());
            startDate.setDate(startDate.getDate(new Date(selected.date.valueOf())));
            $('.to_date').datepicker('setStartDate', startDate);
        });
    $('.to_date').datepicker({

        weekStart: 1,
        startDate: startDate,
        endDate: ToEndDate,
        autoclose: true
    })
        .on('changeDate', function(selected){
            FromEndDate = new Date(selected.date.valueOf());
            FromEndDate.setDate(FromEndDate.getDate(new Date(selected.date.valueOf())));
            $('.from_date').datepicker('setEndDate', FromEndDate);
        });

    $(function() {
        $('.datepicker').keypress(function(event) {
            event.preventDefault();

            return false;
        });
    });

    //Logout
    function adminLogout()
    {
        $.ajax({
            url:"{{ url('/') }}/ajax/logout",
            type:'post',
            error:function(){
                url='{{ url('/master-hub') }}';
                window.setTimeout(function() { window.location = url }, 100)
            },
            success:function(data)
            {
                url='{{ url('/master-hub') }}';
                window.setTimeout(function() { window.location = url }, 100)

            }
        });
    }

    function adminCCLogout()
    {
        $.ajax({
            url:"{{ url('/') }}/contact_center/ajax/logout",
            type:'post',
            error:function(){
                url='{{ url('/') }}';
                window.setTimeout(function() { window.location.href = url }, 100)
            },
            success:function(data)
            {
                url = '{{ url('/') }}';
                window.setTimeout(function() { window.location.href = url }, 100)

            }
        });
    }

    function adminMLogout()
    {
        $.ajax({
            url:"{{ url('/') }}/monitoring/ajax/logout",
            type:'post',
            error:function(){
                url='{{ url('/') }}/monitoring';
                window.setTimeout(function() { window.location.href = url }, 100)
            },
            success:function(data)
            {
                url='{{ url('/') }}/monitoring';
                window.setTimeout(function() { window.location.href = url }, 100)

            }
        });
    }

    function viewVideo(id)
    {

        toastr.remove();
        $('#iframe').attr('src', '');

        $('#iframe').attr('src', "{{url('/')}}/video_safe/"+id);


        setTimeout(function() {
            $('#videoModal').modal('show');
        }, 1000);


    }

    $('#generate').click(function () {
        var code=Math.random().toString(36).substring(6);
        $('.code').val(code);

    })

</script>
<!-- Date picker validation -->
<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>

<script>
    toastr.options = {
        "closeButton": true,
        "debug": true,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": true,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": 0,
        "extendedTimeOut": 0,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut",
        "tapToDismiss": false
    };

    // Initialize Firebase
    var config = {
        // apiKey: "AIzaSyCBjADBb4XRMa207yYz5iWqNIbZ3NzEods",
        // authDomain: "ifollow-cc-3f29a.firebaseapp.com",
        // databaseURL: "https://ifollow-cc-3f29a.firebaseio.com",
        // projectId: "ifollow-cc-3f29a",
        // storageBucket: "ifollow-cc-3f29a.appspot.com",
        // messagingSenderId: "897644458314"

        apiKey: "AIzaSyCBq7Eyh6Bzfpfn28m1xi3d5CjQaH_syoc",
        authDomain: "ifollow-realtorsafewalk.firebaseapp.com",
        databaseURL: "https://ifollow-realtorsafewalk.firebaseio.com",
        projectId: "ifollow-realtorsafewalk",
        storageBucket: "ifollow-realtorsafewalk.appspot.com",
        messagingSenderId: "479657899808",
        appId: "1:479657899808:web:0e83598e122d368fbe8945",
        measurementId: "G-D8FMBG2F9V"
    };
    firebase.initializeApp(config);

        <?php

if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$name = $user[0]['organization_name'];
	$organization_id = $user[0]['organization_id'];
} else {
	$organization_id = '';
}
$url = url('/') . '/panic'
?>
    var Ref = firebase.database().ref();

    var timestamp=new Date().getTime();

        <?php

if (Session::has('contact_center_admin')) {?>
    Ref.orderByChild("organizationId").equalTo('{{$organization_id}}').on("child_added", function(snapshot) {
        if(snapshot.val().timestamp>timestamp){

            console.log(snapshot.val().timestamp);
            setTimeout(function () {
                var video_id=snapshot.key;
                console.log(snapshot.val().type);
                if(snapshot.val().type=='panic'){
                    toastr["error"]('A new panic alert is in progress click to view<br /><a target="_blank" class="btn btn-success clear" onClick="viewVideo(\'' + video_id + '\')">View</a>');
                }else{
                    toastr["error"]('A new Tip Report has been submitted click to view<br /><a target="_blank" class="btn btn-success clear" onClick="viewVideo(\'' + video_id + '\')">View</a>');
                }

            },1000);
        }
    }, function (error) {
        console.log("Error: " + error.code);
    });
    <?php }?>

    $.validator.addMethod("pwcheck", function(value) {
        return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
            && /[a-z]/.test(value) // has a lowercase letter
            && /\d/.test(value) // has a digit
    });


    //edit Contact Center
    $('#edit-profile-contact-center').validate({
        rules: {
            name: {required: true},user_name: {required: true},
            email: {required: true,email:true},
            phone: {required: true,number:true,minlength:10,maxlength:11},
            code: {required: true},no_of_users: {required: true},

        },
        errorClass : 'text-danger',
        submitHandler: function(form) {

            $('#edit_profile_contact_center_button').attr('disabled', true);
            $('#edit_profile_contact_center_button').html('Loading ...');
            var formData = new FormData($("#edit-profile-contact-center")[0]);
            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/edit_profile",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#edit_profile_contact_center_button').attr('disabled', false);
                    $('#edit_profile_contact_center_button').html('Update Profile');
                    if (data == 'success') {
                        toastr["success"]('Profile updated successfully');
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
</script>
<script type="text/javascript">
    //single invitees
    $(document).on('submit',"#SingleInvitees_form",function(e){
        e.preventDefault();
        // $('#SingleInviteesbtn').attr('disabled',true);
        // $('#SingleInviteesbtn').html('Loading ...');
        var formData = new FormData($("#SingleInvitees_form")[0]);
        $.ajax({
            url:"{{ url('/') }}/contact_center/ajax/single_invitee",
            type:'POST',
            cache: "false",
            contentType: false,
            processData: false,
            data: formData,
            beforeSend:function(){
                $('#SingleInviteesbtn').attr('disabled',true);
                $('#SingleInviteesbtn').html('Loading...');
            },
            error:function(error){
                $('#SingleInviteesbtn').attr('disabled',false);
                $('#SingleInviteesbtn').html('Add Invitee');
                errors = $.parseJSON(error.responseText)
                if(typeof errors.response != 'undefined')
                {

                    toastr["error"](errors.response);
                    window.setTimeout(function() { $('.toast-close-button').click(); }, 10000)
                }else{
                    $.each(errors,function(key,val){
                        if(typeof val.name != 'undefined')
                        {
                            toastr["error"](val.name);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                        }
                        if(typeof val.phone != 'undefined')
                        {
                            toastr["error"](val.phone);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                        }
                        if(typeof val.email != 'undefined')
                        {
                            toastr["error"](val.email);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                        }
                        if(typeof val.message != 'undefined')
                        {
                            toastr["error"](val.message);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                        }
                        if(typeof val.subject != 'undefined')
                        {
                            toastr["error"](val.subject);
                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                        }
                    });
                }
            },
            success:function(data)
            {
                $('#SingleInviteesbtn').attr('disabled',false);
                $('#SingleInviteesbtn').html('Add Invitee');
                toastr["success"]('Invited successfully');
                window.setTimeout(function() { window.location.href = "{{ url('/invitees') }}" }, 1000)

            }
        })


    });


    $('#invite').validate({
        rules: {subject:{required:true}, message: { minlength: 6,maxlength:300,required: true },csv:{required:true}
        },
        errorClass : 'text-danger',
        errorPlacement: function(error, element) {
            if (element.attr("name") == "csv" )
            {

                error.insertAfter($(element).parents('.fileinput'));
            }
            else{

                error.insertAfter(element);
            }
        },
        submitHandler:function(form){
            $('#inviteesButton').attr('disabled',true);
            $('#inviteesButton').html('Loading ...');
            var formData = new FormData($("#invite")[0]);
            $.ajax({
                url:"{{ url('/') }}/contact_center/ajax/add_invitees",
                type:'post',
                cache: "false",
                contentType: false,
                processData: false,
                data: formData,
                error:function(error){
                    errors = $.parseJSON(error.responseText)
                    $('#inviteesButton').attr('disabled',false);
                    $('#inviteesButton').html('Invites');
                    if(typeof errors.response != 'undefined')
                    {

                        toastr["error"](errors.response);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 10000)
                    }
                },
                success:function(data)
                {

                    $('#inviteesButton').attr('disabled',false);
                    $('#inviteesButton').html('Invites');
                    toastr["success"]('Send successfully');
                    window.setTimeout(function() { location.reload() }, 100)
                },
            })


        }
    });


    //Send MN
    $('#send-push').validate({
        errorClass : 'text-danger',
        rules: { title: { minlength: 5,maxlength:50,required: true }, notification: { minlength: 5,maxlength:300,required: true },'groups[]' :{required : true,minlength:1} , priority:{required : true},
        },

        submitHandler:function(form){
            window.onbeforeunload = null;

            if(schedule_dropdown != 0)
            {

                    $('#send_push').modal('hide');
                    bootbox.confirm("You are about to schedule a Mass Notification. Are you sure?", function (result) {
                        if (result == true) {
                            toastr['success']('Scheduling...')
                            $('#notificationButton').attr('disabled',true);
                            $('#notificationButton').html('Loading ...');
                            if($('form#send-push input[type="file"]').val() == "")
                            {
                                 content_type = 'application/x-www-form-urlencoded; charset=UTF-8';
                                 proccess_data = true;
                                 formData = $("#send-push").serialize();
                            }else{
                                 content_type = false;
                                 proccess_data = false;
                                   formData = new FormData($("#send-push")[0]);
                            }
                            $.ajax({
                                url:"{{ url('/') }}/contact_center/ajax/notification",
                                type:'POST',
                                contentType: content_type,
                                processData: proccess_data,
                                data: formData,
                                headers: {
                                "cache-control": "no-cache"
                                },
                                error:function(error){
                                    $('#send_push').modal('show');
                                    $('#notificationButton').attr('disabled',false);
                                    $('#notificationButton').html('Send Notification');
                                    // errors = $.parseJSON(error.responseText)

                                    $.each(error,function(key,val){
                                        if(typeof val.date != 'undefined')
                                        {
                                            toastr["error"](val.date);

                                        }
                                        if(typeof val.time != 'undefined')
                                        {
                                            toastr["error"](val.time);
                                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                                        }
                                        if(typeof val.groups != 'undefined')
                                        {
                                            toastr["error"](val.groups);
                                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                                        }

                                    });

                                },
                                success:function(data)
                                {
                                    $('#notificationButton').attr('disabled',false);
                                    $('#notificationButton').html('Send Notification');
                                    toastr["success"]('Send successfully');
                                    window.setTimeout(function() { location.reload() }, 1000)
                                }
                            })
                        }else{
                            $('#send_push').modal('show');
                        }
                    })
                }else{

                   $('#send_push').modal('hide');



                    bootbox.confirm("You are about to send a Mass Notification. Are you sure?", function (result) {
                        if (result == true) {
                            // alert($('form#send-push input[type="file"]').val())
                            if($('form#send-push input[type="file"]').val() == "")
                            {
                               content_type = 'application/x-www-form-urlencoded; charset=UTF-8';
                                 proccess_data = true;
                                 formData = $("#send-push").serialize();
                            }else{
                                 content_type = false;
                                 proccess_data = false;
                                   formData = new FormData($("#send-push")[0]);
                            }
                            $('#notificationButton').attr('disabled',true);
                            $('#notificationButton').html('Loading ...');

                            toastr["success"]('Sending ....');
                            $.ajax({
                                url:"{{ url('/') }}/contact_center/ajax/notification",
                                type:'post',
                                contentType: content_type,
                                processData: proccess_data,
                                data: formData,
                                error:function(error){
                                    $('#send_push').modal('show');
                                    $('#notificationButton').attr('disabled',false);
                                    $('#notificationButton').html('Send Notification');
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
                                        if(typeof val.groups != 'undefined')
                                        {
                                            toastr["error"](val.groups);
                                            window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                                        }

                                    });


                                },
                                success:function(data)
                                {


                                    $('#notificationButton').attr('disabled',false);
                                    $('#notificationButton').html('Send Notification');
                                    toastr["success"]('Send successfully');
                                    // window.location.closed
                                    window.setTimeout(function() { window.location.reload(true) }, 100)
                                    return $("body").append(_self.openModelTemplate);
                                }
                            })
                        }else{
                            $('#send_push').modal('show');
                        }
                    });

                }
            }
    });

    $('#create-group').validate({
        errorClass : 'text-danger',
        rules: { title: { minlength: 5,maxlength:50,required: true }, 'group_users[]': { required: true}
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "group_users[]" )
            {
                $("#error_group_user").html(error);
            }
            else{
                error.insertAfter(element);
            }
        },

        submitHandler:function(form){
            $('#CreateGroup').modal('hide');
            $('#notificationButton').attr('disabled',true);
            $('#notificationButton').html('Loading ...');
            var formData = new FormData($("#create-group")[0]);
            toastr["success"]('Creating ....');
            $.ajax({
                url:"{{ url('/') }}/contact_center/ajax/create_group",
                type:'post',
                cache: "false",
                contentType: false,
                processData: false,
                data: formData,
                error:function(){

                },
                success:function(data)
                {
                    $('#notificationButton').attr('disabled',false);
                    $('#notificationButton').html('Create Group');
                    toastr["success"]('Created successfully');
                    window.setTimeout(function() { location.reload() }, 1000)
                }
            })
        }
    });


    $(document).on('submit','#edit-my-schedule',function(e){
        e.preventDefault();
        fd = new FormData($('#edit-my-schedule')[0]);
        $.ajax({
            type : "post",
            url : '{{ url('contact_center/ajax/edit_my_schedule') }}',
            contentType :false,
            processData : false,
            data : fd,
            success : function(data,status)
            {
                toastr['success']('schedule updated successfully')
                window.setTimeout(function(){ location.reload();},1000);

            }, error: function(errors) {
                $('#edit_profile_contact_center_button').attr('disabled', false);
                $('#edit_profile_contact_center_button').html('Update Schedule');
                error = $.parseJSON(errors.responseText);
                $.each(error,function(key,value){
                    if(typeof value.monday_start_time != 'undefined')
                    {
                        toastr['error'](value.monday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                    }
                    if(typeof value.monday_close_time != 'undefined')
                    {
                        toastr['error'](value.monday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)
                    }
                    if(typeof value.tuesday_start_time != 'undefined')
                    {
                        toastr['error'](value.tuesday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.tuesday_close_time != 'undefined')
                    {
                        toastr['error'](value.tuesday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }

                    if(typeof value.wednesday_start_time != 'undefined')
                    {
                        toastr['error'](value.wednesday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.wednesday_close_time != 'undefined')
                    {
                        toastr['error'](value.wednesday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }

                    if(typeof value.thursday_start_time != 'undefined')
                    {
                        toastr['error'](value.thursday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.thursday_close_time != 'undefined')
                    {
                        toastr['error'](value.thursday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.friday_start_time != 'undefined')
                    {
                        toastr['error'](value.friday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.friday_close_time != 'undefined')
                    {
                        toastr['error'](value.friday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }

                    if(typeof value.saturday_start_time != 'undefined')
                    {
                        toastr['error'](value.saturday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.saturday_close_time != 'undefined')
                    {
                        toastr['error'](value.saturday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }

                    if(typeof value.sunday_start_time != 'undefined')
                    {
                        toastr['error'](value.sunday_start_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }
                    if(typeof value.sunday_close_time != 'undefined')
                    {
                        toastr['error'](value.sunday_close_time);
                        window.setTimeout(function() { $('.toast-close-button').click(); }, 4000)

                    }

                })


            },
        })

    });



    $('#editProfileModal').on('shown.bs.modal', function() {

                @php if(session('contact_center_admin')): @endphp
        var id = '{{ session('contact_center_admin.0.id') }}';

        @php endif; @endphp
        $.ajax({
            type : 'GET',
            url : '{{ url('ajax/get_additional_fields') }}',
            data : 'id='+id,
            success : function(data,status){
                if(data.additional_fields != null)
                {
                    $('#edit-profile-contact-center .additional_field').empty();
                    $.each(data.additional_fields,function(k,v){
                        $('#edit-profile-contact-center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" value="'+v+'" placeholder="Add Some Additional" name="additional_fields[]"></div>');
                    })
                }else{
                    $('#edit-profile-contact-center .additional_field').empty();
                }
            },
        });
    });
    $(document).on('click','#add-contact-center #add_additional',function(e){
        $('#add-contact-center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })
    $(document).on('click','#editProfileModal  #add_additional',function(e){
        $('#editProfileModal  .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })
    $(document).on('click','#add_sub_contact_center  #add_additional',function(e){
        $('#add_sub_contact_center .additional_field').append('<div id="additional_field" class="form-group"><label class="form-label">Additional Field</label><input type="text" class="form-control btn-circle" placeholder="Add Some Additional" name="additional_fields[]"></div>')
    })

    $(document).on('hide.bs.modal','#videoModal', function () {
        <?php
if (Request::has('type') && Request::has('video_id')): ?>
            window.location.href = '{{ url('/dashboard') }}';
        <?php endif;?>
        $('#iframe').attr('src', '');
    })
    $(document).on('click','#create-schedule',function(e){
        fd = new FormData();
        fd.append('days',$("select[name='days']").val());
        $.ajax({
            type : 'post',
            contentType :false,
            processData : false,
            url : '{{ url('/contact_center/ajax/create_schedule') }}',
            data : fd,
            success : function(data,status){
                if(data != '')
                {
                    $('#modal-lg').addClass('modal-lg')
                    $('#form-column').removeClass('col-sm-12').addClass('col-sm-4')
                    $('#col-schedule').removeClass('col-sm-12').addClass('col-sm-8')

                }
                $('#days-data').html(data)
                $('#days-data .selectpicker').selectpicker('refresh')
            }
        })
    })

    /*$(document).on('hide.bs.modal','.modal',function(){
                $('#modal-lg').removeClass('modal-lg')
                $('#form-column').removeClass('col-sm-4').addClass('col-sm-12')
                $('#col-schedule').removeClass('col-sm-8').addClass('col-sm-12')
                $('#days-data').html('');

    })

    */
    function change_schedule_status(name,current)
    {
        value = $("#add_sub_contact_center select[name='"+name+"_status']").val();

        if(value == 'inactive')
        {

            $("#add_sub_contact_center select[name='"+name+"_start_time']").attr('disabled',true);
            $("#add_sub_contact_center select[name='"+name+"_close_time']").attr('disabled',true);
            $("#add_sub_contact_center select[name='"+name+"_start_time_am_pm']").attr('disabled',true);
            $("#add_sub_contact_center select[name='"+name+"_close_time_am_pm']").attr('disabled',true);
            $(".selectpicker").selectpicker('refresh');

        }else{

            $("#add_sub_contact_center select[name='"+name+"_start_time']").attr('disabled',false);
            $("#add_sub_contact_center select[name='"+name+"_close_time']").attr('disabled',false);
            $("#add_sub_contact_center select[name='"+name+"_start_time_am_pm']").attr('disabled',false);
            $("#add_sub_contact_center select[name='"+name+"_close_time_am_pm']").attr('disabled',false);
            $(".selectpicker").selectpicker('refresh');

        }


    }

</script>

<script type="text/javascript" src="{{ asset('/') }}/public/js/audio.js"></script>
<!-- for Edige/FF/Chrome/Opera/etc. getUserMedia support -->
<script src="{{ asset('/public/js/webrtc') }}/gumadapter.js"></script>

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
    var recordingDIV = document.querySelector('.recordrtcpush');
    var recordingMedia = recordingDIV.querySelector('.recording-media-push');
    var recordingPlayer = recordingDIV.querySelector('#audio-player-push');
    var mediaContainerFormat = recordingDIV.querySelector('.media-container-format-push');

    recordingDIV.querySelector('button').onclick = function() {
        var button = this;

        if(button.innerHTML === 'Stop Recording') {

            button.disabled = true;
            button.disableStateWaiting = true;
            setTimeout(function() {
                button.disabled = false;
                button.disableStateWaiting = false;
            }, 2 * 1000);
            $('#rec-push').hide();
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
                $('#notificationButton').attr('disabled',true);
                $('#editnotificationButton').attr('disabled',true);
                $('#rec-push').show();
                button.innerHTML = 'Stop Recording';
                button.disabled = false;
            },
            onMediaStopped: function() {
                button.innerHTML = 'Start Recording';
                $('#notificationButton').attr('disabled',false);
                $('#editnotificationButton').attr('disabled',false);
                $('#rec-push').hide();
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

    if(typeof webrtcDetectedBrowser != "undefined" && webrtcDetectedBrowser === 'edge') {
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
                var link = document.getElementById('audio-player-push');
                var audio_src = document.querySelector('#send-push > #audio_src');
                var audio_src_edit_push = document.querySelector('#edit-push > #audio_src');
                link.style.display = 'none'; //or
                link.style.visibility = 'hidden';
                if(typeof fileURL != 'undefined')
                {
                    $('#notificationButton').attr('disabled',false)
                    $('#editnotificationButton').attr('disabled',false)

                    var audiohear = document.getElementById('hear-audio');
                    var source = document.getElementById('hear-audio-src');
                    source.src =  fileURL
                    audiohear.load();
                    audiohear.play();
                    var editaudiohear = document.getElementById('edit-hear-audio');
                    var editaudiosource = document.getElementById('edit-hear-audio-src');
                    if(editaudiosource != null)
                    {

                        editaudiosource.src =  fileURL
                        editaudiohear.load();
                        editaudiohear.play();
                    $(editaudiohear).show()
                    }
                    $(".toast-close-button:first").click();
                    toastr['success']('Recorded Successfully');
                    $(audiohear).show()
                    window.setTimeout(function() {$('.toast-close-button').click()}, 1000);
                    audio_src.value = fileURL;

                    if(audio_src_edit_push != null){

                    audio_src_edit_push.value = fileURL;
                    }

                }else{

                    toastr['success']('Loading...')
                }
                $('#rec-push').hide();
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

    function exitFunc(){
        return true;
    }

    function editSchedule(){
        // alert('working')
        $('#edit_my_schedule').modal('show');
    }

    function mass_notification(type){
        if(type==1){
            $('#text_notification').prop('checked', true) ;
            $('#voice_notification').prop('checked', false);
            $('#file-push').show();
            $('.recordrtcpush').hide();

        }else{
            $('#voice_notification').prop('checked', true) ;
            $('#text_notification').prop('checked', false) ;
            $('#file-push').hide();
            $('.recordrtcpush').show();
        }

        $('#send_push').modal('show')
    }


</script>

<script>

    $('#add_tag').validate({
        rules: {
            tag: {required: true},

        },
        errorClass : 'text-danger',
        submitHandler: function(form) {

            $('#addTagButton').attr('disabled', true);
            $('#addTagButton').html('Loading ...');
            var formData = new FormData($("#add_tag")[0]);
            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/add_tag",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#addTagButton').attr('disabled', false);
                    $('#addTagButton').html('Add Tag');
                    if (data['msg']==='success') {
                        toastr["success"]('Tag added successfully');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data['msg']);
                    }
                }
            })
        }
    });

    $('#add_multiple_tag').validate({
        rules: {
            csv: {required: true},

        },
        errorClass : 'text-danger',
        submitHandler: function(form) {

            $('#addMultipleTagButton').attr('disabled', true);
            $('#addMultipleTagButton').html('Loading ...');
            var formData = new FormData($("#add_multiple_tag")[0]);
            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/add_multiple_tags",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#addMultipleTagButton').attr('disabled', false);
                    $('#addMultipleTagButton').html('Add Multiple Tags');
                    if (data['msg']==='success') {
                        toastr["success"]('Tag added successfully');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data['msg']);
                    }
                }
            })
        }
    });
    $('#edit_tag').validate({
        rules: {
            tag: {required: true},

        },
        errorClass : 'text-danger',
        submitHandler: function(form) {

            $('#editTagButton').attr('disabled', true);
            $('#editTagButton').html('Loading ...');
            var formData = new FormData($("#edit_tag")[0]);
            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/edit_tag",
                type: 'post',
                cache: "false",
                contentType: false,
                processData: false,
                data:formData,
                success: function(data) {
                    $('#editTagButton').attr('disabled', false);
                    $('#editTagButton').html('Edit Tag');
                    if (data['msg']==='success') {
                        toastr["success"]('Tag updated successfully');
                        window.setTimeout(function() {
                            location.reload();
                        }, 500)
                    } else {
                        toastr["error"](data['msg']);
                    }
                }
            })
        }
    });

    function getTemplate(current){
        template_id =  $(current).val();
        if(template_id !== ''){

        $.ajax({
            type : 'post',
            data : {'template_id':template_id},
            url : '{{ url('/contact_center/ajax/getTemplate') }}',
            success : function(data,status){
                $('#send-push input[name="title"]').val(data.response.title);
                $('#send-push textarea[name="notification"]').val(data.response.notification);
            }
        })
        }else{
            $('#send-push input[name="title"]').val('');
            $('#send-push textarea[name="notification"]').val('');
        }
    }

</script>

<script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
<!-- Bootstrap Core JavaScript -->
<script type="text/javascript">

    // Initialize Firebase
    var config = {
    // apiKey: "AIzaSyCBjADBb4XRMa207yYz5iWqNIbZ3NzEods",
    // authDomain: "ifollow-cc-3f29a.firebaseapp.com",
    // databaseURL: "https://ifollow-cc-3f29a.firebaseio.com",
    // projectId: "ifollow-cc-3f29a",
    // storageBucket: "ifollow-cc-3f29a.appspot.com",
    // messagingSenderId: "897644458314"

    apiKey: "AIzaSyCBq7Eyh6Bzfpfn28m1xi3d5CjQaH_syoc",
    authDomain: "ifollow-realtorsafewalk.firebaseapp.com",
    databaseURL: "https://ifollow-realtorsafewalk.firebaseio.com",
    projectId: "ifollow-realtorsafewalk",
    storageBucket: "ifollow-realtorsafewalk.appspot.com",
    messagingSenderId: "479657899808",
    appId: "1:479657899808:web:0e83598e122d368fbe8945",
    measurementId: "G-D8FMBG2F9V"
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
$(document).on('shown.bs.modal', function() {
    $(document).off('focusin.modal');
});
    var VideoRef = firebase.database().ref('AdminChat/{{ $organization_id }}');
    window.messages = VideoRef.child('messages').orderByChild('timestamp');
    const messages  = window.messages
    var UserTimestamp = VideoRef.child('admins');
messages.on("child_added", function(snapshot) {
            var time = new Date(snapshot.val().timestamp).toLocaleTimeString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}'});
            var date = new Date(snapshot.val().timestamp).toLocaleDateString('en-US',{timeZone:'{{session('contact_center_admin.0.time_zone.timezone_code')}}',month:'long',day:'2-digit',year :"numeric"});
            var name = snapshot.val().name;
            var message = snapshot.val().message
        if( snapshot.val().adminId == {{$admin_id}}) {

               var html='<div class="right-single-chat"><span class="name-span">'+name+'</span><span class="admin-speech-bubble-right msg">'+message +'</span><span class="time-span"> &nbsp;'+time+' '+date+'</span></div>';
        }
        else{

               var html ='<div class="left-single-chat"><span class="name-span">'+name+'</span><p class="admin-speech-bubble msg">'+message+'</p><span class="time-span"> &nbsp;'+time+' '+date+'</span></div>';
        }
        $('.admin-chating').append(html);
        $('.admin-panel-body').animate({scrollTop : $('.admin-panel-body')[0].scrollHeight},10);
        if ($('.is-chat-close').val() == 'open') {
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
</script>

<script type="text/javascript">
    $(document).ready(function(){
         $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    })
var input = $('input.message');
 const VideoRefMsg= firebase.database().ref('AdminChat/{{ $organization_id }}/messages');
     var admin = firebase.database().ref('AdminChat/{{ $organization_id }}/admins/{{ $admin_id }}');
    $(document).on('click','#send-chat-link', function(e) {
            input = $('#admin-btn-input')
        if (input.val().length > 0) {
            var getTxt = input.val();
            VideoRefMsg.push ({
                message: getTxt,
                name : '{{$admin_name}}',
                adminId : '{{$admin_id}}',
                timestamp:firebase.database.ServerValue.TIMESTAMP
            });
             admin.update({
      "timestamp": firebase.database.ServerValue.TIMESTAMP
    });
            $('.admin-panel-body').scrollTop( $('.admin-panel-body')[0].scrollHeight,100);

            input.val('');
        }
    });
    $(document).on('click','.chat-box-close', function(e) {
        $('.is-chat-close').val('close')
        $(this).hide();
        admin.update({
      "timestamp": firebase.database.ServerValue.TIMESTAMP
    });
        $('.chat-box').slideToggle();
        $('.admin-panel-body').animate({scrollTop : $('.admin-panel-body')[0].scrollHeight},100);
    });
       /* $(document).on('click','.chat-box', function(e) {
            $('#admin-btn-input').focus();

    });*/
    $(document).on('click','.chat-box .chat-head', function(e) {
        $('.is-chat-close').val('open')
        $('#chat-badge').html('');
        $('#chat-badge').hide();
        $('.chat-box').hide();
        $('.chat-box-close').show();
    });

</script>