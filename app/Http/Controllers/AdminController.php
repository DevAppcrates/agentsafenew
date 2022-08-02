<?php

namespace App\Http\Controllers;
use App\Admin;
use App\Codes;
use App\Countries;
use App\Days;
use App\ForgotPassword;
use App\GroupMembers;
use App\Groups;
use App\Monitor;
use App\MonitorOrganization;
use App\Organizations;
use App\Rules\FridayCloseTime;
use App\Rules\FridayStartTime;
use App\Rules\MondayCloseTime;
use App\Rules\MondayStartTime;
use App\Rules\PublishDateValidate;
use App\Rules\PublishHourValidate;
use App\Rules\SaturdayCloseTime;
use App\Rules\SaturdayStartTime;
use App\Rules\SundayCloseTime;
use App\Rules\SundayStartTime;
use App\Rules\ThursdayCloseTime;
use App\Rules\ThursdayStartTime;
use App\Rules\TuesdayCloseTime;
use App\Rules\TuesdayStartTime;
use App\Rules\WednesdayCloseTime;
use App\Rules\WednesdayStartTime;
use App\Schedule;
use App\TimeZone;
use App\UserAddress;
use App\UserEmergencyContacts;
use App\UserMedicalInfo;
use App\Users;
use App\VideoLocationTracking;
use App\Videos;
use Illuminate\Http\Request;
use Mail;
use Ramsey\Uuid\Uuid;
use Session;
use \DateTime;
use \DateTimeZone;
class AdminController extends Controller
{
    public function admin_login(Request $request)
    {
        $email=$request->input('email');
        $password=$request->input('password');
        $password=md5($password);

        if($user=Admin::where('email',$email)->where('password',$password)->first()) {
            if($user->status != 'enabled' && $user->user_type == 2){
                echo 'Your Account Has been Disabled By <b>Administration</b>. For further details contact with your <b>Authorities</b>';
            }else{
                $data = $user->toArray();
                Session::push('admin', $data);
                echo 'login successful';
            }
        }else{
            echo 'Invalid credentials';
        }
    }

    public function add_admin(Request $request)
    {
        $name=$request->input('name');
        $email=$request->input('email');
        $password=$request->input('password');
        $password=md5($password);

        if(Admin::where('email',$email)->exists()) {
            echo 'Account already exists';
        }else{
            $admin=new Admin();
            $admin->name=$name;
            $admin->email=$email;
            $admin->password=$password;
            $admin->user_type=2;
            $admin->save();
            echo 'Added successfully!';
        }
    }

