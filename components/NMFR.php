<?php
namespace app\components;

use app\models\Beallitasok;
use Yii;

class NMFR {
    //public static $USERNAME = 'autovtest';
    //public static $PASSWORD = 'AUTOv2020test';

    private static function validateXml($xmlSource) {
        try {
            $xml = new \DOMDocument();
            $xml->loadXML($xmlSource);

            return !!$xml->schemaValidate('components/nmfr_schema/hu/nmfr/type/product/motorway.xsd');
        } catch (\Throwable $e) {
            return false;
        }
    }

    private static function call($url, $body) {
        try {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, $url);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/xml',
                'Accept: application/xml',
            ]);

            $result = curl_exec($ch);

            if (curl_errno($ch)) {
                return null;
            }

            curl_close($ch);

            return $result;
        } catch (\Throwable $e) {
            return null;
        }
    }

    private static function buildXml($data, $isRoot = true) {
        $xml = $isRoot ? '<?xml version="1.0" encoding="UTF-8"?>' : '';

        $elem = $data[0];
        $attrs = $data[1] ?? [];
        $children = $data[2] ?? [];

        $xml .= '<' . $elem;
        foreach ($attrs as $attrName => $attrValue) {
            $xml .= ' ';
            $xml .= $attrName;
            $xml .= '="';
            $xml .= htmlspecialchars($attrValue, ENT_XML1 | ENT_COMPAT);
            $xml .= '"';
        }
        $xml .= '>';
        if (is_string($children)) {
            $xml .= htmlspecialchars($children, ENT_XML1);
        } else if (is_array($children)) {
            foreach ($children as $child) {
                if (is_string($child)) {
                    $xml .= htmlspecialchars($child, ENT_XML1);
                } else if (is_array($child)) {
                    $xml .= self::buildXml($child, false);
                } else {
                    throw new \RuntimeException('Invalid XML child.');
                }
            }
        } else {
            throw new \RuntimeException('Invalid XML child.');
        }
        $xml .= '</' . $elem . '>';
        return $xml;
    }

    private static function flattenXml($xmlArray, $prefix = '') {
        $flat = [];
        foreach (($xmlArray['attributes'] ?? []) as $k => $v) {
            $flat[$prefix . ':' . $k] = $v;
        }
        if ($xmlArray['content'] ?? null) {
            $flat[$prefix . '.' . $xmlArray['name']] = $xmlArray['content'];
        } else {
            foreach (($xmlArray['children'] ?? []) as $child) {
                $flat = array_merge($flat, self::flattenXml($child, $prefix ? $prefix . '.' . $xmlArray['name'] : $xmlArray['name']));
            }
        }
        return $flat;
    }

    private static function xmlToFlatArray($xmlSource) {
        try {
            $xmlArray = (new XmlToArray())->load_string($xmlSource);
            return self::flattenXml($xmlArray);
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function purchase() {
        /*
        <?xml version="1.0" encoding="UTF-8"?>
        <highwayVignettePurchaseRequest xmlns="http://product.types.nmfr.hu/motorway">
            <context actionId="WEB_LOGIN" requestId="15151561651" requestRootId="156165116151" xmlns="http://common.types.nmfr.hu/commonservice">
                <user>
                    <userId>autovtest</userId>
                    <password>AUTOv2020test</password>
                </user>
            </context>
            <vehicle xmlns="http://product.types.nmfr.hu/motorway">
                <licensePlateNumber xmlns="http://product.types.nmfr.hu/common">BND007</licensePlateNumber>
                <countryCode xmlns="http://product.types.nmfr.hu/common">H</countryCode>
            </vehicle>
            <externalCustomerId>21323213</externalCustomerId>
            <vignetteCategory>VAN</vignetteCategory>
            <vignetteType>YEAR_17</vignetteType>
        </highwayVignettePurchaseRequest>
        */
        $xml = self::buildXml([
            'highwayVignettePurchaseRequest',
            [ 'xmlns' => "http://product.types.nmfr.hu/motorway" ],
            [
                [
                    "context",
                    [
                        "actionId" => "WEB_LOGIN",
                        "requestId" => "15151561651dd",
                        "requestRootId" => "156165116151dee",
                        "xmlns" => "http://common.types.nmfr.hu/commonservice",
                    ],
                    [
                        [
                            "user",
                            [],
                            [
                                [ "userId", [], Beallitasok::get('nmfr_felhasznalonev') ],
                                [ "password", [], Beallitasok::get('nmfr_jelszo') ],
                            ]
                        ]
                    ]
                ],
                [
                    "vehicle",
                    [ "xmlns" => "http://product.types.nmfr.hu/motorway" ],
                    [
                        [
                            "licensePlateNumber",
                            [ "xmlns" => "http://product.types.nmfr.hu/common" ],
                            "BND007",
                        ],
                        [
                            "countryCode",
                            [ "xmlns" => "http://product.types.nmfr.hu/common" ],
                            "H",
                        ],
                    ]
                ],
                [ "externalCustomerId", [], "21323213" ],
                [ "vignetteCategory", [], "VAN" ],
                [ "vignetteType", [], "YEAR_17" ],
            ]
        ]);
        $isXmlValid = self::validateXml($xml);
        if (!$isXmlValid) {
            return null;
        }
        $resposne = self::call(Beallitasok::get('nmfr_purchase_url'), $xml);
        if (!$resposne) {
            return null;
        }
        $json = self::xmlToFlatArray($resposne);
        return $json;
    }
}