<?php

namespace App\Repositories\UserNotification;

use App\Notification;
use App\Repositories\BaseRepository;
use App\UserNotification;
use Tymon\JWTAuth\Facades\JWTAuth;

class  UserNotificationRepository extends BaseRepository implements UserNotificationRepositoryInterface
{
    /**
     * @var UserNotification
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param UserNotification $model
     */
    public function __construct(UserNotification $model)
    {
        parent::__construct($model);
    }

    public function viewNotification($request)
    {
        $arrData = UserNotification::where([['user_id', JWTAuth::user()->id], ['notification_id', $request->id]])->first();
        if ($arrData) {
            $arrData->is_readed = 1;
            $arrData->save();
            $dataNotification = $arrData->notification->toArray();
            return $dataNotification;
        } elseif (JWTAuth::user()->level) {
            $arrData = Notification::findOrFail($request->id);
            return $arrData;
        }
        return false;
    }

}
