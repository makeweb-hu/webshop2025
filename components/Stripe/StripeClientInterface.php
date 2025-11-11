<?php

namespace app\components\Stripe;

/**
 * Interface for a Stripe client.
 */
interface StripeClientInterface extends BaseStripeClientInterface
{
    /**
     * Sends a request to Stripe's API.
     *
     * @param string $method the HTTP method
     * @param string $path the path of the request
     * @param array $params the parameters of the request
     * @param array|\app\components\Stripe\Util\RequestOptions $opts the special modifiers of the request
     *
     * @return \app\components\Stripe\StripeObject the object returned by Stripe's API
     */
    public function request($method, $path, $params, $opts);
}
