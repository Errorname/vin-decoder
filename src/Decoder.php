<?php

namespace Errorname\VINDecoder;

class Decoder {

    /* Current api url for the VINDecoder by Vincario */
    private static $apiUrl = "https://api.vindecoder.eu/2.0";
    private static $apiKey;
    private static $secretKey;

    /**
     * Initialize the decoder
     *
     * @param array $keys
     */
    public static function initDecoder($keys = []) {

        self::$apiKey = $keys['api_key'] ?? env('VINDECODER_APIKEY','ok');
        self::$secretKey = $keys['secret_key'] ?? env('VINDECODER_SECRETKEY','ok');
    }

    // PUBLIC API METHODS

    /**
     * Retrieve available decode info on a VIN
     *
     * @param string $vin
     *
     * @return array
     */
    public static function info($vin) {

        self::validateVIN($vin);

        $id = 'info-'.$vin;
        $controlSum = self::controlSum($id);

        $url = self::$apiUrl."/".self::$apiKey."/".$controlSum."/decode/info/".$vin.".json";

        $data = self::callAPI($url);

        return $data['decode'];
    }

    /**
     * Retrieve actual decode info on a VIN
     *
     * @param string $vin
     *
     * @return VIN
     */
    public static function decode($vin) {

        self::validateVIN($vin);

        $id = $vin;
        $controlSum = self::controlSum($id);

        $url = self::$apiUrl."/".self::$apiKey."/".$controlSum."/decode/".$vin.".json";

        $data = self::callAPI($url);

        $vin = new VIN($data['decode']);

        return $vin;
    }

    /**
     * Retrieve current balance
     *
     * @return int
     */
    public static function balance() {

        $id = 'balance';
        $controlSum = self::controlSum($id);

        $url = self::$apiUrl."/".self::$apiKey."/".$controlSum."/balance.json";

        $data = self::callAPI($url);

        return $data['API Decode'];
    }

    // PRIVATE HELPERS METHODS

    /**
     * Validate VIN
     *
     * @param string $vin
     *
     * @throws Exception
     */
    private static function validateVIN($vin) {

        if (!$vin) {
            throw new \Exception('Error: VIN undefined');
        }

        if (strlen($vin) != 17) {
            throw new \Exception('Error: VIN should be 17 characters long');
        }
    }

    /**
     * Generate the controlSum associated with the request
     *
     * @param string $id
     *
     * @return string
     */
    private static function controlSum($id) {

        return substr(sha1($id."|".self::$apiKey."|".self::$secretKey),0,10);
    }

    /**
     * Make the actual request to the API
     *
     * @param string $url
     *
     * @throws Exception
     */
    private static function callAPI($url) {

        $data = json_decode(file_get_contents($url,false),true);

        if (isset($data['error'])) {
            throw new \Exception('Error: Unknown error on VIN during API request');
        }

        return $data;
    }

}
