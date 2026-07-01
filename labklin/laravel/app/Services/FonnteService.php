<?php

namespace App\Services;

use App\Models\NotificationSetting;

class FonnteService
{
    public static function send($target, $message, $schedule = null)
    {
        $setting = NotificationSetting::first();

        if (!$setting || !$setting->is_active || !$setting->api_token) {
            return false;
        }

        $postFields = [
            'target' => $target,
            'message' => $message,
        ];

        if ($schedule) {
            $postFields['schedule'] = $schedule;
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $postFields,
            CURLOPT_HTTPHEADER => array(
                'Authorization: ' . $setting->api_token
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
