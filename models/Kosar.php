<?php

namespace app\models;

use app\components\Helpers;
use Yii;

/**
 * This is the model class for table "kosar".
 *
 * @property integer $id
 * @property string $nev
 * @property string $email
 * @property string $telefonszam
 * @property string $idopont
 * @property string $token
 * @property string $parameterek
 * @property integer $megrendelve
 * @property integer $fizetes_id
 * @property integer $szallitas_id
 * @property string $megjegyzes
 * @property integer $vasarlo_id
 * @property integer $afa
 * @property integer $szallitasi_cim_id
 * @property integer $szamlazasi_cim_id
 * @property string $rendelesszam
 * @property integer $szallitasi_dij_afa
 * @property integer $fizetesi_dij_afa
 * @property integer $kedvezmeny_afa
 * @property string $kedvezmeny_hatasa
 * @property integer $szallitasi_dij
 * @property integer $fizetesi_dij
 * @property number $kedvezmeny
 *
 * @property Fizetes $fizetes
 * @property Szallitas $szallitas
 * @property Vasarlo $vasarlo
 * @property Cim $szallitasiCim
 * @property Cim $szamlazasiCim
 */
class Kosar extends \yii\db\ActiveRecord
{
    public $sendEmail = null;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'kosar';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['idopont'], 'safe'],
            [['token'], 'required'],
            [['parameterek'], 'string'],
            [['megrendelve', 'fizetes_id', 'szallitas_id', 'vasarlo_id', 'afa', 'szallitasi_cim_id', 'szamlazasi_cim_id', 'szallitasi_dij', 'fizetesi_dij', 'kedvezmeny'], 'integer'],
            [['nev', 'email', 'telefonszam'], 'string', 'max' => 255],
            [['email'], 'email'],
            [['token'], 'string', 'max' => 100],
            [['megjegyzes'], 'string', 'max' => 512],
            [['rendelesszam'], 'string', 'max' => 20],
            [['fizetes_id'], 'exist', 'skipOnError' => true, 'targetClass' => Fizetes::className(), 'targetAttribute' => ['fizetes_id' => 'id']],
            [['szallitas_id'], 'exist', 'skipOnError' => true, 'targetClass' => Szallitas::className(), 'targetAttribute' => ['szallitas_id' => 'id']],
            [['vasarlo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vasarlo::className(), 'targetAttribute' => ['vasarlo_id' => 'id']],
            [['szallitasi_cim_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cim::className(), 'targetAttribute' => ['szallitasi_cim_id' => 'id']],
            [['szamlazasi_cim_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cim::className(), 'targetAttribute' => ['szamlazasi_cim_id' => 'id']],
            [['kupon_id', 'kedvezmeny_hatasa'], 'safe'],
            [['szallitasi_dij_afa', 'fizetesi_dij_afa'], 'integer', 'min' => 0],
            [['fizetve', 'statusz', 'csomagszam'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nev' => 'Nev',
            'email' => 'Email',
            'telefonszam' => 'Telefonszam',
            'idopont' => 'Idpőpont',
            'token' => 'Token',
            'parameterek' => 'Parameterek',
            'megrendelve' => 'Megrendelve',
            'fizetes_id' => 'Fizetes ID',
            'szallitas_id' => 'Szallitas ID',
            'megjegyzes' => 'Megjegyzes',
            'vasarlo_id' => 'Vasarlo ID',
            'afa' => 'Afa',
            'szallitasi_cim_id' => 'Szallitasi Cim ID',
            'szamlazasi_cim_id' => 'Szamlazasi Cim ID',
            'rendelesszam' => 'Rendelesszam',
            'customer' => 'Megrendelő',
            'total' => 'Végösszeg',
            'payment_status' => 'Fizetés',
            'shipping_status' => 'Teljesítés',
            'status' => 'Státusz',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayment()
    {
        return $this->hasOne(Fizetes::className(), ['id' => 'fizetes_id']);
    }

    public function getCoupon()
    {
        return $this->hasOne(Kupon::className(), ['id' => 'kupon_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShipping()
    {
        return $this->hasOne(Szallitas::className(), ['id' => 'szallitas_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomer()
    {
        return $this->hasOne(Vasarlo::className(), ['id' => 'vasarlo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getShippingAddress()
    {
        return $this->hasOne(Cim::className(), ['id' => 'szallitasi_cim_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBillingAddress()
    {
        return $this->hasOne(Cim::className(), ['id' => 'szamlazasi_cim_id']);
    }

    public function getItems() {
        return KosarTetel::find()->where(['kosar_id' => $this->getPrimaryKey()])->all();
    }

    public function getVatRate() {
        if ($this->megrendelve) {
            if (is_null($this->afa)) {
                return 0;
            } else {
                return $this->afa / 100;
            }
        } else {
            return intval(Beallitasok::get('afa')) / 100;
        }
    }

    public function getShippingVatRate() {
        if ($this->megrendelve) {
            if (is_null($this->szallitasi_dij_afa)) {
                return ($this->afa ?: 0) / 100;
            } else {
                return $this->szallitasi_dij_afa / 100;
            }
        } else {
            return intval(Beallitasok::get('afa')) / 100;
        }
    }

    public function getPaymentVatRate() {
        if ($this->megrendelve) {
            if (is_null($this->fizetesi_dij_afa)) {
                return ($this->afa ?: 0) / 100;
            } else {
                return $this->fizetesi_dij_afa / 100;
            }
        } else {
            return intval(Beallitasok::get('afa')) / 100;
        }
    }

    public function getItemsTotal() {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getPrice();
        }
        return $sum;
    }

    public function getItemsTotalNet() {
        $sum = 0;
        foreach ($this->items as $item) {
            $sum += $item->getPriceNet();
        }
        return $sum;
    }

    public function getShippingPrice() {
        if ($this->megrendelve) {
            // Már megrendelés
            return $this->szallitasi_dij;
        } else {
            // Még csak kosár
            if ($this->shipping) {
                // Már meg lett adva a szállítási mód
                return $this->shipping->ar ?: 0;
            } else {
                // Még nem lett megadva a szállítási mód
                return 0;
            }
        }
    }

    public function getShippingPriceNet() {
        return $this->getShippingPrice() / (1 + $this->getVatRate());
    }

    public function getPaymentPrice() {
        if ($this->megrendelve) {
            // Már megrendelés
            return $this->fizetesi_dij;
        } else {
            // Még csak kosár
            if ($this->payment) {
                // Már meg lett adva a szállítási mód
                return $this->payment->ar ?: 0;
            } else {
                // Még nem lett megadva a szállítási mód
                return 0;
            }
        }
    }

    public function getPaymentPriceNet() {
        return $this->getPaymentPrice() / (1 + $this->getVatRate());
    }

    public function getDiscount() {
        if ($this->megrendelve) {
            // Már megrendelés
            return -$this->kedvezmeny;
        } else {
            // Még csak kosár
            if (!$this->coupon) {
                return $this->calcCouponDiscount();
            }
        }
    }

    public function spreadDiscountByVatForProducts() {
        $vatsTable = [];
        $totalDiscount = 0;
        foreach ($this->items as $item) {
            if ($totalDiscount + $item->getPrice() > $this->kedvezmeny) {
                $subPrice = $this->kedvezmeny - $totalDiscount;
                if (isset($vatsTable[ $item->afa ])) {
                    $vatsTable[$item->afa] += $subPrice;
                } else {
                    $vatsTable[$item->afa] = $subPrice;
                }
                break;
            } else {
                if (isset($vatsTable[ $item->afa ])) {
                    $vatsTable[$item->afa] += $item->getPrice();
                } else {
                    $vatsTable[$item->afa] = $item->getPrice();
                }
                $totalDiscount += $item->getPrice();
            }
            if ($totalDiscount >= $this->kedvezmeny) {
                break;
            }
        }
        return $vatsTable;
    }

    // Szétbontja a termékekre ható kedvezményt áfa szerint, mivel az tételenként eltérhet
    public function spreadDiscountsByVat() {
        if ($this->megrendelve) {
            $type = $this->kedvezmeny_hatasa ?: 'termekek';
        } else {
            $type = $this->coupon->kedvezmeny_hatasa;
        }
        if ($type === 'termekek') {
            return $this->spreadDiscountByVatForProducts();
        } else if ($type === 'szallitasi_dij') {
            return [
                ($this->szallitasi_dij_afa ?: $this->afa) => $this->kedvezmeny,
            ];
        } else {
            // Végösszeg
            $vatsTable = $this->spreadDiscountByVatForProducts();
            $totalDiscount = 0;
            foreach ($vatsTable as $_ => $p) {
                $totalDiscount += $p;
            }
            if ($totalDiscount < $this->kedvezmeny) {
                if ($this->szallitasi_dij) {
                    if ($totalDiscount + $this->szallitasi_dij > $this->kedvezmeny) {
                        $subPrice = $this->kedvezmeny - $totalDiscount;
                    } else {
                        $subPrice = $this->szallitasi_dij;
                    }
                    if (isset($vatsTable[ $this->szallitasi_dij_afa ?: $this->afa ])) {
                        $vatsTable[ $this->szallitasi_dij_afa ?: $this->afa ] += $subPrice;
                    } else {
                        $vatsTable[ $this->szallitasi_dij_afa ?: $this->afa ] = $subPrice;
                    }
                    $totalDiscount += $subPrice;
                }
                if ($totalDiscount < $this->kedvezmeny) {
                    if ($this->fizetesi_dij) {
                        if ($totalDiscount + $this->fizetesi_dij > $this->kedvezmeny) {
                            $subPrice = $this->kedvezmeny - $totalDiscount;
                        } else {
                            $subPrice = $this->fizetesi_dij;
                        }
                        if (isset($vatsTable[ $this->fizetesi_dij_afa ?: $this->afa ])) {
                            $vatsTable[ $this->fizetesi_dij_afa ?: $this->afa ] += $subPrice;
                        } else {
                            $vatsTable[ $this->fizetesi_dij_afa ?: $this->afa ] = $subPrice;
                        }
                    }
                }
            }
            return $vatsTable;
        }
    }

    public function getDiscountNet() {
        $vatsTable = $this->spreadDiscountsByVat();
        $totalDiscountNet = 0;
        foreach ($vatsTable as $vat => $discountGross) {
            $vatRate = intval($vat) / 100;
            $totalDiscountNet += $discountGross / (1 + $vatRate);
        }
        return -$totalDiscountNet;
    }

    public function calcCouponDiscount() {
        // TODO
        return 0;
    }

    public function getTotal() {
        $sum = $this->getItemsTotal();

        $sum += $this->getShippingPrice();
        $sum += $this->getPaymentPrice();
        $sum += $this->getDiscount();

        return $sum;
    }

    public function getNetTotal() {
        $sum = $this->getItemsTotalNet();

        $sum += $this->getShippingPriceNet();
        $sum += $this->getPaymentPriceNet();
        $sum += $this->getDiscountNet();

        return $sum;
    }

    public function getTotalVat() {
        return $this->getTotal() - $this->getNetTotal();
    }

    public function postProcess() {
        if ($this->coupon && (!$this->kedvezmeny || $this->kedvezmeny != $this->calcCouponDiscount())) {
            $this->kedvezmeny = $this->calcCouponDiscount();
            $this->kedvezmeny_hatasa = $this->coupon->kedvezmeny_hatasa;
            $this->save(false);
        }

        if ($this->sendEmail === 'true') {
            $attachment = '';

            $invoices = $this->getInvoices();
            if (count($invoices) > 0) {
                $attachment = 'storage/szamlazzhu/pdf/' . $invoices[count($invoices) - 1]->bizonylatszam . '.pdf';
            }

            if ($this->statusz === 'atveheto') {
                EmailSablon::findOne(4)->send($this->getPrimaryKey(), $this->email, $attachment);
            } else if ($this->statusz === 'kiszallitas_alatt') {
                EmailSablon::findOne(5)->send($this->getPrimaryKey(), $this->email, $attachment);
            } else if ($this->statusz === 'elvetve') {
                EmailSablon::findOne(7)->send($this->getPrimaryKey(), $this->email);
            } else if ($this->statusz === 'adatok_modositva') {
                EmailSablon::findOne(8)->send($this->getPrimaryKey(), $this->email);
            }
        }
    }

    public function beforeUpdate($data) {
        if ($this->kupon_id == 0) {
            $this->kupon_id = null;
            $this->save(false);
        }
    }

    public static function createNewCart() {
        $model = new Kosar;
        $model->token = Helpers::random_bytes();
        $model->idopont = date('Y-m-d H:i:s');
        $model->afa = intval(Beallitasok::get('afa'));
        $model->save(false);
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => $model->token,
            'expire' => time() + 86400 * 365,
        ]));
        return $model;
    }

    public static function current($create = false) {
        $sessionToken = Yii::$app->request->cookies->getValue('cart', '');
        $session = Kosar::findOne(['token' => $sessionToken]);
        if ($session) {
            return $session;
        }
        if (!$create) {
            return null;
        }
        $model = new Kosar;
        $model->token = Helpers::random_bytes();
        $model->idopont = date('Y-m-d H:i:s');
        $model->afa = intval(Beallitasok::get('afa'));
        $model->save(false);
        Yii::$app->response->cookies->add(new \yii\web\Cookie([
            'name' => 'cart',
            'value' => $model->token,
            'expire' => time() + 86400 * 365,
        ]));
        return $model;
    }

    public static function nr() {
        $cart = self::current();
        if (!$cart) {
            return 0;
        }
        return count($cart->items);
    }

    public function columnViews() {
        return [
            'idopont' => function () {
                return $this->megrendeles_idopontja ?: $this->idopont;
            },
            'customer' => function () {
                return $this->customer ? $this->customer->nev : ($this->nev ?: $this->email ?: ($this->shipping ? $this->shipping->nev : '(ismeretlen)'));
            },
            'payment_status' => function () {
                if ($this->fizetve == 1) {
                    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                  <svg class="mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  Fizetve
                </span>';
                }
                if ($this->fizetve == 2) {
                    return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                  <svg class="mr-1.5 h-2 w-2 text-red-400" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  Visszatérítve
                </span>';
                }
                return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                  <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  Nincs fizetve
                </span>';
            },
            'shipping_status' => function () {
                $color = 'gray';
                if ($this->statusz === 'torolve') {
                    $color = 'red';
                } else if ($this->statusz === 'teljesitve') {
                    $color = 'green';
                } else if ($this->statusz === 'atveheto' || $this->statusz === 'kiszallitas_alatt') {
                    $color = 'blue';
                }
                return '<span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-'.$color.'-100 text-'.$color.'-800">
                  <svg class="mr-1.5 h-2 w-2 text-'.$color.'-400" fill="currentColor" viewBox="0 0 8 8">
                    <circle cx="4" cy="4" r="3" />
                  </svg>
                  '.Kosar::statuses()[$this->statusz].'
                </span>';
            },
            'status' => function () {
                $html = '';
                $html .= $this->columnViews()['payment_status']();
                $html .= ' ';
                $html .= $this->columnViews()['shipping_status']();
                return $html;
            },
            'total' => function () {
                return number_format($this->getTotal(), 0, ',', ' ') . ' Ft';
            }
        ];
    }

    public static function statuses() {
        return [
            'nincs_teljesitve' => 'Nincs teljesítve',
            'adatok_modositva' => 'Adatok módosítva',
            'atveheto' => 'Átvehető',
            'kiszallitas_alatt' => 'Kiszállítás alatt',
            'teljesitve' => 'Teljesítve',
            'elvetve' => 'Törölve',
        ];
    }

    public function getInvoices() {
        if (!$this->megrendelve) {
            return [];
        }
        return Szamla::find()->where(['kosar_id' => $this->getPrimaryKey()])->all();
    }

    public function getItemsForInvoice() {
        $items = [];
        foreach ($this->items as $item) {
            $items[] = [
                'name' => $item->termeknev ? $item->termeknev : ($item->product ? $item->product->nev : '(termék neve)'),
                'amount' => $item->mennyiseg,
                //'quantity_unit' => 'db',
                'unit' => trim($item->product ? $item->product->unit->rovid_nev : 'db') ?: 'db',
                'unit_price_gross' => $item->egysegar,
                'price_gross' => $item->egysegar * $item->mennyiseg,
                'price_net' => ($item->egysegar * $item->mennyiseg) / (1 + $item->getVatRate()),
                'unit_price_net' => $item->egysegar / (1 + $item->getVatRate()),
                'vat' => $item->afa ?: 0,
                'comment' => '', // TODO: variation, sku etc.
            ];
        }
        if ($this->szallitasi_dij) {
            $items[] = [
                'name' => 'Szállítási díj',
                'amount' => 1,
                'unit' => 'db',
                //'quantity_unit' => 'db',
                'unit_price_gross' => $this->szallitasi_dij,
                'price_gross' => $this->szallitasi_dij,
                'price_net' => $this->szallitasi_dij / (1 + $this->getShippingVatRate()),
                'unit_price_net' => $this->szallitasi_dij / (1 + $this->getShippingVatRate()),
                'vat' => $this->szallitasi_dij_afa ?: $this->afa ?: 0,
                'comment' => '',
            ];
        }
        if ($this->fizetesi_dij) {
            $items[] = [
                'name' => 'Fizetés díja',
                'amount' => 1,
                'unit' => 'db',
                //'quantity_unit' => 'db',
                'unit_price_gross' => $this->fizetesi_dij,
                'price_gross' => $this->fizetesi_dij,
                'price_net' => $this->fizetesi_dij / (1 + $this->getPaymentVatRate()),
                'unit_price_net' => $this->fizetesi_dij / (1 + $this->getPaymentVatRate()),
                'vat' => $this->fizetesi_dij_afa ?: $this->afa ?: 0,
                'comment' => '',
            ];
        }
        if ($this->kedvezmeny) {
            $vatsTable = $this->spreadDiscountsByVat();
            foreach ($vatsTable as $discountVat => $discount) {
                $discountVatRate = $discountVat / 100;
                $items[] = [
                    'name' => 'Kedvezmény',
                    'amount' => -1,
                    'unit' => 'db',
                    'quantity_unit' => 'db',
                    'unit_price_gross' => $discount,
                    'price_gross' => $discount,
                    'price_net' => $discount / (1 + $discountVatRate),
                    'unit_price_net' => $discount / (1 + $discountVatRate),
                    'vat' => $discountVat,
                    'comment' => '',
                ];
            }
        }
        return $items;
    }

    public function decrementStock() {
        try {
            foreach ($this->items as $item) {
                $amount = intval($item->mennyiseg);
                $product = $item->product;

                if ($product) {
                    $product->keszlet -= $amount;
                    if ($product->keszlet < 0) {
                        $product->keszlet = 0;
                    }
                    $product->save(false);
                }

                $variation = $item->variation;
                if ($variation) {
                    if ($variation->keszlet) {
                        $variation->keszlet -= $amount;
                        if ($variation->keszlet < 0) {
                            $variation->keszlet = 0;
                        }
                        $variation->save(false);
                    }
                }
            }
        } catch (\Throwable $e) {
            // nop
        }
    }

    public function getDataForEmailTemplate() {
        $items = [];

        foreach ($this->items as $item) {
            $items[] = [
                'termeknev' => $item->termeknev ?: ($item->product ? $item->product->nev : '(termék neve)'),
                'foto_url' => $item->product ? Helpers::rootUrl() . $item->product->getThumbnail() : Helpers::rootUrl() . '/img/product-sample-1.jpg',
                'opciok' => $item->variation ? $item->variation->optionsAsString() : '', // TODO: variation, options
                'mennyiseg' => ($item->mennyiseg . ' db'),
                'ar' => Helpers::formatMoney($item->getPrice()),
            ];
        }

        return [
            'nev' => $this->nev,
            'email' => $this->email,
            'telefonszam' => $this->telefonszam,
            'rendelesszam' => $this->rendelesszam,
            'szallitasi_mod' => $this->shipping->nev,
            'fizetesi_mod' => $this->payment->nev,
            'szallitasi_cim' => $this->shippingAddress->toMultilineHtml(),
            'szamlazasi_cim' => $this->billingAddress->toMultilineHtml(),
            'megjegyzes' => trim($this->megjegyzes) ? [ $this->megjegyzes ] : [],
            'fizetes_menete' => trim($this->payment->fizetesi_instrukcio) ? [ $this->payment->fizetesi_instrukcio ] : [],
            'termekek' => $items,
            'termekek_osszesen' => Helpers::formatMoney($this->getItemsTotal()),
            'szallitas_dija' => $this->szallitasi_dij ? [ Helpers::formatMoney($this->szallitasi_dij) ] : [ '–' ],
            'fizetes_dija' => $this->fizetesi_dij ? [ Helpers::formatMoney($this->fizetesi_dij) ] : [],
            'kedvezmeny' => Helpers::formatMoney($this->getTotalDiscount()),
            'afa_osszesen' => Helpers::formatMoney($this->getTotalVat()),
            'vegosszeg' => Helpers::formatMoney($this->getTotal()),
        ];
    }

    public static function total() {
        $current = self::current();
        if (!$current) {
            return 0;
        }
        return $current->getTotal();
    }

    public function getTotalDiscount() {
        $total = 0;
        foreach ($this->items as $item) {
            $product = $item->product;
            $total += $product->originalPrice() - $product->currentPrice();
        }
        return $total;
    }

    public static function nrOfLikes() {
        $cart = self::current();
        if (!$cart) {
            return 0;
        }
        return count($cart->likes);
    }

    public function getLikes() {
        return KosarKedveles::find()->where([ 'kosar_id' => $this->getPrimaryKey() ])->all();
    }

    public function refreshCart() {
        // Refresh coupon, discount, vat etc.
        if (!$this->megrendelve) {

            // Refresh items
            foreach ($this->items as $item) {
                if (!$item->product) {
                    // A termék már nem létezik
                    $item->delete();
                    continue;
                }
                if (!$item->statusz) {
                    // A termék inaktív lett
                    $item->delete();
                    continue;
                }

                if ($item->variation) {
                    // Variáció
                } else {
                    // Nem variáció
                    $item->egysegar = $item->product->currentPrice();
                    $item->termeknev = $item->product->nev;
                    $item->afa = $item->product->afa ?: intval(Beallitasok::get('afa'));
                    $item->save(false);
                }
            }
        }
    }
}
