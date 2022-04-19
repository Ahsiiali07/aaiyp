<?php

namespace App\Http\Controllers\API;

use App\Forms\Users\RegisterForm;
use App\Forms\Users\UpdateForm;
use App\Models\User;
use App\Services\INotificationTypes;
use App\Services\Users\UserService;
use App\Traits\NotificationTrait;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Support\Facades\Validator;
use Stripe\Exception\ApiErrorException;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserController extends Controller
{

    /**
     * @var UserService $userService
     */
    private $userService;

    /**
     * UserController constructor.
     */
    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Login api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        if (isset($request['email'], $request['password'], $request['device_token'])) {
            $res = $this->userService->login($request['email'], $request['password'], $request['device_token']);
            if ($res == 'wrong_credentials') {

                return $this->parametersInvalidResponse(trans('Wrong Credentials!'));

            } elseif ($res == 'is_not_verified') {
                $user = $this->userService->fetchByEmail($request['email']);

                $data['user'] = $user;

                return $this->parametersInvalidResponse(trans('Email is not Verified!'), null, $data);

            } elseif ($res == 'is_blocked') {
                $user = $this->userService->fetchByEmail($request['email']);

                $data['user'] = $user;

                return $this->successResponse(trans('User is Blocked!'), $data);

            } else {
                $user = $res;
                $success['user']  = $this->userService->addSubscriptionInfo( $user['id'] );
                $success['token'] = $this->userService->fetchToken($user['id']);

                return $this->successResponse(trans('Logged in!'), $success);
            }
        }
        return $this->parametersInvalidResponse();
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function createChat( Request $request ) {
        /** @var User $user */
        $user = Auth::user();

        if ( $user ) {
            $validated = Validator::make( $request->all(), [
                'data_time'      => 'required',
                'long_data_time' => 'required',
                'receiver_id'    => 'required',
                'sender_id'      => 'required',
            ] );

            if ( $validated->fails() ) {
                return $this->parametersInvalidResponse( null, $validated->errors()->all() );
            }

            $res = $this->userService->createChat( $request->all() );
            if ( $res ) {

                $data['data']            = $res;
                $data['receiver_id']     = $request['receiver_id'];
                $data['long_time_stamp'] = $request['long_data_time'];
                NotificationTrait::sendNotification( $request['sender_id'],
                    [
                        'title'           => 'Chat Scheduled',
                        'description'     => 'A chat has be scheduled with you.',
                        'notification_id' => $res['id']
                    ],
                    INotificationTypes::TYPE_CHAT
                );

                return $this->successResponse( trans( 'Chat schedule Saved!' ), $res );
            }

        }
    }

    /**
     * Forget Password Request api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function forgetPasswordRequest(Request $request): JsonResponse
    {
        if (isset($request['email'])) {
            $res = $this->userService->forgetPasswordRequest($request['email']);
            if ($res) {
                $data['user'] = $this->userService->addSubscriptionInfo( $res['id'] );
                return $this->successResponse(trans('Forget Password Request Sent!'), $data);
            }
            return $this->parametersInvalidResponse();
        }
        return $this->parametersInvalidResponse();
    }

    /**
     * Forget Password Request api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function forgetPasswordPin(Request $request): JsonResponse
    {
        if ($request['pin']) {
            $res = $this->userService->pinMatch($request['pin']);
            if ($res) {
                $data['user'] = $this->userService->addSubscriptionInfo( $res['id'] );

                return $this->successResponse(trans('PIN Matched'), $data);
            }

            return $this->parametersInvalidResponse(trans('Pin does not Match'));
        }

        return $this->parametersInvalidResponse();
    }

    /**
     * Check Otp
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkOtp(Request $request): JsonResponse
    {
        if (isset($request['otp'])) {
            $res = $this->userService->otpMatch($request['otp']);
            if ($res) {
                $user = $res;
                $data['user'] = $this->userService->addSubscriptionInfo( $user['id'] );
                $data['token'] = $this->userService->fetchToken($user['id']);

                return $this->successResponse(trans('OTP Matched!'), $data);
            }

            return $this->parametersInvalidResponse(trans('OTP does not Match'));
        }

        return $this->parametersInvalidResponse();
    }

    /**
     * Generate New Otp
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function generateNewOtp(Request $request): JsonResponse
    {
        if (isset($request['user_id'])) {
            $res = $this->userService->generateNewOtp($request['user_id']);
            if ($res) {
                $user = $this->userService->addSubscriptionInfo( $res['id'] );
                $data['user'] = $user;

                return $this->successResponse(trans('New OTP is created and sent to your email!'), $data);
            }

            return $this->parametersInvalidResponse();
        }

        return $this->parametersInvalidResponse();
    }

    /**
     * Change Password api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function changePasswordPin(Request $request): JsonResponse
    {
        if (isset($request['user_id'], $request['password'])) {
            $res = $this->userService->changePassword($request['user_id'], $request['password']);
            if ($res) {
                $data['user'] = $this->userService->addSubscriptionInfo( $res['id'] );

                return $this->successResponse(trans('Password Changed!'), $data);
            }

            return $this->parametersInvalidResponse();
        }

        return $this->parametersInvalidResponse();
    }

    /**
     * Change Password api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function checkEmail(Request $request): JsonResponse
    {
        if (isset($request['email'])) {
            $res = $this->userService->findByEmail($request['email']);
            if ($res) {
                if ($res['is_verified']) {
                    return $this->successResponse(trans('Your email is verified!'), $res);
                }

                return $this->parametersInvalidResponse(trans('Your email not verified!'), $res);
            }
            return $this->parametersInvalidResponse();
        }
        return $this->parametersInvalidResponse();
    }

    /**
     * Register api
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $validated = Validator::make($request->all(), [
            'email' => 'email|required|unique:users',
            'firstname' => 'required',
            'lastname' => 'required',
            'mobile' => 'required',
            'device_token' => 'required',
            'image'     =>'required',
            'password' => 'required|confirmed|min:6',
            'password_confirmation' => 'required',
        ]);

        if ($validated->fails()) {
            return $this->parametersInvalidResponse(null, $validated->errors()->all());
        }
        $form = new RegisterForm();
        $form->loadFromArray($request->all());
        $user = $this->userService->register($form);
        if ($user) {
            $data['user'] = $this->userService->addSubscriptionInfo( $user['id'] );
            return $this->successResponse(trans('User registered successfully!'), $data);
        }
        return $this->parametersInvalidResponse();
    }

//    /**
//     * @param Request $request
//     * @param $token
//     * @return JsonResponse
//     */
//    public function registerPassword(Request $request, $token): JsonResponse
//    {
//        $validated = Validator::make($request->all(), [
//            'password' => 'required|confirmed|min:6',
//            'password_confirmation' => 'required',
//        ]);
//
//        if ($validated->fails()) {
//            return $this->parametersInvalidResponse(null, $validated->errors()->all());
//        }
//
//        $user = $this->userService->registerPassword($token, $request->all());
//        if ($user) {
//            $data['user'] = $user;
//
//            return $this->successResponse(trans('User password Saved!'), $data);
//        }
//
//        return $this->parametersInvalidResponse();
//
//    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        /** @var User $user */
        $user = Auth::user();

        if ($user) {

            if ($request->email) {
                $validated = Validator::make($request->all(), [
                    'email' => 'required|email|unique:users',
                ]);

                if ($validated->fails()) {
                    return $this->parametersInvalidResponse(null, $validated->errors()->all());
                }
            }


            $form = new UpdateForm();
            $form->loadFromArray($request->all());
            $user = $this->userService->updateDetails($form, $user->id);
            $data['user'] = $this->userService->addSubscriptionInfo( $user['id'] );

            return $this->successResponse(trans('User details updated!'), $data);

        }

        return $this->unAuthorizedResponse();

    }


        /**
     * Details api
     *
     * @return JsonResponse
     */
    public function details(): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $data['user'] = $this->userService->addSubscriptionInfo( $user['id'] );

            return $this->successResponse(null, $data);
        }

        return $this->unAuthorizedResponse();
    }

