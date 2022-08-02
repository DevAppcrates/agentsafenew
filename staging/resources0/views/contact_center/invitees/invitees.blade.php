@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} | Non App Users
@stop
@section('css')
    <!-- BEGIN PAGE LEVEL PLUGINS -->
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/datatables.min.css" rel="stylesheet" type="text/css" />
        <link href="{{ url('/public') }}/assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css" rel="stylesheet" type="text/css" />
        <!-- END PAGE LEVEL PLUGINS -->
@stop
@section('page-content')
<style type="text/css">
    .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 !important;
    }
</style>
<!-- BEGIN CONTENT -->
                <div class="page-content-wrapper">
                    <!-- BEGIN CONTENT BODY -->
                    <div class="page-content">

                        <!-- BEGIN PAGE TITLE-->
                        {{-- <h1 class="page-title"> {{ session('contact_center_admin.0.name') }}
                            <small>Guest Users</small>
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
                                            <span class="caption-subject"> Non App Users</span>
                                            {{-- <span class="caption-helper"></span> --}}
                                        </div>
                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>
                                    </div>
                                    <div class="portlet-body">
                                        <div class="scroller" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
                                            <div class="table-responsive">
                                            <table id="example2" class="table table-striped table-bordered table-hover dt-responsive">
                                                <thead>
                                                    @php $i = 1; @endphp

                                                    <tr>
                                                        <th style="display: none">#</th>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Phone</th>
                                                        <th>Tag</th>
                                                        <th>Created At</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>


                                                    @foreach($invitees as $invitee)
                                                        <tr>
                                                            <td style="display: none">{{$i}}</td>
                                                            <td >{{$invitee->name}}</td>
                                                            <td >{{$invitee->email}}</td>
                                                            <td >{{$invitee->phone}}</td>
                                                            <td style="min-width: 150px">
                                                                @if($invitee->user_tags->count()>0)
                                                                    @foreach($invitee->user_tags as $tag)
                                                                        <span class="badge badge-pill light-blue">{{$tag->tag->tag_name}}</span>
                                                                    @endforeach
                                                                @endif

                                                            </td>
                                                            <td >{{$invitee->created_at}}</td>
                                                            <td >
                                                                <a class="light-blue-text p-r-1" onclick="user_tags('{{$invitee->id}}')"><i class="fa fa-tags"></i> Add/Edit Tags</a>

                                                                <a class="red-text" onclick="deleteInvitee('{{$invitee->id}}')"><i class="fa fa-times"></i> Delete</a>
                                                            </td>
                                                        </tr>
                                                        @php $i++; @endphp
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>


                    </div>
                    <!-- END CONTENT BODY -->
                </div>
                <!-- END CONTENT -->

    <script>
        // $("#users").dataTable({
        //     "aaSorting": [[ 0, "desc" ]],
        //     "sPaginationType": "full_numbers",
        //     "iDisplayLength" : 20
        // });
        // $('#users_filter input').addClass('form-control');
        //Delete practice tip

        function deleteInvitee(id)
        {
            bootbox.confirm("Are you sure you want to delete this invitee?", function (result) {
                if (result == true) {
                    $.get("{{url('/')}}/contact_center/ajax/delete_invitee/"+id, function (result) {

                        toastr["success"]('Changes confirmed');
                        window.setTimeout(function() { location.reload() }, 100);

                    });
                }
                else {

                }
            });
        }

        function user_tags(id) {

            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/user_tags/"+id+"/2",
                type: 'get',
                error: function() {
                    setTimeout(function () {
                        $('.loader').hide();
                    },500);
                },
                success: function(data) {
                    $('#user_tags').html(data);
                    $('#userTags').modal('show');
                }
            })
        }


    </script>

@stop

@section('scripts')
<script type="text/javascript">

     $(function () {
       $('#example2').DataTable({
           "aaSorting": [],
           "sPaginationType": "full_numbers",
           "DisplayLength" : 20,
           'paging'      : true,
           'searching'   : true,
           'ordering'    : true,
           'info'        : true,
           'autoWidth'   : false,
            "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
            "language": {
                            "sLengthMenu": "_MENU_ Records",
                            "search": "Search  ",
                        }

       })
       })
</script>
<script type="text/javascript">

$(document).ready(function(){
     /*$.fn.dataTable.ext.errMode = 'none';
    const table = $('#example2').DataTable();
    table.buttons('.buttonsToHide').nodes().css("display", "none");*/
})
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