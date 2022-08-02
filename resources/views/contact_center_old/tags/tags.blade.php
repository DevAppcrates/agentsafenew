@extends('contact_center.layout.default')
@section('content')
    @include('contact_center.header')
    <!--Main layout-->

    <main class="">
        <div class="container-fluid" style="height: 500px" >
            <div class="row">
                <div class="col-xs-12 col-md-12 col-sm-12">
                    <br>
                    <br>
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-tags"></i>Tags</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover table-header-fixed responsive table-success" id="example2">
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

                                                <button class="btn
                                                              dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" onclick="assign_tag('{{$tag->tag_id}}')"><i class="fa fa-pencil"></i> Assign tag to users</a>
                                                    <a class="dropdown-item" onclick="edit_tag('{{$tag->tag_id}}','{{$tag->tag_name}}')"><i class="fa fa-pencil"></i> Edit Tag</a>

                                                </div>
                                            </div>
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
    </main>

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
                <div class="modal-body">
                    <form class="form-group" id="edit_tag" novalidate="novalidate">
                        <label class="form-label">Tag <span class="form-asterick">&#42;</span></label>
                        <input class="form-control btn-circle" type="text" autocomplete="off" id="edit_tag_name" name="tag" placeholder="Tag"><br/>
                        <input class="form-control btn-circle" type="hidden" autocomplete="off" name="tag_id" id="tag_id" placeholder="tag_id"><br/>
                        <button class="btn btn-block btn-md" id="editTagButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;padding: 12px;">Edit Tag</button>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>

    <!--/Main layout-->
    @include('footer')

    <!--/Main layout-->

    <script>
        var oTable = $('#example1').dataTable(
            {
                "sScrollY":  "100%",
                "bPaginate": true,
                "bJQueryUI": true,
                "bScrollCollapse": false,
                "bLengthChange": true,
                "bAutoWidth": false,
                "sScrollX": "100%",

            });

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
                "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ],

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

    <!--detail -->
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
        }
    </style>
@endsection