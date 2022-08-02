<?php

namespace App\Http\Controllers;

use App\Admin;
use App\Countries;
use App\Days;
use App\ForgotPassword;
use App\GroupMembers;
use App\Groups;
use App\Hours;
use App\Invitees;
use App\NotificationGroup;
use App\Notifications;
use App\NotificationUserStatus;
use App\Organizations;
use App\Rules\FridayCloseTime;
use App\Rules\FridayStartTime;
use App\Rules\MondayCloseTime;
use App\Rules\MondayStartTime;
use App\Rules\PublishDateValidate;
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
use App\TagMembers;
use App\Tags;
use App\Templates;
use App\TimeZone;
use App\UserAddress;
use App\UserDeletedNotification;
use App\UserEmergencyContacts;
use App\UserMedicalInfo;
use App\Users;
use App\VideoLocationTracking;
use App\Videos;
use Dropbox\Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Mail;
use Ramsey\Uuid\Uuid;
use Redirect;
use Session;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use \DateTime;
use \DateTimeZone;
use \Validator;

class ContactCenterController extends Controller {
	public function __construct() {
		$this->setDefaultTimeZone();
	}

	public function setDefaultTimeZone() {
		if (Session::has('contact_center_admin')) {
			ini_set('date.timezone', session('contact_center_admin.0.time_zone.timezone_code'));
		}

	}

	public function contact_center_login(Request $request) {
		$email = $request->input('email');
		$password = $request->input('password');
		$password = md5($password);
		if ($user = Organizations::with('time_zone', 'country')->where('email', $email)->where('password', $password)->first()) {
			if ($user->status != 'enabled' && $user->type == 1) {
				echo 'Your Account Has been Disabled By <b>Administration</b>. For further details contact with Authorities';
			} elseif ($user->status != 'enabled' && $user->type == 2) {
				echo 'Your Account Has been Disabled By <b>Administration</b>. For further details contact with your <b>contact center</b> Authorities';
			} else {

				$data = $user->toArray();
				Session::push('contact_center_admin', $data);

				echo 'login successful';
			}
		} else {
			echo 'Invalid credentials';
		}
	}

	public function add_organization(Request $request) {
		$request->validate([
			'monday_start_time' => [new MondayStartTime($request->monday_status)],
			'monday_close_time' => [new MondayCloseTime($request->monday_status)],
			'tuesday_start_time' => [new TuesdayStartTime($request->tuesday_status)],
			'tuesday_close_time' => [new TuesdayCloseTime($request->tuesday_status)],
			'wednesday_start_time' => [new WednesdayStartTime($request->wednesday_status)],
			'wednesday_close_time' => [new WednesdayCloseTime($request->wednesday_status)],
			'thursday_start_time' => [new ThursdayStartTime($request->thursday_status)],
			'thursday_close_time' => [new ThursdayCloseTime($request->thursday_status)],
			'friday_start_time' => [new FridayStartTime($request->friday_status)],
			'friday_close_time' => [new FridayCloseTime($request->friday_status)],
			'saturday_start_time' => [new SaturdayStartTime($request->saturday_status)],
			'saturday_close_time' => [new SaturdayCloseTime($request->saturday_status)],
			'sunday_start_time' => [new sundayStartTime($request->sunday_status)],
			'sunday_close_time' => [new SundayCloseTime($request->sunday_status)],
		]);
		$name = $request->input('name');
		$email = $request->input('email');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$additional_detail = $request->input('additional_detail');
		$start_time = $request->input('start_time');
		$end_time = $request->input('end_time');
		$password = md5($request->input('password'));

		if (Organizations::where('email', $email)->first()) {
			echo 'Email already exists';
		} else {
			if (Session::has('contact_center_admin')) {
				$user = Session::get('contact_center_admin');
				$organization_id = $user[0]['organization_id'];
				$organization_name = $user[0]['organization_name'];
			}
			$code = Organizations::where('organization_id', $organization_id)->first();
			$phone_codes = Countries::where('id', $code->country_id)->first(['phone_code']);
			$organization = new Organizations();
			$organization->organization_id = $organization_id;
			$organization->organization_name = $organization_name;
			$organization->name = $name;
			$organization->email = $email;
			$organization->phone_number = '+' . $phone_codes->phone_code . $phone;
			$organization->password = $password;
			$organization->code = $code->code;
			$organization->address = $address;
			$organization->country_id = session('contact_center_admin.0.country_id');

			// $organization->start_time=$start_time;
			// $organization->end_time=$end_time;
			$organization->timezone_id = session('contact_center_admin.0.time_zone.id');
			$organization->type = 2;
			$organization->additional_detail = $additional_detail;
			$arr = [];
			if ($request->has('additional_fields')) {
				foreach ($request->additional_fields as $key => $value) {
					if (empty($value)) {
						unset($key);
					} else {
						$arr[] = $value;
					}

				}
			}
			if (count($arr) > 0) {

				$organization->additional_fields = $arr;
			}
			$save = $organization->save();
			if ($save) {
				$admin_id = $organization->id;
				$this->set_schedule($admin_id, $organization_id);
				echo 'success';

			} else {
				echo 'An error occurred during adding contact center,please try again';
			}
		}
	}

	public function set_schedule($admin_id, $organization_id) {
		for ($i = 1; $i <= 7; $i++) {
			$schedule = new Schedule();
			$schedule->day_id = $i;
			$schedule->admin_id = $admin_id;
			$schedule->organization_id = $organization_id;
			$schedule->status = 'active';
			$schedule->open_time = 23;
			$schedule->open_time_format = 'am';
			$schedule->close_time = 22;
			$schedule->close_time_format = 'pm';
			$schedule->save();
		}
	}

	public function edit_organization(Request $request) {

		$name = $request->input('name');
		$id = $request->input('id');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$additional_detail = $request->input('additional_detail');
		// $start_time=$request->input('start_time');
		// $end_time=$request->input('end_time');
		$arr = [];
		$organization = Organizations::where('id', $id)->first();
		$phone_codes = Countries::where('id', $organization->country_id)->first(['phone_code']);
		$organization->name = $name;
		$organization->phone_number = '+' . $phone_codes->phone_code . $phone;
		$organization->address = $address;
		/*  $organization->start_time=$start_time;
        $organization->end_time=$end_time;*/
		$organization->additional_detail = $additional_detail;
		$organization->country_id = session('contact_center_admin.0.country_id');
		if ($request->has('additional_fields')) {
			foreach ($request->additional_fields as $key => $value) {
				if (empty($value)) {
					unset($key);
				} else {
					$arr[] = $value;
				}

			}
		}
		if (count($arr) > 0) {
			$organization->additional_fields = $arr;
		}
		$save = $organization->save();
		if ($save) {

			echo 'success';
		} else {
			echo 'An error occurred during editing contact center,please try again';
		}

	}

