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
                                <i class="fa fa-users"></i>Active Groups
                            </div>
                        </div>
                        <div class="portlet-body">
                            <table class="table table-striped table-hover responsive"  id="example2">
                                <thead>
                                @php $i = 1; @endphp
                                <tr>
                                    <th style="display: none">#</th>
                                    <th>Title</th>
                                    <th>Total Members</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups as $group)
                                    <tr>
                                        <td style="display: none">{{$i}}</td>
                                        <td >{{$group->title}}</td>
                                        <td ><a data-id='{{ $group->id }}' style="padding-top: 10px;" class="btn btn-sm btn-outline red" onclick="view_members('{{ $group->id }}','{{$group->title}}',this)">
                                                @if($group->is_default == 1 && $group->title == 'Invited Users')
                                                    {{ $inviteesCount }} Member
                                                @else
                                                    {{$group->members_count}} Members</a>
                                        </td>
                                        @endif
                                        <td >{{$group->created_at}}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actions</button>
                                                <div class="dropdown-menu">
                                                    <a  onclick="edit_group('{{ $group->id }}','{{ $group->title }}',this,'{{ session('contact_center_admin.0.type') }}')" class="dropdown-item"><i class="fa fa-edit"></i> Edit</a>
                                                    <a class="dropdown-item" onclick="delete_group('{{ $group->id }}','{{ $group->title }}',this,'{{ session('contact_center_admin.0.type') }}')" ><i class="fa fa-trash"></i> Delete</a>
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
    <div class="modal fade" id="group_members" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <!--Content-->
            <div class="modal-content" style="margin-top: 70px">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="GroupMembersLabel">Group Members</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <table id="example" class="table table-full-width table-checkable responsive table-condensed table-scrollable table_responsive">
                        <thead>
                        <tr>
                            <th>Image</th>
                            <th>name</th>
                            <th>Type</th>
                            <th>Action</th>
                            <th>Added On</th>
                        </tr>
                        </thead>
                    </table>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>
    {{-- edit Group Modal --}}
    <div class="modal fade" id="EditGroup" tabindex="-1" role="dialog">
        <div class="modal-dialog " role="document">
            <!--Content-->
            <div class="modal-content" style="margin-top: 70px">
                <!--Header-->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="EditGroupLabel">Edit Group</h4>
                </div>
                <!--Body-->
                <div class="modal-body">
                    <form class="form-group" id="edit-group">
                        <input  type="hidden" name="id">
                        <label class="form-label">Name A Group <span class="form-asterick">&#42;</span></label>
                        <input class="form-control btn-circle" type="text" autocomplete="off" name="title" placeholder="Title"><br/>
                        <br>
                        <div class="form-group">
                            <label class="form-label">Click on a User’s Name to Add to this Group <span class="form-asterick">&#42;</span></label>
                            <div id="edit_invitee-div" class="form-group">
                                <select id="edit_users"  class="ms form-control btn-circle" name="group_users[]" multiple="multiple">
                                    <?php $users = \App\Users::with('user_tags.tag')->where('organization_id',session('contact_center_admin.0.organization_id'))->where('status','enabled')->get(); ?>
                                    <?php $invitees = \App\Invitees::with('user_tags.tag')->where('organization_id',session('contact_center_admin.0.organization_id'))->get(); ?>
                                    @foreach($users as $user)
                                        @php $tags=''; @endphp
                                        @if($user->user_tags->count()>0)
                                            @foreach($user->user_tags as $tag)
                                                @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                                            @endforeach
                                            @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                                        @endif
                                        <option  value="{{'1,'.  $user->user_id }}">
                                            {{ $user->first_name.' '.$user->last_name . $tags}}
                                        </option>
                                    @endforeach
                                    @foreach($invitees as $invite)
                                        @php $tags=''; @endphp
                                        @if($invite->user_tags->count()>0)
                                            @foreach($invite->user_tags as $tag)
                                                @php $tags=$tag->tag->tag_name.', '.$tags; @endphp
                                            @endforeach
                                            @php $tags=' ('.rtrim($tags,', ').' )'; @endphp
                                        @endif
                                        <option  value="{{'2,'.  $invite->id }}" >
                                            {{$invite->name. $tags}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <br/>
                            <div id="error_group_user"></div>
                        </div>
                        <button class="btn" id="EditGroupButton" style="margin: auto;width: 100%;padding-left: 40px; padding-right: 40px; color: #222;margin-left: 2px;background-color: #0275d8;">Update Group</button>
                    </form>
                </div>
                <!--/.Content-->
            </div>
        </div>
    </div>
    @include('footer')
    <script type="text/javascript">
        function edit_group(id,title,current,admin_type)
        {
            if(admin_type != 2)
            {
                var group_name = $(current).parents('tr').children('td').eq(1).text();
                if(title == 'Invited Users')
                {
                    toastr['error']('App Users & Invited Users are Default Groups Cannot Be Edited');
                }else{
                    //  $('#edit_users-div').show()
                    //   $('#edit_invitee-div').hide()
                    $.ajax({
                        type : 'GET',
                        url : "{{ url('contact_center/ajax/get_group_members') }}/"+id,
                        data : {'data':1},
                        success : function(data,status)
                        {

                            members = data.members;
                            console.log(members);
                            // alert(members.length)
                            $('#edit-group input[name="id"]').val(id)
                            $('#edit-group input[name="title"]').val(title)
                            $('#edit_users').attr('disabled',false);
                            $('input[name="title"]').attr('disabled',false)
                            $('#EditGroupButton').attr('disabled',false)

                            $('#edit_users').multiSelect('refresh');
                            $('#edit_users').multiSelect('deselect_all');


                            $.each($('#EditGroup #edit_users > option'),function(key,value){

                                if(members.length == 0)
                                {
                                    $('#edit_users').multiSelect('deselect',$(value).attr('value'));
                                }
                                else
                                {
                                    $.each(members,function(k,v){

                                        if($(value).attr('value') == members[k]['type']+','+members[k]['user_id'])
                                        {
                                            $(value).attr('selected',true);
                                            $('#edit_users').multiSelect('select',members[k]['type']+','+members[k]['user_id']);
                                        }

                                    })
                                }
                            });
                            if(data.group.is_default == 1)
                            {
                                $('input[name="title"]').attr('disabled',true)
                                $('#EditGroupButton').attr('disabled',true);
                                $('#edit_users').attr('disabled','disabled');
                                $('#edit_users').multiSelect('refresh');
                            }

                            if(data.group.is_default == 1)
                            {

                                toastr['error']('App Users & Invited Users are Default Groups Cannot Be Edited');
                            }else{

                                $('#EditGroup').modal('show')
                            }

                        },

                    })

                }
            }else
            {
                toastr['error']("you don't have rights to edit/delete groups");
            }


        }
        function view_members(group_id,title,current)
        {
            tr = $('#example').DataTable();

            var group_name = $(current).parents('tr').children('td').eq(1).text();
            if(title === 'Invited Users')
            {

                $.ajax({
                    type : 'GET',
                    url : "{{ url('contact_center/ajax/get_group_members') }}/"+group_id+'/'+title,
                    success : function(data,status)
                    {
                        $("#GroupMembersLabel").html(data.group.title+"");

                        $.each(data.response,function(key,value){


                            if(data.group.is_default != 0)
                            {
                                button = '<button disabled="disabled" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }else{
                                button = '<button class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }
                            tr.row.add( [
                                'N/A',
                                value.name,
                               'Guest User',
                                button,
                                value.created_at,
                            ] ).draw( false );

                        })
                        $('#group_members').modal('show');


                    }
                })
            }else{
                $.ajax({
                    type : 'GET',
                    url : "{{ url('contact_center/ajax/get_group_members') }}/"+group_id,
                    success : function(data,status)
                    {
                        if(data.group.is_default == 1)
                        {
                            $("#GroupMembersLabel").html(data.group.title+"");

                        }else{

                            $("#GroupMembersLabel").html(data.group.title+" Members");
                        }

                        $.each(data.response,function(key,value){
                            remove_member = "remove_members('"+value.user_id+"','"+group_id+"',this)"
                            if(data.group.is_default != 0)
                            {
                                button = '<button disabled="disabled" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }else{
                                button = '<button onclick="'+remove_member+'" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }
                            tr.row.add( [
                                '<img class="img-rounded" width="50px" height="50px" src="'+value.display_picture+'">',
                                value.first_name+" "+value.last_name,
                                'App User',
                                button,
                                value.member.created_at,
                            ] ).draw( false );

                        });
                        console.log(data.invitees)
                        $.each(data.invitees,function(key,value){
                            remove_member = "remove_members('"+value.id+"','"+group_id+"',this)"
                            if(data.group.is_default != 0)
                            {
                                button = '<button disabled="disabled" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }else{
                                button = '<button onclick="'+remove_member+'" class="btn red btn-outline"><i class="fa fa-trash"></i>Remove</button>'
                            }
                            tr.row.add( [
                                'N/A',
                                value.name,
                                'Guest User',
                                button,
                                value.created_at,
                            ] ).draw( false );

                        })
                        $('#group_members').modal('show');
                    }
                })
            }
        }
        function remove_members(user_id,group_id,current)
        {

            tr = $('#example').DataTable();
            $.ajax({
                type : 'GET',
                url : "{{ url('contact_center/ajax/remove_member') }}/"+user_id+"/"+group_id,
                success : function(data,status)
                {
                    child_length = $(current).parents('tr.child').length;
                    // alert(child_length)
                    if(child_length == 1){
                        newObj = current;
                        $(current).parents('tr.child').prev("tr.parent").remove()
                        $(newObj).parents('tr.child').remove()
                        // tr.row($(current).parents('tr')).remove().draw();
                    }else{
                        tr.row($(current).parents('tr')).remove().draw();

                    }
                    $('a[data-id = "'+group_id+'"]').html(data+" Members")
                },
            })
        }
        $(document).on('hide.bs.modal','.modal', function () {
            tr = $('#example').DataTable();
            tr.clear().draw();
            // .remove();
            // $('#example tbody > tr').each(function(k,v){

            // })
        })

        $(function () {
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
        })

        $(document).ready(function(){

            $('#edit_users').multiSelect({
                selectableHeader: "<a href='#' id='select-all4'>select all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
                selectionHeader: "<a href='#' id='deselect-all4'>deselect all</a><input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to unselect'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                // afterSelect: function(){
                //   this.qs1.cache();
                //   this.qs2.cache();
                // },
                // afterDeselect: function(){
                //   this.qs1.cache();
                //   this.qs2.cache();
                // },
            });


            $('#edit_invitee').multiSelect({
                selectableHeader: "<input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search by Name or Tag'>",
                selectionHeader: "<input type='text' class='search-input form-control btn-circle' autocomplete='off' placeholder='Search to unselect'>",
                afterInit: function(ms){
                    var that = this,
                        $selectableSearch = that.$selectableUl.prev(),
                        $selectionSearch = that.$selectionUl.prev(),
                        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                        selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

                    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                        .on('keydown', function(e){
                            if (e.which === 40){
                                that.$selectableUl.focus();
                                return false;
                            }
                        });

                    that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                        .on('keydown', function(e){
                            if (e.which == 40){
                                that.$selectionUl.focus();
                                return false;
                            }
                        });
                },
                // afterSelect: function(){
                //   this.qs1.cache();
                //   this.qs2.cache();
                // },

            })
            // afterDeselect: function(){
            //   this.qs1.cache();
            //   this.qs2.cache();
            // },
            $('#EditGroup #edit-group').validate({
                rules: { title: { minlength: 5,maxlength:50,required: true }, 'group_users[]': { required: true}
                },
                errorPlacement: function(error, element) {
                    alert(element)
                    if (element.attr("name") == "group_users[]" )
                    {
                        $("#error_group_user").html(error);
                    }
                    else{
                        error.insertAfter(element);
                    }
                },
                submitHandler:function(form){
                    $('#EditGroupButton').attr('disabled',true);
                    $('#EditGroupButton').html('Loading ...');
                    formData = new FormData($("#edit-group")[0]);
                    toastr["success"]('Updating ....');
                    $.ajax({
                        type:'POST',
                        url:"{{ url('/') }}/contact_center/ajax/edit_group",
                        contentType: false,
                        processData: false,
                        data: formData,
                        error:function(){

                        },
                        success:function(data)
                        {
                            $('#EditGroupButton').attr('disabled',false);
                            $('#EditGroupButton').html('Update Group');
                            toastr["success"]('Updated successfully');
                            window.setTimeout(function() { location.reload() }, 1000)
                        },
                    })
                }
            });
        });
        $(document).on('click','#select-all4',function(){
            $('#edit_users').multiSelect('select_all');
            return false;
        });
        $(document).on('click','#deselect-all4',function(){
            $('#edit_users').multiSelect('deselect_all');
            return false;
        });


        function delete_group(id,title,current,admin_type)
        {
            if(admin_type != 2)
            {

                bootbox.confirm("Are you sure you want to delete the "+title+"?", function (result) {
                    if (result == true) {
                        $.ajax({
                            "method" : "post",
                            url : "{{url('contact_center/ajax/delete_group')}}",
                            data : "id="+id,
                            error: function(error){
                                error = $.parseJSON(error.responseText);
                                toastr['error'](error.response);
                            },
                            success : function(response,stat){
                                tr = $('#example2').DataTable();
                                toastr["success"]('Deleted successfully');
                                child_length = $(current).parents('tr.child').length;
                                if(child_length == 1){
                                    newObj = current;
                                    tr.row($(current).parents('tr.child').prev("tr.parent")).remove().draw();
                                    tr.row($(newObj).parents('tr.child')).remove().draw();
                                    // $(current).parents('tr.child').prev("tr.parent").remove()
                                    // $(newObj).parents('tr.child').remove()
                                    // $(newObj).parents('tr.child').remove()
                                }else{
                                    tr.row($(current).parents('tr')).remove().draw();
                                    // $(current).parents('tr').remove();
                                }

                                window.setTimeout(function() { $('.toast-close-button').click(); }, 1000)
                            },
                        });



                    }
                    else {
                    }
                });
            }else{

                toastr['error']("you don't have rights to edit/delete groups");
            }
        }

    </script>
@endsection