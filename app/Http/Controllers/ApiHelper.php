<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApiHelper {

	public static function getWithoutToken($url) {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_URL") . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
            ),
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return ApiHelper::parseJson($response, "ApiHelper@getWithoutToken", $err);
    }

    public static function getWithToken($token, $url, $debug = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_URL") . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $token,
                "Content-Type: application/json",
            ),
            CURLOPT_CUSTOMREQUEST => "GET",
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ApiHelper::parseJson($response, "ApiHelper@getWithToken", $err);
    }

    public static function postWithoutToken($iData, $url) {

        $data = http_build_query($iData);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_URL") . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        return ApiHelper::parseJson($response, "ApiHelper@postWithoutToken", $err);
    }

    public static function postWithToken($token, $iData, $url) {
        $data = http_build_query($iData);

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => env("API_URL") . $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $token
            ),
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data,
        ));
        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        return ApiHelper::parseJson($response, "ApiHelper@postWithToken", $err);
    }

    public static function parseJson( $response , $messageLog , $err) {
        if ($err) {
            \Log::error($messageLog, ['message' => $response]);
            return false;
        }
        \Log::info($messageLog, ['response' => $response]);
        $responseJs = json_decode($response);

        return $responseJs;
    }

}
