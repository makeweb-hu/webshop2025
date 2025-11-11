<?php
namespace app\components;

use app\models\Felhasznalo;

class TwoFactorAuth {
    public static function generateSecret($userEmail) {
        require_once 'components/google-authenticator/autoload.php';
        $issuer = "flavon";
        $accountName = $userEmail;
        $secretFactory = new \Dolondro\GoogleAuthenticator\SecretFactory();
        $secret = $secretFactory->create($issuer, $accountName);
        return $secret;
    }

    public static function getSecret($userEmail) {
        require_once 'components/google-authenticator/autoload.php';
        $user = Felhasznalo::findOne(['email' => $userEmail]);
        if (!$user) {
            return null;
        }
        if (!$user->ketfaktoros_kulcs) {
            $secret = self::generateSecret($userEmail);
            /*
            $user->ketfaktoros_kulcs = $secret->getSecretKey();
            */
            $user->save(false);
            return $secret;
        } else {
            return new \Dolondro\GoogleAuthenticator\Secret("flavon", $userEmail, $user->ketfaktoros_kulcs);
        }
    }

    public static function auth($secret, $userEmail, $code) {
        require_once 'components/google-authenticator/autoload.php';
        $googleAuth = new \Dolondro\GoogleAuthenticator\GoogleAuthenticator();
        $user = Felhasznalo::findOne(['email' => $userEmail]);
        return $googleAuth->authenticate($secret, $code);
    }
}