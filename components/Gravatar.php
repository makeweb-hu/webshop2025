<?php
namespace app\components;

class Gravatar {

    public static function generate($email, $size = 256) {
        require "components/jdenticon/vendor/autoload.php";

        $icon = new \Jdenticon\Identicon();
        $icon->setValue($email);
        $icon->setSize($size);

        return $icon->getImageDataUri('png');
    }

}