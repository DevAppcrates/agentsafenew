<?php

namespace App\Http\Controllers;

use App\Helpers\apiHelper;
use App\Notifications;
use App\UserDeletedNotification as DeletedNotify;
use App\DeletedTip;
use App\Organizations;
use App\Users;
use App\VideoLocationTracking;
use App\Videos;
use App\GroupMembers;
use App\NotificationGroup;
use App\Schedule;
use Illuminate\Http\Request;
use OpenTok\OpenTok;
use OpenTok\MediaMode;
use OpenTok\ArchiveMode;
use OpenTok\Role;
use OpenTok\Archive;
use Illuminate\Support\Facades\Validator;
use Mail;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;;
use \DateTime;
use \DateTimeZone;
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

define('Monday', 1);
define('Tuesday', 2);
define('Wednesday', 3);
define('Thursday', 4);
define('Friday', 5);
define('Saturday', 6);
define('Sunday', 7);
class VideosController extends Controller
{
    protected $opentok_api_key = '46010562'; // 45965942
    protected $opentok_api_secret = 'c058d681990737683d3d9870c378566c934162db'; //88206886168d79fcce62c7a093a4bda399a80d68

    public function get_user_videos(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $uservideos = Videos::where('user_id',$user_id)->where('archive_id','!=','')->orderBy('id','desc')->get();
            $response = apiHelper::success('User Videos',$uservideos);
            return response()->json($response);
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function get_notifications(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) 
        {
            $rules=array( 'organization_id' => 'required');
            $validations= Validator::make($request->all(), $rules);
            if($validations->fails()){
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $groups = GroupMembers::where('user_id',$user_id)->pluck('group_id')->all();
            $notifications = NotificationGroup::whereIn('group_id',$groups)->pluck('notification_id')->all();
            $deleted_notification = DeletedNotify::where('user_id',$user_id)->pluck('notification_id')->all();

            $notifications = Notifications::where('organization_id',$request->organization_id)->whereIn('id',$notifications)->whereNotIn('id',$deleted_notification)->where('is_archive',0)->where('status',1)->orderBy('created_at','desc')->get();
            $response = apiHelper::success('Get notifications',$notifications);
            return response()->json($response);
        }else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function create_video_session(Request $request)
    {

        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules=array( 'type' => 'required');
        $validations= Validator::make($request->all(), $rules);
        if($validations->fails())
        {
            $messages = $validations->messages();
            $data=apiHelper::validation_error('Validation errors',$messages);
            return response()->json($data,403);
        }
        $organization = Users::where('user_id',$user_id)->where('auth_id',$auth_id)->pluck('organization_id')->first();
        $organization = Organizations::with('time_zone')->where('organization_id',$organization)->where('type',1)->first();
            $video_id = rand(1000,9999) . 6 . time();
            $opentok = new OpenTok($this->opentok_api_key, $this->opentok_api_secret);
            $sessionOptions = array(
                'archiveMode' => ArchiveMode::ALWAYS,
                'mediaMode' => MediaMode::ROUTED
            );
            $session = $opentok->createSession($sessionOptions);
            $sessionId = $session->getSessionId();
            $token = $opentok->generateToken($sessionId);

            $video = new Videos();
            $video->video_id = $video_id;
            $video->user_id = $user_id;
            $video->session_token = $sessionId;
            $video->opentok_token = $token;
            $current_time = new DateTime('now',new DateTimeZone($organization['time_zone']['timezone_code']));
        $video->created_at = $current_time;
            if ($request->type) $video->type = $request->type;
            $video->save();

            $data = array('session_token' => $sessionId,'opentok_token' => $token ,'video_id' => $video_id );
            $response=apiHelper::success('Create successfully!',$data);
            return response()->json($response);
        }
        else
        {
            $response=apiHelper::error('“You Are Not Authorized To Use This Feature” Please contact the administrator of your program.');
            return response()->json($response,401);   // Status code 401 shows un authorized
        }
    }
    public function update_video_time(Request $request)
    {
         $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('video_id' => 'required','video_time'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
              $video = Videos::where('video_id',$request->video_id)->first();
            $video->video_time = $request->video_time;


            $save = $video->save();
            if ($save){
                $response=apiHelper::success1('Updated successfully!');
                return response()->json($response);
            }
            else {
                $response=apiHelper::error('Unknown Error');
                return response()->json($response,401);
            }
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }

    }
    public function update_video_archive_id(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('video_id' => 'required' , 'archive_id' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }

            $video = Videos::where('video_id',$request->video_id)->first();
            $video->archive_id = $request->archive_id;

            $save = $video->save();
            if ($save){
               $this->sendMessageToContacts($user_id,$request->video_id);
                $response=apiHelper::success1('Updated successfully!');
                return response()->json($response);
            }
            else {
                $response=apiHelper::error('Unknown Error');
                return response()->json($response,401);
            }
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function update_video_location(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('video_id' => 'required', 'latitude' => 'required', 'longitude' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails()) {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }

            $video_location = new VideoLocationTracking();
            $video_location->video_tracking_id = rand(1000,9999) . 7 . time();;
            $video_location->video_id = $request->video_id;
            $video_location->user_id = $user_id;
            $video_location->latitude = $request->latitude;
            $video_location->longitude = $request->longitude;
            $save = $video_location->save();
            if ($save){
                $response=apiHelper::success1('Added successfully!');
                return response()->json($response);
            }
            else {
                $response=apiHelper::error('Unknown Error');
                return response()->json($response,401);
            }
        }
        else {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function create_image_session(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('type'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails())
            {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $video_id = rand(1000,9999) . 6 . time();
            $organization = Users::where('user_id',$user_id)->where('auth_id',$auth_id)->pluck('organization_id')->first();
            $organization = Organizations::with('time_zone')->where('organization_id',$organization)->where('type',1)->first();
            $video = new Videos();
            $video->video_id = $video_id;
            $video->user_id = $user_id;
            if(empty($request->image_path)){
            $video->message = $request->message;
            }else{    
            $video->image_path = $request->image_path;
            }
            $current_time = new DateTime('now',new DateTimeZone($organization['time_zone']['timezone_code']));
            $video->created_at = $current_time;
            $video->session_token = '';
            $video->opentok_token = '';
            $video->archive_id =$video_id;
            $video->is_image = 1;
            if ($request->type) $video->type = $request->type;
            $save =$video->save();

            if ($save){
                $this->sendMessageToContacts($user_id,$video_id);
                $data = array('video_id' => $video_id);
                $response=apiHelper::success('Create successfully!',$data);
                return response()->json($response);
            }
            else {
                $response=apiHelper::error('Unknown Error');
                return response()->json($response,401);
            }

        }
        else
        {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function get_user_tips(Request $request){
         $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        
        if(apiHelper::authenticate($user_id,$auth_id)) {
                $video_ids = DeletedTip::where('user_id',$user_id)->pluck('video_id')->all();
                $tips =  Videos::where('user_id',$user_id)->whereNotIn('video_id',$video_ids)->where('type','anonymous')->get();
                $response = apiHelper::success('User Tips',$tips);
                return response()->json($response);
        }else{
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

     public function sendMessageToContacts($user_id,$video_id)
    {
        $organization_id=Users::where('user_id',$user_id)->pluck('organization_id')->first();
        $time_zone = Organizations::with('time_zone')->where('organization_id',$organization_id)->first();
         $tz_identifier = $time_zone['time_zone']['timezone_code'];  
        ini_set('date.timzone', $tz_identifier);
          $time = date('l',time());
         $am = date('A');
         $admins = Schedule::with('start_time','close_time')->where('organization_id',$organization_id)->where('day_id',constant($time))->where('status','active')->get()->toArray();
         $admin_ids = [];
        
          // $current_time = strtotime($time_zone['time_zone']['utc_diff']." hours");
                    $current_time = new DateTime('now',new DateTimeZone($time_zone['time_zone']['timezone_code']));
         foreach ($admins as  $admin) 
         {
             $admin['close_time']['hour'];
                $open_time_format = $admin['open_time_format'];     
                $close_time_format = $admin['close_time_format'];
                $start_time = $admin['start_time']['hour'];
                 $close_time = $admin['close_time']['hour'];
              
                 $start_time .= ' '.$open_time_format; 
                 $close_time .= ' '.$close_time_format;
                   // $start_time = new Carbon($start_time,$tz_identifier);

       
        $start_time = new DateTime($start_time,new DateTimeZone($time_zone['time_zone']['timezone_code']));
        $close_time = new DateTime($close_time,new DateTimeZone($time_zone['time_zone']['timezone_code']));

               /*  $start_time = $start_time->addHours($time_zone['time_zone']['utc_diff']." hours")->timestamp;*/
                   // $close_time = new Carbon($close_time,$tz_identifier);
                 // $close_time = $close_time->addHours($time_zone['time_zone']['utc_diff']." hours")->timestamp;  
                if($start_time <= $current_time && $close_time >= $current_time )
                {

                    $admin_ids[] = $admin['admin_id'];
                }

                

         }
         
        $contacts = Organizations::whereIn('id',$admin_ids)->get();
     
        $contacts_email = $contacts->pluck('email')->toArray();
        $contacts_number = $contacts->pluck('phone_number');

        $type=Videos::where('video_id',$video_id)->pluck('type')->first();
        //MAIL
        try {
            Mail::send([], [], function ($message) use ($contacts_email,$type,$video_id) {
                if($type=='panic'){
                    $body = 'A new panic alert is in progress. View Here: https://controlhub.ifollow.com/dashboard?type='.$type.'&video_id='.$video_id;
                }else{
                    $body = 'A new Report Tip has been submitted. View Here: https://controlhub.ifollow.com/dashboard?type='.$type.'&video_id='.$video_id;
                }
                $message->to($contacts_email)->subject('iFollow | Alert')->setBody($body, 'text/html');
            });
        }catch (\Exception $e)
        {
            $exceptionmessage = $e->getMessage();
        }

        if($type=='panic'){
            $body = 'A new panic alert is in progress. View Here: https://controlhub.ifollow.com/dashboard?type='.$type.'&video_id='.$video_id;
        }else{
            $body = 'A new Report Tip has been submitted. View Here: https://controlhub.ifollow.com/dashboard?type='.$type.'&video_id='.$video_id;
        }
        $accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
        $authToken = '002a6ef044af01d69cb979eb4107b9fe';
        $twilioNumber = "+14359195249";
        foreach ($contacts_number as $numberitem) {

            $client = new Client($accountSid, $authToken);


            try {
                $client->messages->create(
                    ''.$numberitem,
                    [
                        "body" => $body,
                        "from" => $twilioNumber
                    ]
                );
            } catch (TwilioException $e) {
               // echo($e->getMessage());


            }
        }
   
}

    public function dropboxFileUpload()
    {
        $client_drop = new ClientDropbox('6FSiD5aWshAAAAAAAAAAXrvxsghKJRsg7JX44AcbiuvQsmFRRaw6_16KrXP3LYx0');

        $adapter = new DropboxAdapter($client_drop);

        $filesystem = new Filesystem($adapter);
        dd($filesystem);


        $Client = new ClientDropbox('6FSiD5aWshAAAAAAAAAAXrvxsghKJRsg7JX44AcbiuvQsmFRRaw6_16KrXP3LYx0', '0ipp1g22795rr56');
        $imgfile = 'Tanzania.png';
        $im = imagecreatefrompng($imgfile);
        $index = imageColorclosest($im,0,0,0);
        imagecolorset($im,$index,100,0,0);  //reddish color
        $imgres = 'Tanzania-modified.png';
        //header('Content-type: image/png');
        imagepng($im,$imgres); imagedestroy($im);

        $file = fopen(('http://192.241.188.72/public/images/banner/RPC-Banner.png'), 'r');
        // $size = filesize('http://192.241.188.72/public/images/banner/RPC-Banner.png');
        $dropboxFileName = '/myphoto4.png';


        $data=$Client->uploadFile($dropboxFileName,WriteMode::add(),$file,222);
        dd($data);
        die;
        $links['share'] = $Client->createShareableLink($dropboxFileName);
        $links['view'] = $Client->createTemporaryDirectLink($dropboxFileName);


        print_r($links);
    }

    public function shirtColor($id)
    {
        header('Content-Type: image/png');

        /* RGB of your inside color */
        $rgb = array(0,0,$id);
        /* Your file */
        $file="https://t-shirts.pk/wp-content/uploads/2017/01/p5.png";

        /* Negative values, don't edit */
        $rgb = array(255-$rgb[0],255-$rgb[1],255-$rgb[2]);

        $im = imagecreatefrompng($file);

        imagefilter($im, IMG_FILTER_NEGATE);
        imagefilter($im, IMG_FILTER_COLORIZE, $rgb[0], $rgb[1], $rgb[2]);
        imagefilter($im, IMG_FILTER_NEGATE);

        imagealphablending( $im, false );
        imagesavealpha( $im, true );
        imagepng($im);
        imagedestroy($im);
        echo $im;
        die;
        $Client = new ClientDropbox('6FSiD5aWshAAAAAAAAAAXrvxsghKJRsg7JX44AcbiuvQsmFRRaw6_16KrXP3LYx0', '0ipp1g22795rr56');
        $imgfile = 'Tanzania.png';
        $im = imagecreatefrompng($imgfile);
        $index = imageColorclosest($im,0,0,0);
        imagecolorset($im,$index,100,0,0);  //reddish color
        $imgres = 'Tanzania-modified.png';
        //header('Content-type: image/png');
        imagepng($im,$imgres); imagedestroy($im);

        $file = fopen(('http://192.241.188.72/public/images/banner/RPC-Banner.png'), 'r');
        // $size = filesize('http://192.241.188.72/public/images/banner/RPC-Banner.png');
        $dropboxFileName = '/myphoto4.png';


        $data=$Client->uploadFile($dropboxFileName,WriteMode::add(),$file,222);
        dd($data);
        die;
        $links['share'] = $Client->createShareableLink($dropboxFileName);
        $links['view'] = $Client->createTemporaryDirectLink($dropboxFileName);


        print_r($links);
    }

    public function sendMessageToManDown(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('latitude' => 'required' , 'longitude' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails())
            {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }

            $user_contact_ids=UserManDownContacts::where('user_id',$user_id)->pluck('user_contact_id')->all();
            $user_contacts = UserContacts::whereIn('user_contact_id',$user_contact_ids)->get();
            $user_contacts_email = $user_contacts->pluck('email')->toArray();
            $user_contacts_number = $user_contacts->pluck('number');

            $user = User::where('user_id',$user_id)->first();
            $user_email = $user->email;
            $user_first_name = $user->first_name;
            $user_first_name = $user->latitude;
            $user_first_name = $user->first_name;
            array_push($user_contacts_email, $user_email);

            try {
                Mail::send([], [], function ($message) use ($user_contacts_email,$user_first_name) {
                    $url="https://www.google.com/maps/?q=-15.623037,18.388672";
                    $body = "Your friend, $user_first_name, has not moved for past few minutes. Please contact the person to make sure they are okay. View location Here: ".$url;
                    $message->to($user_contacts_email)->subject('iFollow | Your Friend Need Help')->setBody($body, 'text/html');
                });
            }catch (\Exception $e) {
                $exception_message = $e->getMessage();
            }


            $accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
            $authToken = '002a6ef044af01d69cb979eb4107b9fe';
            $twilioNumber = "+14359195249";
            foreach ($user_contacts_number as $user_number) {
                $url="https://www.google.com/maps/?q=-15.623037,18.388672";
                $client = new Client($accountSid, $authToken);
                $message = "Your friend, $user_first_name, has not moved for past few minutes. Please contact the person to make sure they are okay. View location Here: ".$url;

                try {
                    $client->messages->create(
                        '+'.$user_number,
                        [
                            "body" => $message,
                            "from" => $twilioNumber
                        ]
                    );

                } catch (TwilioException $e) {
                    //echo($e->getMessage());
                }

            }

            $response=apiHelper::success1('Send successfully!');
            return response()->json($response);
        }
        else
        {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }

    }

    public function getVideoUrlArchiveID(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('archive_id' => 'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails())
            {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }

            $url="https://s3-us-west-1.amazonaws.com/i-follow/46010562/$request->archive_id/archive.mp4";
            $handle = curl_init($url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            if($httpCode == 405 or $httpCode==404) {
                $archive_url='';
            }else{
                $archive_url=$url;
            }
            curl_close($handle);
            $data=array('url'=>$archive_url);
            $response=apiHelper::success('Get video url',$data);

            return response()->json($response);
        }
        else
        {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function checkArchiveId($archive_id)
    {

        $url="https://s3-us-west-1.amazonaws.com/i-follow/46010562/$archive_id/archive.mp4";
        $handle = curl_init($url);
        curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($handle);

        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        if($httpCode == 405 or $httpCode==404) {
            echo 'error';
        }else{
            echo 'success';
        }
        curl_close($handle);

    }

    public function showVideo($video_id)
    {
        $opentok_api = $this->opentok_api_key;
        $video = Videos::where('video_id',$video_id)->first();
        $user=Users::where('user_id',$video->user_id)->first();
        if($video->archive_id){
            $archive_id=$video->archive_id;
            $archive_url="https://s3-us-west-1.amazonaws.com/i-follow/46010562/$archive_id/archive.mp4";
            $handle = curl_init($archive_url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);
            if($video->is_image){
                return view('videos.show_image',compact('opentok_api','video','user'));
            }else{
                if($httpCode == 405 or $httpCode==404){
                    return view('videos.show_video',compact('opentok_api','video','user'));

                }else{
                    return view('videos.show_video_complete',compact('opentok_api','video','archive_url','user'));
                }
            }
            // return view('videos.show_video_complete',compact('opentok_api','video','archive_url','user'));
        }else{
            return view('videos.show_video',compact('opentok_api','video','user'));
        }
    }

    public function showVideoSafe($video_id)
    {

        $opentok_api = $this->opentok_api_key;
        $video = Videos::where('video_id',$video_id)->first();
        $user=Users::where('user_id',$video->user_id)->first();
        if($video->archive_id){
            $archive_id=$video->archive_id;
            $archive_url="https://s3-us-west-1.amazonaws.com/i-follow/46010562/$archive_id/archive.mp4";
            $handle = curl_init($archive_url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);


            if($httpCode == 405 or $httpCode==404){
                if($video->is_image){
                    return view('contact_center_2.video.show_image',compact('opentok_api','video','user'));
                }else{
                    return view('contact_center_2.video.show_video_safe',compact('opentok_api','video','user'));

                }
            }else{
                return view('contact_center_2.video.show_video_safe_complete',compact('opentok_api','video','archive_url','user'));
            }
            // return view('videos.show_video_complete',compact('opentok_api','video','archive_url','user'));
        }else{
            return view('contact_center_2.video.show_video_safe',compact('opentok_api','video','user'));
        }
    }

    public function showVideo2($video_id)
    {
        $opentok_api = $this->opentok_api_key;
        $video = Videos::where('video_id',$video_id)->first();
        $user=Users::where('user_id',$video->user_id)->first();
        if($video->archive_id){
            $archive_id=$video->archive_id;
            $archive_url="https://s3-us-west-1.amazonaws.com/i-follow/46010562/$archive_id/archive.mp4";
            $handle = curl_init($archive_url);
            curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            curl_close($handle);

            if($video->is_image){
                return view('video.show_image',compact('opentok_api','video','user'));
            }else{
                if($httpCode == 405 or $httpCode==404){
                    return view('video.show_video',compact('opentok_api','video','user'));

                }else{
                    return view('video.show_video_complete',compact('opentok_api','video','archive_url','user'));
                }
            }


            // return view('videos.show_video_complete',compact('opentok_api','video','archive_url','user'));
        }else{
            if($video->is_image){
                return view('videos.show_image',compact('opentok_api','video','user'));
            }else{
                return view('videos.show_video',compact('opentok_api','video','user'));
            }
        }
    }

    public function startArchive(Request $request)
    {
        $opentok = new OpenTok($this->opentok_api_key, $this->opentok_api_secret);
        $sessionId=$request->input('session_id');
        $archive = $opentok->startArchive($sessionId);
        // Store this archiveId in the database for later use
        $archiveId = $archive->id;
        $data=array('archive_id'=>$archiveId);
        return response()->json($data);
    }

    public function stopArchive(Request $request)
    {
        $opentok = new OpenTok($this->opentok_api_key, $this->opentok_api_secret);
        $archive_id=$request->input('archive_id');
        $opentok->stopArchive($archive_id);
        $data=array('msg'=>'success');
        return response()->json($data);
    }

    public function delete_notification(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) 
        {
            $rules=array('notification_id' => 'required');
            $validations= Validator::make($request->all(), $rules);
            if($validations->fails())
            {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $result = DeletedNotify::create(['user_id'=>$user_id,'notification_id'=>$request->notification_id]);
            if($result)
            {
                $data=apiHelper::success1('Deleted successfully');
                return response()->json($data);
            }else{
                $data=apiHelper::error('There is an issue while deleting');
                return response()->json($data);
            }

        }else{
             $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function upload()
    {
        foreach(array('video', 'audio') as $type) {
            if (isset($_FILES["${type}-blob"])) {

                $fileName = $_POST["${type}-filename"];
                $filename=uniqid();
                $filePath = 'Audios/' . $filename;
                $file_Path = 'Audios/' . $fileName;
                Storage::disk('s3')->put($file_Path,file_get_contents($_FILES["${type}-blob"]["tmp_name"]), 'public');

            }
        }
        echo 'success';
    }


    public function update_tip_message(Request $request){
            $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) {
            $rules = array('video_id'=>'required','message'=>'required');
            $validations = Validator::make($request->all(),$rules);
            if ($validations->fails())
            {
                $messages = $validations->messages();
                $data = apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
             $video = Videos::where('video_id',$request->video_id)->first();
            $video->message = $request->message;
            $save = $video->save();

            if ($save){
                $response=apiHelper::success('Updated successfully!',$video);
                return response()->json($response);
            }
            else {
                $response=apiHelper::error('Unknown Error');
                return response()->json($response,401);
            }

        }
        else
        {
            $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

    public function user_tip_delete(Request $request)
    {
        $user_id=$request->header('user-id');
        $auth_id=$request->header('auth-id');
        if(apiHelper::authenticate($user_id,$auth_id)) 
        {
            $rules=array('video_id' => 'required');
            $validations= Validator::make($request->all(), $rules);
            if($validations->fails())
            {
                $messages = $validations->messages();
                $data=apiHelper::validation_error('Validation errors',$messages);
                return response()->json($data,403);
            }
            $result = DeletedTip::create(['user_id'=>$user_id,'video_id'=>$request->video_id]);
            if($result)
            {
                $data=apiHelper::success1('Deleted successfully');
                return response()->json($data);
            }else{
                $data=apiHelper::error('There is an issue while deleting');
                return response()->json($data);
            }

        }else{
             $response=apiHelper::error('Unauthorized user');
            return response()->json($response,401);
        }
    }

}