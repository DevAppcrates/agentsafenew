<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/audio', function () {
	return view('welcome');
});

Route::get('/master-hub', function () {
	return view('login');
})->middleware('guest:master_hub');

Route::get('/monitor-hub', function () {
	return view('monitor.login');
})->middleware('guest:monitor_hub');


Route::get('/master-hub/forget/email', function () {return view('forget-email-verify');});
Route::get('/master-hub/password/change/{token}', 'AdminController@password_change_view');

Route::get('/notification/{user_id}/{notification_id}/{type}', 'ContactCenterController@notification_user_status');

Route::get('/test', function () {
	$url = 'https://s3-us-west-1.amazonaws.com/i-follow/Audios/13108237643730257.m4a';
	$data = json_decode(file_get_contents('http://api.rest7.com/v1/sound_convert.php?url=' . $url . '&format=ogg'));
	//or:
	$data = json_decode(file_get_contents('http://api.rest7.com/v1/sound_convert.php?url=' . $url . '&format=m4a'));

	if ($data->success !== 1) {
		die('Failed');
	} //
	//$song = file_get_contents($data->file);
	//$data=file_put_contents('sound.ogg', $song);
	dd($data->file);

});

Route::any('upload', 'VideosController@upload');
Route::get('video/{video_id}', 'VideosController@showVideo');
Route::get('video2/{video_id}', 'VideosController@showVideo2');
Route::get('video_safe/{video_id}', 'VideosController@showVideoSafe');
Route::get('getTokBoxVideoList', 'VideosController@getTokBoxVideoList');
Route::get('checkArchiveId/{archive_id}', 'VideosController@checkArchiveId');

Route::get('/', function () {return view('contact_center.login');});
// Route::get('/contact_center_2', function () {return view('contact_center_2.login');})->middleware('guest:control_hub');
Route::get('/forget/email', function () {return view('contact_center.forget-email-verify');});
Route::get('/password/change/{token}', 'ContactCenterController@password_change_view');

Route::group(['middleware' => ['session'], 'prefix' => 'master-hub'], function () {
	Route::get('/admin', function () {return view('login');});
	Route::get('/dashboard', function () {return view('dashboard');});
	Route::get('/monitors', 'AdminController@monitors');

	Route::get('/organization', 'AdminController@organization');
	Route::get('/organization-detail/{org_id}', 'AdminController@organization_detail')->name('contact-center-detail');
	/*   Route::get('/users', 'AdminController@users');
		    Route::get('/enabled_users', 'AdminController@enabled_users');
	*/

	Route::get('/codes', 'AdminController@codes');
	Route::get('/active_codes', 'AdminController@active_codes');
	Route::get('/in_active_codes', 'AdminController@in_active_codes');

	Route::get('/administrators', 'AdminController@administrators');

});

Route::group(['middleware' => ['contact_center_session']], function () {

	Route::group([], function () {
		Route::get('/users', 'ContactCenterController@users');
		Route::get('/enabled_users', 'ContactCenterController@enabled_users');
		Route::get('/disabled_users', 'ContactCenterController@disabled_users');
		Route::get('/user_detail/{id}', 'ContactCenterController@user_detail');
		Route::get('/dashboard', function () {return view('contact_center.dashboard');});
		Route::get('/safewalk', function () {return view('contact_center.video.panic');});
		Route::get('/pending_safewalk', function () {return view('contact_center.video.panic');});
		Route::get('/report_tip', function () {return view('contact_center.video.video');});
		Route::get('/identification_uploads', function () {return view('contact_center.video.lost_persons');});
		// Route::get('/open_report_tip', function () { return view('contact_center.video.video'); });
		Route::get('/administrators', 'ContactCenterController@administrators');
		Route::get('/notifications', 'ContactCenterController@notifications');
		Route::get('/notification/history/{notification_id}', 'ContactCenterController@notification_history');
		Route::get('/groups', 'ContactCenterController@groups');
		Route::get('/archive/notifications', 'ContactCenterController@archive_notifications');
		Route::get('/invitees', 'ContactCenterController@invitees');
		Route::get('/tags', 'ContactCenterController@tags');
		Route::get('/notification-templates', 'ContactCenterController@notification_templates');

	});
});

Route::group(['prefix' => 'ajax'], function () {

	Route::post('/login', 'AdminController@admin_login');
	Route::post('/logout', 'AdminController@logout');
	Route::post('/add_admin', 'AdminController@add_admin');
	Route::post('/add_code', 'AdminController@add_code');
	Route::post('/change_password', 'AdminController@change_password');
	Route::post('/add_organization', 'AdminController@add_organization');
	Route::post('/edit_organization', 'AdminController@edit_organization');
	Route::post('/add_monitor', 'AdminController@add_monitor');
	Route::post('/edit_monitor', 'AdminController@edit_monitor');
	Route::post('/delete_monitor', 'AdminController@delete_monitor');
	
	Route::get('/user_status/{id}', 'AdminController@user_status');
	Route::post('/add_monitoring_official', 'AdminMonitoringCentersController@add_monitoring_official');
	Route::post("/add_admin_for_contact_center", 'AdminController@add_admin_for_contact_center');
	Route::post("/edit_admin_for_contact_center", 'AdminController@edit_admin_for_contact_center');
	Route::post('/delete_admin_for_contact_center', 'AdminController@delete_admin_for_contact_center');
	Route::get('get_additional_fields', 'AdminController@get_additional_field_for_edit_display');
	Route::get('change_user_status', 'AdminController@change_user_status');
	Route::post('/delete_admin_for_master_control_center', 'AdminController@delete_admin_for_master_control_center');
	Route::get('change_admin_status_for_master_control_center', 'AdminController@change_admin_status_for_master_control_center');
	Route::post('delete_cc', 'AdminController@delete_cc');
	Route::post('edit_admin_schedule', 'AdminController@edit_admin_schedule');

	route::get('change_organization_status', 'AdminController@change_organization_status');
	route::post('cc_admin_note', 'AdminController@cc_admin_note');
	route::post('monitor_note', 'AdminController@monitor_note');
	route::post('cc_user_note', 'AdminController@cc_user_note');
	Route::post('/change_password_master_hub', 'AdminController@change_password_master_hub');
	Route::post('/forget', 'AdminController@master_hub_forget');

});

