<?php

namespace App\Http\Controllers;

use App\Mail\MailNotify;
use App\Notification;
use App\User;
use App\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Facades\JWTAuth;

class NotificationController extends Controller
{
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }

    public function sendNotificationAllMember(Request $request)
    {
        $userId = JWTAuth::user()->id;
        DB::beginTransaction();
        try {
            $notification = $this->notification->create([
                'title' => $request->get('title'),
                'content' => $request->get('content'),
                'created_by' => $userId,
                'update_by' => $userId,
            ]);
            $userNotification = new UserNotification();
            $userNotification->user_id = $userId;
            $userNotification->notification_id = $notification->id;
            $userNotification->save();
        } catch (QueryException $ex) {
            DB::rollBack();
            return response()->json([
                'status' => 500,
                'message' => $ex
            ]);
        }
        DB::commit();

        $arrEmail = User::select('email')->where('level', '!=', '1')->get()->pluck('email')->toArray();
        $emails = array_values($arrEmail);
        Mail::to($emails)->send(new MailNotify($notification));
        if (Mail::failures()) {
            return response()->Fail('Sorry! Please try again latter');
        } else {
            return response()->json([
                'status' => 200,
                'message' => 'Successfully send in your mail'
            ]);
        }
    }

    public function viewNotification(Request $request)
    {
        $arrEmail = UserNotification::where([['user_id', JWTAuth::user()->id], ['notification_id', $request->id]])->first();
        $arrEmail->is_readed = 1;
        $arrEmail->save();
        $dataNotification = $arrEmail->notification->toArray();
        if ($arrEmail) {
            return response()->json([
                'status' => 200,
                'notification' => $dataNotification
            ]);
        } else {
        }
    }
}
