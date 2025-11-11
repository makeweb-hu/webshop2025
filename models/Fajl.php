<?php

namespace app\models;

use app\components\Helpers;
use app\components\Imagelib;
use Yii;

/**
 * This is the model class for table "fajl".
 *
 * @property integer $id
 * @property string $fajlnev
 * @property integer $felhasznalo_id
 * @property string $feltoltve
 * @property string $sha1
 * @property integer $meret
 */
class Fajl extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fajl';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['fajlnev', 'feltoltve', 'sha1', 'meret'], 'required'],
            [['felhasznalo_id', 'meret'], 'integer'],
            [['feltoltve'], 'safe'],
            [['fajlnev', 'sha1'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'fajlnev' => 'Fajlnev',
            'felhasznalo_id' => 'Felhasznalo ID',
            'feltoltve' => 'Feltoltve',
            'sha1' => 'Sha1',
            'meret' => 'Meret',
        ];
    }

    public function getExtension() {
        return str_replace(".", "", strtolower(pathinfo($this->fajlnev, PATHINFO_EXTENSION) ?: ''));
    }

    public static function uploadByUrl($url) {
        $urlParts = explode('/', $url);

        $data = self::download($url);
        $filename = $urlParts[count($urlParts) - 1];
        $binary = $data;
        $sha1 = sha1($binary);

        // Save record

        $dirPath = 'storage/blobs/' . substr($sha1, 0, 2);
        $filePath = 'storage/blobs/' . substr($sha1, 0, 2) . '/' . $sha1;

        if (!file_exists($filePath)) {
            if (!is_dir($dirPath)) {
                mkdir($dirPath);
            }

            // Save file
            file_put_contents($filePath, $binary);
        }

        // Create file model
        $fileModel = new Fajl;
        $fileModel->fajlnev = $filename;
        $fileModel->felhasznalo_id = null;
        $fileModel->feltoltve = date('Y-m-d H:i:s');
        $fileModel->sha1 = $sha1;
        $fileModel->meret = strlen($binary);
        $fileModel->save(false);

        return $fileModel;
    }

    public function resizePhotoContain($width, $height) {
        $path = 'storage/cache/photo/' . $this->getPrimaryKey() . '-'. $width . 'x' . $height . '-contain-white.jpg';
        if (file_exists($path)) {
            return '/' . $path;
        }
        /*
        if (!$this->isPhoto()) {
            return '/img/no-photo.svg?v=1';
        }
        */
        $img = Imagelib::open($this->getFilePath());
        if (!$img) {
            return '/img/no-photo.svg?v=2';
        }
        $resized = Imagelib::contain($img, $width, $height);
        if (!$resized) {

            return '/img/no-photo.svg?v=3';
        }
        Imagelib::save($resized, $path);
        return '/' . $path;
    }

    public function isPhoto() {
        $ext = strtolower($this->getExtension());
        return $ext === 'jpg' || $ext === 'png' || $ext == 'jpeg' || $ext == 'gif' || $ext == 'bmp' || $ext == 'webp';
    }

    public static function download($url) {
        $image = $url;
        $ch = curl_init($image);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $rawdata=curl_exec ($ch);
        return $rawdata;
    }

    public function resizePhotoCover($width, $height) {
        $path = 'storage/cache/photo/' . $this->getPrimaryKey() . '-'. $width . 'x' . $height . '-cover.jpg';
        if (file_exists($path)) {
            return '/' . $path;
        }
        if (!$this->isPhoto()) {
            return '/img/no-photo.jpg?v=1';
        }
        $img = Imagelib::open($this->getFilePath());
        if (!$img) {
            return '/img/no-photo.jpg?v=2';
        }
        $resized = Imagelib::cover($img, $width, $height);
        if (!$resized) {
            return '/img/no-photo.jpg?v=3';
        }
        Imagelib::save($resized, $path);
        return '/' . $path;
    }

    public function getFilePath() {
        return 'storage/blobs/' . substr($this->sha1, 0, 2) . '/' . $this->sha1;
    }

    public function getUrl() {
        return '/' . $this->getFilePath();
    }

    public function generateDownloadUrl() {
        $name = Helpers::random_bytes();
        $ext = $this->getExtension();
        $path = 'storage/cache/download/' . $name . '.' . $ext;
        copy($this->getFilePath(), $path);
        return '/' . $path;
    }
}
