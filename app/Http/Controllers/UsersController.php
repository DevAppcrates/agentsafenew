<?php

namespace App\Http\Controllers;

use App\ForgotPassword;
use App\GroupMembers;
use App\Groups;
use App\Helpers\apiHelper;
use App\Invitees;
use App\Notifications;
use App\NotificationUserStatus;
use App\Organizations;
use App\TagMembers;
use App\TimeZone;
use App\UserAddress;
use App\UserEmergencyContacts;
use App\UserMedicalInfo;
use App\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Mail;
use Ramsey\Uuid\Uuid;
use Validator;
use \DateTime;
use \DateTimeZone;

define('Member', '1');
define('Owner', '2');

class UsersController extends Controller {
	public function register(Request $request) {
		$rules = array('first_name' => 'required', 'last_name' => 'required', 'email' => 'required', 'password' => 'required', 'code' => 'required', 'country_code' => 'required', 'phone_number' => 'required|max:10');
		$validations = Validator::make($request->all(), $rules);
		if ($validations->fails()) {
			$messages = $validations->messages();
			$data = apiHelper::validation_error('Validation errors', $messages);
			return response()->json($data, 403);
		}

		if ($organization = Organizations::with('time_zone')->where('code', $request->code)->where('type', 1)->first()) {

			ini_set('date.timezone', $organization['time_zone']['timezone_code']);

			if ($organization->status == 'disabled'):
				$data = apiHelper::error('sorry for inconvenience ' . $organization->organization_name . ' has been disabled by the ThemeParkAlert Authorities.');
				return response()->json($data, 401);
			endif;
			$invite_count = Invitees::where('organization_id', $organization->organization_id)->count();

			$user_id = Uuid::uuid1();

			$organization_id = $organization->organization_id;
			$organization_name = $organization->organization_name;
			$limit_users = $organization->no_of_users;
			$organization_users = Users::where('organization_id', $organization_id)->count();
			$sum = $invite_count + $organization_users;

			if ($sum >= $limit_users) {
				$data = apiHelper::error('We can not process your request at this time. Please contact your organization, and reference "error 343".');
				return response()->json($data);
			} elseif ($id = Invitees::where('organization_id', $organization->organization_id)->where('email', $request->email)->pluck('id')->first()) {
				$data = array('user_id' => $user_id, 'type' => 1);
				// GroupMembers::where('user_id', $id)->update($data);
				if ($d = GroupMembers::where('user_id', $id)->first()) {
					$d->user_id = $user_id;
					$d->type = 1;
					$d->save();

				}
				// TagMembers::where('user_id', $id)->update($data);
				if ($t = TagMembers::where('user_id', $id)->first()) {
					$t->user_id = $user_id;
					$t->type = 1;
					$t->save();
				}

				Invitees::where('organization_id', $organization->organization_id)->where('email', $request->email)->delete();
				$is_invited = true;
			} else {

				$is_invited = false;
			}

			if (Users::where('email', $request->email)->exists()) {
				$data = apiHelper::error('Email already exists');
				return response()->json($data);
			}
		} else {
			$data = apiHelper::error('You have entered an invalid code');
			return response()->json($data);
		}

		$user = new Users();
		$user->user_id = $user_id;
		$user->organization_id = $organization_id;
		$user->auth_id = hash('sha256', time());
		$user->email = $request->email;
		$user->password = bcrypt($request->password);
		$user->device_token = $request->device_token;
		$user->first_name = $request->first_name;
		$user->is_invited = $is_invited;
		$user->last_name = $request->last_name;
		$user->date_of_birth = $request->date_of_birth;
		$user->school_name = $organization_name;
		$user->school_name = $organization_name;
		$user->country_code = $request->country_code;
		$user->phone_number = $request->phone_number;
		$current_time = new DateTime('now', new DateTimeZone($organization['time_zone']['timezone_code']));
		$user->created_at = $current_time;
		// $user->created_at = date('Y-m-d G:i:s',time());
		if ($request->display_picture) {

			// $source = fopen($request->display_picture, 'r');
			// $path = 'public/images/user/' . uniqid() . '.png';
			// $destination = fopen($path, 'w');
			// stream_copy_to_stream($source, $destination);
			// fclose($source);
			// fclose($destination);

			list($baseType, $img) = explode(';', $request->display_picture);
			list(, $img) = explode(',', $img);
			$img = base64_decode($img);
			// dd();
			$path = 'public/images/user/' . uniqid() . '.png';

			$fileStream = fopen($path, "wb");

			fwrite($fileStream, $img);
			fclose($fileStream);
			// $img_url = url('/') . '/' . $path;

			$user->display_picture = url('/') . '/' . $path;
		} else {
			$user->display_picture = 'http://18.216.155.238/ThemeParkAlert_Backend/public/uploads/userdp/default-dp.jpg';
		}
		$save = $user->save();
		//$save = true;
		if ($save) {
			$user_address = new UserAddress();
			$user_address->user_id = $user->user_id;
			$user_address->save();
			$user_medical_info = new UserMedicalInfo();
			$user_medical_info->user_id = $user->user_id;
			$user_medical_info->save();

			$app_group = Groups::where('title', 'App Users')->where('organization_id', $user->organization_id)->first();
			if ($app_group) {
				GroupMembers::create(['user_id' => $user_id, 'group_id' => $app_group->id, 'created_at' => $current_time]);
			}
			$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts', 'organization')->where('user_id', $user_id)->first();
			$data = apiHelper::success('Registration Successful', $user);
			return response()->json($data);
		} else {
			$data = apiHelper::error('An error occurred while registering the user, please try again');
			return response()->json($data, 403);
		}
	}

