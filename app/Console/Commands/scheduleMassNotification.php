<?php

namespace App\Console\Commands;

use App\GroupMembers;
use App\Invitees;
use App\NotificationGroup;
use App\Notifications;
use App\Users;
use Illuminate\Console\Command;
use Mail;
use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class scheduleMassNotification extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'scheduleMassNotification:sendNotification';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Schedule Mass Notification';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle() {

		$notifications = Notifications::with(['organization.time_zone'])->where('published_at', '!=', NULL)->where('status', 0)->where('is_archive', 0)->get();
		foreach ($notifications as $notification) {
			config(['app.timezone' => $notification['organization']['time_zone']['timezone_code']]);
			date_default_timezone_set(config('app.timezone'));

			if (strtotime($notification->published_at) <= time()) {
				$groups = NotificationGroup::where('notification_id', $notification->id)->pluck('group_id')->all();

				$notification->status = 1;
				$notification->save();
				if ($notification->to_all_users == 0) {

					$user_ids = GroupMembers::selectRaw('distinct user_id')->whereIn('group_id', $groups)->get()->pluck('user_id');
					$users = Users::whereIn('user_id', $user_ids)->get();
					$invitees_users = Invitees::whereIn('id', $user_ids)->get();
				} else {
					$users = Users::where('organization_id', session('contact_center_admin.0.organization_id'))->where('device_token', '!=', NULL)->where('is_push', 1)->get();
					$invitees_users = Invitees::where('organization_id', $notification['organization']['organization_id'])->get();
					$firebase_tokens = Users::where('organization_id', $notification['organization']['organization_id'])->where('device_token', '!=', NULL)->where('is_push', 1)->pluck('device_token')->all();
				}

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
								$message->to($user->email)->subject($notification->priority . $notification->title . ' - ' . $notification['organization']['organization_name'])->setBody($body, 'text/html');

							});

						} catch (\Exception $e) {

						}

						$body = $notification->priority . ' ' . $notification->title . ' - ' . $notification['organization']['organization_name'] . "\n\n" . $notification->title . "\n\n";
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
						}
					}

					//Notification
					$fields = array(
						'notification' => array(
							'id' => $notification->id,
							'title' => $notification->priority . ' ' . "\n\n" . $notification->title,
							'text' => $notification->notification,
							'organization_id' => $notification->organization_id,
							'type' => $notification->type,
							'path' => $notification->path,
							'priority' => $notification->priority,
							'created_at' => $notification->created_at,
							'sound' => 'default',
						),
						'data' => array(
							'id' => $notification->id,
							'title' => $notification->priority . ' ' . "\n\n" . $notification->title,
							'text' => $notification->notification,
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
								$message->to($user->email)->subject($notification->priority . ' ' . $notification->title . ' - ' . $notification['organization']['organization_name'])->setBody($body, 'text/html');

							});

						} catch (\Exception $e) {

						}

						$body = $notification->priority . ' ' . $notification->title . ' - ' . $notification['organization']['organization_name'] . "\n\n" . $notification->title . "\n\n";
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

	}

	protected function fetchTinyUrl($url) {
		$ch = curl_init();
		$timeout = 5;
		curl_setopt($ch, CURLOPT_URL, 'http://tinyurl.com/api-create.php?url=' . $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
		$data = curl_exec($ch);
		curl_close($ch);
		return '' . $data . '';
	}
}