    public function add_organization(Request $request)
    {
        $user_name=$request->input('user_name');
        $name=$request->input('name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $code=$request->input('code');
        $address=$request->input('address');
        $additional_detail = $request->input('additional_detail');
        $password=md5($request->input('password'));
        if(Organizations::where('code',$code)->orWhere('email',$email)->first()){
            echo 'Code/Email already exists';
        }else{
            $phone_codes = Countries::where('id',$request->phone_code)->first(['phone_code']);
            $organization=new Organizations();
            $organization->organization_id=uniqid();
            $organization->organization_name=$name;
            $organization->name=$user_name;
            $organization->email=$email;

            $organization->phone_number= '+'.$phone_codes->phone_code.$phone;
            $organization->password=$password;
            $organization->code=$code;
            $organization->timezone_id = $request->time_zone;
            $organization->address=$address;
            $organization->no_of_users=$request->no_of_users;
            $organization->additional_detail = $additional_detail;
            $organization->country_id = $request->phone_code;
            $arr = [];
            if($request->has('additional_fields'))
            {
                foreach ($request->additional_fields as $key => $value)
                {
                    if(empty($value))
                    {
                        unset($key);
                    }else
                    {
                        $arr[] = $value;
                    }

                }
            }
            if(count($arr) > 0)
            {
                $organization->additional_fields  = $arr;
            }
            $save=$organization->save();
            if($save){
                $group = new Groups;
                $group->organization_id = $organization->organization_id;
                $group->title = 'Invited Users';
                $group->status = 1;
                $group->is_default = 1;
                $timezone = TimeZone::find($request->time_zone);
                ini_set('date.timezone',$timezone['timezone_code']);
                $current_time = new DateTime('now',new DateTimeZone($timezone['timezone_code']));
                $group->created_at =  $current_time;
                $group->save();
                $groups = new Groups;
                $groups->organization_id = $organization->organization_id;
                $groups->title = 'App Users';
                $groups->status = 1;

                $groups->created_at =  $current_time;
                $groups->is_default = 1;
                $groups->save();
                $admin_id=$organization->id;
                $this->set_schedule($admin_id,$organization->organization_id);
                echo 'success';
            }else{
                echo 'An error occurred during adding contact center,please try again';
            }
        }
    }

    public function edit_organization(Request $request)
    {
        $id=$request->input('id');
        $name=$request->input('name');
        $user_name=$request->input('user_name');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $additional_detail = $request->input('additional_detail');
        $organization=Organizations::where('id',$id)->first();
        if(Organizations::where('id','!=',$id)->where('email',$request->email)->count() == 1){
            return  'email address already exists';
        }
        $phone_codes = Countries::where('id',$request->phone_code)->first(['phone_code']);
        $organization->organization_name=$name;
        $organization->email = $request->email;
        $organization->name=$user_name;
        $organization->timezone_id = $request->time_zone;
        $organization->phone_number= '+'.$phone_codes->phone_code.$phone;
        $organization->address=$address;
        $organization->additional_detail = $additional_detail;
        $arr = [];
        $organization->no_of_users=$request->no_of_users;
        $organization->country_id = $request->phone_code;

        if($request->has('additional_fields'))
        {
            foreach ($request->additional_fields as $key => $value)
            {
                if(empty($value))
                {
                    unset($key);
                }else
                {
                    $arr[] = $value;
                }

            }
        }
        if(count($arr) > 0)
        {
            $organization->additional_fields  = $arr;
        }else{
            $organization->additional_fields  = NULL;
        }
        $save=$organization->save();

        if($save){
            Organizations::where('organization_id',$organization->organization_id)->update(['timezone_id'=>$request->time_zone]);
            echo 'success';
        }else{
            echo 'An error occurred during adding contact center,please try again';
        }
    }

    public function monitors()
    {
        $monitors=Monitor::with('organizations.organization','phone_code')->orderBy('id','desc')->get();
        return view('monitors.monitors',["monitors"=>$monitors]);
    }

    public function add_monitor(Request $request)
    {
        $user_name=$request->input('user_name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $additional_detail = $request->input('additional_detail');
        $password=md5($request->input('password'));
        if(Monitor::where('monitor_email',$email)->first()){
            echo 'Email already exists';
        }else{
            $phone_codes = Countries::where('id',$request->phone_code)->first(['phone_code']);
            $monitor = new Monitor();
            $monitor->monitor_id=uniqid();
            $monitor->monitor_name = $user_name;
            $monitor->monitor_email = $email;

            $monitor->phone_number= '+'.$phone_codes->phone_code.$phone;
            $monitor->password=$password;
            $monitor->address=$address;
            $monitor->additional_detail = $additional_detail;
            $monitor->country_id = $request->phone_code;
            $arr = [];
            if($request->has('additional_fields'))
            {
                foreach ($request->additional_fields as $key => $value)
                {
                    if(empty($value))
                    {
                        unset($key);
                    }else
                    {
                        $arr[] = $value;
                    }

                }
            }
            if(count($arr) > 0)
            {
                $monitor->additional_fields  = $arr;
            }
            $save=$monitor->save();
            if($save){
                if(count($request->contact_centers) > 0){
                    foreach ($request->contact_centers as $key => $cc) {
                        $monitoringOrg = new MonitorOrganization;
                        $monitoringOrg->monitor_id = $monitor->monitor_id;
                        $monitoringOrg->organization_id = $cc;
                        $monitoringOrg->save();
                    }
                }
                echo 'success';
            }else{
                echo 'An error occurred during adding Monitor,please try again';
            }
        }
    }

    public function edit_monitor(Request $request)
    {
        $user_name=$request->input('user_name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $additional_detail = $request->input('additional_detail');
        $password=md5($request->input('password'));
        if(Monitor::where('monitor_email',$email)->where('id','!=',$request->id)->first()){
            echo 'Email already exists';
        }else{
            $phone_codes = Countries::where('id',$request->phone_code)->first(['phone_code']);
            $monitor = Monitor::find($request->id);
            $monitor->monitor_name = $user_name;
            $monitor->monitor_email = $email;

            $monitor->phone_number= '+'.$phone_codes->phone_code.$phone;
            $monitor->address=$address;
            $monitor->additional_detail = $additional_detail;
            $monitor->country_id = $request->phone_code;
            $arr = [];
            if($request->has('additional_fields'))
            {
                foreach ($request->additional_fields as $key => $value)
                {
                    if(empty($value))
                    {
                        unset($key);
                    }else
                    {
                        $arr[] = $value;
                    }

                }
            }
            if(count($arr) > 0)
            {
                $monitor->additional_fields  = $arr;
            }
            $save=$monitor->save();
            if($save){
                if(count($request->contact_centers) > 0){
                    MonitorOrganization::where('monitor_id',$monitor->monitor_id)->delete();
                    foreach ($request->contact_centers as $key => $cc) {
                        $monitoringOrg = new MonitorOrganization;
                        $monitoringOrg->monitor_id = $monitor->monitor_id;
                        $monitoringOrg->organization_id = $cc;
                        $monitoringOrg->save();
                    }
                }
                echo 'success';
            }else{
                echo 'An error occurred during adding Monitor,please try again';
            }
        }
    }

    public function delete_monitor(Request $request){
        Monitor::find($request->id)->delete();
    }

    public function change_password(Request $request)
    {
        if (Session::has('admin')) {
            $user = Session::get('admin');
            $email=$user[0]['email'];
            $password=$request->input('old_password');
            $password=md5($password);
            if($user=Admin::where('email',$email)->where('password',$password)->first()) {
                $user->password=md5($request->new_password);
                $user->save();
                echo 'success';
            }else{
                echo 'You have entered an incorrect old password';
            }
        }
    }

    public function add_code(Request $request)
    {
        $name=$request->input('name');
        $code=$request->input('code');

        if(Codes::where('code',$code)->exists()) {
            echo 'Code already exists';
        }else{
            $codes=new Codes();
            $codes->organization_name=$name;
            $codes->code=$code;
            $codes->user_type=2;
            $codes->save();
            echo 'Added successfully!';
        }
    }


    public function users(Request $request)
    {
        $type=$request->input('type');
        if(empty($type)){
            $type='first_name';
        }
        $search=$request->input('search','');
        $s_date=$request->input('s_date');
        $e_date=$request->input('e_date');
        $data=array('type'=>$type,'search'=>$search,'s_date'=>$s_date,'e_date'=>$e_date);

        if(empty($s_date)){
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->paginate(20);
        }else{
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->whereBetween('created_at', array($s_date, $e_date))
                ->paginate(20);

        }
        return view('users.users',["users"=>$users,'data'=>$data]);
    }

    public function user_status($id)
    {
        $user=Users::where('user_id',$id)->first();
        if($user->status=='enabled'){
            $user->status='disabled';
        }else{
            $user->status='enabled';
        }
        $user->save();
    }

    public function organization()
    {
        $users=Organizations::where('type',1)->orderBy('id','desc')->get();
        return view('members.members',["users"=>$users]);
    }
    public function organization_detail($org_id)
    {
        $contact_detail =  Organizations::with('time_zone','country')->where('organization_id',$org_id)->where('type',1)->first();
        $subAdmins = Organizations::with('schedule.days','schedule.start_time','schedule.close_time')->where('organization_id',$contact_detail->organization_id)->whereIn('type',[3,2])->get();
        $users = Users::where('organization_id',$contact_detail->organization_id)->get();
        $users = Users::where('organization_id',$contact_detail->organization_id)->get();

        return view('members.organization-detail')->with(['admins'=>$subAdmins,'contact_detail'=>$contact_detail,"users"=>$users]);
    }

    public function change_organization_status(Request $request){
        $org = Organizations::find($request->id);
        if($org->status == 'enabled')
        {
            $org->status = 'disabled';
        }else
        {

            $org->status = 'enabled';
        }
        $org->save();
        return $org;
    }

    public function change_user_status(Request $request)
    {
        $user = Users::find($request->id);
        if($user->status == 'enabled'):
            $user->status = 'disabled';
        else:
            $user->status = 'enabled';
        endif;
        $user->save();
        return $user;
    }
    public function change_admin_status_for_master_control_center(Request $request)
    {
        $user = Admin::find($request->id);
        if($user->status == 'enabled'):
            $user->status = 'disabled';
        else:
            $user->status = 'enabled';
        endif;
        $user->save();
        return $user;
    }
    public function add_admin_for_contact_center(Request $request)
    {
        $name=$request->input('name');
        $email=$request->input('email');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $additional_detail = $request->input('additional_detail');
        $password=md5($request->input('password'));
        $arr = [];
        if(Organizations::where('email',$email)->first()){
            echo 'Email already exists';
        }else{

            $code = Organizations::with('time_zone')->where('organization_id',$request->organization_id)->where('type',1)->first();
            ini_set('date.timezone',$code['time_zone']['timezone_code']);
            $phone_codes = Countries::where('id',$code->country_id)->first(['phone_code']);
            $organization=new Organizations();
            $organization->organization_id=$request->organization_id;
            $organization->organization_name=$code->organization_name;
            $organization->name=$name;
            $organization->email=$email;
            $organization->phone_number= '+'.$phone_codes->phone_code.$phone;
            $organization->password=$password;
            $organization->code=$code->code;
            $organization->address=$address;
            $organization->type = 3;
            $organization->timezone_id = $code->timezone_id;
            $organization->country_id = $code->country_id;
            $organization->created_at = date('Y-m-d G:i:s',time());
            $organization->additional_detail = $additional_detail;
            if($request->has('additional_fields'))
            {
                foreach ($request->additional_fields as $key => $value) {
                    if(empty($value))
                    {
                        unset($key);
                    }else
                    {
                        $arr[] = $value;
                    }

                }
                if(count($arr) > 0)
                {
                    $organization->additional_fields  = $arr;
                }

            }
            $save=$organization->save();
            if($save){
                $admin_id=$organization->id;
                $this->set_schedule($admin_id,$request->organization_id);
                echo 'success';
            }else{
                echo 'An error occurred during adding contact center,please try again';
            }
        }
    }

    public function set_schedule($admin_id,$organization_id)
    {
        for ($i=1;$i<=7;$i++){
            $schedule=new Schedule();
            $schedule->day_id=$i;
            $schedule->admin_id=$admin_id;
            $schedule->organization_id=$organization_id;
            $schedule->status='active';
            $schedule->open_time=23;
            $schedule->open_time_format='am';
            $schedule->close_time=22;
            $schedule->close_time_format='pm';
            $schedule->save();
        }
    }

    public function get_additional_field_for_edit_display(Request $request)
    {
        // function for showing dynamic additional field if added for admin
        return Organizations::find($request->id);
    }
    public function edit_admin_for_contact_center(Request $request)
    {
        $arr = [];
        $name=$request->input('name');
        $id=$request->input('id');
        $phone=$request->input('phone');
        $address=$request->input('address');
        $organization=Organizations::where('id',$id)->first();
        $org = Organizations::where('organization_id',$organization->organization_id)->first(['country_id']);
        if(count($org) == 0)
        {
            echo 'please set Country code of Contact Center First';
            die;
        }
        $phone_codes = Countries::where('id',$org->country_id)->first(['phone_code']);
        $organization->name=$name;
        $organization->phone_number= '+'.$phone_codes->phone_code.$phone;
        $organization->address=$address;
        if($request->has('additional_fields'))
        {
            foreach ($request->additional_fields as $key => $value) {
                if(empty($value))
                {
                    unset($key);
                }else
                {
                    $arr[] = $value;
                }

            }
            if(count($arr) > 0)
            {
                $organization->additional_fields  = $arr;
            }else
            {

                $organization->additional_fields  = NULL;
            }

        }
        $save=$organization->save();
        if($save)
        {
            echo 'success';
        }else
        {
            echo 'An error occurred during adding contact center,please try again';
        }
    }

    public function delete_admin_for_contact_center(Request $request)
    {
        $result =  Organizations::find($request->id)->delete();
        $result =  Schedule::where('admin_id',$request->id)->delete();
        if($result)
        {
            return response()->json(['response'=>'success']);
        }else
        {
            return response()->json(['response'=>'not succeeded']);
        }
    }
    public function delete_admin_for_master_control_center(Request $request)
    {
        $result =  Admin::find($request->id)->delete();
        if($result)
        {
            return response()->json(['response'=>'success']);
        }else
        {
            return response()->json(['response'=>'not succeeded']);
        }

    }
    public function enabled_users(Request $request)
    {
        $type=$request->input('type');
        if(empty($type)){
            $type='first_name';
        }
        $search=$request->input('search','');
        $s_date=$request->input('s_date');
        $e_date=$request->input('e_date');
        $data=array('type'=>$type,'search'=>$search,'s_date'=>$s_date,'e_date'=>$e_date);

        if(empty($s_date)){
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->where('status','enabled')->paginate(20);
        }else{
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->where('status','enabled')->whereBetween('created_at', array($s_date, $e_date))
                ->paginate(20);

        }
        return view('users.users',["users"=>$users,'data'=>$data]);

    }

    public function disabled_users(Request $request)
    {
        $type=$request->input('type');
        if(empty($type)){
            $type='first_name';
        }
        $search=$request->input('search','');
        $s_date=$request->input('s_date');
        $e_date=$request->input('e_date');
        $data=array('type'=>$type,'search'=>$search,'s_date'=>$s_date,'e_date'=>$e_date);

        if(empty($s_date)){
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->where('status','disabled')->paginate(20);
        }else{
            $users=Users::with('organization')->where($type,'like', '%' . $search . '%')
                ->where('status','disabled')->whereBetween('created_at', array($s_date, $e_date))
                ->paginate(20);

        }
        return view('users.users',["users"=>$users,'data'=>$data]);
    }

    public function codes()
    {
        $codes=Codes::where('user_type',2)->get();
        return view('codes.codes',["codes"=>$codes]);
    }

    public function active_codes()
    {
        $codes=Codes::where('user_type',2)->where('status',1)->get();
        return view('codes.codes',["codes"=>$codes]);
    }

    public function in_active_codes()
    {
        $codes=Codes::where('user_type',2)->where('status',0)->get();
        return view('codes.codes',["codes"=>$codes]);
    }

    public function administrators()
    {
        $admins=Admin::where('user_type',2)->orderBy('id','desc')->get();
        return view('administrators.administrators',["admins"=>$admins]);
    }

    public function logout()
    {
        Session::flush('admin');
        Session::flush('contact_center_admin');
        return redirect();
    }
    public function delete_cc(Request $request)
    {

        $users = Users::where('organization_id',$request->org_id)->get()->pluck('user_id');
        $panic = Videos::WhereIn('user_id',$users)->forceDelete();
        VideoLocationTracking::WhereIn('user_id',$users)->delete();
        GroupMembers::WhereIn('user_id',$users)->delete();
        Groups::where('organization_id',$request->org_id)->delete();
        UserMedicalInfo::WhereIn('user_id',$users)->delete();
        UserEmergencyContacts::WhereIn('user_id',$users)->delete();
        UserAddress::WhereIn('user_id',$users)->delete();
        Users::whereIn('user_id',$users)->delete();
        $orgs = Organizations::where('organization_id',$request->org_id)->pluck('id')->all();
        Schedule::whereIn('admin_id',$orgs)->delete();
        $result = Organizations::where('organization_id',$request->org_id)->delete();

    }
    public function cc_admin_note(Request $request)
    {
        $id=$request->input('id');
        $notes=$request->input('notes');
        $user= Organizations::where('id',$id)->first();
        // dd($user);
        $user->notes=str_replace("'","",$notes);
        $user->save();
    }

    public function monitor_note(Request $request)
    {
        $id=$request->input('note_id');
        $notes=$request->input('notes');
        $monitor= Monitor::where('id',$id)->first();
        // dd($monitor);
        $monitor->notes=str_replace("'","",$notes);
        $monitor->save();
    }
    public function cc_user_note(Request $request)
    {
        $id=$request->input('note_id');
        $notes=$request->input('notes');
        $user= Users::where('id',$id)->first();
        // dd($user);
        $user->notes=str_replace("'","",$notes);
        $user->save();
    }

    public function edit_admin_schedule(Request $request)
    {
        $request->validate([
            'monday_start_time' =>   [new MondayStartTime($request->monday_status)],
            'monday_close_time' =>   [new MondayCloseTime($request->monday_status)],
            'tuesday_start_time' =>  [new TuesdayStartTime($request->tuesday_status)],
            'tuesday_close_time'=>   [new TuesdayCloseTime($request->tuesday_status)],
            'wednesday_start_time'=> [new WednesdayStartTime($request->wednesday_status)],
            'wednesday_close_time'=> [new WednesdayCloseTime($request->wednesday_status)],
            'thursday_start_time' => [new ThursdayStartTime($request->thursday_status)],
            'thursday_close_time'=>  [new ThursdayCloseTime($request->thursday_status)],
            'friday_start_time' =>   [new FridayStartTime($request->friday_status)],
            'friday_close_time' =>   [new FridayCloseTime($request->friday_status)],
            'saturday_start_time' => [new SaturdayStartTime($request->saturday_status)],
            'saturday_close_time'=>  [new SaturdayCloseTime($request->saturday_status)],
            'sunday_start_time' =>   [new sundayStartTime($request->sunday_status)],
            'sunday_close_time'=>    [new SundayCloseTime($request->sunday_status)],
        ]);
        // dd($request->all());
        $days = Days::all()->toArray();

        foreach ($days as $day)
        {
            $day_name = strtolower($day['name']);
            // $request->get('admin_id');
            if($request->get($day_name.'_status') == 'active'):
                $org = Organizations::find($request->get('admin_id'));
                $schedule =  Schedule::updateOrCreate(['admin_id'=>$request->get('admin_id'),'organization_id'=>$org->organization_id,'day_id'=>$day['id']],['open_time'=>$request->get($day_name.'_start_time'),'open_time_format'=>$request->get($day_name.'_start_time_am_pm'),'close_time'=>$request->get($day_name.'_close_time'),'close_time_format'=>$request->get($day_name.'_close_time_am_pm'),'status'=>$request->get($day_name.'_status')]);
            else:
                $schedule =  Schedule::updateOrCreate(['admin_id'=>$request->admin_id,'day_id'=>$day['id']],['status'=>$request->get($day_name.'_status')]);
            endif;
        }
    }



     public function master_hub_forget(Request $request)
    {
            $exists = Admin::where('email',$request->email)->first();
            if(!$exists)
            {
                die("email doesn't exists OR invalid email given");

            }
           
            $organization = Admin::where('email',$request->email)->first();
           $token =  uniqid();
           ForgotPassword::where('email',$organization->email)->delete();
           $forgot = new ForgotPassword;
           $forgot->email = $organization->email;
           $forgot->token = $token;
           $forgot->save();
            Mail::send([], [], function ($message) use ($organization,$token) {
                       $body = "<h1>Hello ".$organization->name."! </h1>";
                       $body .= "<p>
                       We Have received your request to reset the password for your iFollow Master-hub account. If you did-not request this change, please contact your iFollow rep immediately. Otherwise: Please click the following link to securely reset your password.
                       </p>";
                       $body .= "<strong>click here:</strong>".url('master-hub/password/change').'/'.$token;
                       $body .= "<br><strong>Do not reply to this email. It has been automatically generated.<strong>";


                       $message->to($organization->email)->subject('Ifollow | Forget Password Verification')->setBody($body, 'text/html');
                   });
            $request->session()->flash('success', 'password Verification Link has been sent to your email address kindly. check it out & change the password safely...');
            return response()->json(['response'=>'success']);

    }

    public function password_change_view(Request $request,$token){

            $requested_by = ForgotPassword::where('token',$token)->exists();
            if(!$requested_by)
            {
            $request->session()->flash('error', 'Request Timeout! verification link has been expired make a new request');
                 return redirect('/');
            }
            return view('password_change',['token'=>$token]);
    }

    public function change_password_master_hub(Request $request){

       $requested_by = ForgotPassword::where('token',$request->token)->first();
       $org = Admin::where('email',$requested_by->email)->first();
       $org->password = md5($request->input('password'));
       
       $save = $org->save();
           if($save)
           {
            ForgotPassword::where('email',$org->email)->delete();
            $request->session()->flash('success', 'Password Changed Successfully...');
           return response()->json(['response'=>'success']);
           }else
           {
             $request->session()->flash('error', 'there is an issue while changing password try with new request');
           return response()->json(['response'=>'unsuccess']);
           }
       
    }
}
