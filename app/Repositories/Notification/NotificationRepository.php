<?php

namespace App\Repositories\Notification;

use App\Notification;
use App\Repositories\BaseRepository;
use App\User;
use App\UserNotification;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Facades\JWTAuth;

class  NotificationRepository extends BaseRepository implements NotificationRepositoryInterface
{
    /**
     * @var Notification
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param Notification $model
     */
    public function __construct(Notification $model)
    {
        parent::__construct($model);
    }

    public function sendAllMember($request)
    {
        $userId = JWTAuth::user()->id;
        DB::beginTransaction();
        try {
            $notification = parent::create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'created_by' => $userId,
                'update_by' => $userId,
            ]);
            $dataUser = User::select('email', 'id')->where('level', '!=', '1')->get();
            $arrIdUser = $dataUser->pluck('id');
            $arrEmail = array_values($dataUser->pluck('email')->toArray());
            $arrData = [];
            $now = Carbon::now()->toDateTimeString();
            foreach ($arrIdUser as $key => $value) {
                $arrData[$key]['user_id'] = $value;
                $arrData[$key]['notification_id'] = $notification->id;
                $arrData[$key]['created_at'] = $now;
                $arrData[$key]['updated_at'] = $now;
            }
            UserNotification::insert($arrData);
            DB::commit();
            return [
                'notification' => $notification,
                'arrEmail' => $arrEmail
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }


}
