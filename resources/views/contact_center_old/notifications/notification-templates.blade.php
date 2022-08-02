@extends('contact_center.layout.default')
@section('content')
@include('contact_center.header')
<main class="">
    <div class="container-fluid" style="height: 500px" >
        <div class="row">
            <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
                <div class="portlet box blue">
                    <div class="portlet-title d-inline-block">
                        <div class="caption">

                            <i class="fa fa-bell-o"></i> Notification Templates</div>
                    </div>
                            <button data-toggle='modal' data-target='#add-template' class="btn pull-right waves-effect waves-light"><i class="fa fa-plus"></i> Add</button>
                    <div class="portlet-body">
                        <table cellspacing="10" style="width: 100% !important;" class="table table-striped table-hover responsive table-condensed"  id="table">
                            <thead>
                            <tr>
                                <th>Title</th>
                                <th>Notification</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($templates as $record)
                                    <tr>
                                        <td>{{ $record->title }}</td>
                                        <td>{{ $record->notification }}</td>
                                        <td><button onclick="editTemplate('{{ $record->id }}','{{ $record->title }}','{{ $record->notification }}')" class="btn btn-info"><i class="fa fa-pencil"></i>Edit</button><button onclick="deleteTemplate(this,'{{ $record->id }}')" class="btn btn-info"><i class="fa fa-trash"></i>Delete</button></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <br/><br/>
            </div>
            <br/><br/><br/><br/>
        </div>
    </div>
</main>
@include('footer')
<script type="text/javascript">
        $(document).ready(function(){

    const table = $("#table").dataTable({
       "aaSorting": [],
        "sPaginationType": "full_numbers",
        "iDisplayLength" : 20
    });
    $('#add-template-form').validate({
        errorClass : 'text-danger',
        rules: { title: { minlength: 5,maxlength:50,required: true },
                     notification: { minlength: 5,maxlength:300,required: true }
            },
        submitHandler:function(form){
                        var fd = new FormData($('#add-template-form')[0]);
                        $('#add-template-btn').attr('disabled','disabled');
                        $('#add-template-btn').html('Loading...');
                        $.ajax({
                            type : 'post',
                            url : '{{ url('contact_center/ajax/add-template') }}',
                            processData : false,
                            contentType : false,
                            data : fd,
                            success : function(data,status){
                                if(data == 'Created successfully'){
                                    toastr['success'](data);
                                    $('#add-template-btn').removeAttr('disabled');
                                    $('#add-template-btn').html('Save');
                                    setTimeout(function(){
                                        window.location.reload();
                                    },1000)
                                }
                            },
                            error : function(error){
                                $('#add-template-btn').removeAttr('disabled');
                                $('#add-template-btn').html('Save');
                            }
                        });
        }
    });
    $('#edit-template-form').validate({
        errorClass : 'text-danger',
        rules: { title: { minlength: 5,maxlength:50,required: true },
                     notification: { minlength: 5,maxlength:300,required: true }
            },
        submitHandler:function(form){
                        var fd = new FormData($('#edit-template-form')[0]);
                        $('#edit-template-btn').attr('disabled','disabled');
                        $('#edit-template-btn').html('Loading...');
                        $.ajax({
                            type : 'post',
                            url : '{{ url('contact_center/ajax/edit-template') }}',
                            processData : false,
                            contentType : false,
                            data : fd,
                            success : function(data,status){
                                if(data == 'Updated successfully'){
                                    toastr['success'](data);
                                    $('#edit-template-btn').removeAttr('disabled');
                                    $('#edit-template-btn').html('Update');
                                    setTimeout(function(){
                                        window.location.reload();
                                    },1000)
                                }
                            },
                            error : function(error){
                                $('#edit-template-btn').removeAttr('disabled');
                                $('#edit-template-btn').html('Update');
                            }
                        });
        }
    });
        })

    function editTemplate(id,title,notification){
        $('#edit-template #template_id').val(id);
        $('#edit-template input[name="title"]').val(title);
        $('#edit-template textarea[name="notification"]').val(notification);
        $('#edit-template').modal('show')
    }

    function deleteTemplate(current,id){


        $.ajax({
                            type : 'post',
                            url : '{{ url('contact_center/ajax/delete-template') }}',
                            data : {'id' : id},
                            success : function(data,status){
                                if(data == 'Deleted successfully'){
                                    toastr['success'](data);
                                    table =  $("#table").DataTable();
                                    table.row($(current).parents('tr')).remove().draw();
                                    // setTimeout(function(){

                                    // },1000)
                                }
                            },
                            error : function(error){

                            }});
    }

</script>
@stop