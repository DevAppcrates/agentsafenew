<!-- BEGIN SIDEBAR -->
 <?php $path = basename(Request::url());?>
 <?php

$url = url('/') . "";

$value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
if (Session::has('contact_center_admin')) {
	$user = Session::get('contact_center_admin');
	$email = $user[0]['email'];
	$name = $user[0]['organization_name'];
	$organization_id = $user[0]['organization_id'];
	$user_type = $user[0]['type'];

	$firebase_url = 'https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy=%22organizationId%22&equalTo=%22' . $organization_id . '%22';

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $firebase_url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$data = curl_exec($ch);
	curl_close($ch);

	$data = json_decode($data);
	$data = (array) $data;
	$lost_person = $tips = $panic = 0;

	foreach ($data as $row) {
		if ($row->isActive == true and $row->type == 'panic') {
			$panic++;
		} else if ($row->isActive == true and $row->type == 'lost_person') {
			$lost_person++;
		} else if ($row->isActive == true and $row->type != 'panic') {
			$tips++;
		}
	}
}

?>



                <div class="page-sidebar-wrapper">
                    <!-- BEGIN SIDEBAR -->
                    <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                    <!-- DOC: Change data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                    <div class="page-sidebar navbar-collapse collapse">
                        <!-- BEGIN SIDEBAR MENU -->
                        <!-- DOC: Apply "page-sidebar-menu-light" class right after "page-sidebar-menu" to enable light sidebar menu style(without borders) -->
                        <!-- DOC: Apply "page-sidebar-menu-hover-submenu" class right after "page-sidebar-menu" to enable hoverable(hover vs accordion) sub menu mode -->
                        <!-- DOC: Apply "page-sidebar-menu-closed" class right after "page-sidebar-menu" to collapse("page-sidebar-closed" class must be applied to the body element) the sidebar sub menu mode -->
                        <!-- DOC: Set data-auto-scroll="false" to disable the sidebar from auto scrolling/focusing -->
                        <!-- DOC: Set data-keep-expand="true" to keep the submenues expanded -->
                        <!-- DOC: Set data-auto-speed="200" to adjust the sub menu slide up/down speed -->
                        <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="true" data-auto-scroll="true" data-slide-speed="200" data-style='red'>
                            <!-- DOC: To remove the sidebar toggler from the sidebar you just need to completely remove the below "sidebar-toggler-wrapper" LI element -->
                            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
                            <!-- END SIDEBAR TOGGLER BUTTON -->
                            <li class="nav-item start{{ ($path == 'dashboard')?'active':'' }}">
                                <a href="{{$url}}/dashboard" class="nav-link">
                                    <i class="icon-home"></i>
                                    <span class="title">Dashboard</span>
                                </a>
                            </li>
                            @if(session('contact_center_admin.0.type') != 2)
                            {{-- Sub Adminis --}}
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                   <i class="icon-users"></i>
                                    <span class="title">Sub Administrators</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item {{ ($path == '')?'active':'' }}">
                                        <!--<a class="nav-link ">
                                        </a>-->
                                        <a href="#" data-toggle="modal" data-target="#add_sub_contact_center" class="nav-link waves-effect">
                                            <i class="icon-users"></i>
                                            <span class="title">Add Sub Administrator</span>

                                    </a>
                                    </li>

                                    <li class="nav-item  {{ ($path == 'administrators')?'active':'' }}">
                                        <a href="{{$url}}/administrators" class="nav-link ">
                                            <i class="icon-users"></i>
                                            <span class="title">Sub Administrators List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            @endif
                            {{-- Tags --}}
                            <li class="nav-item {{ ($path == 'active-cities' || $path == 'deactive-cities')?'':'' }}">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-tag"></i>
                                    <span class="title">Tags</span>
                                    <span class="arrow"></span>


                                </a>
                                <ul class="sub-menu">
                                    <li class="nav-item ">
                                        <a href="#" data-toggle="modal" data-target="#addTag"  class="nav-link ">
                                            <i class="icon-tag"></i>
                                            <span class="title">Add A Single Tag</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ ($path == 'active-cities')?'active':'' }}">
                                        <a href="#" data-toggle="modal" data-target="#addMultipleTag" class="nav-link ">
                                            <i class="icon-tag"></i>
                                            <span class="title">Add Multiple Tags</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ ($path == 'tags')?'active':'' }}">
                                        <a href="{{$url}}/tags" class="nav-link ">
                                            <i class="icon-tag"></i>
                                            <span class="title">Tag List</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>

                             {{-- Guests --}}

                           {{-- app users --}}
                            <li class="nav-item">
                                <a href="javascript:;" class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Users</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">
                                    @if(session('contact_center_admin.0.type') != 2)
                                    <li class="nav-item ">
                                        <a href="#" data-toggle="modal" data-target="#invitees" class="nav-link ">
                                            <i class="icon-bell"></i>
                                            <span class="title">Add Multiple Users</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ">
                                        <a href="#" data-toggle="modal" data-target="#SingleInvitees" class="nav-link ">
                                            <i class="icon-bell"></i>
                                            <span class="title">Add Users Individually</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ ($path == 'invitees')?'active':'' }}">
                                        <a href="{{$url}}/invitees" class="nav-link ">
                                            <i class="icon-camcorder"></i>
                                            <span class="title">List Non-App Users</span>
                                        </a>
                                    </li>
                                    @endif

                                    <li class="nav-item {{ ($path == 'users')?'active':'' }}">
                                        <a href="{{$url}}/users" class="nav-link ">
                                            <i class="icon-users"></i>
                                            <span class="title">List App-Users</span>
                                        </a>
                                    </li>
                                     <li class="nav-item {{ ($path == 'enabled_users')?'active':'' }}">
                                        <a href="{{$url}}/enabled_users" class="nav-link ">
                                            <i class="icon-check"></i>
                                            <span class="title">Enabled Users</span>
                                        </a>
                                    </li>
                                     <li class="nav-item {{ ($path == 'disabled_users')?'active':'' }}">
                                        <a href="{{$url}}/disabled_users" class="nav-link ">
                                            <i class="icon-ban"></i>
                                            <span class="title">Disabled Users</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            {{-- groups --}}
                            <li class="nav-item">
                                <a href="javascript:;"  class="nav-link nav-toggle">
                                    <i class="icon-users"></i>
                                    <span class="title">Groups</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item {{ ($path == 'videos')?'active':'' }}">
                                        <a href="#" data-toggle="modal" data-target="#CreateGroup" class="nav-link ">
                                            <i class="icon-users"></i>
                                            <span class="title">Create Groups</span>
                                        </a>
                                    </li>
                                     <li class="nav-item {{ ($path == 'groups')?'active':'' }}">
                                        <a href="{{$url}}/groups" class="nav-link ">
                                            <i class="icon-check"></i>
                                            <span class="title">View Groups</span>
                                        </a>
                                    </li>


                                </ul>
                            </li>

                             {{-- Panics --}}
                            <li class="nav-item">
                                <a href="javascript:;"  class="nav-link nav-toggle">
                                    <i class="icon-camcorder"></i>
                                    <span class="title">All Safe Walks @if($panic!=0)<span class="badge badge-primary"> {{ $panic }} </span>@endif</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item {{ ($path == 'safewalk')?'active':'' }}">
                                        <a href="{{$url}}/safewalk" class="nav-link ">
                                            <i class="icon-camcorder"></i>
                                            <span class="title">Ended Safe Walks</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ ($path == 'pending_safewalk')?'active':'' }}">
                                        <a href="{{$url}}/pending_safewalk" class="nav-link ">
                                            <i class="icon-camcorder"></i>
                                            <span class="title">Active Safe Walks</span>
                                        </a>
                                    </li>



                                </ul>
                            </li>
                            {{-- Anonymous Panics --}}


                           {{--  <li class="nav-item">
                                <a href="javascript:;"  class="nav-link nav-toggle">
                                    <i class="icon-camcorder"></i>
                                    <span class="title">Report Tip @if($tips!=0) <span class="badge badge-primary">{{$tips}}</span> @endif</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item {{ ($path == 'report_tip')?'active':'' }}">
                                        <a href="{{$url}}/report_tip" class="nav-link ">
                                            <i class="icon-camcorder"></i>
                                            <span class="title">Reported Tips</span>
                                        </a>
                                    </li>
                                </ul>
                            </li> --}}


                             {{-- Anonymous Panics --}}
                            <li class="nav-item">
                                <a href="javascript:;"  class="nav-link nav-toggle">
                                    <i class="icon-camcorder"></i>
                                    <span class="title">Identification Upload @if($lost_person!=0) <span class="badge badge-primary">{{$lost_person}}</span> @endif</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item {{ ($path == 'identification_upload')?'active':'' }}">
                                        <a href="{{$url}}/identification_uploads" class="nav-link ">
                                            <i class="icon-camcorder"></i>
                                            <span class="title">Identification Upload</span>
                                        </a>
                                    </li>




                                </ul>
                            </li>

                            <li class="nav-item {{ $path == 'notifications'?'active open':'' }}">
                                <a href="javascript:;"  class="nav-link nav-toggle">
                                    <i class="icon-bell"></i>
                                    <span class="title">Mass Notification</span>
                                    <span class="arrow"></span>
                                </a>
                                <ul class="sub-menu">

                                    <li class="nav-item {{ ($path == 'videos')?'active':'' }}">
                                        <a  href="#" onclick="mass_notification('1')"  class="nav-link ">
                                            <i class="icon-note"></i>
                                            <span class="title">Send Text Notification</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ ($path == 'videos')?'active':'' }}">
                                        <a  href="#" onclick="mass_notification('2')"  class="nav-link ">
                                            <i class="icon-microphone"></i>
                                            <span class="title">Send Voice Notification</span>
                                        </a>
                                    </li>
                                    <li class="nav-item {{ (Request::url()  == url('notifications') && $path == 'notifications')?'active':'' }}">
                                        <a href="{{$url}}/notifications" class="nav-link ">
                                            <i class="icon-bell"></i>
                                            <span class="title">List Of Notifications</span>
                                        </a>
                                    </li>

                                    <li class="nav-item {{ ($path == 'notification-templates')?'active':'' }}">
                                        <a href="{{$url}}/notification-templates" class="nav-link ">
                                            <i class="icon-bell"></i>
                                            <span class="title">Notifications Templates</span>
                                        </a>
                                    </li>
                                    @if(session('contact_center_admin.0.type') != 2)
                                    <li class="nav-item {{ (Request::url()  == url('/archive/notifications') && $path == 'notifications')?'active':'' }}">
                                        <a href="{{$url}}/archive/notifications" class="nav-link ">
                                            <i class="icon-folder"></i>
                                            <span class="title">Archived Notifications</span>
                                        </a>
                                    </li>
                                    @endif;
                                </ul>
                            </li>


                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->

