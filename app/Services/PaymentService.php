<?php

namespace App\Services;


use App\Models\User;
use Illuminate\Support\Str;
use Stripe\Exception\ApiErrorException;

/**
 * Class PlanService
 * @package App\Services
 */
class PaymentService {


    /**
     * PartnerService constructor.
     */
    public function __construct() {
        //
    }

    /**
     * @param $request
     * @param $user
     *
     * @return mixed
     * @throws ApiErrorException
     */
    public function addPaymentMethod( $request, $user ) {
        \Stripe\Stripe::setApiKey( config( 'services.stripe.secret' ) );
        $stripeToken = \Stripe\Token::create( array(
            "card" => array(
                "number"    => $request['number'],
                "exp_month" => Str::before( $request['expiry'], '/' ),
                "exp_year"  => Str::after( $request['expiry'], '/' ),
                "cvc"       => $request['cvc'],
                "name"      => $request['name']
            )
        ) );
        $user->createOrGetStripeCustomer( [ 'source' => $stripeToken->id ] );
        $paymentMethod = \Stripe\PaymentMethod::create( [
            'type' => 'card',
            'card' => [
                'token' => $stripeToken->id,
            ],
        ] );
        $user->updateDefaultPaymentMethod( $paymentMethod );

        return $paymentMethod;
    }
}
