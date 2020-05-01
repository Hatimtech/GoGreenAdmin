<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

require APPPATH . 'third_party/vendor/autoload.php';

use telesign\sdk\messaging\MessagingClient;
use function telesign\sdk\util\randomWithNDigits;

if (!function_exists('send_sms')) {
    function send_sms($phone_number = null, $otp = null) 
    {    
        if($phone_number && $otp) 
        {
            $customer_id = "58D2F5D2-3D2B-4545-B0D1-8AF60C1C04E8";
            $api_key = "QtWaGNgDmF4k79bDrdl/6fLbVBKtHeCJ2K/34PEtMuGruzbR984FYVn7bMiqdh7cW3m7SgjyeXRF2qh47kwSOw==";
            $message_type = "ARN";

            $message = "Your GoGreen account verification otp is {$otp}";

            $messaging = new MessagingClient($customer_id, $api_key, $rest_endpoint = "https://rest-ww.telesign.com");
            $response = $messaging->message($phone_number, $message, $message_type);

            if($response->status_code == 200)
            {
                return true;
            }
        }
        return false;
    }
}

if (!function_exists('send_payment_link_sms')) {
    function send_payment_link_sms($phone_number = null, $link = null) 
    {    
        if($phone_number && $link) 
        {
            $customer_id = "58D2F5D2-3D2B-4545-B0D1-8AF60C1C04E8";
            $api_key = "QtWaGNgDmF4k79bDrdl/6fLbVBKtHeCJ2K/34PEtMuGruzbR984FYVn7bMiqdh7cW3m7SgjyeXRF2qh47kwSOw==";
            $message_type = "ARN";

            $message = "Dear Customer, please click on given link to make a payment against your order with go green in order to enjoy your services continously. {$link}";

            $messaging = new MessagingClient($customer_id, $api_key, $rest_endpoint = "https://rest-ww.telesign.com");
            $response = $messaging->message($phone_number, $message, $message_type);

            if($response->status_code == 200)
            {
                return true;
            }
        }
        return false;
    }
}

