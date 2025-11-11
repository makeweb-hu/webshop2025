<?php
namespace app\components;

use app\models\Rendszerbeallitas;

/*
curl -s --user 'api:key-f08b5621950d91b78ef14cab7f53108d' \
    https://api.mailgun.net/v3/mail1.euroadvance.hu/messages \
    -F from='Excited User <gabor@mail1.euroadvance.hu>' \
    -F to=YOU@YOUR_DOMAIN_NAME \
    -F to=bar@example.com \
    -F subject='Hello' \
    -F text='Testing some Mailgun awesomeness!'
*/

class Mailgun {

    public static function send($token, $mailfromname, $mailfrom, $to, $subject, $html, $replyto = '') {
        $API_KEY = Rendszerbeallitas::get('mailgun_api_kulcs');
        $DOMAIN = explode("@", $mailfrom)[1];

        // Click tracks
        $html = preg_replace_callback("@href=[\"']([^'\"]*)['\"]@", function ($match) use ($token) {
            $url = trim($match[1] ?? '');
            if (substr($url, 0, 7) === "http://" || substr($url, 0, 8) === "https://") {
                return 'href="https://cloud.euroadvance.hu/site/track-mail-click?token='.$token.'&url=' . urlencode($url) . '"';
            } else {
                return $match[0];
            }
        }, $html);

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://api.eu.mailgun.net/v3/'.$DOMAIN.'/messages');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $post = [
            'from' => $mailfromname . ' <' . $mailfrom . '>',
            'to' => $to,
            'subject' => $subject,
            'html' => $html . '<img width="1px" height="1px" src="https://cloud.euroadvance.hu/site/track-mail-open?t='.time().'&token=' . $token . '" />',
            'h:Reply-To' => $replyto
        ];
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $headers = [
            'Authorization: Basic '. base64_encode("api:" . $API_KEY) // <---
        ];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

        $result = curl_exec($ch);
        try {
            $result = json_decode($result, true);
        } catch (\Throwable $ignore) {
            $result = [];
        }

        if (curl_errno($ch)) {
            // echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);

        return $result;
    }
}

