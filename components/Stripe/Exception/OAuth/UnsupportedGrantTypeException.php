<?php

namespace app\components\Stripe\Exception\OAuth;

/**
 * UnsupportedGrantTypeException is thrown when an unuspported grant type
 * parameter is specified.
 */
class UnsupportedGrantTypeException extends OAuthErrorException
{
}