Route::group(['prefix' => 'contact_center/ajax'], function () {

	Route::get('/getLatlongs/{video_id}', 'VideosController@getLatlongs');
	Route::post('/add_organization', 'ContactCenterController@add_organization');
	Route::post('/edit_organization', 'ContactCenterController@edit_organization');
	Route::post('/change_password', 'ContactCenterController@change_password');
	Route::post('/change_password_cc', 'ContactCenterController@change_password_cc');
	Route::post('/video_note', 'ContactCenterController@video_note');
	Route::post('/notification_note', 'ContactCenterController@notification_note');
	Route::post('/user_note', 'ContactCenterController@user_note');
	Route::post('/organization_note', 'ContactCenterController@organization_note');
	Route::post('/admin_note', 'ContactCenterController@admin_note');
	Route::get('/delete_invitee/{id}', 'ContactCenterController@delete_invitee');
	Route::post('/login', 'ContactCenterController@contact_center_login');
	Route::post('/forget', 'ContactCenterController@contact_center_forget');
	Route::post('/logout', 'ContactCenterController@logout');
	Route::post('/notification', 'ContactCenterController@notification');

	Route::post('/edit_notification', 'ContactCenterController@edit_notification');
	Route::get('/delete_notification', 'ContactCenterController@delete_notification');
	Route::post('/add_invitees', 'ContactCenterController@add_invitees');
	Route::post('single_invitee', 'ContactCenterController@single_invitees');
	Route::post('edit_profile', 'ContactCenterController@edit_profile');
	Route::post('delete_admin', 'ContactCenterController@delete_admin');
	Route::get('change_admin_status', 'ContactCenterController@change_admin_status');
	Route::get('get_additional_fields', 'ContactCenterController@get_additional_field_for_edit_display');
	Route::post('delete_panic', 'ContactCenterController@delete_panic');
	Route::post('delete_user', 'ContactCenterController@delete_user');
	Route::post('add_archive', 'ContactCenterController@add_archive');
	Route::post('create_group', 'ContactCenterController@create_group');
	Route::get('get_group_members/{group_id}/{group_name?}/{notification_id?}', 'ContactCenterController@get_group_members');
	Route::get('get_group_members_with_notification/{group_id}/{notification_id}/{group_name?}', 'ContactCenterController@get_group_members_with_notification');
	Route::get('remove_member/{user_id}/{group_id}', 'ContactCenterController@remove_member');
	Route::post('edit_group', 'ContactCenterController@edit_group');
	Route::post('delete_group', 'ContactCenterController@delete_group');
	Route::post('create_schedule', 'ContactCenterController@create_schedule');
	Route::post('edit_my_schedule', 'ContactCenterController@edit_my_schedule');
	Route::post('edit_admin_schedule', 'ContactCenterController@edit_admin_schedule');
	Route::post('/add_tag', 'ContactCenterController@add_tag');
	Route::post('/add_multiple_tags', 'ContactCenterController@add_multiple_tags');
	Route::post('/edit_tag', 'ContactCenterController@edit_tag');
	Route::post('/assign_tag', 'ContactCenterController@assign_tag');
	Route::post('/assign_tag_users', 'ContactCenterController@assign_tag_users');
	Route::post('/add-template', 'ContactCenterController@add_template');
	Route::post('/edit-template', 'ContactCenterController@edit_template');
	Route::post('/delete-template', 'ContactCenterController@delete_template');
	Route::post('/getTemplate', 'ContactCenterController@getTemplate');

	Route::get('/tag_members/{id}', function () {
		return view('contact_center.tags.tag_members');
	});
	Route::get('/user_tags/{id}/{type}', function () {
		return view('contact_center.users.user_tags');
	});
});

Route::group(['prefix' => 'monitor-hub/ajax'], function () {

	Route::post('/login', 'MonitorController@monitor_login');
	Route::post('/forget', 'MonitorController@monitor_forget');
	Route::post('/change_password_monitor', 'MonitorController@change_password_monitor');
	Route::post('/logout', 'MonitorController@logout');
});


// monitors panel Route 

	Route::get('monitor-hub/password/change/{token}', 'MonitorController@password_change_view');

Route::group(['middleware' => ['monitor_session'],'prefix'=>'monitor-hub'], function () {

	Route::group([], function () {
		// Route::get('/dashboard', function () {return view('monitor.dashboard');});
		Route::get('/safewalk', function () {return view('monitor.video.panic');});
		Route::get('/pending_safewalk', function () {return view('monitor.video.panic');});
		Route::get('/identification_uploads', function () {return view('monitor.video.lost_persons');});
	});
});