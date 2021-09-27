<?php

namespace App\Http\Controllers\client;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use SoapClient;

use Mail;
use \Swift_Mailer;
use \Swift_SmtpTransport;

class ApiHelper {

	/**
	 * Gets data without token.
	 *
	 * @param      string  $url    The url
	 *
	 * @return     json    Data response after json decode
	 */
	public static function getWithoutToken($url) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL =>$url,
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


    /**
     * Gets data with token.
     *
     * @param      string  $token  The token api
     * @param      string  $url    The url
     *
     * @return     json    Data response after json decode
     */
    public static function getWithToken($token, $url, $debug = false) {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => (App::environment() == 'production' ? env("API_URL_PRO") : env("API_URL")) . $url,
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
        \Log::info("postWithoutToken", ["url" => $url]);
        $data = http_build_query($iData);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
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
            CURLOPT_URL => (App::environment() == 'production' ? env("API_URL_PRO") : env("API_URL")) . $url,
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
        if ( App::environment() !== 'production' && $responseJs == null ) {
            dd($response);
        } else if ($responseJs == null ) { 
            \Log::error("Client Response error ", ['response' => $response]);
        }
        \Log::info($messageLog, ['responseJs' => $responseJs]);
        return $responseJs;
    }

}
