<?php

namespace App\Http\Controllers\API;

use App;
use App\Http\Controllers\Controller;
use App\Services\ISubscription;
use App\Services\PaymentService;
use App\Services\Users\UserService;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Cashier\Exceptions\CustomerAlreadyCreated;
use Laravel\Cashier\Exceptions\PaymentActionRequired;
use Laravel\Cashier\Exceptions\PaymentFailure;
use Stripe\Exception\ApiErrorException;
use Stripe\PaymentMethod;

/**
 * Class PaymentController
 * @package App\Http\Controllers\API
 */
class PaymentController extends Controller {

    /** @var PaymentService $paymentService */
    public $paymentService;

    /** @var UserService $userService */
    public $userService;

    /** @var $secret */
    public $secret;

    /**
     * PaymentController constructor.
     */
    public function __construct() {
        $this->userService    = App::make( UserService::class );
        $this->paymentService = new PaymentService();
        $this->secret         = 'sk_test_51KgXDtLP4vuCnKzH86jxCnQXv7GEZjoxiCbfYvS5KDl2HW3YCxGEr0TksPToET2pQeMHbSmt26bdtmriwbzmjGye00i6ae9ngW';
    }

    /**
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function fetchAllPlans(): JsonResponse
    {
        \Stripe\Stripe::setApiKey( $this->secret );
        $plans = \Stripe\Plan::all();

        return response()->json( [
            'data'   => $plans,
            'status' => IResponseCodes::SUCCESS
        ] );
    }

    /**
     * @param $plan
     *
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function retrieve( $plan ): JsonResponse
    {
        \Stripe\Stripe::setApiKey( $this->secret );
        $plan = \Stripe\Plan::retrieve( $plan );

        return response()->json( [
            'data'   => $plan,
            'status' => IResponseCodes::SUCCESS
        ] );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws PaymentActionRequired
     * @throws PaymentFailure
     */
    public function createSubscription( Request $request ): JsonResponse
    {

        if ( isset( $request['payment_method_id'], $request['plan_id'] ) ) {
            /** @var App\Models\User $user */
            $user = Auth::user();
            if ( count( $user->subscriptions ) == 0) {

                $user->newSubscription(ISubscription::PRIMARY, $request['plan_id'] )
                     ->create( $request['payment_method_id'] );

                return response()->json( [
                    'msg'    => 'Successful Subscribed',
                    'status' => IResponseCodes::SUCCESS
                ] );
            }

            return response()->json( [
                'msg'    => 'Already Subscribed to a Plan!',
                'status' => IResponseCodes::SUCCESS
            ] ); //
        }

        return response()->json( [
            'msg'    => 'Parameters Invalid!',
            'status' => IResponseCodes::UNAUTHORISED
        ] );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws PaymentActionRequired
     * @throws PaymentFailure
     */
    public function redeemSubscription( Request $request ): JsonResponse
    {

        if ( isset( $request['payment_method_id'], $request['plan_id'] ) ) {
            /** @var App\Models\User $user */
            $user = Auth::user();
            $user->newSubscription(ISubscription::PRIMARY, $request['plan_id'] )
                     ->withCoupon('TOFFC')
                     ->create( $request['payment_method_id'] );

            return response()->json( [
                'msg'    => 'Successful Subscribed',
                'status' => IResponseCodes::SUCCESS
            ] );
        }

        return response()->json( [
            'msg'    => 'Parameters Invalid!',
            'status' => IResponseCodes::UNAUTHORISED
        ] );
    }

    /**
     * @return JsonResponse
     */
    public function fetchPaymentMethod(): JsonResponse
    {

        /** @var App\Models\User $user */
        $user = Auth::user();

        if ( $user->hasPaymentMethod() ) {
            $paymentMethod = $user->paymentMethods()[0]->id;

            return response()->json( [
                'data'   => $paymentMethod,
                'status' => IResponseCodes::SUCCESS
            ] );
        }

        return response()->json( [
            'data'   => null,
            'msg'    => 'No Payment Method Found',
            'status' => IResponseCodes::SUCCESS
        ] );
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     * @throws ApiErrorException
     */
    public function addPaymentMethod( Request $request ): JsonResponse
    {

        if ( isset( $request['number'], $request['expiry'], $request['cvc'], $request['name'] ) ) {

            /** @var App\Models\User $user */
            $user = Auth::user();

            $paymentMethod = $this->paymentService->addPaymentMethod( $request, $user );
            if ( $paymentMethod ) {

                return response()->json( [
                    'data'   => $paymentMethod->id,
                    'status' => IResponseCodes::SUCCESS
                ] );
            }

            return response()->json( [
                'data'   => null,
                'msg'    => 'No Payment Method Found',
                'status' => IResponseCodes::SUCCESS
            ] );
        }

        return response()->json( [
            'msg'    => 'Parameters Invalid!',
            'status' => IResponseCodes::UNAUTHORISED
        ] );
    }
}