//    /**
//     * @param $user_id
//     * Details api
//     *
//     * @return JsonResponse
//     */
//    public function getProfile($user_id): JsonResponse
//    {
//        $user = $this->userService->findById($user_id);
//
//        $posts = $this->postService->postsForSpecificUser($user_id);
//
//        if ($user) {
//            $data['user'] = $user;
//            $data['posts'] = $posts->load(
//                'images',
//                'comments',
//                'comments.user',
//                'category',
//                'user',
//                'sale_type',
//                'likes',
//                'is_liked',
//                'comments',
//                'shareByUser'
//            );
//
//            return $this->successResponse(null, $data);
//        }
//
//        return $this->unAuthorizedResponse();
//    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return $this->successResponse(trans('User has successfully logged out!'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function signout(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user) {
            $user->delete();

            return $this->successResponse(trans('Successfully signed out!'));
        }

        return $this->unAuthorizedResponse();
    }

        /**
     * Details api
     *
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        $item=$this->userService->getUser();

        if ($item) {
            return $this->successResponse(trans('Operation Successful!'), $item);
        }
        return $this->parametersInvalidResponse();
    }

    /**
     * Details api
     *
     * @return JsonResponse
     */
    public function getLeader(): JsonResponse
    {
        $item=$this->userService->getLeader();

        if ($item) {
            return $this->successResponse(trans('Operation Successful!'), $item);
        }
        return $this->parametersInvalidResponse();
    }


    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function isSubscribed( Request $request ) {
        $user = Auth::user();

        if ( $user ) {
            if ( count( $user->subscriptions ) > 0 ) {
                return $this->successResponse(trans('User is subscribed!'), $this->userService->addSubscriptionInfo( $user['id'] ));
            }

            return $this->successResponse('User is not subscribed to an package!', $user);

        }

        return $this->unAuthorizedResponse();
    }
}
