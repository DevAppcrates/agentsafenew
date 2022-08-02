<!-- BEGIN SIDEBAR -->
 <?php $path = basename(Request::url());?>
 <?php

$url = url('/') . "/monitor-hub";

$value = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lost_person = $tips = $panic = 0;
if (Session::has('monitor_admin')) {
	$user = Session::get('monitor_admin');
	$email = $user[0]['monitor_email'];
	$name = $user[0]['monitor_name'];

	$organization_ids = data_get($user[0]['organizations'],'*.organization_id');
	foreach ($organization_ids as $key => $organization_id) {
    	$firebase_url = 'https://ifollow-cc-3f29a.firebaseio.com/.json?orderBy=%22organizationId%22&equalTo=%22' . $organization_id . '%22';

    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $firebase_url);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	$data = curl_exec($ch);
    	curl_close($ch);

    	$data = json_decode($data,true);
    	$datas[] = (array) $data;
    }
    foreach ($datas as $data) {

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

                        <!-- END SIDEBAR MENU -->
                        <!-- END SIDEBAR MENU -->
                    </div>
                    <!-- END SIDEBAR -->
                </div>
                <!-- END SIDEBAR -->

