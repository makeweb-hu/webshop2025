<?php

// File generated from our OpenAPI spec

namespace app\components\Stripe\Service\BillingPortal;

class SessionService extends \app\components\Stripe\Service\AbstractService
{
    /**
     * Creates a session of the customer portal.
     *
     * @param null|array $params
     * @param null|array|\app\components\Stripe\Util\RequestOptions $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\BillingPortal\Session
     */
    public function create($params = null, $opts = null)
    {
        return $this->request('post', '/v1/billing_portal/sessions', $params, $opts);
    }
}
