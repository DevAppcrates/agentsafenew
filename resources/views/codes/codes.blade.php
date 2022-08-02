@extends('layout.default')
@section('content')
    @include('header')
    <!--Main layout-->

    <main class="">
        <div class="container-fluid" style="height: 500px" >
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
                    <table class="table"  id="users">
                        <thead class="thead-inverse">
                        <tr>
                            <th style="display: none">Id</th>
                            <th>Organization Name</th>
                            <th>Code</th>
                            <th>Status</th>
                            <th>Created At</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($codes as $code)
                            <tr>
                                <td style="display: none">{{$code->id}}</td>
                                <td >{{$code->organization_name}}</td>
                                <td >{{$code->code}}</td>
                                <td >
                                    @if($code->status==1)
                                        <h5><span class="badge green" style="color: white; font-size: 18px;padding: 5px 15px;border-radius: 3px;">Active</span></h5>
                                        @else
                                        <h5><span class="badge red" style="color: white; font-size: 18px;padding: 5px;border-radius: 3px;">In-Active</span></h5>

                                    @endif
                                </td>
                                <td >{{$code->created_at}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
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
            "iDisplayLength" : 10
        });
        $('#users_filter input').addClass('form-control');

    </script>
    <style>
        table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after, table.dataTable thead .sorting_asc_disabled:after, table.dataTable thead .sorting_desc_disabled:after {
            display: none !important;
        }
    </style>
@endsection