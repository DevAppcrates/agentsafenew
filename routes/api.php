<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
// });

Route::group(['prefix' => 'v1'], function() {
    Route::post('register', 'UsersController@register');
    Route::post('login', 'UsersController@login');
    Route::post('logout', 'UsersController@logout');
    Route::post('forgot_password', 'UsersController@forgot_password');
    Route::post('verify_code', 'UsersController@verify_code');
    Route::post('change_password', 'UsersController@change_password');
    Route::post('edit_profile', 'UsersController@edit_profile');
    Route::post('edit_profile_info', 'UsersController@edit_profile_info');
    Route::post('update_device_token', 'UsersController@update_device_token');
    Route::post('update_push_setting', 'UsersController@update_push_setting');
    Route::post('update_setting', 'UsersController@update_setting');
    Route::post('notification_view', 'UsersController@notification_view');

    Route::post('create_video_session', 'VideosController@create_video_session');
    Route::post('create_image_session', 'VideosController@create_image_session');
    Route::post('update_video_archive_id', 'VideosController@update_video_archive_id');
    Route::post('update_video_location', 'VideosController@update_video_location');
    Route::post('get_notifications', 'VideosController@get_notifications');
    Route::post('update_video_time','VideosController@update_video_time');
    Route::any('delete_notification', 'VideosController@delete_notification');
    Route::any('user_tip_delete', 'VideosController@user_tip_delete');

    Route::post('create_group', 'GroupsController@create_group');
    Route::post('edit_group', 'GroupsController@edit_group');
    Route::post('add_group_member', 'GroupsController@add_group_member');
    Route::post('join_group_member', 'GroupsController@join_group_member');
    Route::post('delete_group_member', 'GroupsController@delete_group_member');
    Route::post('my_groups', 'GroupsController@my_groups');
    Route::post('joined_groups', 'GroupsController@joined_groups');
    Route::post('add_group_alert', 'GroupsController@add_group_alert');
    Route::post('group_detail', 'GroupsController@group_detail');
    Route::post('group_count', 'GroupsController@group_count');
    Route::any('send_push_notifications/{group_id}/{user_id}', 'GroupsController@send_push_notifications');
    Route::any('sendMessageToContacts/{group_id}/{user_id}', 'VideosController@sendMessageToContacts');
    Route::post('get_user_tips','VideosController@get_user_tips');
    Route::post('update_tip_message','VideosController@update_tip_message');
    Route::post('update_lost_person','VideosController@update_lost_person');

});
