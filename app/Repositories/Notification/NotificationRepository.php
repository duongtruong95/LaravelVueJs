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
                'updated_by' => $userId,
            ]);
            $dataUser = User::select('email', 'id', 'device_token')->where('level', '!=', '1')->get();
            $arrIdUser = $dataUser->pluck('id');
            $arrEmail = array_values($dataUser->pluck('email')->toArray());
            $deviceTokens = array_values($dataUser->whereNotNull('device_token')->pluck('device_token')->toArray());
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
                'arrEmail' => $arrEmail,
                'deviceTokens' => $deviceTokens,
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function list()
    {
        if (JWTAuth::user()->level) {
            $items = Notification::paginate(2);
        } else {
            $items = Notification::whereHas('users', function ($q) {
                $q->where('users.id', JWTAuth::user()->id);
            })->paginate(2);
        }
        $items->map(function ($item) {
            $item->created_by = $item->userCreated->name;
            $item->updated_by = $item->userUpdated->name;
            unset($item->userCreated);
            unset($item->userUpdated);
            return $item;
        });
        return [
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ],
            'data' => $items->items()
        ];
    }

    public function userNotification($id)
    {
        $data = Notification::with('users')->find($id);
        $items = $data->users()->paginate(5);
        $items->map(function ($item) use ($data) {
            $item->is_readed = $item->pivot->is_readed;
            unset($item->pivot);
            return $item;
        });
        return [
            'pagination' => [
                'total' => $items->total(),
                'per_page' => $items->perPage(),
                'current_page' => $items->currentPage(),
                'last_page' => $items->lastPage(),
                'from' => $items->firstItem(),
                'to' => $items->lastItem()
            ],
            'data' => [
                'users' => $items->items(),
                'notification' => $data->title
            ]
        ];
    }

}
