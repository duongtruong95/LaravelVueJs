<?php
namespace App\Repositories\Notification;

interface NotificationRepositoryInterface
{
    public function sendAllMember($request);
    public function list();
    public function userNotification($request);
}
