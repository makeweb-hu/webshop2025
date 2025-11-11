<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "felhasznalo".
 *
 * @property integer $id
 * @property string $email
 * @property string $jelszo_hash
 * @property string $letrehozva
 * @property integer $ertesites
 *
 * @property Munkamenet[] $munkamenets
 */
class Felhasznalo extends \yii\db\ActiveRecord
{
    public $tempPassword;

    public static function roleNames() {
        return [
            'superadmin' => 'Szuperadmin',
            'admin' => 'Admin',
            'moderator' => 'Moderátor',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'felhasznalo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'nev', 'jogosultsag'], 'required'],
            [['letrehozva'], 'safe'],
            [['tempPassword'], 'string', 'min' => 10],
            [['email', 'jelszo_hash'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['jogosultsag', 'profilkep_id', 'ketfaktoros_kulcs', 'ertesites'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev' => 'Név',
            'email' => 'E-mail cím',
            'jelszo_hash' => 'Jelszo Hash',
            'letrehozva' => 'Létrehozás időpontja',
            'jogosultsag' => 'Jogosultsag',
            'tempPassword' => 'Ideiglenes jelszó',
            'fancy_name' => 'Név',
            'twofactor' => '2FA',
            'ertesites' => 'E-mail értesítés',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSessions()
    {
        return $this->hasMany(Munkamenet::className(), ['felhasznalo_id' => 'id']);
    }

    public static function current() {
        $session = Munkamenet::current();
        return $session ? $session->user : null;
    }

    public function getFile() {
        return Fajl::findOne(['id' => $this->profilkep_id]);
    }

    public function columnViews() {
        return [
            'jogosultsag' => function () {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                    '.self::roleNames()[$this->jogosultsag].'
                </span>';
            },
            'fancy_name' => function () {
                return '<span class="flex items-center">'.$this->getProfileImg(30) . $this->nev.'</span>';
            },
            'twofactor' => function () {
                if (!$this->ketfaktoros_kulcs) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fa-regular fa-circle-xmark mr-1"></i> Nincs beállítva
                            </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-circle-check text-green-500 mr-1"></i> Beállítva
                            </span>';
            },
            'ertesites' => function () {
                if (!$this->ertesites) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                <i class="fa-regular fa-circle-xmark mr-1"></i> Nem kér értesítést
                            </span>';
                }
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                <i class="fa-solid fa-envelope text-green-500 mr-1"></i> Kér értesítést
                            </span>';
            },
        ];
    }

    public function beforeCreate() {
        $this->jelszo_hash = password_hash($this->tempPassword ?: Helpers::random_bytes(8), PASSWORD_DEFAULT);
        $this->letrehozva = date('Y-m-d H:i:s');
    }

    public function log($type, $params = []) {
        $record = new FelhasznaloNaplo;
        $record->felhasznalo_id = $this->getPrimaryKey();
        $record->letrehozva = date('Y-m-d H:i:s');
        $record->tipus = $type;
        $record->parameterek = json_encode($params);
        $record->save(false);
    }

    public function getProfilePic() {
        $f = $this->file;
        if ($f) {
            return $f->resizePhotoCover(100, 100);
        }
        return '/img/no-profile-pic.webp';
    }

    public function getProfileImg($width = 50) {
        return '<img src="'.$this->profilePic.'" class="mr-2 rounded-full" style="width: '.$width.'px;" />';
    }

    public function isSuperadmin() {
        return $this->jogosultsag === 'superadmin';
    }

    public function isAdmin() {
        return $this->jogosultsag === 'superadmin' || $this->jogosultsag === 'admin';
    }

    public function isModerator() {
        return $this->jogosultsag === 'superadmin' || $this->jogosultsag === 'admin' || $this->jogosultsag === 'moderator';
    }
}
