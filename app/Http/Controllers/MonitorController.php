<?php

namespace App\Http\Controllers;

use App\ForgotPassword;
use App\Http\Controllers\Controller;
use App\Monitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Mail;

class MonitorController extends Controller
{
    //
    public function monitor_login(Request $request) {
		$email = $request->input('email');
		$password = $request->input('password');
		$password = md5($password);
		if ($user = Monitor::with('organizations.organization.time_zone', 'phone_code')->where('monitor_email', $email)->where('password', $password)->first()) {
			if ($user->status != 'enabled') {
				echo 'Your Account Has been Disabled By <b>Administration</b>. For further details contact with Authorities';
			} else {

				$data = $user->toArray();
				Session::push('monitor_admin', $data);

				echo 'login successful';
			}
		} else {
			echo 'Invalid credentials';
		}
	}

	public function logout(Request $request){
		$request->session()->forget('monitor_admin');
	}
	public function monitor_forget(Request $request) {
		$exists = Monitor::where('monitor_email', $request->email)->first();
		if (!$exists) {
			die("email doesn't exists OR invalid email given");

		}

		$monitor = Monitor::where('monitor_email', $request->email)->first();
		$token = uniqid();
		ForgotPassword::where('email', $monitor->monitor_email)->delete();
		$forgot = new ForgotPassword;
		$forgot->email = $monitor->monitor_email;
		$forgot->token = $token;
		$forgot->save();

		Mail::send([], [], function ($message) use ($monitor, $token) {

			$body = "<h1>Hello " . $monitor->monitor_name . "! </h1>";
			$body .= "<p>
                       We Have received your request to reset the password for your AgentSafeWalk Monitor-Hub account. If you did-not request this change, please contact your AgentSafeWalk rep immediately. Otherwise: Please click the following link to securely reset your password.
                       </p>";
			$body .= "<strong>click here:</strong>" . url('monitor-hub/password/change') . '/' . $token;
			$body .= "<br><strong>Do not reply to this email. It has been automatically generated.<strong>";

			$message->to($monitor->monitor_email)->subject('AgentSafeWalk | Forget Password Verification')->setBody($body, 'text/html');
		});
		$request->session()->flash('success', 'password Verification Link has been sent to your email address kindly. check it out & change the password safely...');
		return response()->json(['response' => 'success']);

	}
public function change_password_monitor(Request $request) {

		$requested_by = ForgotPassword::where('token', $request->token)->first();
		$monitor = Monitor::where('monitor_email', $requested_by->email)->first();
		$monitor->password = md5($request->input('password'));

		$save = $monitor->save();
		if ($save) {
			ForgotPassword::where('email', $monitor->email)->delete();
			$request->session()->flash('success', 'Password Changed Successfully...');
			return response()->json(['response' => 'success']);
		} else {
			$request->session()->flash('error', 'there is an issue while changing password try with new request');
			return response()->json(['response' => 'unsuccess']);
		}

	}
	public function password_change_view(Request $request, $token) {
		$requested_by = ForgotPassword::where('token', $token)->exists();
		if (!$requested_by) {
			$request->session()->flash('error', 'Request Timeout! verification link has been expired make a new request');
			return redirect('/monitor-hub');
		}
		return view('monitor.password_change', ['token' => $token]);
	}
}
