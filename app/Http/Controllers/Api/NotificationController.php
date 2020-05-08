<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendNotificationEmail;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\Size\SizeRepository;
use App\Repositories\UserNotification\UserNotificationRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    public function __construct(
        NotificationRepository $notificationRepository,
        UserNotificationRepository $userNotificationRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->userNotificationRepository = $userNotificationRepository;
    }

    public function sendNotificationAllMember(Request $request)
    {
        try {
            $result = $this->notificationRepository->sendAllMember($request);
            if($result) {
                dispatch(new SendNotificationEmail($result['notification'], $result['arrEmail']));
                return response()->json([
                    'status' => true,
                    'code' => Response::HTTP_OK,
                    'message' => 'Send Notification Successful!'
                ]);
            }
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $ex
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function viewNotification(Request $request)
    {
        $arrData = $this->userNotificationRepository->viewNotification($request);
        if (!$arrData) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_FORBIDDEN,
                'message' => 'Permisstion Required!',
            ], Response::HTTP_FORBIDDEN);
        }
        return response()->json([
            'status' => true,
            'code' => Response::HTTP_OK,
            'data' => $arrData
        ]);
    }
}
