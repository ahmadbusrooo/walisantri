<?php
defined('BASEPATH') OR exit('No direct script access allowed');

function send_fcm_notification($token, $title, $message, $data = [])
{
    $CI = &get_instance();
    $CI->load->config('fcm'); // Load konfigurasi FCM
    $server_key = $CI->config->item('fcm_server_key');

    $payload = [
        'to' => $token,
        'notification' => [
            'title' => $title,
            'body' => $message,
            'sound' => 'default'
        ],
        'data' => $data // Data tambahan
    ];

    $headers = [
        'Authorization: key=' . $server_key,
        'Content-Type: application/json'
    ];

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));

    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}
