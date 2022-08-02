@extends('contact_center.layout.default')
@section('content')
    @include('contact_center.header')
    <!--Main layout-->

    <main class="">
        <div class="container-fluid" style="height: 500px" >
            <div class="row">
                <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
                    <div class="portlet box blue">
                        <div class="portlet-title">
                            <div class="caption">
                                <i class="fa fa-user"></i>Guest Users</div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped responsive"  id="example1">
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
                    <br/><br/>
                </div>
                <br/><br/><br/><br/>
            </div>
        </div>
    </main>

    <!--/Main layout-->
    @include('footer')
    <script>
        $("#users").dataTable({
            "aaSorting": [[ 0, "desc" ]],
            "sPaginationType": "full_numbers",
            "iDisplayLength" : 20
        });
        $('#users_filter input').addClass('form-control');
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

$(function () {
        $('#example1').DataTable({
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
        })
    </script>
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
        }
    </style>
@endsection