<?php
/**
 * Created by PhpStorm.
 * User: minht
 * Date: 5/31/2017
 * Time: 11:46 AM
 */

namespace App\Traits;


use GuzzleHttp\Client;

trait Firebase
{
    public function sendBatchNotification($deviceTokens, $data = [])
    {
//        self::subscribeTopic($deviceTokens, $data['topicName']);
//        self::sendNotification($data, $data['topicName']);
//        self::unsubscribeTopic($deviceTokens, $data['topicName']);
        self::sendNotificationMutipleDevice($deviceTokens, $data);
    }

    public function sendNotification($notifications, $topicName = null)
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $data = [
            "to" => '/topics/' . $topicName,
            "data" => [
                "notification" => $notifications
            ]
        ];
        $this->execute($url, json_encode($data));
    }

    public function subscribeTopic($deviceTokens, $topicName = null)
    {
        $url = 'https://iid.googleapis.com/iid/v1:batchAdd';
        $data = [
            'to' => '/topics/' . $topicName,
            'registration_tokens' => $deviceTokens,
        ];

        $this->execute($url, json_encode($data));
    }

    public function unsubscribeTopic($deviceTokens, $topicName = null)
    {
        $url = 'https://iid.googleapis.com/iid/v1:batchRemove';
        $data = [
            'to' => '/topics/' . $topicName,
            'registration_tokens' => $deviceTokens,
        ];

        $this->execute($url, json_encode($data));
    }

    public function sendNotificationMutipleDevice($deviceTokens = [], $notifications = [])
    {
        $url = 'https://fcm.googleapis.com/fcm/send';
        $deviceTokens = array_values($deviceTokens);
        $data = [
            "registration_ids" => $deviceTokens,
            "data" => [
                "notification" => $notifications
            ]
        ];

        $this->execute($url, json_encode($data));
    }

    public function execute($url, $data = [], $method = 'POST')
    {
        $client = new Client();
        try {
            $result = $client->request($method, $url, [
                'body' => $data,
                'headers' => [
                    'Authorization' => 'key=' . env('FCM_LEGACY_KEY'),
                    'Content-Type' => 'application/json',
                ],
            ]);
        } catch (\Exception $e) {
            throw $e;
        }
        return json_decode($result->getBody(), true);
    }
}
