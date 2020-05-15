<?php

namespace App\Http\Controllers\Api;
use NotificationChannels\WebPush\HasPushSubscriptions;

use App\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserController extends Controller
{
    use HasPushSubscriptions;
    public function __construct(
        UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }

    public function list(Request $request)
    {
        try {
            $data = $this->userRepository->list();
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
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function create(Request $request)
    {
        $user = $this->userRepository->create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'level' => $request->get('level')
        ]);

        return response()->json([
            'status' => true,
            'message' => 'User created successfully',
            'data' => $user
        ]);
    }

    public function saveToken (Request $request)
    {
        try {
            $user = $this->userRepository->saveToken($request);
            return response()->json([
                'status' => true,
                'code' => Response::HTTP_OK,
                'data' => $user
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'code' => Response::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $ex->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}
