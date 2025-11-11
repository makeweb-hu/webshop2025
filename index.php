<?php

error_reporting(E_ERROR | E_PARSE);

function password_protection($protect, $login, $callback) {
    if ($protect) {
        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];
        if (isset($_SERVER['PHP_AUTH_USER']) && $username === $login["username"] && $password === $login["password"]) {
            $callback();
        } else {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'You have to log in to access the website.';
            exit;
        }
    } else {
        $callback();
    }
}

$protect = false;

password_protection($protect, array(
    "username" => "admin",
    "password" => "admin"
), function () {
    // comment out the following two lines when deployed to production
     defined('YII_DEBUG') or define('YII_DEBUG', true);
     defined('YII_ENV') or define('YII_ENV', 'dev');

    defined('WEB_ROOT') or define('WEB_ROOT', dirname(__FILE__));

    require(__DIR__ . '/vendor/autoload.php');
    require(__DIR__ . '/vendor/yiisoft/yii2/Yii.php');

    $config = require(__DIR__ . '/config/web.php');

    (new yii\web\Application($config))->run();
});