	public function login(Request $request) {
		$rules = array('email' => 'required', 'password' => 'required');
		$validations = Validator::make($request->all(), $rules);
		if ($validations->fails()) {
			$messages = $validations->messages();
			$data = apiHelper::validation_error('Validation errors', $messages);
			return response()->json($data, 403);
		}
		$password = $request->password;

		if ($user = Users::where('email', $request->email)->first()) {
			$org = Organizations::with('time_zone')->where('organization_id', $user->organization_id)->first();
			date_default_timezone_set($org['time_zone']['timezone_code']);
			if ($org->status == 'disabled'):
				$data = apiHelper::error("sorry for inconvenience " . $org->organization_name . ' has been disabled by the ThemeParkAlert Authorities.');
				return response()->json($data);
			endif;
			$hashed_password = $user->password;
			if (Hash::check($password, $hashed_password)) {
				$user->auth_id = hash('sha256', time());
				$user->save();
				if ($user->status == 'disabled') {
					$data = apiHelper::error('You Are Not Authorized To Use This Program Please contact the administrator of your program');
					return response()->json($data, 409);
				}
				$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts', 'organization')->where('user_id', $user->user_id)->first();
				$response = apiHelper::success('Login successfully', $user);
				return response()->json($response);

			} else {
				$data = apiHelper::error('Invalid Credentials');
				return response()->json($data, 409);
			}
		} else {
			$data = apiHelper::error('Invalid Credentials');
			return response()->json($data, 409);
		}
	}

