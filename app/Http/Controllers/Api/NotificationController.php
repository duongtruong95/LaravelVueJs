<?php

namespace App\Http\Controllers\Api;

use App\Jobs\SendNotificationEmail;
use App\Repositories\Notification\NotificationRepository;
use App\Repositories\UserNotification\UserNotificationRepository;
use App\Traits\Firebase;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;

class NotificationController extends Controller
{
    use Firebase;
    public function __construct(
        NotificationRepository $notificationRepository,
        UserNotificationRepository $userNotificationRepository
    )
    {
        $this->notificationRepository = $notificationRepository;
        $this->userNotificationRepository = $userNotificationRepository;
    }

    public function list(Request $request)
    {
        try {
            $data = $this->notificationRepository->list();
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $data
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $ex->getMessage()
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function sendNotificationAllMember(Request $request)
    {
        try {
            $result = $this->notificationRepository->sendAllMember($request);
            $notifications = [
                'topicName' => 'notification_'. $result['notification']->id,
                'title' => $request->get('title'),
                'body' => $request->get('content'),
                'click_action' => url("/notification/" . $result['notification']->id)
            ];
            if($result['deviceTokens']) {
                $this->sendBatchNotification($result['deviceTokens'], $notifications);
            }
            dispatch(new SendNotificationEmail($result['notification'], $result['arrEmail']));
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'message' => 'Send Notification Successful!'
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $ex->getMessage()
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

    public function getListCheckNotification(Request $request)
    {
        try {
            $data = $this->notificationRepository->userNotification($request->id);
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $data
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $ex->getMessage()
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
