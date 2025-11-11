<?php

namespace app\components;
use app\models\Beallitasok;
use app\models\Kosar;
use yii\web\UploadedFile;
use app\components\Imagelib;

use Yii;

class Helpers {

    public static function formatMoney($money, $postfix = ' Ft') {
        return number_format($money, 0, ',', ' ') . $postfix;
    }

    public static function findDefaultName($names) {
        foreach ($names as $name) {
            if ($name['language'] === 'hu') {
                return $name['content'];
            }
        }
        foreach ($names as $name) {
            if ($name['language'] === 'en') {
                return $name['content'];
            }
        }
        return $names[0]['content']; // fallback: first
    }

    public static function setSmpt() {
        Yii::$app->mailer->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => Beallitasok::get('smtp_host'),
            'username' => Beallitasok::get('smtp_username'),
            'password' => Beallitasok::get('smtp_password'),
            'port' => Beallitasok::get('smtp_port'),
            'encryption' => strtolower(Beallitasok::get('smtp_encryption')),
            'streamOptions' => [
                'ssl' => [
                    'allow_self_signed' => true,
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                ],
            ],
        ]);
    }

    public static function isSsl() {
        if ( isset($_SERVER['HTTPS']) ) {
            if ( 'on' == strtolower($_SERVER['HTTPS']) )
                return true;
            if ( '1' == $_SERVER['HTTPS'] )
                return true;
        } elseif ( isset($_SERVER['SERVER_PORT']) && ( '443' == $_SERVER['SERVER_PORT'] ) ) {
            return true;
        }
        return false;
    }

    public static function isEmailValid($email) {
        return !!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", $email);
    }

    public static function isPhoneValid($phone) {
        return !!preg_match("/^\+[0-9]{6,}$/i", $phone);
    }

    public static function rootUrl() {
        if (self::isSsl()) {
            return 'https://' . Beallitasok::get('domain');
        } else {
            return 'http://' . Beallitasok::get('domain');
        }
    }

    public static function humanFileSize($size,$unit="") {
        if( (!$unit && $size >= 1<<30) || $unit == "GB")
            return number_format($size/(1<<30),2)."GB";
        if( (!$unit && $size >= 1<<20) || $unit == "MB")
            return number_format($size/(1<<20),2)."MB";
        if( (!$unit && $size >= 1<<10) || $unit == "KB")
            return number_format($size/(1<<10),2)."KB";
        return number_format($size)." bytes";
    }

    public static function render($path, $params = []) {
        return Yii::$app->controller->renderPartial('@app/themes/main/admin/' . $path, $params);
    }

    public static function isLicencePlateValid($str) {
        $str = strtolower($str);
        return !!preg_match("@^[a-z0-9]{3,25}$@", $str);
    }

    public static function urlWithId($url, $id) {
        if (strpos($url, '?') !== false) {
            return $url . '&id=' . $id;
        } else {
            return $url . '?id=' . $id;
        }
    }

    public static function renderColumn($model, $column) {
        if (method_exists($model, 'columnViews')) {
            $views = $model->columnViews();
        } else {
            $views = [];
        }
        if ($views[$column] ?? null) {
            return $views[$column]() ?: '-';
        }

        // Raw value
        try {
            return $model->$column ?? '-';
        } catch (\Throwable $e) {
            return '-';
        }
    }

    public static function urlWithParam($url, $params = [], $id = '') {
        if ($id) {
            $url .= '?id=' . $id;
        }
        $paramsStr = '';
        foreach ($params as $k => $v) {
            $paramsStr .= $k . '=' . urlencode($v);
        }
        if (strpos($url, '?') !== false) {
            return $url . '&' . $paramsStr;
        } else {
            return $url . '?' . $paramsStr;
        }
    }

    public static function isHungarianLicencePlateValid($str) {
        $str = strtolower($str);
        if (strlen($str) < 3) {
            return false;
        }
        // https://hu.wikipedia.org/wiki/Magyarorsz%C3%A1gi_forgalmi_rendsz%C3%A1mok
        return !!preg_match("@^([a-z]{4}[0-9]{3}|cd[0-9]{6}|i[0-9]{2}[a-z]{2}[0-9]{2}|i[0-9]{3}[a-z]{2}|cd[0-9]{6}|ot[a-z]{2}[0-9]{3}|ra[0-9]{5}|[a-z]{3}[a-z0-9]{0,3}[0-9])$@", $str);
    }

	public static function random_bytes($len = 16) {
		// 256-bit (32 bytes) by default
		// in PHP 7 use \random_bytes($len)
		$binary_str = openssl_random_pseudo_bytes($len);
		return bin2hex($binary_str);
	}

	public static function randomOrderNumber() {
        $hex = Helpers::random_bytes(4);
        $dec = strrev(strval(hexdec($hex)));
        return substr($dec, 0, 8);
    }

    public static function nextOrderNumber() {
        // 16603324
        // 6015874
        return strval(6015874 + intval(Kosar::find()->where(['megrendelve' => 1])->count()) + 1);
    }

    public static function createUrl($text){
        // 1) Töröljük le a whitespace-eket elejéről/végéről
        $text = trim($text);

        // 2) Unicode normalizálás + ékezetek eltávolítása, ha elérhető INTL
        if (class_exists('Transliterator')) {
            // pl. "Árvíztűrő tükörfúrógép" -> "Arvizturo tukorfurogep"
            $trans = Transliterator::create('NFD; [:Nonspacing Mark:] Remove; NFC; Latin-ASCII');
            $text = $trans->transliterate($text);
        } else {
            // Biztonsági fallback
            $text = str_replace(
                ['Á','á','É','é','Í','í','Ó','ó','Ö','ö','Ő','ő','Ú','ú','Ü','ü','Ű','ű'],
                ['A','a','E','e','I','i','O','o','O','o','O','o','U','u','U','u','U','u'],
                $text
            );
            $text = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $text);
        }

        // 3) Kisbetűsítés
        $text = strtolower($text);

        // 4) Nem alfanumerikus karakterek helyére kötőjel
        $text = preg_replace('/[^a-z0-9]+/u', '-', $text);

        // 5) Dupla kötőjelek összevonása
        $text = preg_replace('/-+/', '-', $text);

        // 6) Trimmelés az elejéről-végéről
        $text = trim($text, '-');

        return $text;
    }



    public static function handle_uploaded_photo($model, $img, $img_url) {

        
        $img_path="";
        

         if($img==='img' || $img==='img_mobile')
            {
                $image = UploadedFile::getInstance($model, 'img');
                $path=$img_url;
                $img=$model->img;
            }

            else{
                
                $image = UploadedFile::getInstance($model, 'meta_img');
                $img=$model->meta_img;
                $path=$img_url;
                $img=$model->meta_img;
            }
        

        if (!empty($image)) {


        $img_name=substr(uniqid('', true), -20);
        $img_name = str_replace(".", "", $img_name);

     
            $img = Imagelib::open($image->tempName);
            if ($img) {
                $full_size = Imagelib::contain($img, 5000, 5000);
                Imagelib::save($full_size, $path.$img_name.'.png');
                $img_path="/".$path.$img_name.'.png';
            }

        }


       
        return $img_path;
       
       
    }

    public static function is_valid_email($email) {
        return !!preg_match('/^\s*[a-zA-Z0-9]+([\.\-_][a-zA-Z0-9]+)*@[a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*(\.[a-zA-Z0-9]+(\-[a-zA-Z0-9]+)*)*\.[a-zA-Z]{2,20}\s*$/', $email);
    }




    public static function replaceBase64Images($str) {
		return preg_replace_callback('@(data:[^;]+;base64,[^\'"]*)@', function ($match) {
			$data = $match[0];
			if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
				$data = substr($data, strpos($data, ',') + 1);
				$type = strtolower($type[1]); // jpg, png, gif

				if (!in_array($type, [ 'jpg', 'jpeg', 'gif', 'png' ])) {
					throw new \Exception('invalid image type');
				}

				$data = base64_decode($data);

				if ($data === false) {
					throw new \Exception('base64_decode failed');
				}
			} else {
				throw new \Exception('did not match data URI with image data');
			}
			$filename = "images/editor/image-" . strval(time()) . rand(100000, 999999) . ".{$type}";
			file_put_contents($filename, $data);
			
			return \yii\helpers\Url::base(true) . "/" . $filename; // Abszolút URL, hogy pl. email template-eknél is működjön
		}, $str);
	}
	
}

?>