	public function forgot_password(Request $request) {
		$rules = array('email' => 'required');
		$validations = Validator::make($request->all(), $rules);
		if ($validations->fails()) {
			$messages = $validations->messages();
			$data = apiHelper::validation_error('Validation errors', $messages);
			return response()->json($data, 403); // Status code 403 shows Validation error
		}
		$email = $request->email;
		if ($user = Users::where('email', $email)->first()) {
			ForgotPassword::where('email', $email)->delete();

			Mail::send([], [], function ($message) use ($email) {
				$verifyCode = mt_rand(1000, 9999);
				$body = "<h1>Hi, </h1>";
				$body .= "<p>
               We Have received your request to reset your password for your ThemeParkAlert Alert App. If you did-not request this change, please contact your administrator immediately. Otherwise please enter the following 4 digit code where indicated on your app screen and proceed in resetting your password.
               </p>";
				$body .= '<span>Your 4 digit verification code is:</span>';
				$body .= '<strong>' . $verifyCode . '</strong>';
				$body .= "<br><strong>Do not reply to this email. It has been automatically generated.<strong>";
				$fPass = new Forgotpassword;
				$fPass->email = $email;
				$fPass->token = $verifyCode;
				$fPass->save();
				$message->to($email)->subject('ThemeParkAlert | Forgot Password')->setBody($body, 'text/html');
			});
			$data = apiHelper::success1('A verification code has been sent to your registered email address');
			return response()->json($data);
		} else {
			$response = apiHelper::error("An account doesn't exist with this email address");
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function verify_code(Request $request) {
		$rules = array('email' => 'required', 'code' => 'required', 'password' => 'required');
		$validations = Validator::make($request->all(), $rules);
		if ($validations->fails()) {
			$messages = $validations->messages();
			$data = apiHelper::validation_error('Validation errors', $messages);
			return response()->json($data, 403); // Status code 403 shows Validation error
		}

		if (ForgotPassword::where('email', $request->email)->where('token', $request->code)->first()) {
			if ($user = Users::where('email', $request->email)->first()) {
				$user->password = bcrypt($request->password);
				$user->save();
				$response = apiHelper::success1('Password confirmed');
				return response()->json($response, 200);
			} else {
				$response = apiHelper::error('You’ve entered an invalid email');
				return response()->json($response, 401); // Status code 401 shows un authorized
			}
		} else {
			$response = apiHelper::error('Invalid Code');
			return response()->json($response, 401); // Status code 401 shows un authorized

		}
	}

	public function change_password(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$rules = array('old_password' => 'required', 'new_password' => 'required');
			$validations = Validator::make($request->all(), $rules);
			if ($validations->fails()) {
				$messages = $validations->messages();
				$data = apiHelper::validation_error('Validation errors', $messages);
				return response()->json($data, 403); // Status code 403 shows Validation error
			}
			if ($user = Users::where('user_id', $user_id)->first()) {
				if (Hash::check($request->old_password, $user->password)) {
					$user->password = bcrypt($request->new_password);
					$user->save();
					$response = apiHelper::success1('Changes confirmed');
					return response()->json($response, 200);
				} else {
					$response = apiHelper::error('Invalid old password');
					return response()->json($response);
				}
			} else {
				$response = apiHelper::error('Invalid credentials');
				return response()->json($response, 401);
			}
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function edit_profile(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$rules = array('first_name' => 'required', 'last_name' => 'required', 'school_name' => 'required', 'country_code' => 'required', 'phone_number' => 'required|max:10');
			$validations = Validator::make($request->all(), $rules);
			if ($validations->fails()) {
				$messages = $validations->messages();
				$data = apiHelper::validation_error('Validation errors', $messages);
				return response()->json($data, 403); // Status code 403 shows Validation error
			}
			if ($user = Users::where('user_id', $user_id)->first()) {
				$user->first_name = $request->first_name;
				$user->last_name = $request->last_name;
				$user->school_name = $request->school_name;
				$user->date_of_birth = $request->date_of_birth;

				$user->country_code = $request->country_code;
				$user->phone_number = $request->phone_number;
				if ($request->display_picture) {
					$source = fopen($request->display_picture, 'r');
					$path = 'public/images/user/' . uniqid() . '.png';
					$destination = fopen($path, 'w');
					stream_copy_to_stream($source, $destination);
					fclose($source);
					fclose($destination);
					$user->display_picture = url('/') . '/' . $path;
				}
				$user->save();
				$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts')->where('user_id', $user_id)->first();
				$data = apiHelper::success('Changes confirmed', $user);
				return response()->json($data);
			} else {
				$response = apiHelper::error('Invalid credentials');
				return response()->json($response, 401);
			}
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function edit_profile_info(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			// $rules = array('address_1' => 'required');
			// $validations = Validator::make($request->all(), $rules);
			// if ($validations->fails()) {
			// 	$messages = $validations->messages();
			// 	$data = apiHelper::validation_error('Validation errors', $messages);
			// 	return response()->json($data, 403); // Status code 403 shows Validation error
			// }
			$user_address = UserAddress::where('user_id', $user_id)->first();
			$user_address->address_1 = $request->address_1;
			$user_address->address_2 = $request->address_2;
			$user_address->city = $request->city;
			$user_address->state = $request->state;
			$user_address->country = $request->country;
			$user_address->zipcode = $request->zipcode;
			$user_address->save();
			$user_medical_info = UserMedicalInfo::where('user_id', $user_id)->first();
			$user_medical_info->illness_allergies = $request->illness_allergies;
			$user_medical_info->dr_name = $request->dr_name;
			$user_medical_info->dr_phone = $request->dr_phone;
			$user_medical_info->save();
			$emergency_contacts = $request->emergency_contacts;
			if (is_array($emergency_contacts)) {
				UserEmergencyContacts::where('user_id', $user_id)->delete();
				foreach ($emergency_contacts as $emergency_contact) {
					$contact = new UserEmergencyContacts();
					$contact->name = $emergency_contact['name'];
					$contact->relation = $emergency_contact['relation'];
					$contact->phone = $emergency_contact['phone'];
					$contact->user_id = $user_id;
					$contact->save();
				}
			}
			$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts')->where('user_id', $user_id)->first();
			$data = apiHelper::success('Changes confirmed', $user);
			return response()->json($data);
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function update_device_token(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$rules = array('device_token' => 'required');
			$validations = Validator::make($request->all(), $rules);
			if ($validations->fails()) {
				$messages = $validations->messages();
				$data = apiHelper::validation_error('Validation errors', $messages);
				return response()->json($data, 403); // Status code 403 shows Validation error
			}

			$user = Users::where('user_id', $user_id)->first();
			$user->device_token = $request->device_token;
			$user->save();

			if (Users::where('user_id', '!=', $user_id)->where('device_token', $request->device_token)->count() > 0):
				Users::where('user_id', '!=', $user_id)->where('device_token', $request->device_token)->update(['device_token' => NULL]);
			endif;
			$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts')->where('user_id', $user_id)->first();
			$data = apiHelper::success('Changes confirmed', $user);
			return response()->json($data);
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function update_push_setting(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$rules = array('is_push' => 'required');
			$validations = Validator::make($request->all(), $rules);
			if ($validations->fails()) {
				$messages = $validations->messages();
				$data = apiHelper::validation_error('Validation errors', $messages);
				return response()->json($data, 403); // Status code 403 shows Validation error
			}
			$user = Users::where('user_id', $user_id)->first();
			$user->is_push = $request->is_push;
			$user->save();

			$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts')->where('user_id', $user_id)->first();
			$data = apiHelper::success('Changes confirmed', $user);
			return response()->json($data);
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function update_setting(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$rules = array('type' => 'required');
			$validations = Validator::make($request->all(), $rules);
			if ($validations->fails()) {
				$messages = $validations->messages();
				$data = apiHelper::validation_error('Validation errors', $messages);
				return response()->json($data, 403); // Status code 403 shows Validation error
			}
			if ($request->type == 'sound') {
				$rules = array('is_sound' => 'required');
				$validations = Validator::make($request->all(), $rules);
				if ($validations->fails()) {
					$messages = $validations->messages();
					$data = apiHelper::validation_error('Validation errors', $messages);
					return response()->json($data, 403); // Status code 403 shows Validation error
				}
				$user = Users::where('user_id', $user_id)->first();
				$user->is_sound = $request->is_sound;
				$user->save();

			} elseif ($request->type == 'sleep') {
				$rules = array('is_sleeping' => 'required');
				$validations = Validator::make($request->all(), $rules);
				if ($validations->fails()) {
					$messages = $validations->messages();
					$data = apiHelper::validation_error('Validation errors', $messages);
					return response()->json($data, 403); // Status code 403 shows Validation error
				}
				$user = Users::where('user_id', $user_id)->first();
				$user->is_sleeping = $request->is_sleeping;
				$user->save();

			} else {
				$rules = array('session_type' => 'required');
				$validations = Validator::make($request->all(), $rules);
				if ($validations->fails()) {
					$messages = $validations->messages();
					$data = apiHelper::validation_error('Validation errors', $messages);
					return response()->json($data, 403); // Status code 403 shows Validation error
				}
				$user = Users::where('user_id', $user_id)->first();
				$user->session_type = $request->session_type;
				$user->save();
			}

			$user = Users::with('user_address', 'user_medical_info', 'user_emergency_contacts')->where('user_id', $user_id)->first();
			$data = apiHelper::success('Changes confirmed', $user);
			return response()->json($data);
		} else {
			$response = apiHelper::error('Invalid credentials');
			return response()->json($response, 401); // Status code 401 shows un authorized
		}
	}

	public function notification_view(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$organization_id = Notifications::where('id', $request->id)->pluck('organization_id')->first();
			$time_zone_id = Organizations::where('organization_id', $organization_id)->pluck('timezone_id')->first();
			$timezone_code = TimeZone::where('id', $time_zone_id)->pluck('timezone_code')->first();
			$current_time = new DateTime('now', new DateTimeZone($timezone_code));

			if ($notification = NotificationUserStatus::where('user_id', $user_id)->where('notification_id', $request->id)->first()) {
				$notification->notification = $current_time;
				$notification->save();
			} else {
				$notification = new NotificationUserStatus();
				$notification->user_id = $user_id;
				$notification->notification_id = $request->id;
				$notification->notification = $current_time;
				$notification->save();
			}

			$data = apiHelper::success1('Confirmed');
			return response()->json($data);

		} else {
			$data = apiHelper::error('unauthorized user');
			return response()->json($data, 401);
		}
	}

	public function logout(Request $request) {
		$user_id = $request->header('user-id');
		$auth_id = $request->header('auth-id');
		if (apiHelper::authenticate($user_id, $auth_id)) {
			$user = Users::where('user_id', $user_id)->where('auth_id', $auth_id)->first();
			$user->device_token = NULL;
			$save = $user->save();
			if ($save) {
				$data = apiHelper::success1('successfully Log-out');
				return response()->json($data);
			}

		} else {
			$data = apiHelper::error('unauthorized user');
			return response()->json($data, 401);
		}
	}
}
