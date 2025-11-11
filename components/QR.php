<?php
namespace app\components;

class QR {

    public static function generate($url) {
        require_once 'components/simple_qrcode/autoload.php';

        $generator = new \SimpleSoftwareIO\QrCode\Generator;

        return 'data:image/svg+xml;base64,' . base64_encode(
            strval(
                $generator->format('svg')
                    ->size(100)
                    ->generate($url)
            )
        );
    }

}

