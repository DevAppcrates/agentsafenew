@extends('contact_center.layout.default')
@section('title')
    {{ config('app.name') }} | Tags
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
                            <small>Tag list</small>
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
                                            <span class="caption-subject"> Tag list</span>
                                            {{-- <span class="caption-helper"></span> --}}
                                        </div>

                                        <div class="actions">
                                            <a class="btn btn-circle btn-icon-only red fullscreen" href="javascript:;"><i class="icon-size-fullscreen"></i> </a>
                                        </div>

                                    </div>

                                        <div class="portlet-body">
                                            <!-- <div class="scroller"
                                                 data-rail-visible="1"
                                                 data-rail-color="yellow"
                                                 data-handle-color="#a1b2bd"> -->

                                            <div class="table-responsive">
                                                <table id="example2" class="table table-striped table-bordered table-hover">
                                                        @php $i = 1; @endphp
                                                            <thead>
                                                                <tr>
                                                    <th style="display: none">#</th>
                                                    <th>Tag</th>
                                                    <th>No of members</th>
                                                    <th>Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tfoot>
                                                                <tr>
                                                    <th style="display: none">#</th>
                                                    <th>Tag</th>
                                                    <th>No of members</th>
                                                    <th>Action</th>
                                                                </tr>
                                                            </tfoot>
                                                            <tbody>
                                                                @php $i =1;  @endphp
                                                                    @foreach($tags as $tag)
                                                                        <tr>
                                                                            <td style="display: none">{{$i}}</td>
                                                                            <td >{{$tag->tag_name}}</td>
                                                                            <td >{{$tag->tag_members_count}}</td>
                                                                            <td >
                                                                            <div class="btn-group">

                                                                                    <button class="btn dropdown-toggle"
                                                                                            type="button"
                                                                                            style="width: 90px; height: 16px; margin-top: -1px;"
                                                                                            data-toggle="dropdown"
                                                                                            aria-haspopup="true"
                                                                                            aria-expanded="false">
                                                                                        Actions
                                                                                    </button>
                                                                                <div class="dropdown-menu">
                                                                                    <a  class="dropdown-item"
                                                                                        onclick="assign_tag('{{$tag->tag_id}}')">
                                                                                        <i class="fa fa-pencil"></i>
                                                                                        Assign tag to users
                                                                                    </a>
                                                                                    <a  class="dropdown-item"
                                                                                        onclick="edit_tag('{{$tag->tag_id}}','{{$tag->tag_name}}')">
                                                                                            <i class="fa fa-pencil"></i> Edit Tag
                                                                                    </a>

                                                                                </div>
                                                                            </div>
                                                                            </td>
                                                                        </tr>
                                                                        @php $i++; @endphp
                                                                    @endforeach
                                                            </tbody>

                                                </table>
                                            </div>
                    <!-- END CONTENT BODY -->
                                            {{-- </div> --}}
                                        </div>
                                </div>
                            </div>
                        </div>
                <!-- END CONTENT -->
            </div>
        </div>

        <div class="modal fade" id="editTag" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <!--Content-->
            <div class="modal-content" style="margin-top: 70px">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">Edit Tag</h4>
                </div>
                <!--Body-->
                    <form id="edit_tag" novalidate="novalidate">
                        <div class="modal-body">
                                <label class="form-label">Tag <span class="form-asterick">&#42;</span></label>
                                <input class="form-control btn-circle" type="text" autocomplete="off" id="edit_tag_name" name="tag" placeholder="Tag"><br/>
                                <input class="form-control btn-circle" type="hidden" autocomplete="off" name="tag_id" id="tag_id" placeholder="tag_id"><br/>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary waves-effect" id="editTagButton">Edit Tag</button>
                        </div>
                    </form>
                <!--/.Content-->
            </div>
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
     .dataTables_wrapper .dataTables_paginate .paginate_button {
  padding: 0 !important;
margin: 2px;
    }
@media screen and (max-width: 768px){
    .table-scrollable .dataTable td>.btn-group, .table-scrollable .dataTable th>.btn-group {
    position: relative !important;
}
    .table div.dropdown-menu {
    position: relative;

}
</style>

@stop

@section('scripts')
<script type="text/javascript">

$(document).ready(function(){
    /* $.fn.dataTable.ext.errMode = 'none';
    const table = $('#example1').DataTable();
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



<script>
        /*var oTable = $('#example1').dataTable(
            {
                "sScrollY":  "100%",
                "bPaginate": true,
                "bJQueryUI": true,
                "bScrollCollapse": false,
                "bLengthChange": true,
                "bAutoWidth": false,
                "sScrollX": "100%",

            });*/

        $(document).ready(function() {
           $('#example2').DataTable({
                "aaSorting": [[ 0, "desc" ]],
                "sPaginationType": "full_numbers",
                "DisplayLength" : 20,
                'paging'      : true,
                'searching'   : true,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false,
                "autoWidth": true,
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],
                "language": {
                            "sLengthMenu": "_MENU_ Records",
                            "search": "Search  ",
                        }

            })
        });

        function edit_tag(id,name) {
            $('#tag_id').val(id);
            $('#edit_tag_name').val(name);
            $('#editTag').modal('show');
        }

        function assign_tag(id) {

            $.ajax({
                url: "{{url('/')}}/contact_center/ajax/tag_members/"+id,
                type: 'get',
                error: function() {
                    setTimeout(function () {
                        $('.loader').hide();
                    },500);
                },
                success: function(data) {
                    $('#tag_html').html(data);
                    $('#assignTag').modal('show');
                }
            })
        }

    </script>
@stop