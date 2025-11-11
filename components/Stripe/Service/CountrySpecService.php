<?php

// File generated from our OpenAPI spec

namespace app\components\Stripe\Service;

class CountrySpecService extends \app\components\Stripe\Service\AbstractService
{
    /**
     * Lists all Country Spec objects available in the API.
     *
     * @param null|array $params
     * @param null|array|\app\components\Stripe\Util\RequestOptions $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\Collection<\app\components\Stripe\CountrySpec>
     */
    public function all($params = null, $opts = null)
    {
        return $this->requestCollection('get', '/v1/country_specs', $params, $opts);
    }

    /**
     * Returns a Country Spec for a given Country code.
     *
     * @param string $id
     * @param null|array $params
     * @param null|array|\app\components\Stripe\Util\RequestOptions $opts
     *
     * @throws \app\components\Stripe\Exception\ApiErrorException if the request fails
     *
     * @return \app\components\Stripe\CountrySpec
     */
    public function retrieve($id, $params = null, $opts = null)
    {
        return $this->request('get', $this->buildPath('/v1/country_specs/%s', $id), $params, $opts);
    }
}
