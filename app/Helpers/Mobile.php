<?php

namespace App\Helpers;

use Keygen\Keygen;

class Mobile
{
    /**
     * Create 5 numeric random code for send sms
     *
     * @return string
     */
    public static function RandomCode()
    {
        return Keygen::numeric(5)->generate();
    }

    /**
     * Send sms from kavenegar sms-panel api
     *
     * @param string mobile_number
     * @param string verification_code
     *
     * @return array
     */
    public static function sendSMS($mobile_number, $verification_code)
    {
        try {
            $api = new \Kavenegar\KavenegarApi(env('SMS_PANEL_APIKEY'));
            $res = $api->VerifyLookup($mobile_number, $verification_code,$verification_code,$verification_code, env('SMS_PANEL_TOKEN'));
            if ($res) {
                return true;
            }
        } catch (\Kavenegar\Exceptions\ApiException $e) {
            return ['status' => 0, 'error' => $e->errorMessage()];
        } catch (\Kavenegar\Exceptions\HttpException $e) {
            return ['status' => 0, 'error' => $e->errorMessage()];
        }
    }
}
