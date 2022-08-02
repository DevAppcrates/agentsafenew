<?php

namespace App\Http\Controllers;

use App\GroupAlerts;
use App\GroupMembers;
use App\Groups;
use App\Helpers\apiHelper;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;
use Mail;

class GroupsController extends Controller
{
    public function create_group(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('title' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            if(Groups::where('user_id',$user_id)->exists()){
                $response=apiHelper::error('You have already created a group.');
                return response()->json($response);
            }else{
                $group_id=Uuid::uuid1();
                $group=new Groups();
                $group->group_id=$group_id;
                $group->title=$request->title;
                $group->user_id=$user_id;
                $group->save();
                $group=Groups::where('group_id',$group_id)->first();
                $response = apiHelper::success('Group created',$group);
                return response()->json($response);
            }
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function edit_group(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('title' => 'required','group_id'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $group_id=$request->group_id;
            if(!Groups::where('user_id',$user_id)->where('group_id',$group_id)->exists()){
                $response=apiHelper::error('You dont have a access to edit this group');
                return response()->json($response);
            }else{
                $group=Groups::where('user_id',$user_id)->where('group_id',$group_id)->first();
                $group->title=$request->title;
                $group->user_id=$user_id;
                $group->save();
                $group=Groups::where('group_id',$group_id)->first();
                $response = apiHelper::success('Changes confirmed',$group);
                return response()->json($response);
            }
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function add_group_member(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('first_name' => 'required','last_name' => 'required','email'=>'required','phone'=>'required','group_id'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $email=$request->email;
            $phone=$request->phone;
            if(!GroupMembers::where(function ($query) use ($email,$phone){
                $query->where('email',$email)->orWhere('phone_number',$phone);
            })->where('group_id',$request->group_id)->exists()){

                $user = Users::where('user_id',$user_id)->first();
                $user_first_name = $user->first_name;
                $code=str_random(8);
                $email=$request->email;
                $group_member=new GroupMembers();
                $group_member->first_name=$request->first_name;
                $group_member->last_name=$request->last_name;
                $group_member->email=$request->email;
                $group_member->phone_number=$request->phone;
                $group_member->code=$code;
                $group_member->group_id=$request->group_id;
                $group_member->save();
                try {
                    Mail::send([], [], function ($message) use ($email,$user_first_name,$code) {
                        $body = "Your friend, $user_first_name has invited you to as a group member. Please download this app and use this code in group section: ".$code;
                        $message->to($email)->subject('iFollow')->setBody($body, 'text/html');
                    });
                }catch (\Exception $e) {}

                $accountSid = 'AC5bfbcd956098ece9ba0bdb4ab724120f';
                $authToken = '9a780884a93d8dc477dd2f48132a631c';
                $twilioNumber = "+12169302831";


                $client = new Client($accountSid, $authToken);
                $body = "Your friend, $user_first_name has invited you to as a group member. Please download this app and use this code in group section: ".$code;
                try {
                    $client->messages->create(
                        '+'.$request->phone,
                        [
                            "body" => $body,
                            "from" => $twilioNumber
                        ]
                    );

                } catch (TwilioException $e) {}

                $group=Groups::where('group_id',$request->group_id)->first();
                $response = apiHelper::success('Member added',$group);
                return response()->json($response);
            }else{
                $response=apiHelper::error('Email/Phone already exists in this group');
                return response()->json($response);
            }
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function join_group_member(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('code' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $user=Users::where('user_id',$user_id)->first();
            $email=$user->email; $phone=$user->phone; $code=$request->code;
            if($group_member=GroupMembers::where(function ($query) use ($email,$phone){
                $query->where('email',$email)->orWhere('phone_number',$phone);
            })->where('code',$code)->where('status',0)->first()){
                $group_member->user_id=$user_id;
                $group_member->status=1;
                $group_member->save();

                $groups=Groups::where('group_id',$group_member->group_id)->first();
                $response = apiHelper::success('Group joined',$groups);
                return response()->json($response);

            }else{
                $response=apiHelper::error('You have entered an invalid code');
                return response()->json($response);
            }
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function delete_group_member(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('group_id' => 'required','id'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            if($group_member=GroupMembers::where('group_id',$request->group_id)->where('id',$request->id)->first()){
                $group_member->delete();
                $groups=Groups::where('group_id',$request->group_id)->first();
                $response = apiHelper::success('Member deleted',$groups);
                return response()->json($response);
            }else{
                $response=apiHelper::error('You have entered invalid group_id');
                return response()->json($response);
            }
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function my_groups(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $groups=Groups::where('user_id',$user_id)->get();
            $response = apiHelper::success('Get groups',$groups);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function joined_groups(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $group_ids=GroupMembers::where('user_id',$user_id)->where('status',1)->pluck('group_id')->all();
            $groups=Groups::whereIn('group_id',$group_ids)->get();
            $response = apiHelper::success('Get groups',$groups);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function group_detail(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('group_id' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $groups=Groups::with('members','group_alerts.user_detail')->where('group_id',$request->group_id)->first();
            $response = apiHelper::success('Get groups',$groups);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function add_group_alert(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('group_id' => 'required','video_url'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }

            $group_alert=new GroupAlerts();
            $group_alert->user_id=$user_id;
            $group_alert->group_id=$request->group_id;
            $group_alert->video_url=$request->video_url;
            $group_alert->save();
            $this->send_push_notifications($user_id,$request->group_id,$request->video_url);
            $group=Groups::where('group_id',$request->group_id)->first();
            $response = apiHelper::success('Alert added',$group);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public function group_count(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $my_group=Groups::where('user_id',$user_id)->count();
            $joined_group=GroupMembers::where('user_id',$user_id)->where('status',1)->count();
            $data=array('count'=>$my_group+$joined_group);
            $response = apiHelper::success('Group count',$data);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }

    public  function send_push_notifications($user_id,$group_id,$video_url)
    {
        $name=Users::where('user_id',$user_id)->pluck('first_name')->first();
        $group_user_ids=Groups::where('group_id',$group_id)->pluck('user_id')->where('user_id','!=',$user_id)->all();
        $group_member_user_ids=GroupMembers::where('group_id',$group_id)->where('user_id','!=',$user_id)->where('status',1)->pluck('user_id')->all();
        $user_ids=array_merge($group_user_ids,$group_member_user_ids);
        $device_tokens=Users::whereIn('user_id',$user_ids)->where('device_token','!=','')->pluck('device_token')->all();
        $data=array('group_id'=>$group_id);
        $fields = array(
            'notification' => array(
                'title' => 'i-Follow',
                'text' => $name.' just added a group alert, click to view',
                'data' => $data,
                'video_url' => $video_url,
                'group_id'=>$group_id
            ),
            'data' => array(
                'title' => 'i-Follow',
                'text' => $name.' just added a group alert, click to view',
                'data' => $data,
                'video_url' => $video_url,
                'group_id'=>$group_id
            ),
            // 'content_available' => true,
            'priority' => 'high',
            'registration_ids' => $device_tokens
        );
        $url = 'https://fcm.googleapis.com/fcm/send';


        $headers = array(
            'Authorization: key=' . 'AIzaSyBSBpzV7Ci5QnekA8R-RwOpkPnKc71dz4s',
            'Content-Type: application/json'
        );
        // Open connection
        $ch = curl_init();
        // Set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Disabling SSL Certificate support temporarly
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
    }
}
