<?php

// File generated from our OpenAPI spec

namespace app\components\Stripe\Service;

class MandateService extends \app\components\Stripe\Service\AbstractService
{
    /**
     * Retrieves a Mandate object.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\app\components\Stripe\Util\RequestOptions $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\Mandate
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/v1/mandates/%s', $id), $params, $opts);
    }
}
