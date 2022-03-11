<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;

class SmsApiChannel
{
    public function send($notifiable, Notification $notification)
    {
        $to = $notifiable->routeNotificationFor('smsapi');

        if (!$to) {
            $to = $notifiable->routeNotificationFor(SmsApiChannel::class);
        }

        if (!$to) {
            return;
        }

        $data = method_exists($notification, 'toSmsApi')
            ? $notification->toSmsApi($notifiable)
            : $notification->toArray();

        if (empty($data)) {
            return;
        }

        if (config('services.sms_api.driver') == 'log') {
            logger(json_encode([
                'to' => $to,
                'data' => $data
            ]));
            logger('SMS to mobile: ' . $to .  ' with message: ' . $data['message']);
        }

        if (config('services.sms_api.driver') == 'api') {
            $response = Http::get(appSettings('sms_api_endpoint'), [
                'key' => appSettings('sms_api_key'),
                'senderid' => appSettings('sms_api_sender_id'),
                'routeid' => appSettings('sms_api_route_id'),
                'contacts' => $to,
                'msg' => $data['
                '],
            ]);

            // if ($response->code !== 200) {
            // throw new \Exception('SMS API error: ' . $response->body());
            // }
            logger('SMS response: ' . $response->body());
        }

        return true;
    }
}