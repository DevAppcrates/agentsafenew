@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} | Notification Template
@stop
@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
@stop
@section('page-content')

<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">

                        <!-- BEGIN PAGE TITLE-->
                       {{--  <h1 class="page-title"> {{ session('contact_center_admin.0.name') }}
                            <small>Notification Template</small>
                        </h1> --}}
                        <!-- END PAGE TITLE-->

                        <div class="page-bar">
                        </div>


                         <div class="row" style="margin-top: 3%">
                            <div class="col-md-12">
                                <div class="portlet light bg-inverse">
                                    <div class="portlet-title">
                                        <div class="caption font-green-sharp">
                                            <i class="icon-speech font-green-sharp"></i>
                                            <span class="caption-subject"> Notification Template</span>
                                            {{-- <span class="caption-helper"></span> --}}

                                        </div>


                                        <div class="actions">
                                            <button data-toggle='modal' data-target='#add-template' class="btn green waves-effect addClass"><i class="fa fa-plus"></i> Create Template</button>
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>

                                    </div>

                                        <div class="portlet-body">
                                            <div class="scroller"
                                                 data-rail-visible="1"
                                                 data-rail-color="yellow"
                                                 data-handle-color="#a1b2bd">

                                            <div class="table-responsive">




                                                <table id="table"
                                                        class="table table-striped table-bordered table-hover"
                                                        data-show-header="true" data-pagination="true"
                                                        data-id-field="name"
                                                        data-page-list="[5, 10, 25, 50, 100, ALL]"
                                                        data-page-size="5"
                                                        >
                                                        @php $i = 1; @endphp
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
                                                                        <td id="actionBtn"><button onclick="editTemplate('{{ $record->id }}','{{ $record->title }}','{{ $record->notification }}')" class="btn btn-info"><i class="fa fa-pencil"></i>&nbsp; Edit</button><button onclick="deleteTemplate(this,'{{ $record->id }}')" class="btn btn-info"><i class="fa fa-trash"></i>&nbsp; Delete</button></td>
                                                                    </tr>
                                                                @endforeach
                                                            </tbody>

                                                </table>
                                            </div>
                    <!-- END CONTENT BODY -->
                                            </div>
                                        </div>
                                </div>
                            </div>
                        </div>
                <!-- END CONTENT -->
            </div>
        </div>

<style>


     #spantags > span.badge.badge-pill.light-blue {
        margin-top: 3px !important;
        width: 100px !important;
        height: 13px !important;
    }

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
        margin: 0;
    }

    ul.pagination li a.active {
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    ul.pagination li.active {
        /*background-color: #4CAF50;*/
        background-color: #047dc4;
        /*padding: 10px 15px;*/
        /*margin: 4px;*/
        color: white;
        border: 1px solid #047dc4;
    }

    /*ul.pagination li a:hover:not(.active) {background-color: #ddd;}*/
    ul.pagination li a:hover {background-color: #999999;}
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 0;
}
 #example2_paginate > ul > li.paginate_button.active:hover {
    background: transparent !important;
    border: none !important;
}
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

    #example2 .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 0 !important;
      margin: 2px;
    }
    .table button.btn {
        width: 100px;
    }

</style>
@stop

@section('scripts')
<script >


    $(document).ready(function(){
        const table = $('#table').DataTable({
           "aaSorting": [[ 0, "desc" ]],
                "sPaginationType": "full_numbers",
                "DisplayLength" : 20,
                'paging'      : true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                 "language": {
                                "search": "Search Templates: ",
                                "sLengthMenu": "_MENU_ Records"
                            }

        })
    });
    $('#add-template-form').validate({
        errorClass : 'text-danger',
        rules: {
            title: {
                        minlength: 5,maxlength:50,required: true
                   },
            notification:
                    {
                        minlength: 5,maxlength:300,required: true
                    }
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
                                    // $('#add-template-btn').removeAttr('disabled');
                                    // $('#add-template-btn').html('Save');
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

    function editTemplate(id,title,notification){
        $('#edit-template #template_id').val(id);
        $('#edit-template input[name="title"]').val(title);
        $('#edit-template textarea[name="notification"]').val(notification);
        $('#edit-template').modal('show')
    }

    function deleteTemplate(current,id){
        bootbox.confirm("Are you sure you want to delete the templete?", function (result) {
            if (result == true) {
               $.ajax({
                        type : 'post',
                        url : '{{ url('contact_center/ajax/delete-template') }}',
                        data : {'id' : id},
                            success : function(data,status){
                                if(data == 'Deleted successfully'){
                                    toastr['success'](data);
                                    table =  $("#table").DataTable();
                                    table.row($(current).parents('tr')).remove().draw();
                                    setTimeout(function(){
                                        window.location.reload();
                                    },1000)
                                }
                            },
                            error : function(error){

                            }
                    });
            }
            else {

            }
        });
    }

</script>
<!-- BEGIN PAGE LEVEL PLUGINS -->
        <script src="{{url('public')}}/assets/global/scripts/datatable.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/datatables.min.js" type="text/javascript"></script>
        <script src="{{url('public')}}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL PLUGINS -->
        <!-- BEGIN PAGE LEVEL SCRIPTS -->
        <script src="{{url('public')}}/assets/pages/scripts/table-datatables-responsive.min.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL SCRIPTS -->

@stop

<style>
    .btn-info{
        margin-left: 5px !important;
    }
    .addClass{
        /*float: right;*/
        width: 138px;
        height: 38px;
        background-color: #265e85 !important;
        /*fill: #265e85;*/
    }


</style>