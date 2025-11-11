<?php

// File generated from our OpenAPI spec

namespace app\components\Stripe;

/**
 * PaymentMethod objects represent your customer's payment instruments. They can be
 * used with <a
 * href="https://stripe.com/docs/payments/payment-intents">PaymentIntents</a> to
 * collect payments or saved to Customer objects to store instrument details for
 * future payments.
 *
 * Related guides: <a
 * href="https://stripe.com/docs/payments/payment-methods">Payment Methods</a> and
 * <a href="https://stripe.com/docs/payments/more-payment-scenarios">More Payment
 * Scenarios</a>.
 *
 * @property string $id Unique identifier for the object.
 * @property string $object String representing the object's type. Objects of the same type share the same value.
 * @property \app\components\Stripe\StripeObject $acss_debit
 * @property \app\components\Stripe\StripeObject $afterpay_clearpay
 * @property \app\components\Stripe\StripeObject $alipay
 * @property \app\components\Stripe\StripeObject $au_becs_debit
 * @property \app\components\Stripe\StripeObject $bacs_debit
 * @property \app\components\Stripe\StripeObject $bancontact
 * @property \app\components\Stripe\StripeObject $billing_details
 * @property \app\components\Stripe\StripeObject $boleto
 * @property \app\components\Stripe\StripeObject $card
 * @property \app\components\Stripe\StripeObject $card_present
 * @property int $created Time at which the object was created. Measured in seconds since the Unix epoch.
 * @property null|string|\app\components\Stripe\Customer $customer The ID of the Customer to which this PaymentMethod is saved. This will not be set when the PaymentMethod has not been saved to a Customer.
 * @property \app\components\Stripe\StripeObject $eps
 * @property \app\components\Stripe\StripeObject $fpx
 * @property \app\components\Stripe\StripeObject $giropay
 * @property \app\components\Stripe\StripeObject $grabpay
 * @property \app\components\Stripe\StripeObject $ideal
 * @property \app\components\Stripe\StripeObject $interac_present
 * @property \app\components\Stripe\StripeObject $klarna
 * @property \app\components\Stripe\StripeObject $konbini
 * @property bool $livemode Has the value <code>true</code> if the object exists in live mode or the value <code>false</code> if the object exists in test mode.
 * @property null|\app\components\Stripe\StripeObject $metadata Set of <a href="https://stripe.com/docs/api/metadata">key-value pairs</a> that you can attach to an object. This can be useful for storing additional information about the object in a structured format.
 * @property \app\components\Stripe\StripeObject $oxxo
 * @property \app\components\Stripe\StripeObject $p24
 * @property \app\components\Stripe\StripeObject $sepa_debit
 * @property \app\components\Stripe\StripeObject $sofort
 * @property string $type The type of the PaymentMethod. An additional hash is included on the PaymentMethod with a name matching this value. It contains additional information specific to the PaymentMethod type.
 * @property \app\components\Stripe\StripeObject $wechat_pay
 */
class PaymentMethod extends ApiResource
{
    const OBJECT_NAME = 'payment_method';

    use ApiOperations\All;
    use ApiOperations\Create;
    use ApiOperations\Retrieve;
    use ApiOperations\Update;

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\PaymentMethod the attached payment method
     */
    public function attach($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/attach';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }

    /**
     * @param null|array $params
     * @param null|array|string $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\PaymentMethod the detached payment method
     */
    public function detach($params = null, $opts = null)
    {
        $url = $this->instanceUrl() . '/detach';
        list($response, $opts) = $this->_request('post', $url, $params, $opts);
        $this->refreshFrom($response, $opts);

        return $this;
    }
}
