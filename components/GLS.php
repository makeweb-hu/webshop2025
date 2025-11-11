<?php
namespace app\components;

use Yii;
use yii\base\Component;

class GLS extends Component
{
    public $enableCsrfValidation = false;


    private static $base_url = 'https://api.mygls.hu/ParcelService.svc/json/';
    private static $username = 'borago.74@gmail.com';
    private static $password = 'Kukorikotkoda1';
    private static $sender_id = '100033983';

    private static function get_client()
    {
        return new \SoapClient(
            self::$base_url

        );
    }

    public static function printlabel($data)
    {
        ini_set('memory_limit', '1024M');
        ini_set('max_execution_time', 600);

        $url = self::$base_url;

        $clientNumber = self::$sender_id;

        $username = self::$username;

        $pwd = self::$password;
        $password = $password = "[" . implode(',', unpack('C*', hash('sha512', $pwd, true))) . "]";

        $parcelsJson = json_encode([[
            "ClientNumber" => $clientNumber,
            "ClientReference" => "",
            "CODAmount" => $data['codamount'],
            "CODReference" => "codref",
            "Content" => "-",
            "Count" => 1, // $data['codamount'],
            "DeliveryAddress" => [
                "City" => $data["consig_city"],
                "ContactEmail" => $data["consig_email"],
                "ContactName" => $data["consig_name"],
                "ContactPhone" => $data["consig_phone"],
                "CountryIsoCode" => "HU",
                "HouseNumber" => "",
                "Name" => $data["consig_name"],
                "Street" => $data["consig_address"],
                "ZipCode" => $data["consig_zipcode"]
            ],
            "PickupAddress" => [
                "City" => 'Nyíregyháza', // $data["sender_city"],
                "ContactEmail" => 'borago.74@gmail.com', // $data["sender_email"],
                "ContactName" => 'Markos Ágnes', // $data["sender_contact"],
                "ContactPhone" => '+36307386216', // $data["sender_phone"],
                "CountryIsoCode" => "HU",
                "HouseNumber" => "",
                "Name" => 'Borago.hu', // $data["sender_name"],
                "Street" => 'Fő u. 29.', // $data["sender_address"],
                "ZipCode" => '4551', // $data["sender_zipcode"]
            ],
            "PickupDate" => null, // $data['pickupdate'] . " 10:00:00",
            "ServiceList" => []
        ]]);

        $method = "PrintLabels";

        // PrintLabels($username,$password,$url,"PrintLabels",$parcelsJson);

        //Test request:
        $request = '{"Username":"' . $username . '","Password":' . $password . ',"ParcelList":' . $parcelsJson . '}';

        //Service calling:
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_URL, $url . $method);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_TIMEOUT, 600);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $request);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($request))
        );
        $response = curl_exec($curl);

        if ($response === false) {
            die('curl_error:"' . curl_error($curl) . '";curl_errno:' . curl_errno($curl));
        }
        curl_close($curl);

        // var_dump($response);

        //var_dump($response);die();
        if (count(json_decode($response)->PrintLabelsErrorList) == 0 && count(json_decode($response)->Labels) > 0) {
            //Label(s) saving:
            $pdf = implode(array_map('chr', json_decode($response)->Labels));

            // file_put_contents('php_rest_client_PrintLabels.pdf', $pdf);

            return [
                "pcls" => json_decode($response)->PrintLabelsInfoList[0]->ParcelNumber,
                "pdf" => $pdf,
            ];

        }

        return json_decode($response)->PrintLabelsErrorList[0]->ErrorDescription;
    }
}