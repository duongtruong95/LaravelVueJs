<?php

namespace App\Repositories\User;

use App\Notification;
use App\Repositories\BaseRepository;
use App\User;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class  UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @var Notification
     */
    protected $model;

    /**
     * UserRepository constructor.
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function list()
    {
        $items = User::paginate(5);
        $items->map(function ($item) {
            $item->level = $item->level ? "admin" : "user";
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

    public function saveToken($request)
    {
        DB::beginTransaction();
        try {
            User::where('device_token', $request->get('fcm_token'))->update(['device_token' => null]);
            $user = User::find(JWTAuth::user()->id)->update(['device_token' => $request->get('fcm_token')]);
            DB::commit();
            return  $user;
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
