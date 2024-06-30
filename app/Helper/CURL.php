<?php

namespace App\Helpers;

use stdClass;

class CURL
{
    public static function send($url, $body, $header)
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($body));
        curl_setopt($ch, CURLOPT_POST, 1);

        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

        $result = curl_exec($ch);
        curl_close($ch);

        if (curl_errno($ch)) {
            return (curl_error($ch));
        }

        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $res = new stdClass;
        $res->status = $status;
        $res->data = json_decode($result);

        return $res;
    }
}
