@extends('contact_center.layout.default')
@section('content')
@include('contact_center.header')

<main class="">
    <div class="container-fluid" style="height: 500px" >
        <div class="row">
            <div class="col-xs-12 col-lg-12 col-md-12 col-sm-12 table_responsive" style="padding: 0px;margin-top: 50px">
                <div class="portlet box blue">
                    <div class="portlet-title">
                        <div class="caption">
                            <i class="fa fa-bell-o"></i>Archived Mass Notification</div>
                    </div>
                    <div class="portlet-body">
                        <table class="table table-striped table-hover responsive table-success"  id="example2">
                            <thead>
                            @php $i = 1; @endphp
                            <tr>
                                <th style="display: none">#</th>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Notification</th>
                                <th>Detail</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($notifications as $notification)
                            <tr>
                                <td style="display: none">{{$i}}</td>
                                <td >{{$notification->name}}</td>
                                <td >{{$notification->title}}</td>
                                <td >{{$notification->notification}}</td>
                                <td >
                                    @if($notification->type==2)
                                    <video style="height: 100px;" width="180" height="200" class="img-thumbnail img-responsive" controls>
                                        <source src="{{$notification->path}}" type="video/mp4">
                                        <source src="{{$notification->path}}" type="video/ogg">
                                        Your browser does not support the video tag.
                                    </video>
                                    @elseif($notification->type==1)
                                    <img src="{{$notification->path}}" width="180" height="80" class="img-responsive img-thumbnail" style="object-fit: contain;height: 100px">
                                    @endif
                                </td>
                                <td >{{$notification->created_at->DiffForHumans()}}</td>
                                <td>
                                    <div class="btn-group">
                                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>

                                        <div class="dropdown-menu">
                                            @if(!empty($notification->notes))
                                            <button type="button" class="dropdown-item" data-toggle="tooltip" data-placement="left" title="{{$notification->notes}}">
                                                <i class="fa fa-sticky-note"></i> View Notes
                                            </button>
                                            @endif
                                            @php
                                            $clear = trim(preg_replace('/ +/', ' ', preg_replace('/[^A-Za-z0-9 ]/', ' ', urldecode(html_entity_decode(strip_tags($notification->notes))))));

                                            @endphp
                                            <a class="dropdown-item" onclick="add_notes('{{$notification->id}}','{{$clear}}')"><i class="fa fa-pencil"></i> Add/Edit Note</a>
                                            @if(session('contact_center_admin.0.type') == 1)
                                            <a data-id="{{ $notification->id }}" class="btnDelete dropdown-item"><i class="fa fa-trash"></i> Delete</a>
                                            <a data-id="{{ $notification->id }}" class="btnAddTOArchived dropdown-item"><i class="fa fa-trash"></i> Add to Archive</a>
                                            @endif
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
                <br/><br/>
            </div>
            <br/><br/><br/><br/>
        </div>
    </div>
</main>

@endsection