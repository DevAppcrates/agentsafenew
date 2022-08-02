
<!-- Material select -->

$(document).ready(function() {
    $('.mdb-select').material_select();
    });
<!-- JS Functions -->


// Edit Cooperative
function editCooperative(id)
{

    $.ajax({
        url:"<?php echo url('/')?>/editCooperativeModal",
        type:'post',
        data:{id:id},
        error:function(){
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {
            var obj = jQuery.parseJSON( data );
            var cooperative_id=obj.first;
            var cooperative_name=obj.second;
            $('#cooperativeEditModal').modal('show');
            $("#edit_cooperative_name").val(cooperative_name);
            $("#edit_cooperative_id").val(cooperative_id);
        }
    });

    }

//Edit Wet-Mill
function editWet_Mill(id)
{
    $.ajax({
        url:"<?php echo url('/')?>/editWet_MillModal",
        type:'post',
        data:{id:id},
        error:function(){

            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {
            var obj = jQuery.parseJSON( data );
            var wet_mill_id=obj.first;
            var wet_mill_name=obj.second;

            $('#edit-wetMill').html(data);
            $('#wet_millEditModal').modal('show');
            $("#edit_wet_mill_id").val(wet_mill_id);
            $("#edit_wet_mill_name").val(wet_mill_name);

        }
    });
    }

//Edit Operator
function editOperator(id)
{

    $.ajax({
        url:"<?php echo url('/')?>/editOperatorModal",
        type:'post',
        data:{id:id},
        error:function(){
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {

            var obj = jQuery.parseJSON( data );
            var operator_name=obj.first;
            var operator_pass=obj.second;
            var operator_id=obj.third;

            $("#operator_name_edit").val(operator_name);
            $("#operator_pass_edit").val(operator_pass);
            $("#operator_id_edit").val(operator_id);
            $('#operatorEditModal').modal('show');
        }
    });
    }

//Delete Operator
function deleteOperator(id)
{
bootbox.confirm("Are you sure you want to delete this Operator?", function (result) {
    if (result == true) {
        $.get("<?php echo url('/') ?>/deleteOperator/"+id, function (result) {

            toastr["success"](result);
            url='<?php echo url('/')?>/operators';
            window.setTimeout(function() { window.location.href = url }, 1000)

        });
    }
    else {

    }
});
}

//Delete Wet_mill
function deleteWet_Mill(id)
{
    bootbox.confirm("Are you sure you want to delete this Wet-Mill?", function (result) {
        if (result == true) {
            $.get("<?php echo url('/') ?>/deleteWetMill/"+id, function (result) {

                toastr["success"](result);
                url='<?php echo url('/')?>/wet_mills';
                window.setTimeout(function() { window.location.href = url }, 1000)

            });
        }
        else {

        }
    });
    }

//Edit Farmer
function editFarmer(id)
{
    $.ajax({
        url:"<?php echo url('/')?>/editFarmerModal",
        type:'post',
        data:{id:id},
        error:function(){
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {

            var obj = jQuery.parseJSON( data );
            var farmer_name=obj.first;
            var farmer_trees=obj.second;
            var farmer_id=obj.third;

            $("#farmer_name_edit").val(farmer_name);
            $("#farmer_trees_edit").val(farmer_trees);
            $("#farmer_id_edit").val(farmer_id);
            $('#farmerEditModal').modal('show');
        }
    });
    }

//Delete Faq
function deleteFaq(id)
{
    bootbox.confirm("Are you sure you want to remove this FAQ?", function (result) {
        if (result == true) {
            $.get("<?php echo url('/') ?>/deleteOperator/"+id, function (result) {

                toastr["success"](result);
                url='<?php echo url('/')?>/operators';
                window.setTimeout(function() { window.location.href = url }, 1000)

            });
        }
        else {

        }
    });
}

//Logout
function adminLogout()
{
    $.ajax({
        url:"<?php echo url('/')?>/ajax/logout",
        type:'post',
        error:function(){
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)

        }
    });
}

function adminCCLogout()
{
    $.ajax({
        url:"<?php echo url('/')?>/contact_center/ajax/logout",
        type:'post',
        error:function(){
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)
        },
        success:function(data)
        {
            url='<?php echo url('/')?>';
            window.setTimeout(function() { window.location.href = url }, 100)

        }
    });
}


<!-- Validations -->


$(document).ready(function(){

//Login
    $('#form').validate({
        rules: { password: { minlength: 5,required: true }, email: {required: true}
        },

        submitHandler:function(form){

            $('#logInButton').attr('disabled',true);
            $('#logInButton').html('Loading ...');
            $.ajax({
                url:"<?php echo url('/')?>/admin/login",
                type:'post',
                data: $("#form").serialize(),
                error:function(){
                    url='<?php echo url('/')?>';
                    window.setTimeout(function() { window.location.href = url }, 100)
                },
                success:function(data)
                {
                    $('#logInButton').attr('disabled',false);
                    $('#logInButton').html('Log In');
                    if(data=='Login Successfully')
                    {
                        toastr["success"](data);
                        url='<?php echo url('/')?>/dashboard';
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

//Add Farmer
    $('#add-farmers').validate({
    rules: {  file: {required: true} },

    submitHandler:function(form){
    $('#addFarmerButton').attr('disabled',true);
    $('#addFarmerButton').html('Loading ...');
    var formData = new FormData($("#add-farmers")[0]);
    $.ajax({
    url:"<?php echo url('/')?>/importFarmers",
    type:'post',
    data: formData,
    error:function(){
    $('#addFarmerButton').attr('disabled',false);
    $('#addFarmerButton').html('Add Farmer');
    toastr["error"]('Invalid File');
    },
    success:function(data)
    {

    $('#addFarmerButton').attr('disabled',false);
    $('#addFarmerButton').html('Add Farmer');
    if(data=='Save Successfully')
    {
    window.setTimeout(function() {$("#farmersModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/farmers';
    window.setTimeout(function() { window.location.href = url }, 1000)
    }
    else
    {
    toastr["error"](data);
    }
    },
    contentType: false,
    processData: false,
    cache:false
    })
    }
    });

//Add Cooperative
    $('#add-cooperative').validate({
    rules: {  cooperative_name: {required: true}  },

    submitHandler:function(form){
    $('#addCooperativeButton').attr('disabled',true);
    $('#addCooperativeButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/addCooperative",
    type:'post',
    data: $("#add-cooperative").serialize(),
    error:function(){
    url='<?php echo url('/')?>';
    window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#addCooperativeButton').attr('disabled',false);
    $('#addCooperativeButton').html('Add Cooperative');
    if(data=='Save Successfully')
    {
    window.setTimeout(function() {$("#cooperativeModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/cooperatives';
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

//Edit Cooperative
    $('#edit-cooperative').validate({
    rules: {  cooperative_name: {required: true}  },

    submitHandler:function(form){
    $('#editCooperativeButton').attr('disabled',true);
    $('#editCooperativeButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/editCooperative",
    type:'post',
    data: $("#edit-cooperative").serialize(),
    error:function(){
    url='<?php echo url('/')?>';
    window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#editCooperativeButton').attr('disabled',false);
    $('#editCooperativeButton').html('Edit Cooperative');
    if(data=='Edit Successfully')
    {
    window.setTimeout(function() {$("#cooperativeEditModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/cooperatives';
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

//Add Wet-Mill
    $('#add-wet_mill').validate({
    rules: {  wet_mill_name: {required: true}  },

    submitHandler:function(form){
    $('#addWetMillButton').attr('disabled',true);
    $('#addWetMillButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/addWetMill",
    type:'post',
    data: $("#add-wet_mill").serialize(),
    error:function(){

    url='<?php echo url('/')?>';
// window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#addWetMillButton').attr('disabled',false);
    $('#addWetMillButton').html('Add Cooperative');
    if(data=='Save Successfully')
    {
    window.setTimeout(function() {$("#wet_millModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/wet_mills';
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

//Edit Wet-Mill
    $('#edit-wet_mill').validate({
    rules: {  wet_mill_name: {required: true}  },

    submitHandler:function(form){
    $('#editWetMillButton').attr('disabled',true);
    $('#editWetMillButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/editWetMill",
    type:'post',
    data: $("#edit-wet_mill").serialize(),
    error:function(){

    url='<?php echo url('/')?>';
// window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#editWetMillButton').attr('disabled',false);
    $('#editWetMillButton').html('Edit Cooperative');
    if(data=='Edit Successfully')
    {
    window.setTimeout(function() {$("#wet_millEditModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/wet_mills';
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

//Add Operator
    $('#add-operator').validate({
    rules: {  username: {required: true},password: {required: true}, wet_mill_operator: {required: true} },

    submitHandler:function(form){
    $('#addOperatorButton').attr('disabled',true);
    $('#addOperatorButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/addOperator",
    type:'post',
    data: $("#add-operator").serialize(),
    error:function(){

    url='<?php echo url('/')?>';
// window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#addOperatorButton').attr('disabled',false);
    $('#addOperatorButton').html('Add Operator');
    if(data=='Save Successfully')
    {
    window.setTimeout(function() {$("#operatorModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/operators';
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

//Edit Operator
    $('#edit-operator').validate({
    rules: {  username: {required: true},password: {required: true}},

    submitHandler:function(form){
    $('#editOperatorButton').attr('disabled',true);
    $('#editOperatorButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/editOperator",
    type:'post',
    data: $("#edit-operator").serialize(),
    error:function(){

    url='<?php echo url('/')?>';
// window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#editOperatorButton').attr('disabled',false);
    $('#editOperatorButton').html('Edit Operator');
    if(data=='Edit Successfully')
    {
    window.setTimeout(function() {$("#operatorEditModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/operators';
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

//edit Farmer
    $('#edit-farmer').validate({
    rules: {  farmer_name: {required: true},no_of_trees: {required: true}},

    submitHandler:function(form){
    $('#editFarmerButton').attr('disabled',true);
    $('#editFarmerButton').html('Loading ...');
    $.ajax({
    url:"<?php echo url('/')?>/editFarmer",
    type:'post',
    data: $("#edit-farmer").serialize(),
    error:function(){

    url='<?php echo url('/')?>';
// window.setTimeout(function() { window.location.href = url }, 100)
    },
    success:function(data)
    {
    $('#editFarmerButton').attr('disabled',false);
    $('#editFarmerButton').html('Edit farmer');
    if(data=='Edit Successfully')
    {
    window.setTimeout(function() {$("#farmerEditModal").modal('hide'); }, 2000);
    toastr["success"](data);
    url='<?php echo url('/')?>/farmers';
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

    });