	public function get_additional_field_for_edit_display(Request $request) {
		// function for showing dynamic additional field if added for admin
		return Organizations::find($request->id);
	}

	public function change_password(Request $request) {
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$email = $user[0]['email'];
			$password = $request->input('old_password');
			$password = md5($password);
			if ($user = Organizations::where('email', $email)->where('password', $password)->first()) {
				$user->password = md5($request->new_password);
				$user->save();
				echo 'success';
			} else {
				echo 'You have entered an incorrect old password';
			}
		}
	}

	public function users(Request $request) {
		$type = $request->input('type');
		if (empty($type)) {
			$type = 'first_name';
		}
		$search = $request->input('search', '');
		$s_date = $request->input('s_date');
		$e_date = $request->input('e_date');
		$data = array('type' => $type, 'search' => $search, 's_date' => $s_date, 'e_date' => $e_date);
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
		}
		if (empty($s_date)) {
			$users = Users::with('organization', 'user_emergency_contacts', 'user_tags.tag')->where($type, 'like', '%' . $search . '%')
				->where('organization_id', $organization_id)->orderby('id', 'desc')->paginate(20);
		} else {
			$users = Users::with('organization', 'user_tags.tag')->where($type, 'like', '%' . $search . '%')
				->whereBetween('created_at', array($s_date, $e_date))
				->where('organization_id', $organization_id)->paginate(20);

		}
		return view('contact_center.users.users', ["users" => $users, 'data' => $data]);
	}

	public function user_status($id) {
		$user = Users::where('user_id', $id)->first();
		if ($user->status == 'enabled') {
			$user->status = 'disabled';
			$user->auth_id = hash('sha256', time());
		} else {
			$user->status = 'enabled';
			$user->auth_id = hash('sha256', time());
		}
		$user->save();
	}

	public function enabled_users(Request $request) {
		$type = $request->input('type');
		if (empty($type)) {
			$type = 'first_name';
		}
		$search = $request->input('search', '');
		$s_date = $request->input('s_date');
		$e_date = $request->input('e_date');
		$data = array('type' => $type, 'search' => $search, 's_date' => $s_date, 'e_date' => $e_date);
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
		}
		if (empty($s_date)) {
			$users = Users::with('organization')->where($type, 'like', '%' . $search . '%')->where('status', 'enabled')
				->where('organization_id', $organization_id)->paginate(20);
		} else {
			$users = Users::with('organization')->where($type, 'like', '%' . $search . '%')->where('status', 'enabled')
				->whereBetween('created_at', array($s_date, $e_date))
				->where('organization_id', $organization_id)->paginate(20);

		}
		return view('contact_center.users.users', ["users" => $users, 'data' => $data]);

	}

	public function disabled_users(Request $request) {
		$type = $request->input('type');
		if (empty($type)) {
			$type = 'first_name';
		}
		$search = $request->input('search', '');
		$s_date = $request->input('s_date');
		$e_date = $request->input('e_date');
		$data = array('type' => $type, 'search' => $search, 's_date' => $s_date, 'e_date' => $e_date);
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
		}
		if (empty($s_date)) {
			$users = Users::with('organization')->where($type, 'like', '%' . $search . '%')->where('status', 'disabled')
				->where('organization_id', $organization_id)->paginate(20);
		} else {
			$users = Users::with('organization')->where($type, 'like', '%' . $search . '%')->where('status', 'disabled')
				->whereBetween('created_at', array($s_date, $e_date))
				->where('organization_id', $organization_id)->paginate(20);

		}
		return view('contact_center.users.users', ["users" => $users, 'data' => $data]);
	}

	public function administrators() {
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
		}
		if (session('contact_center_admin.0.type') == 2) {
			abort(404);
		}
		$admins = Organizations::with(['schedule' => function ($q) {
			$q->orderBy('day_id');
		}, 'schedule.days', 'schedule.start_time', 'schedule.close_time'])->where('type', 2)->where('organization_id', $organization_id)->orderby('id', 'desc')->get();
		return view('contact_center.administrators.administrators', ["admins" => $admins]);
	}

	public function delete_admin(Request $request) {
		Schedule::where('admin_id', $request->id)->delete();
		$result = Organizations::find($request->id)->delete();

		if ($result) {
			return response()->json(['response' => 'success']);
		} else {
			return response()->json(['response' => 'not succeeded']);
		}
	}

	public function change_admin_status(Request $request) {
		$org = Organizations::find($request->id);
		if ($org->status == 'enabled') {
			$org->status = 'disabled';
		} else {

			$org->status = 'enabled';
		}
		$org->save();
		return $org;
	}

	public function notifications() {
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
			$notifications = Notifications::where('organization_id', $organization_id)->where('is_archive', 0)->orderby('id', 'desc')->get();
		}
		return view('contact_center.notifications.notifications', ["notifications" => $notifications]);
	}

	public function archive_notifications() {
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
			$notifications = Notifications::where('organization_id', $organization_id)->where('is_archive', 1)->get();
		}
		return view('contact_center.notifications.notifications', ["notifications" => $notifications]);
	}

	public function invitees() {
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
		}
		$invitees = Invitees::with('user_tags.tag')->where('organization_id', $organization_id)->get();
		return view('contact_center.invitees.invitees', ["invitees" => $invitees]);
	}

	public function notification(Request $request) {
		set_time_limit(0);
		ini_set('memory_limit', '512M');
		$timestamp = '';

		if ($request->date && $request->time && $request->am_pm) {
			config(['app.timezone' => session('contact_center_admin.0.time_zone.timezone_code')]);
			ini_set('date.timezone', config('app.timezone'));
			$time = Hours::where('id', $request->time)->first();
			$timestamp = $request->date . ' ' . $time->hour . ' ' . $request->am_pm;

		}

		$valid = Validator::make($request->all(), ['time' => ['required_if:schedule,1', new PublishDateValidate($timestamp, session('contact_center_admin.0.time_zone.timezone_code'), $request->schedule)], 'date' => 'required_if:schedule,1', 'am_pm' => 'required_if:schedule,1'], ['time.required_if' => 'time is required to schedule the Mass Notification properly', 'date.required_if' => 'date is required to schedule the Mass Notification properly', 'am_pm.required_if' => 'AM/PM must be set']);
		if ($valid->fails()) {
			return response()->json($valid->messages(), 422);
		}
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
			$admin_id = $user[0]['id'];
			$organization_name = $user[0]['organization_name'];
			$name = $user[0]['name'];
		}
		config(['app.timezone' => session('contact_center_admin.0.time_zone.timezone_code')]);
		ini_set('date.timezone', config('app.timezone'));
		stream_context_set_default([
			'ssl' => [
				'verify_peer' => false,
				'verify_peer_name' => false,
			],
		]);
		$notification = new Notifications();
		$notification->organization_id = $organization_id;
		$notification->admin_id = $admin_id;
		$notification->name = $name;
		$notification->title = $request->title;
		$notification->notification = $request->notification;
		$notification->priority = '[ ' . $request->priority . ' Alert ]';
		$current_time = new DateTime('now', new DateTimeZone(session('contact_center_admin.0.time_zone.timezone_code')));

		$notification->created_at = $current_time;
		if ($request->hasFile('file')) {
			$destinationPath = 'public/images/notifications/';
			$extension = $request->file->extension();
			$image = uniqid() . '.' . $extension;
			$request->file->move($destinationPath, $image);
			$image_path = url('/') . '/' . $destinationPath . $image;
			$notification->path = $image_path;
			$check_image_path = str_replace('https://', 'http://', $image_path);

			if (strstr($request->file->getClientMimeType(), "image")) {
				$type = 1;
			} else {
				$type = 2;
			}

			$notification->type = $type;

		} elseif ($request->audio_src) {
			$notification->type = 3;
			$notification->path = $request->audio_src;
			$notification->notification = NULL;
		} else {

			$notification->type = 0;
		}

		if ($request->date && $request->time && $request->am_pm) {
			$time = Hours::where('id', $request->time)->first();
			$date = strtotime($request->date . ' ' . $time->hour . ' ' . $request->am_pm);
			$notification->status = 0;
			$notification->published_at = date('Y-m-d G:i:s', $date);

		}
		if ($request->is_report == 'on') {
			$notification->is_report = 1;
		}
		$notification->save();
		if ($request->has('groups')) {
			$groups = $request->groups;

			foreach ($groups as $key => $value) {

				NotificationGroup::create(['notification_id' => $notification->id, 'group_id' => $value]);
			}
			$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->get()->pluck('user_id');
			$users = Users::whereIn('user_id', $user_ids)->get();
			$invitees_users = Invitees::whereIn('id', $user_ids)->get();
			$firebase_tokens = $users->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
		} else {

			$users = Users::where('organization_id', session('contact_center_admin.0.organization_id'))->where('device_token', '!=', NULL)->where('is_push', 1)->get();
			$invitees_users = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->get();
			$firebase_tokens = Users::where('organization_id', session('contact_center_admin.0.organization_id'))->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
		}
		if ($request->schedule == 0) {

			if (count($users)) {

				//Mail

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('steve@agentsafewalk.com', $organization_name);
							$message->to($user->email)->subject($notification->priority . $notification->title . ' - ' . session('contact_center_admin.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('contact_center_admin.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->country_code . '' . $user->phone_number;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}

				//Notification
				$fields = array(
					'notification' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'path' => $notification->path,
						'priority' => $notification->priority,
						'created_at' => $notification->created_at,
						'sound' => 'default',
					),
					'data' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'priority' => $notification->priority,
						'path' => $notification->path,
						'created_at' => $notification->created_at,
						'data' => '',
						'sound' => 'default',
					),
					'content_available' => true,
					'priority' => 'high',
					'registration_ids' => $firebase_tokens,
				);
				$url = 'https://fcm.googleapis.com/fcm/send';

				$headers = array(
					'Authorization: key=' . 'AIzaSyAWqFiS1PV8WrZumrUSxQAH4ZbR6EtasaE',
					'Content-Type: application/json',
				);
				// Open connection
				$ch = curl_init();
				// Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
			}

			if (count($invitees_users)) {

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($invitees_users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('steve@agentsafewalk.com', $organization_name);
							$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . session('contact_center_admin.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('contact_center_admin.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->phone;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}
			}
		}

	}

	public function edit_notification(Request $request) {
		$timestamp = '';
		if ($request->date && $request->time && $request->am_pm) {
			// dd($request->am_pm);
			$time = Hours::where('id', $request->time)->first();
			$timestamp = $request->date . ' ' . $time->hour . ' ' . $request->am_pm;

		}

		$request->validate(['groups' => 'required', 'time' => ['required_if:schedule,1', new PublishDateValidate($timestamp, session('contact_center_admin.0.time_zone.timezone_code'), $request->schedule)], 'date' => 'required_if:schedule,1', 'am_pm' => 'required_if:schedule,1'], ['time.required_if' => 'time is required to schedule the Mass Notification properly', 'date.required_if' => 'date is required to schedule the Mass Notification properly', 'am_pm.required_if' => 'AM/PM must be set']);
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
			$admin_id = $user[0]['id'];
			$organization_name = $user[0]['organization_name'];
			$name = $user[0]['name'];
		}
		config(['app.timezone' => session('contact_center_admin.0.time_zone.timezone_code')]);
		ini_set('date.timezone', config('app.timezone'));
		// date_default_timezone_set(config('app.timezone'));

		$notification = Notifications::find($request->id);
		$notification->organization_id = $organization_id;
		$notification->admin_id = $admin_id;
		$notification->name = $name;
		// $pattern = '/[\'\/~`\!@#\$%\^&\*\(\)_\-\+=\{\}\[\]\|;"\<\>\?\\\]/';

		$notification->title = $request->title;
		$notification->notification = $request->notification;
		$notification->priority = '[ ' . $request->priority . ' Alert ]';
		if ($request->type == 2) {
			$type = 3;
			$notification->path = $request->audio_src;
		} else {
			// $notification->type = 0;
			// $notification->path = NULL;
		}
		if ($request->file) {

			if (file_exists(base_path('public') . '/images/notifications/' . basename($notification->path))) {
				unlink(base_path('public') . '/images/notifications/' . basename($notification->path));
			}
			$destinationPath = 'public/images/notifications/';

			$extension = $request->file->extension();
			$image = uniqid() . '.' . $extension;
			$request->file->move($destinationPath, $image);
			$image_path = url('/') . '/' . $destinationPath . $image;
			$notification->path = $image_path;
			$check_image_path = str_replace('https://', 'http://', $image_path);
			if (strstr($request->file->getClientMimeType(), "image")) {
				$type = 1;
			} else {
				$type = 2;
			}

			$notification->type = $type;

		}
		if ($request->schedule == 0) {
			$notification->status = 1;
			$notification->published_at = NULL;

		} else {
			if ($request->date && $request->time && $request->am_pm) {
				$time = Hours::where('id', $request->time)->first();
				$date = $request->date . ' ' . $time->hour . ' ' . $request->am_pm;
				$notification->status = 0;
				// (date('Y-m-d H:i:s',strtotime($date);
				$notification->published_at = date('Y-m-d H:i:s', strtotime($date));

			}

		}
		if ($request->has('groups')) {
			$notification->to_all_users = 0;

		} else {
			$notification->to_all_users = 1;
		}
		$notification->save();
		if ($request->has('groups')) {
			$groups = $request->groups;
			NotificationGroup::where('notification_id', $notification->id)->delete();
			foreach ($groups as $key => $value) {

				NotificationGroup::create(['notification_id' => $notification->id, 'group_id' => $value]);
			}
			$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->get()->pluck('user_id');
			$users = Users::whereIn('user_id', $user_ids)->get();
			$invitees_users = Invitees::whereIn('id', $user_ids)->get();
			$firebase_tokens = $users->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
		} else {

			$users = Users::where('organization_id', session('contact_center_admin.0.organization_id'))->where('device_token', '!=', NULL)->where('is_push', 1)->get();
			$invitees_users = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->get();
			$firebase_tokens = Users::where('organization_id', session('contact_center_admin.0.organization_id'))->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
		}
		if ($request->schedule == 0) {
			if (count($users)) {

				//Mail

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('steve@agentsafewalk.com', $organization_name);

							$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . session('contact_center_admin.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('contact_center_admin.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->user_id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->country_code . '' . $user->phone_number;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}

				//Notification
				$fields = array(
					'notification' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'path' => $notification->path,
						'priority' => $notification->priority,
						'created_at' => $notification->created_at,
						'sound' => 'default',
					),
					'data' => array(
						'id' => $notification->id,
						'title' => $notification->priority . ' ' . "\n\n" . $request->title,
						'text' => $request->notification,
						'organization_id' => $notification->organization_id,
						'type' => $notification->type,
						'priority' => $notification->priority,
						'path' => $notification->path,
						'created_at' => $notification->created_at,
						'data' => '',
						'sound' => 'default',
					),
					'content_available' => true,
					'priority' => 'high',
					'registration_ids' => $firebase_tokens,
				);
				$url = 'https://fcm.googleapis.com/fcm/send';

				$headers = array(
					'Authorization: key=' . 'AIzaSyAWqFiS1PV8WrZumrUSxQAH4ZbR6EtasaE',
					'Content-Type: application/json',
				);
				// Open connection
				$ch = curl_init();
				// Set the url, number of POST vars, POST data
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
				$result = curl_exec($ch);
			}

			if (count($invitees_users)) {

				$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
				$authToken = '002a6ef044af01d69cb979eb4107b9fe';
				$twilioNumber = "+14359195249";
				$client = new Client($accountSid, $authToken);

				foreach ($invitees_users as $user) {
					try {
						Mail::send([], [], function ($message) use ($user, $notification, $organization_name) {

							$body = $notification->priority . '<br>';
							$body .= '<strong>' . $notification->title . '</strong><br>';
							if ($notification->notification) {
								$body .= '<br>' . $notification->notification;
							}
							if ($notification->is_report) {
								$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/2';
								$url = $this->fetchTinyUrl($url);
								$body .= '<br>' . '<a href="' . $url . '">Click here</a>';
								$body .= "to confirm receipt of this message.";

							}
							$message->from('steve@agentsafewalk.com', $organization_name);

							$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . session('contact_center_admin.0.organization_name'))->setBody($body, 'text/html');

						});

					} catch (\Exception $e) {

					}

					$body = $notification->priority . ' ' . $request->title . ' - ' . session('contact_center_admin.0.organization_name') . "\n\n" . $notification->title . "\n\n";
					if ($notification->notification) {
						$body .= $notification->notification . "\n\n";

					}
					if ($notification->is_report) {
						$url = url('/') . '/notification/' . $user->id . '/' . $notification->id . '/1';
						$url = $this->fetchTinyUrl($url);
						$body .= "Click Here to confirm receipt of this message." . "\n\n";
						$body .= $url;
					}

					$phone_number = $user->phone;
					try {
						$client->messages->create(
							'' . $phone_number,
							[
								"body" => $body,
								"from" => $twilioNumber,
							]
						);
					} catch (TwilioException $e) {
						// echo($e->getMessage());
					}
				}
			}
		}
	}

	public function delete_notification(Request $request) {
		NotificationGroup::where('notification_id', $request->notification_id)->delete();
		UserDeletedNotification::where('notification_id', $request->notification_id)->delete();
		$notification = Notifications::find($request->notification_id)->delete();

	}

	public function add_invitees(Request $request) {
		// $message = $request->input('message');
		if (Session::has('contact_center_admin')) {
			$user = Session::get('contact_center_admin');
			$organization_id = $user[0]['organization_id'];
			$organization_name = $user[0]['organization_name'];
		}

		$inviteCount = Invitees::where('organization_id', $organization_id)->count();
		$no_of_users = Organizations::where('organization_id', session('contact_center_admin.0.organization_id'))->where('type', 1)->first(['no_of_users']);
		$no_of_users = $no_of_users->no_of_users;
		$userCount = Users::where('organization_id', $organization_id)->count();

		$sum = $userCount + $inviteCount;
		try {
			if ($request->hasFile('csv')) {
				$results = $this->csvToArray($request->file('csv'));
				if ($sum >= $no_of_users || count($results) >= $no_of_users) {
					return response()->json(['response' => 'you are going to exceed invitees Limit. delete added invitees or get more no of users by requesting Administration'], 422);
				}
				foreach ($results as $result) {
					if (!Invitees::where('organization_id', $organization_id)->where('email', $result['email'])->first()) {
						$invite = new Invitees();
						$invite->organization_id = $organization_id;
						$invite->name = $result['name'];
						$invite->email = $result['email'];
						$invite->phone = $result['phone'];
						$current_time = new DateTime('now', new DateTimeZone(session('contact_center_admin.0.time_zone.timezone_code')));
						$invite->created_at = $current_time;
						$invite->save();
						if (!empty($result['tags'])) {
							$tags = explode(',', $result['tags']);

							foreach ($tags as $tag_name) {
								$tag_name = trim($tag_name);
								if ($tag_id = Tags::where('tag_name', $tag_name)->pluck('tag_id')->first()) {
									$tag_member = new TagMembers();
									$tag_member->tag_id = $tag_id;
									$tag_member->type = 2;
									$tag_member->user_id = $invite->id;
									$tag_member->save();
								}
							}
						}

						$data['company'] = $organization_name;
						$data['subject'] = $request->subject;
						$data['user_email'] = $result['email'];
						$data['user_name'] = $result['name'];
						$data['code'] = $user[0]['code'];
						$data['email'] = $user[0]['email'];
						$name = $result['name'];
						$email = $result['email'];
						$subject = $request->subject;

						Mail::send('mail.invite', ["data" => $data], function ($message) use ($name, $email, $subject, $organization_name) {
							$message->from('steve@agentsafewalk.com', $organization_name);

							$message->to($email, $name);

							$message->subject($subject);
						});
						// $this->send_message($request->subject, $result['email'], $result['phone'], $message, $organization_name);
					}

				}
			}

		} catch (\Exception $e) {
			echo 'An error occurred during adding invitees, please try again';
		}

	}

	public function edit_profile(Request $request) {
		$id = $request->input('id');
		$name = $request->input('name');
		$user_name = $request->input('user_name');
		$phone = $request->input('phone');
		$address = $request->input('address');
		$additional_detail = $request->input('additional_detail');
		$organization = Organizations::with('time_zone')->where('id', $id)->first();
		$phone_codes = Countries::where('id', $request->phone_code)->first(['phone_code']);
		$organization->name = $name;
		$organization->organization_name = $user_name;
		$organization->phone_number = '+' . $phone_codes->phone_code . $phone;
		$organization->address = $address;
		$organization->additional_detail = $additional_detail;
		$organization->country_id = $request->phone_code;
		$arr = [];

		if ($request->has('additional_fields')) {
			foreach ($request->additional_fields as $key => $value) {
				if (empty($value)) {
					unset($key);
				} else {
					$arr[] = $value;
				}

			}
		}
		if (count($arr) > 0) {
			$organization->additional_fields = $arr;
		} else {
			$organization->additional_fields = NULL;
		}
		$save = $organization->save();
		if ($save) {

			$data2 = [];
			$data = $organization->toArray();
			$data2[] = $data;
			$request->session()->put('contact_center_admin', $data2);
			echo 'success';
		} else {
			echo 'An error occurred during adding contact center,please try again';
		}
	}

	public function single_invitees(Request $request) {

		$request->validate([
			'name' => 'required',
			'subject' => 'required',
			'email' => 'required|unique:invitees',
			'phone' => 'bail|required|regex:/[0-9]{10,11}/',
			// 'message' => 'required|max:300',
		], ['phone.regex' => 'numbers should not be greater than 11 & less than 10']);
		// $message = $request->input('message');
		$tag_ids = $request->input('tag_ids');
		$inviteCount = Invitees::where('organization_id', $request->organization_id)->count();
		$userCount = Users::where('organization_id', $request->organization_id)->count();
		$no_of_users = Organizations::where('organization_id', session('contact_center_admin.0.organization_id'))->where('type', 1)->first(['no_of_users']);
		$no_of_users = $no_of_users->no_of_users;
		$sum = $userCount + $inviteCount;
		if ($sum >= $no_of_users) {
			return response()->json(['response' => 'you are going to exceed invitees Limit. delete added invitees or get more no of users by requesting Administration'], 422);
		}
		try {

			if (Users::where('email', $request->email)->exists()) {
				return response()->json(['response' => 'This user is already using app'], 422);

			}
			$phone_codes = Countries::where('id', session('contact_center_admin.0.country_id'))->first(['phone_code']);
			$invite = new Invitees();
			$invite->organization_id = $request->organization_id;
			$invite->name = $request->name;
			$invite->email = $request->email;
			$invite->phone = '+' . $phone_codes->phone_code . $request->phone;
			$current_time = new DateTime('now', new DateTimeZone(session('contact_center_admin.0.time_zone.timezone_code')));
			$invite->created_at = $current_time;
			$invite->save();
			if (is_array($tag_ids)) {
				foreach ($tag_ids as $tag_id) {
					$tag_member = new TagMembers();
					$tag_member->tag_id = $tag_id;
					$tag_member->type = 2;
					$tag_member->user_id = $invite->id;
					$tag_member->save();
				}
			}
			if (Session::has('contact_center_admin')) {
				$user = Session::get('contact_center_admin');
				$organization_name = $user[0]['organization_name'];
			}
			$data['company'] = $organization_name;
			$data['subject'] = $request->subject;
			$data['user_email'] = $request->email;
			$data['user_name'] = $request->name;
			$data['code'] = $user[0]['code'];
			$data['email'] = $user[0]['email'];
			$name = $request->name;
			$email = $request->email;
			$subject = $request->subject;

			Mail::send('mail.invite', ["data" => $data], function ($message) use ($name, $email, $subject, $organization_name) {
				$message->from('steve@agentsafewalk.com', $organization_name);

				$message->to($email, $name);

				$message->subject($subject);
			});
			// $this->send_message($request->subject, $request->email, $invite->phone, $message, $organization_name);

		} catch (\Exception $e) {
			echo 'An error occurred while adding invitees, please try again';
		}

	}

	public function delete_panic(Request $request) {
		$panic = Videos::Where('video_id', $request->id)->first();
		$result = $panic->delete();
		if ($result) {
			return response()->json(['data' => Videos::all()]);
		} else {

			return response()->json(['data' => Videos::all()]);
		}
	}

	public function delete_user(Request $request) {
		$users = Users::find($request->id);
		$panic = Videos::Where('user_id', $users->user_id)->forceDelete();
		VideoLocationTracking::Where('user_id', $users->user_id)->delete();
		UserMedicalInfo::Where('user_id', $users->user_id)->delete();
		UserEmergencyContacts::Where('user_id', $users->user_id)->delete();
		UserAddress::Where('user_id', $users->user_id)->delete();
		GroupMembers::Where('user_id', $users->user_id)->delete();
		$result = $users->delete();
		if ($result) {
			return response()->json(['data' => Users::all()]);
		} else {

			return response()->json(['data' => Users::all()]);
		}
	}

	public function delete_invitee($id) {
		GroupMembers::where('user_id', $id)->delete();
		TagMembers::where('user_id', $id)->delete();
		Invitees::where('id', $id)->delete();
	}

	public function video_note(Request $request) {
		$video_id = $request->input('video_id');
		$notes = $request->input('notes');
		$video = Videos::where('video_id', $video_id)->first();
		$video->notes = str_replace("'", "", $notes);
		$video->save();
	}

	public function notification_note(Request $request) {
		$id = $request->input('note_id');
		$notes = $request->input('notes');
		$notification = Notifications::where('id', $id)->first();
		$notification->notes = str_replace("'", "", $notes);
		$notification->save();
	}

	public function user_note(Request $request) {
		$id = $request->input('note_id');
		$notes = $request->input('notes');
		$user = Users::where('id', $id)->first();
		$user->notes = str_replace("'", "", $notes);
		$user->save();
	}

	public function organization_note(Request $request) {
		$id = $request->input('note_id');
		$notes = $request->input('notes');
		$user = Organizations::where('id', $id)->first();
		$user->notes = str_replace("'", "", $notes);
		$user->save();
	}

	public function admin_note(Request $request) {
		$id = $request->input('note_id');
		$notes = $request->input('notes');
		$user = Admin::where('id', $id)->first();
		$user->notes = str_replace("'", "", $notes);
		$user->save();
	}

	private function send_message($subject, $email, $phone, $msg, $organization_name) {
		try {
			Mail::send([], [], function ($message) use ($msg, $email, $subject, $organization_name) {
				$message->from('steve@agentsafewalk.com', $organization_name);
				$message->bcc($email)->subject($subject)->setBody($msg, 'text/html');
			});
		} catch (\Exception $e) {
		}

		$accountSid = 'AC7966ed796f64aa074e05e7db1d982a36';
		$authToken = '002a6ef044af01d69cb979eb4107b9fe';
		$twilioNumber = "+14359195249";
		$client = new Client($accountSid, $authToken);

		try {
			$client->messages->create(
				'' . $phone,
				[
					"body" => $msg,
					"from" => $twilioNumber,
				]
			);
		} catch (TwilioException $e) {
		}
	}

	function csvToArray($filename = '', $delimiter = ',') {
		if (!file_exists($filename) || !is_readable($filename)) {
			return false;
		}

		$header = null;
		$data = array();
		if (($handle = fopen($filename, 'r')) !== false) {

			while (($row = fgetcsv($handle, 1000, $delimiter)) !== false) {
				if (!$header) {
					$header = $row;
				} else {
					$data[] = array_combine($header, $row);
				}

			}
			fclose($handle);
		}

		return $data;
	}

	public function logout() {
		Session::flush('contact_center_admin');
		return redirect();
	}

	public function add_archive(Request $request) {
		$notify = Notifications::find($request->notification_id);
		$notify->is_archive = true;
		$save = $notify->save();
		if ($save) {
			return response()->json(['response' => 'success']);
		} else {

			return response()->json(['response' => 'unsuccess']);
		}
	}

	public function groups() {
		$groups = Groups::with('members')->withCount('members')->where('organization_id', session('contact_center_admin.0.organization_id'))->where('status', 1)->get();
		$inviteesCount = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->count();
		return view('contact_center.groups.groups')->with(['groups' => $groups, 'inviteesCount' => $inviteesCount]);
	}

	public function create_group(Request $request) {
		$groups = new Groups;
		$groups->title = $request->title;
		$groups->organization_id = session('contact_center_admin.0.organization_id');
		$current_time = new DateTime('now', new DateTimeZone(session('contact_center_admin.0.time_zone.timezone_code')));

		$groups->created_at = $current_time;
		$groups->save();

		if ($request->has('group_users')) {
			$group_users = $request->group_users;
			foreach ($group_users as $users) {
				$result_explode = explode(',', $users);
				$type = $result_explode[0];
				$user_id = $result_explode[1];
				$current_time = new DateTime('now', new DateTimeZone(session('contact_center_admin.0.time_zone.timezone_code')));
				GroupMembers::create(['user_id' => $user_id, 'type' => $type, 'group_id' => $groups->id, 'created_at' => $current_time]);
			}
		}
	}

	public function edit_group(Request $request) {
		$group = Groups::find($request->id);
		$group->title = $request->title;
		$group->save();
		if ($request->has('group_users')) {
			GroupMembers::where('group_id', $group->id)->delete();
			$group_users = $request->group_users;
			foreach ($group_users as $users) {
				$result_explode = explode(',', $users);
				$type = $result_explode[0];
				$user_id = $result_explode[1];
				GroupMembers::create(['user_id' => $user_id, 'type' => $type, 'group_id' => $group->id]);
			}
		}
	}

	public function get_group_members(Request $request, $group_id, $group_name = '', $notification_id = '') {

		if ($request->data == 1) {
			if (!empty($group_name)) {
				$group = Groups::find($group_id);
				$group_members = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->get();
				return response()->json(['response' => $group_members, 'group' => $group]);
			}
			$group = Groups::find($group_id);
			$group_members = GroupMembers::where('group_id', $group_id)->get();
			return response()->json(['members' => $group_members, 'group' => $group]);

		}

		if (!empty($group_name)) {
			$group = Groups::find($group_id);
			$group_members = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->get();
			return response()->json(['response' => $group_members, 'group' => $group]);
		}

		$group = Groups::find($group_id);
		$group_members = GroupMembers::where('group_id', $group_id)->pluck('user_id')->all();
		// dd($group_members);

		$members = Users::with(['member' => function ($q) {
			$q->select('user_id', 'created_at');
		}])->whereIn('user_id', $group_members)->get();

		$group_invitees = Invitees::whereIn('id', $group_members)->get();

		return response()->json(['response' => $members, 'invitees' => $group_invitees, 'group' => $group]);
	}

	public function get_group_members_with_notification(Request $request, $group_id, $notification_id, $group_name = '') {
		if (!empty($group_name)) {
			$group = Groups::find($group_id);
			$group_members = Invitees::with(['notification' => function ($q) use ($notification_id) {
				$q->where('notification_id', $notification_id);
			}])->where('organization_id', session('contact_center_admin.0.organization_id'))->get();
			return response()->json(['response' => $group_members, 'group' => $group]);
		}

		$group = Groups::find($group_id);
		$group_members = GroupMembers::where('group_id', $group_id)->pluck('user_id')->all();

		$members = Users::with(['notification' => function ($q) use ($notification_id) {
			$q->where('notification_id', $notification_id);
		}])->with(['member' => function ($q) {
			$q->select('user_id', 'created_at');
		}])->whereIn('user_id', $group_members)->get();

		$group_invitees = Invitees::with(['notification' => function ($q) use ($notification_id) {
			$q->where('notification_id', $notification_id);
		}])->whereIn('id', $group_members)->get();

		return response()->json(['response' => $members, 'invitees' => $group_invitees, 'group' => $group]);
	}

	public function remove_member($user_id, $group_id) {
		GroupMembers::where('user_id', $user_id)->where('group_id', $group_id)->delete();
		return GroupMembers::where('group_id', $group_id)->count();
	}

	public function delete_group(Request $request) {

		$groups = Groups::find($request->id);
		if ($groups->is_default == 0):
			$groups->delete();
		else:
			return response()->json(['response' => "bad request default groups can't be deleted"], 422);
		endif;
		GroupMembers::where('group_id', $request->id)->delete();
	}

	public function notification_history($id) {
		$notification_detail = Notifications::with(['sent_by', 'groups.members'])->withCount(['groups'])->findOrFail($id);
		$groups = NotificationGroup::where('notification_id', $id)->pluck('group_id')->all();
		$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->whereRaw('group_members.created_at <= (SELECT created_at FROM notifications where notifications.id = ?)', [$id])->get()->pluck('user_id');
		$inviteesCount = Invitees::where('organization_id', session('contact_center_admin.0.organization_id'))->count();
		return view('contact_center.notifications.notification-detail', ['notification_detail' => $notification_detail, 'user_ids' => $user_ids, 'inviteesCount' => $inviteesCount]);
	}

	public function create_schedule(Request $request) {
		if ($request->days) {
			$data = $request->toArray();
			$data = explode(',', $data['days']);
			$data = Days::whereIn('id', $data)->get();
			// dd($data);
			return view('contact_center.create_schedule', ['days' => $data])->render();
		}
	}

	public function edit_my_schedule(Request $request) {
		$request->validate([
			'monday_start_time' => [new MondayStartTime($request->monday_status)],
			'monday_close_time' => [new MondayCloseTime($request->monday_status)],
			'tuesday_start_time' => [new TuesdayStartTime($request->tuesday_status)],
			'tuesday_close_time' => [new TuesdayCloseTime($request->tuesday_status)],
			'wednesday_start_time' => [new WednesdayStartTime($request->wednesday_status)],
			'wednesday_close_time' => [new WednesdayCloseTime($request->wednesday_status)],
			'thursday_start_time' => [new ThursdayStartTime($request->thursday_status)],
			'thursday_close_time' => [new ThursdayCloseTime($request->thursday_status)],
			'friday_start_time' => [new FridayStartTime($request->friday_status)],
			'friday_close_time' => [new FridayCloseTime($request->friday_status)],
			'saturday_start_time' => [new SaturdayStartTime($request->saturday_status)],
			'saturday_close_time' => [new SaturdayCloseTime($request->saturday_status)],
			'sunday_start_time' => [new sundayStartTime($request->sunday_status)],
			'sunday_close_time' => [new SundayCloseTime($request->sunday_status)],
		]);

		$days = Days::all()->toArray();

		foreach ($days as $day) {
			$day_name = strtolower($day['name']);
			if ($request->get($day_name . '_status') == 'active'):

				$schedule = Schedule::updateOrCreate(['admin_id' => session('contact_center_admin.0.id'), 'organization_id' => session('contact_center_admin.0.organization_id'), 'day_id' => $day['id']], ['open_time' => $request->get($day_name . '_start_time'), 'open_time_format' => $request->get($day_name . '_start_time_am_pm'), 'close_time' => $request->get($day_name . '_close_time'), 'close_time_format' => $request->get($day_name . '_close_time_am_pm'), 'status' => $request->get($day_name . '_status')]);
			else:
				$schedule = Schedule::updateOrCreate(['admin_id' => session('contact_center_admin.0.id'), 'organization_id' => session('contact_center_admin.0.organization_id'), 'day_id' => $day['id']], ['status' => $request->get($day_name . '_status')]);
			endif;
		}
	}

	public function edit_admin_schedule(Request $request) {
		$request->validate([
			'monday_start_time' => [new MondayStartTime($request->monday_status)],
			'monday_close_time' => [new MondayCloseTime($request->monday_status)],
			'tuesday_start_time' => [new TuesdayStartTime($request->tuesday_status)],
			'tuesday_close_time' => [new TuesdayCloseTime($request->tuesday_status)],
			'wednesday_start_time' => [new WednesdayStartTime($request->wednesday_status)],
			'wednesday_close_time' => [new WednesdayCloseTime($request->wednesday_status)],
			'thursday_start_time' => [new ThursdayStartTime($request->thursday_status)],
			'thursday_close_time' => [new ThursdayCloseTime($request->thursday_status)],
			'friday_start_time' => [new FridayStartTime($request->friday_status)],
			'friday_close_time' => [new FridayCloseTime($request->friday_status)],
			'saturday_start_time' => [new SaturdayStartTime($request->saturday_status)],
			'saturday_close_time' => [new SaturdayCloseTime($request->saturday_status)],
			'sunday_start_time' => [new sundayStartTime($request->sunday_status)],
			'sunday_close_time' => [new SundayCloseTime($request->sunday_status)],
		]);
		// dd($request->all());
		$days = Days::all()->toArray();

		foreach ($days as $day) {
			$day_name = strtolower($day['name']);
			// $request->get('admin_id');
			if ($request->get($day_name . '_status') == 'active'):
				$org = Organizations::find($request->get('admin_id'));
				$schedule = Schedule::updateOrCreate(['admin_id' => $request->get('admin_id'), 'organization_id' => $org->organization_id, 'day_id' => $day['id']], ['open_time' => $request->get($day_name . '_start_time'), 'open_time_format' => $request->get($day_name . '_start_time_am_pm'), 'close_time' => $request->get($day_name . '_close_time'), 'close_time_format' => $request->get($day_name . '_close_time_am_pm'), 'status' => $request->get($day_name . '_status')]);
			else:
				$org = Organizations::find($request->get('admin_id'));
				$schedule = Schedule::updateOrCreate(['admin_id' => $request->admin_id, 'organization_id' => $org->organization_id, 'day_id' => $day['id']], ['status' => $request->get($day_name . '_status')]);
			endif;
		}
	}

	public function contact_center_forget(Request $request) {
		$exists = Organizations::where('email', $request->email)->first();
		if (!$exists) {
			die("email doesn't exists OR invalid email given");

		}

		$organization = Organizations::where('email', $request->email)->first();
		$token = uniqid();
		ForgotPassword::where('email', $organization->email)->delete();
		$forgot = new ForgotPassword;
		$forgot->email = $organization->email;
		$forgot->token = $token;
		$forgot->save();

		Mail::send([], [], function ($message) use ($organization, $token) {
			$body = "<h1>Hello " . $organization->name . "! </h1>";
			$body .= "<p>
                       We Have received your request to reset the password for your AgentSafeWalk Control-hub account. If you did-not request this change, please contact your AgentSafeWalk rep immediately. Otherwise: Please click the following link to securely reset your password.
                       </p>";
			$body .= "<strong>click here:</strong>" . url('/password/change') . '/' . $token;
			$body .= "<br><strong>Do not reply to this email. It has been automatically generated.<strong>";

			$message->to($organization->email)->subject('AgentSafeWalk | Forget Password Verification')->setBody($body, 'text/html');
		});
		$request->session()->flash('success', 'password Verification Link has been sent to your email address kindly. check it out & change the password safely...');
		return response()->json(['response' => 'success']);

	}

	public function password_change_view(Request $request, $token) {

		$requested_by = ForgotPassword::where('token', $token)->exists();
		if (!$requested_by) {
			$request->session()->flash('error', 'Request Timeout! verification link has been expired make a new request');
			return redirect('/');
		}
		return view('contact_center.password_change', ['token' => $token]);
	}

	public function change_password_cc(Request $request) {

		$requested_by = ForgotPassword::where('token', $request->token)->first();
		$org = Organizations::where('email', $requested_by->email)->first();
		$org->password = md5($request->input('password'));

		$save = $org->save();
		if ($save) {
			ForgotPassword::where('email', $org->email)->delete();
			$request->session()->flash('success', 'Password Changed Successfully...');
			return response()->json(['response' => 'success']);
		} else {
			$request->session()->flash('error', 'there is an issue while changing password try with new request');
			return response()->json(['response' => 'unsuccess']);
		}

	}

	public function tags(Request $request) {
		$tags = Tags::withCount('tag_members')->where('organization_id', session('contact_center_admin.0.organization_id'))->get();
		return view('contact_center.tags.tags', ["tags" => $tags]);

	}

	public function add_tag(Request $request) {
		$tag_name = $request->input('tag');

		if (Tags::where('tag_name', $tag_name)->where('organization_id', session('contact_center_admin.0.organization_id'))->exists()) {
			return response()->json(array('msg' => 'Tag already exists'));
		} else {
			$tag = new Tags();
			$tag->tag_id = Uuid::uuid1();
			$tag->tag_name = $tag_name;
			$tag->organization_id = session('contact_center_admin.0.organization_id');
			$tag->save();
			return response()->json(array('msg' => 'success'));
		}
	}

	public function add_multiple_tags(Request $request) {
		try {
			if ($request->hasFile('csv')) {
				$results = $this->csvToArray($request->file('csv'));
				foreach ($results as $result) {
					if (!Tags::where('tag_name', $result['tag'])->where('organization_id', session('contact_center_admin.0.organization_id'))->exists()) {
						$tag = new Tags();
						$tag->tag_id = Uuid::uuid1();
						$tag->tag_name = $result['tag'];
						$tag->organization_id = session('contact_center_admin.0.organization_id');
						$tag->save();
					}
				}
				return response()->json(array('msg' => 'success'));
			}

		} catch (\Exception $e) {
			return response()->json(array('msg' => 'An error occurred during adding tags, please try again'));
		}
	}

	public function edit_tag(Request $request) {
		$tag_id = $request->input('tag_id');
		$tag_name = $request->input('tag');

		if (Tags::where('tag_name', $tag_name)->where('organization_id', session('contact_center_admin.0.organization_id'))->where('tag_id', '!=', $tag_id)->exists()) {
			return response()->json(array('msg' => 'Tag already exists'));
		} else {
			$tag = Tags::where('tag_id', '=', $tag_id)->first();
			$tag->tag_name = $tag_name;
			$tag->save();
			return response()->json(array('msg' => 'success'));
		}
	}

	public function assign_tag(Request $request) {
		$tag_id = $request->input('tag_id');
		$user_ids = $request->input('user_ids');

		TagMembers::where('tag_id', $tag_id)->delete();

		if (is_array($user_ids)) {
			foreach ($user_ids as $user_id) {
				$result_explode = explode(',', $user_id);
				$type = $result_explode[0];
				$user_id = $result_explode[1];
				$tag_member = new TagMembers();
				$tag_member->tag_id = $tag_id;
				$tag_member->type = $type;
				$tag_member->user_id = $user_id;
				$tag_member->save();
			}
		}
		return response()->json(array('msg' => 'success'));
	}

	public function assign_tag_users(Request $request) {
		$user_id = $request->input('user_id');
		$tag_ids = $request->input('tag_ids');

		TagMembers::where('user_id', $user_id)->delete();

		if (is_array($tag_ids)) {
			foreach ($tag_ids as $tag_id) {
				$result_explode = explode(',', $tag_id);
				$type = $result_explode[0];
				$tag_id = $result_explode[1];
				$tag_member = new TagMembers();
				$tag_member->tag_id = $tag_id;
				$tag_member->type = $type;
				$tag_member->user_id = $user_id;
				$tag_member->save();
			}
		}
		return response()->json(array('msg' => 'success'));
	}

	public function notification_user_status($user_id, $notification_id, $type) {
		$organization_id = Notifications::where('id', $notification_id)->pluck('organization_id')->first();
		$time_zone_id = Organizations::where('organization_id', $organization_id)->pluck('timezone_id')->first();
		$timezone_code = TimeZone::where('id', $time_zone_id)->pluck('timezone_code')->first();
		$current_time = new DateTime('now', new DateTimeZone($timezone_code));

		if ($notification = NotificationUserStatus::where('user_id', $user_id)->where('notification_id', $notification_id)->first()) {
			if ($type == 1) {
				$notification->sms = $current_time;
			}
			if ($type == 2) {
				$notification->email = $current_time;
			}
			if ($type == 3) {
				$notification->notification = $current_time;
			}
			$notification->save();
		} else {
			$notification = new NotificationUserStatus();
			$notification->user_id = $user_id;
			$notification->notification_id = $notification_id;
			if ($type == 1) {
				$notification->sms = $current_time;
			}
			if ($type == 2) {
				$notification->email = $current_time;
			}
			if ($type == 3) {
				$notification->notification = $current_time;
			}
			$notification->save();
		}
		return Redirect::to('http://confirms.agentsafewalk.com/');

	}

	function fetchTinyUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return '' . $data . '';
	}

	public function notification_templates() {
		$templates = Templates::where('organization_id', session('contact_center_admin.0.organization_id'))->orderBy('id', 'desc')->get();
		return view('contact_center.notifications.notification-templates', compact('templates'));
	}
	public function add_template(Request $request) {
		$template = new Templates;
		$template->organization_id = session('contact_center_admin.0.organization_id');
		$template->title = $request->title;
		$template->notification = $request->notification;
		$template->save();
		echo 'Created successfully';
	}
	public function edit_template(Request $request) {
		$template = Templates::find($request->template_id);
		$template->title = $request->title;
		$template->notification = $request->notification;
		$template->save();
		echo 'Updated successfully';
	}
	public function delete_template(Request $request) {
		$template = Templates::find($request->id)->delete();
		echo 'Deleted successfully';
	}
	function getTemplate(Request $request) {

		$template = Templates::find($request->template_id);
		return response()->json(['response' => $template]);
	}
}
