<?php
namespace app\components;

use app\components\Stripe\File;
use app\models\Fajl;
use app\models\Felhasznalo;
use yii\base\BaseObject;

class Pdf {

    public static function generate($filename, $html) {
        require_once 'components/dompdf/autoload.php';

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->set_option('isHtml5ParserEnabled', true);
        $dompdf->set_option('isRemoteEnabled', true);
        $dompdf->loadHtml($html, 'UTF-8');
        $dompdf->setPaper('A5', 'landscape');
        $dompdf->render();
        $binary = $dompdf->output();

        $sha1 = sha1($binary);

        $dirPath = 'storage/blobs/' . substr($sha1, 0, 2);
        $filePath = 'storage/blobs/' . substr($sha1, 0, 2) . '/' . $sha1;

        if (!file_exists($filePath)) {
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }

            // Save file
            file_put_contents($filePath, $binary);
        }

        $fileModel = new Fajl;
        $fileModel->fajlnev = $filename;
        $fileModel->felhasznalo_id = null;
        $fileModel->feltoltve = date('Y-m-d H:i:s');
        $fileModel->sha1 = $sha1;
        $fileModel->meret = strlen($binary);
        $fileModel->save(false);

        return $fileModel;
    }

}