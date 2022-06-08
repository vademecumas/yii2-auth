<?php

namespace vademecumas\auth\helpers;

class Curl
{

    public static function send($url, $method = "get", $params = null, $headers, &$errors)
    {
        $curl = curl_init();

        curl_setopt($curl, CURLOPT_URL, $url);
        if ($method == "post") {
            curl_setopt($curl, CURLOPT_POST, 1);
            if ($params) {
                curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($params));
            }
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $curlResponse = curl_exec($curl);

        if ($curlResponse) {

            curl_close($curl);
            $response = json_decode($curlResponse);

            if ($response->status) {
                if (isset($response->data)) {
                    return $response->data;
                } else {
                    return true;
                }
            } else {
                $errors = $response;
                return false;
            }
        } else if ($errno = curl_errno($curl)) {
            $error_message = curl_strerror($errno);
            \Yii::error("cURL error ({$errno}):\n {$error_message}", "auth api curl error");
            curl_close($curl);
        }

        return false;

    }

}