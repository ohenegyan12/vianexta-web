<?php

namespace App\Helpers;

use App\Client;
use App\User;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class Helper
{
    // Product Type Constants
    const GREEN_COFFEE = "green";
    const ROASTED_SINGLE_ORIGIN_COFFEE = "roasted_single_origin";
    const ROASTED_BLEND_COFFEE = "roasted_blend";
    const WHOLE_SALE_BRAND_COFFEE = "whole_sale_brand";

    /* Symbols to check and filter */
    // private static $symbols = ""?;\",+eE.\/""";

    /* Key: Next prime greater than 62 ^ n / 1.618033988749894848 */
    /* Value: modular multiplicative inverse */
    private static $golden_primes = array(
        '1'                  => '1',
        '41'                 => '59',
        '2377'               => '1677',
        '147299'             => '187507',
        '9132313'            => '5952585',
        '566201239'          => '643566407',
        '35104476161'        => '22071637057',
        '2176477521929'      => '294289236153',
        '134941606358731'    => '88879354792675',
        '8366379594239857'   => '7275288500431249',
        '518715534842869223' => '280042546585394647'
    );

    /* Ascii :                    0  9,         A  Z,         a  z     */
    /* $chars = array_merge(range(48,57), range(65,90), range(97,122)) */
    private static $chars62 = array(
        0 => 48,
        1 => 49,
        2 => 50,
        3 => 51,
        4 => 52,
        5 => 53,
        6 => 54,
        7 => 55,
        8 => 56,
        9 => 57,
        10 => 65,
        11 => 66,
        12 => 67,
        13 => 68,
        14 => 69,
        15 => 70,
        16 => 71,
        17 => 72,
        18 => 73,
        19 => 74,
        20 => 75,
        21 => 76,
        22 => 77,
        23 => 78,
        24 => 79,
        25 => 80,
        26 => 81,
        27 => 82,
        28 => 83,
        29 => 84,
        30 => 85,
        31 => 86,
        32 => 87,
        33 => 88,
        34 => 89,
        35 => 90,
        36 => 97,
        37 => 98,
        38 => 99,
        39 => 100,
        40 => 101,
        41 => 102,
        42 => 103,
        43 => 104,
        44 => 105,
        45 => 106,
        46 => 107,
        47 => 108,
        48 => 109,
        49 => 110,
        50 => 111,
        51 => 112,
        52 => 113,
        53 => 114,
        54 => 115,
        55 => 116,
        56 => 117,
        57 => 118,
        58 => 119,
        59 => 120,
        60 => 121,
        61 => 122
    );

    public static function base62($int)
    {
        $key = "";
        while (bccomp($int, 0) > 0) {
            $mod = bcmod($int, 62);
            $key .= chr(static::$chars62[$mod]);
            $int = bcdiv($int, 62);
        }
        return strrev($key);
    }

    public static function unbase62($key)
    {
        $int = 0;
        foreach (str_split(strrev($key)) as $i => $char) {
            $dec = array_search(ord($char), static::$chars62);
            $int = bcadd(bcmul($dec, bcpow(62, $i)), $int);
        }
        return $int;
    }

    public static function decode($hash)
    {
        $length = strlen($hash);
        $ceil = bcpow(62, $length);
        $mmiprimes = array_values(static::$golden_primes);
        $mmi = $mmiprimes[$length];
        $num = static::unbase62($hash);
        $dec = bcmod(bcmul($num, $mmi), $ceil);
        return (int)$dec;
    }

    /**
     * Create a short hash and output it
     *
     * @param int $number
     * @param integer $length
     * @return string
     */
    public static function encode($num, $length = 5)
    {
        $num = static::fixStr((int)$num); // fix string to number
        $ceil = bcpow(62, $length);
        $primes = array_keys(static::$golden_primes);
        $prime = $primes[$length];
        $dec = bcmod(bcmul($num, $prime), $ceil);
        $hash = static::base62($dec);
        return str_pad($hash, $length, "0", STR_PAD_LEFT);
    }

    private static function fixStr($str)
    {
        if (is_int($str)) {
            return $str;
        }

        if ($str === INF) {
            $hex = bin2hex(random_bytes(30));
            $str = static::fixExponential($hex);
        }

        $str_fixed = null;

        if (is_string($str)) {
            $str = hexdec(bin2hex(trim($str)));
            $str_fixed = static::fixExponential($str);
        }

        return $str_fixed;
    }


    public static function getYesNoOption()
    {
        return array('yes', 'no');
    }

    public static function getGenderOptions()
    {
        return array('male', 'female');
    }

    public static function generatePassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    public static function formatPhoneNumber($number)
    {

        // Remove the spaces.
        $number = str_replace(' ', '', $number);
        // Grab the first number. 
        $first_number = substr($number, 0, 1);
        if ($first_number == 0) {
            // Check if the first number is 0.
            // Get rid of the first number.
            $number = substr($number, 1, 99);
            $number = "233" . $number;
        }
        // Remove the + sign.
        $number = str_replace('+', '', $number);

        return $number;
    }

    public function hitCoffeePlugEndpoint($payload, $page)
    {
        return $this->hitCoffeePlugPOSTEndpoint($payload, $page, "POST");
    }

    public function hitCoffeePlugPOSTEndpoint($payload, $page, $method)
    {

        $curl = curl_init();
        $url = env('COFFEEPLUG_BASE_ENDPOINT') . $page;
        $headers = [];
        $session_token = "";

        if (session('auth_user_tokin') != null)
            $session_token = session('auth_user_tokin');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_COOKIE => "SESSION=" . $session_token,
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: SESSION=" . $session_token
            ),
            CURLOPT_HEADERFUNCTION =>
            function ($curl, $header) use (&$headers) {
                $len = strlen($header);
                $header = explode(':', $header, 2);
                if (count($header) < 2) // ignore invalid headers
                    return $len;

                $headers[strtolower(trim($header[0]))][] = trim($header[1]);

                return $len;
            }
        ));

        // dd(request()->cookie());
        $response = curl_exec($curl);
        // Then, after your curl_exec call:
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);
        // $header = json_decode(json_encode($headers),false); 

        $err = curl_error($curl);
        curl_close($curl);
        // dd(env('COFFEEPLUG_BASE_ENDPOINT'));

        // dd($response, $url, $curl, $headers, $body, json_encode($payload));
        if (!$err || $err == "") {
            if ($page == 'login') {
                $body = json_decode($body, true);
                $cookie_data = isset($headers['set-cookie']) && !empty($headers['set-cookie']) ? $headers['set-cookie'][0] : '';
                $session_id = $this->getSessionIDFromCookie($cookie_data);
                // $session_id = rand(10,100);
                $body = array_merge($body, array('sessionId' => $session_id));
                $body = json_decode(json_encode($body));
                Cookie::queue('SESSION', $session_id, 600);
            } else {
                $body = json_decode($body);
            }
            // dd($body);
            return $body;
        } else {
            return array();
        }
    }

    public function getSessionIDFromCookie($data_cookie)
    {
        $sess = explode(' ', trim($data_cookie))[0];
        $sess = str_replace("SESSION=", "", $sess);
        $sess = str_replace(";", "", $sess);

        return $sess;
    }

    public function hitCoffeePlugGetEndpoint($url, $method = 'GET')
    {
        // Debug session information
        $session_token = "";
        if (session('auth_user_tokin') != null) {
            $session_token = session('auth_user_tokin');
        }

        // Log session debugging info
        Log::info('Helper: hitCoffeePlugGetEndpoint called', [
            'url' => $url,
            'method' => $method,
            'session_id' => session()->getId(),
            'auth_user_tokin' => session('auth_user_tokin'),
            'session_token_used' => $session_token,
            'session_status' => session()->isStarted()
        ]);

        $curl = curl_init();
        $url = env('COFFEEPLUG_BASE_ENDPOINT') . $url;
        $session_token = "";

        if (session('auth_user_tokin') != null)
            $session_token = session('auth_user_tokin');
        // dd($url, $session_token);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_COOKIE => "SESSION=" . $session_token,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: SESSION=" . $session_token
            ),
        ));

        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        // dd($curl, $response, $session_token, $url, $body);
        $err = curl_error($curl);
        curl_close($curl);
        $body = json_decode($body);
        if (!$err || $err == "") {
            return $body;
        } else {
            // Return a consistent error object instead of an empty array
            Log::error('cURL error in hitCoffeePlugGetEndpoint', [
                'url' => $url,
                'error' => $err,
                'session_token' => $session_token ? 'present' : 'missing'
            ]);

            return (object) [
                'statusCode' => 500,
                'message' => 'cURL error: ' . $err,
                'data' => null,
                'error' => true
            ];
        }
    }

    /**
     * Hit CoffeePlug endpoint with explicit session token
     * This method is used when the session context might not be available
     */
    public function hitCoffeePlugGetEndpointWithToken($url, $method = 'GET', $session_token = null)
    {
        // Use provided token or fall back to session
        if (empty($session_token)) {
            $session_token = session('auth_user_tokin');
        }

        // Log session debugging info
        Log::info('Helper: hitCoffeePlugGetEndpointWithToken called', [
            'url' => $url,
            'method' => $method,
            'session_id' => session()->getId(),
            'auth_user_tokin' => session('auth_user_tokin'),
            'provided_session_token' => $session_token ? 'present' : 'missing',
            'session_status' => session()->isStarted()
        ]);

        if (empty($session_token)) {
            Log::error('No session token available for API call', [
                'url' => $url,
                'method' => $method
            ]);
            return null;
        }

        $curl = curl_init();
        $full_url = env('COFFEEPLUG_BASE_ENDPOINT') . $url;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $full_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_COOKIE => "SESSION=" . $session_token,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: SESSION=" . $session_token
            ),
        ));

        $response = curl_exec($curl);
        $header_size = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
        $body = substr($response, $header_size);

        $err = curl_error($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        Log::info('Helper: API call completed', [
            'url' => $full_url,
            'http_code' => $http_code,
            'curl_error' => $err,
            'response_size' => strlen($body)
        ]);

        curl_close($curl);

        if (!$err || $err == "") {
            $decoded_body = json_decode($body);
            return $decoded_body;
        } else {
            Log::error('CURL error in hitCoffeePlugGetEndpointWithToken', [
                'url' => $full_url,
                'error' => $err,
                'http_code' => $http_code
            ]);

            // Return a consistent error object instead of null
            return (object) [
                'statusCode' => $http_code ?: 500,
                'message' => 'cURL error: ' . $err,
                'data' => null,
                'error' => true
            ];
        }
    }

    public function hitCoffeePlugPrice()
    {

        $url = env('COFFEEPLUG_PRICE_ENDPOINT');
        $curl = curl_init();
        $session_token = "";

        if (session('auth_user_tokin') != null)
            $session_token = session('auth_user_tokin');

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_COOKIE => "SESSION=" . $session_token,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/json",
                "Cookie: SESSION=" . $session_token
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        // $response = json_decode($response);
        if (!$err || $err == "") {
            return $response;
        } else {
            return array();
        }
    }

    /**
     * Clear session variables
     *
     * This function clears all the session variables
     *
     * @return void
     */

    public function clearSession()
    {
        session()->forget('business_name');
        session()->forget('address_line1');
        session()->forget('address_line2');
        session()->forget('business_type');
        session()->forget('city');
        session()->forget('state');
        session()->forget('zip_code');
        session()->forget('tax_id');
        session()->forget('first_name');
        session()->forget('last_name');
        session()->forget('email');
        session()->forget('phone_number');
        session()->forget('password');
        session()->forget('language');
        session()->forget('country');
        session()->forget('account_type');
        session()->forget('postal_code');

        session()->forget('auth_user_id');
        session()->forget('auth_user_email');
        session()->forget('auth_user_role');
        session()->forget('auth_user_tokin');

        $this->resetCart();
    }

    public function generateProducts()
    {
        $products = $this->hitCoffeePlugGetEndpoint("stock-postings");
        return $products;
    }


    public function filterProducts($products, $filters)
    {
        $filtered_products = array();
        foreach ($products as $product) {
            $variety_parts = explode('-', $product->variety);
            foreach ($filters as $filter) {
                if (isset($variety_parts[1]) && $variety_parts[1] == $filter) {
                    array_push($filtered_products, $product);
                    break;
                }
            }
        }
        return $filtered_products;
    }


    public function getProductMenus()
    {

        $menu = array(
            "countries" => array(array('id' => 1, 'name' => 'Burundi'), array('id' => 2, 'name' => 'Ethiopia')),
            "sample" => array('yes'),
            "type" => array('Commercial', 'Specialty')
        );

        return json_decode(json_encode($menu));
    }

    public function getAuthDetails()
    {
        $auth_data = array(
            "auth_user_id" => session('auth_user_id'),
            "auth_user_email" => session('auth_user_email'),
            "auth_user_role" => session('auth_user_role'),
            "auth_user_tokin" => session('auth_user_tokin'),
            "auth_user_name" => session('auth_user_name')
        );

        return $auth_data;
    }

    public function clearLoginSession()
    {
        // Debug: Log what we're clearing
        error_log('clearLoginSession called - clearing sessions');
        error_log('Before clearing - error session: ' . (session('error') ?? 'null'));
        error_log('Before clearing - success session: ' . (session('success') ?? 'null'));

        // Store any fresh error/success messages before clearing auth sessions
        $freshError = session('error');
        $freshSuccess = session('success');

        // Clear authentication-related sessions
        session()->forget('auth_user_email');
        session()->forget('auth_user_id');
        session()->forget('auth_user_role');
        session()->forget('auth_user_tokin');
        session()->forget('auth_user_name');

        // TEMPORARILY DISABLED: Don't clear error/success sessions to test if that's the issue
        // This allows legitimate login errors to be displayed
        /*
        if (empty($freshError) && empty($freshSuccess)) {
            session()->forget('error');
            session()->forget('success');
            error_log('clearLoginSession - No fresh messages, cleared error/success sessions');
        } else {
            error_log('clearLoginSession - Fresh messages detected, preserving error/success sessions');
            error_log('clearLoginSession - Preserved error: ' . ($freshError ?? 'null'));
            error_log('clearLoginSession - Preserved success: ' . ($freshSuccess ?? 'null'));
        }
        */

        // Always preserve error/success sessions for now
        error_log('clearLoginSession - TEMPORARILY preserving all error/success sessions for testing');
        error_log('clearLoginSession - Preserved error: ' . ($freshError ?? 'null'));
        error_log('clearLoginSession - Preserved success: ' . ($freshSuccess ?? 'null'));

        // Debug: Log what we cleared
        error_log('After clearing - error session: ' . (session('error') ?? 'null'));
        error_log('After clearing - success session: ' . (session('success') ?? 'null'));

        $this->resetCart();
        $logout = $this->hitCoffeePlugEndpoint(array(), 'logout');

        return $logout;
    }

    public function encryptData($original_string)
    {
        $ciphering_value = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering_value);
        $options = 0;
        $encryption_iv = '1234567891011121';
        $encryption_key = $this->config_encrypt_key();

        $encryption_value = openssl_encrypt(
            $original_string,
            $ciphering_value,
            $encryption_key,
            $options,
            $encryption_iv
        );

        return $encryption_value;
    }

    public function decryptData($encryption_value)
    {

        $ciphering_value = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $options = 0;
        $decryption_key = $this->config_encrypt_key();
        $decryption_value = openssl_decrypt(
            $encryption_value,
            $ciphering_value,
            $decryption_key,
            $options,
            $decryption_iv
        );

        return  $decryption_value;
    }

    public function config_encrypt_key()
    {
        $key = "C0FeePluGEnCRYPT!2023";
        return $key;
    }

    public function getCountryCode($country_name)
    {
        $code = "US";
        $countries = json_decode($this->getCountries());
        foreach ($countries as $country) {
            if (strtolower($country->name) == strtolower($country_name)) {
                return $country->code;
            }
        }
        return $code;
    }

    public function formatMoney($amount)
    {
        return number_format($amount, 2, '.', ',');
    }

    public function formatDate($date)
    {
        $date = date_create($date);
        return  date_format($date, "Y/m/d H:i:s");
    }

    public function formatDateToTimeOnly($date)
    {
        $date = date_create($date);
        return  date_format($date, "H:i");
    }

    public function isweekend()
    {
        if (date('D') == 'Sat' || date('D') == 'Sun') {
            return true;
        }
        return false;
    }

    public function sendEmail($reciepient, $message)
    {

        $curl = curl_init();
        $url = env('SENDGRID_URL');
        $apikey = env('SENDGRID_API_KEY');
        $coffeeplug_email = env('SENDGRID_SENDER_EMAIL');
        // dd($reciepient);
        // $payload = '{"personalizations": [{"to": [{"email": "'.$reciepient.'"}]}],"from": {"email": "'.$coffeeplug_email.'"},"subject": "ViaNexta Invite Code","content": [{"type": "text/plain", "value": "'.$message.'"}]}';
        $payload = '{
                "personalizations": [
                    {
                        "to": [
                            {
                                    "email": "' . $reciepient . '"
                                }
                            ]
                        }
                    ],
                    "from": {
                        "email": "' . $coffeeplug_email . '"
                    },
                    "subject": "ViaNexta Invitation!",
                    "content": [
                        {
                            "type": "text/plain",
                            "value": "' . $message . '"
                        }
                    ]
                }';
        //  CURLOPT_POSTFIELDS => $payload,
        //   dd($payload);
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',

            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $apikey,
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);

        $err = curl_error($curl);
        curl_close($curl);


        // dd($response,$payload);
        if (!$err || $err == "") {
            return $response;
        } else {
            return array();
        }
    }

    public function detectContentType($content)
    {
        // Check if content contains HTML tags
        // This is a simple but effective way to detect HTML content
        if (preg_match('/<[^>]+>/', $content)) {
            return 'text/html';
        }
        
        // Check for common HTML entities that might indicate HTML content
        if (preg_match('/&[a-zA-Z0-9#]+;/', $content)) {
            return 'text/html';
        }
        
        // Check for HTML-like patterns (opening and closing tags)
        if (preg_match('/<[a-zA-Z][^>]*>.*<\/[a-zA-Z][^>]*>/', $content)) {
            return 'text/html';
        }
        
        // Default to plain text
        return 'text/plain';
    }

    public function sendEmailWithContentType($recipient, $message, $subject, $contentType = 'text/plain')
    {
        $curl = curl_init();
        $url = env('SENDGRID_URL');
        $apikey = env('SENDGRID_API_KEY');
        $coffeeplug_email = env('SENDGRID_SENDER_EMAIL');
        
        // Escape the message content for JSON
        $escapedMessage = json_encode($message);
        $escapedSubject = json_encode($subject);
        $escapedRecipient = json_encode($recipient);
        $escapedSender = json_encode($coffeeplug_email);
        
        // Remove the quotes that json_encode adds
        $escapedMessage = substr($escapedMessage, 1, -1);
        $escapedSubject = substr($escapedSubject, 1, -1);
        $escapedRecipient = substr($escapedRecipient, 1, -1);
        $escapedSender = substr($escapedSender, 1, -1);
        
        $payload = '{
            "personalizations": [
                {
                    "to": [
                        {
                            "email": "' . $escapedRecipient . '"
                        }
                    ]
                }
            ],
            "from": {
                "email": "' . $escapedSender . '"
            },
            "subject": "' . $escapedSubject . '",
            "content": [
                {
                    "type": "' . $contentType . '",
                    "value": "' . $escapedMessage . '"
                }
            ]
        }';

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $payload,
            CURLOPT_HTTPHEADER => array(
                "Authorization: Bearer " . $apikey,
                "Content-Type: application/json"
            )
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);
        curl_close($curl);

        if (!$err || $err == "") {
            return $response;
        } else {
            return array();
        }
    }

    public function getPrice($quantity, $product, $shipment_mode, $destination_city, $isRoast, $roastType, $grindType, $bagSize)
    {

        if ($product == 'Arabica') {
            //base price set by producer from farm based on variety,quality score and country of origin 
            $base_price_per_pound = 3;

            //the average cost of waiting time in warehouse based on product,quatity and location. This can be based on range or mutiplication of quantity
            $warehouse_base_cost = 1 * $quantity;

            //cost of shipment by air of sea
            if ($shipment_mode == "air") {
                $shipment_cost = $this->shipmentAndTaxCostByAir($quantity);
            } else {
                $shipment_cost = $this->shipmentAndTaxCostByAir($quantity);
            }

            //Cost of delivery based of location adress from the warehouse and quantity 
            $delivery_cost = $this->deliveryAndHandelingCost($quantity, $destination_city);

            //If order requires roasting
            if ($isRoast) {
                $roastPrice = $this->getRoastPrice($roastType, $grindType, $bagSize, $quantity);
            }
        }
    }

    public function shipmentAndTaxCostByAir($quantity)
    {
        if ($quantity >= 1 && $quantity < 10) {
            return array('cost' => 100, 'taxOrInsuarance' => 20);
        } elseif ($quantity >= 10 && $quantity < 50) {
            return array('cost' => 200, 'taxOrInsuarance' => 40);
        } elseif ($quantity >= 50 && $quantity < 70) {
            return array('cost' => 300, 'taxOrInsuarance' => 60);
        } else {
            return array('cost' => 400, 'taxOrInsuarance' => 100);
        }
    }

    public function shipmentAndTaxCostSea($quantity)
    {
        if ($quantity >= 1 && $quantity < 10) {
            return array('cost' => 30, 'taxOrInsuarance' => 10);
        } elseif ($quantity >= 10 && $quantity < 50) {
            return array('cost' => 30, 'taxOrInsuarance' => 20);
        } elseif ($quantity >= 50 && $quantity < 70) {
            return array('cost' => 40, 'taxOrInsuarance' => 30);
        } else {
            return array('cost' => 50, 'taxOrInsuarance' => 40);
        }
    }

    public function deliveryAndHandelingCost($quantity, $destination_city)
    {
        switch ($destination_city) {
            case 'Alabama':
                if ($quantity >= 1 && $quantity < 10) {
                    return array('delivery' => 10, 'handling' => 5);
                } elseif ($quantity >= 10 && $quantity < 50) {
                    return array('delivery' => 15, 'handling' => 10);
                } elseif ($quantity >= 50 && $quantity < 70) {
                    return array('delivery' => 20, 'handling' => 15);
                } else {
                    return array('delivery' => 25, 'handling' => 20);
                }
                break;

            case 'Alabama':
                if ($quantity >= 1 && $quantity < 10) {
                    return array('delivery' => 30, 'handling' => 5);
                } elseif ($quantity >= 10 && $quantity < 50) {
                    return array('delivery' => 35, 'handling' => 10);
                } elseif ($quantity >= 50 && $quantity < 70) {
                    return array('delivery' => 40, 'handling' => 15);
                } else {
                    return array('delivery' => 45, 'handling' => 20);
                }

                break;

            case 'Phily':
                if ($quantity >= 1 && $quantity < 10) {
                    return array('delivery' => 100, 'handling' => 20);
                } elseif ($quantity >= 10 && $quantity < 50) {
                    return array('delivery' => 200, 'handling' => 40);
                } elseif ($quantity >= 50 && $quantity < 70) {
                    return array('delivery' => 300, 'handling' => 60);
                } else {
                    return array('delivery' => 400, 'handling' => 100);
                }

                break;

            case 'New York':
                if ($quantity >= 1 && $quantity < 10) {
                    return array('delivery' => 100, 'handling' => 20);
                } elseif ($quantity >= 10 && $quantity < 50) {
                    return array('delivery' => 200, 'handling' => 40);
                } elseif ($quantity >= 50 && $quantity < 70) {
                    return array('delivery' => 300, 'handling' => 60);
                } else {
                    return array('delivery' => 400, 'handling' => 100);
                }

                break;

            default:

                break;
        }
    }

    public function getRoastPrice($roastType, $grindType, $bagSize, $quantity)
    {
        $roaster = "winwin";
        $bagPrice = 2;
        if ($bagSize == '5Ib_bag') {
            $bagPrice = 2 * $quantity;
        } elseif ($bagSize == '10oz_bag') {
            $bagPrice = 3 * $quantity;
        } else {
            $bagPrice = 5 * $quantity;
        }
        switch ($roaster) {
            case 'millsRoasting':

                if ($roastType == 'Medium') {
                    if ($grindType == 'fine') {
                        $roastPrice = 5 * $quantity;
                        return $roastPrice +  $bagPrice;
                    } else {
                        $roastPrice = 2 * $quantity;
                        return $roastPrice +  $bagPrice;
                    }
                } elseif ($roastType == 'dark') {
                    if ($grindType == 'fine') {
                        $roastPrice = 3 * $quantity;
                        return $roastPrice +  $bagPrice;
                    } else {
                        $roastPrice = 1 * $quantity;
                        return $roastPrice +  $bagPrice;
                    }
                } elseif ($roastType == 'medium_dark') {
                    if ($grindType == 'fine') {
                        $roastPrice = 2 * $quantity;
                        return $roastPrice +  $bagPrice;
                    } else {
                        $roastPrice = 1 * $quantity;
                        return $roastPrice +  $bagPrice;
                    }
                } else {
                    if ($grindType == 'fine') {
                        $roastPrice = 4 * $quantity;
                        return $roastPrice +  $bagPrice;
                    } else {
                        $roastPrice = 3 * $quantity;
                        return $roastPrice +  $bagPrice;
                    }
                }


                break;

            case 'sunsAndCafe':

                break;

            default:

                break;
        }
    }

    public function getCirtifications()
    {
        $cirtifications = array(
            array(
                'name' => 'Fairtrade',
                'definition' => 'Fairtrade certification aims to ensure fair prices, decent working conditions, and fair terms of trade for farmers and workers. It focuses on empowering producers in developing countries and ensuring ethical standards in trade.',
                'principle' => 'Fair pricing, fair labor conditions, direct trade, environmental sustainability, community development.'
            ),
            array(
                'name' => 'Rainforest Alliance',
                'definition' => 'The Rainforest Alliance certification promotes sustainable agricultural practices that conserve biodiversity and ensure sustainable livelihoods. It integrates social, economic, and environmental sustainability.',
                'principle' => ' Biodiversity conservation, sustainable livelihoods, natural resource conservation, climate resilience, community well-being.'
            ),
            array(
                'name' => 'USDA Organic',
                'definition' => 'USDA Organic certification ensures that coffee is produced following federal guidelines addressing soil quality, pest and weed control, and the use of additives. Organic coffee is grown without synthetic fertilizers or pesticides.',
                'principle' => 'No synthetic chemicals, no GMOs, sustainable farming practices, soil and water conservation.'
            ),
            array(
                'name' => 'UTZ Certified',
                'definition' => 'UTZ certification focuses on sustainable farming and better opportunities for farmers, their families, and the planet. UTZ merged with the Rainforest Alliance in 2018, but its standards are still recognized.',
                'principle' => 'Sustainable farming practices, better farming methods, improved working conditions, environmental protection.'
            ),
            array(
                'name' => '4C',
                'definition' => '4C certification promotes sustainability in the coffee sector by improving the economic, social, and environmental conditions of coffee production and processing.',
                'principle' => 'Sustainable production, social responsibility, environmental protection, economic viability.'
            ),
            array(
                'name' => 'Direct Trade',
                'definition' => 'Direct Trade is a sourcing practice where buyers purchase directly from the farmers, ensuring higher prices and better conditions for the producers. It is not a formal certification but follows principles similar to Fairtrade.',
                'principle' => 'Direct purchasing, fair pricing, quality improvement, sustainable relationships.'
            ),
            array(
                'name' => 'Global Coffee Platform',
                'definition' => ' GCP certification focuses on creating a sustainable and thriving coffee sector through collaboration and the implementation of sustainable practices.',
                'principle' => 'Sustainable production, sector collaboration, continuous improvement, economic viability.'
            ),
            array(
                'name' => 'Certified Naturally Grown',
                'definition' => 'CNG is an alternative to the USDA Organic certification, designed for small-scale farmers who sell locally. It adheres to similar principles but is less costly and bureaucratic.',
                'principle' => 'No synthetic chemicals, sustainable farming practices, local sales, peer-review inspections.'
            ),
            array(
                'name' => 'ISO 22000',
                'definition' => 'ISO 22000 certification ensures that food safety management systems are in place to identify and control food safety hazards in coffee production.',
                'principle' => 'Food safety management, hazard control, continuous improvement, compliance with food safety regulations.'
            ),
            array(
                'name' => 'Bird Friendly Certified',
                'definition' => 'This certification ensures that coffee is grown under a canopy of trees, providing habitat for migratory birds and promoting biodiversity.',
                'principle' => 'Shade-grown, biodiversity, organic practices, habitat protection.'
            ),
            array(
                'name' => 'GlobalG.A.P.',
                'definition' => 'This certification ensures that coffee production meets international standards for safe and sustainable agriculture.',
                'principle' => 'Food safety, environmental sustainability, worker welfare, animal welfare.'
            ),
            array(
                'name' => 'IFS Food',
                'definition' => 'IFS Food certification ensures the quality and safety of processed food products, including coffee, throughout the supply chain.',
                'principle' => 'Food safety, quality management, continuous improvement, compliance with food regulations.'
            ),
            array(
                'name' => 'ISO 14001',
                'definition' => 'This certification focuses on effective environmental management systems, ensuring that coffee production minimizes environmental impact.',
                'principle' => 'Environmental management, pollution prevention, regulatory compliance, continuous improvement.'
            ),
            array(
                'name' => 'Nespresso AAA',
                'definition' => 'The Nespresso AAA Sustainable Quality™ Program is an initiative launched by Nespresso in 2003 to ensure the long-term supply of high-quality coffee while improving the livelihoods of coffee farmers and promoting sustainable farming practices.',
                'principle' => ' High-quality standards, technical assistance, environmental protection, climate resilience, fair pricing, community support, collaboration with NGOs, local engagement, supply chain transparency, certification alignment.'
            ),
        );
        //  $cirtifications = array('Fairtrade','Rainforest Alliance','USDA Organic');
        $cirtifications = json_decode(json_encode($cirtifications));
        //  dd($cirtifications[0]->name);
        return $cirtifications;
    }

    public function getCommercialCirtifications()
    {
        $cirtifications = array(
            array(
                'name' => 'Excelsior',
                'definition' => 'Excelsior certification aims to ensure fair prices, decent working conditions, and fair terms of trade for farmers and workers. It focuses on empowering producers in developing countries and ensuring ethical standards in trade.',
                'principle' => 'Excelsior, fair labor conditions, direct trade, environmental sustainability, community development.'
            ),
            array(
                'name' => 'Supremo',
                'definition' => 'Supremo certification promotes sustainable agricultural practices that conserve biodiversity and ensure sustainable livelihoods. It integrates social, economic, and environmental sustainability.',
                'principle' => ' Supremo conservation, sustainable livelihoods, natural resource conservation, climate resilience, community well-being.'
            ),
        );
        $cirtifications = json_decode(json_encode($cirtifications));
        return $cirtifications;
    }


    public function getCountries()
    {
        $countries = '[
        {
        "name": "Afghanistan",
        "dial_code": "+93",
        "code": "AF"
        },
        {
        "name": "Aland Islands",
        "dial_code": "+358",
        "code": "AX"
        },
        {
        "name": "Albania",
        "dial_code": "+355",
        "code": "AL"
        },
        {
        "name": "Algeria",
        "dial_code": "+213",
        "code": "DZ"
        },
        {
        "name": "AmericanSamoa",
        "dial_code": "+1684",
        "code": "AS"
        },
        {
        "name": "Andorra",
        "dial_code": "+376",
        "code": "AD"
        },
        {
        "name": "Angola",
        "dial_code": "+244",
        "code": "AO"
        },
        {
        "name": "Anguilla",
        "dial_code": "+1264",
        "code": "AI"
        },
        {
        "name": "Antarctica",
        "dial_code": "+672",
        "code": "AQ"
        },
        {
        "name": "Antigua and Barbuda",
        "dial_code": "+1268",
        "code": "AG"
        },
        {
        "name": "Argentina",
        "dial_code": "+54",
        "code": "AR"
        },
        {
        "name": "Armenia",
        "dial_code": "+374",
        "code": "AM"
        },
        {
        "name": "Aruba",
        "dial_code": "+297",
        "code": "AW"
        },
        {
        "name": "Australia",
        "dial_code": "+61",
        "code": "AU"
        },
        {
        "name": "Austria",
        "dial_code": "+43",
        "code": "AT"
        },
        {
        "name": "Azerbaijan",
        "dial_code": "+994",
        "code": "AZ"
        },
        {
        "name": "Bahamas",
        "dial_code": "+1242",
        "code": "BS"
        },
        {
        "name": "Bahrain",
        "dial_code": "+973",
        "code": "BH"
        },
        {
        "name": "Bangladesh",
        "dial_code": "+880",
        "code": "BD"
        },
        {
        "name": "Barbados",
        "dial_code": "+1246",
        "code": "BB"
        },
        {
        "name": "Belarus",
        "dial_code": "+375",
        "code": "BY"
        },
        {
        "name": "Belgium",
        "dial_code": "+32",
        "code": "BE"
        },
        {
        "name": "Belize",
        "dial_code": "+501",
        "code": "BZ"
        },
        {
        "name": "Benin",
        "dial_code": "+229",
        "code": "BJ"
        },
        {
        "name": "Bermuda",
        "dial_code": "+1441",
        "code": "BM"
        },
        {
        "name": "Bhutan",
        "dial_code": "+975",
        "code": "BT"
        },
        {
        "name": "Bolivia, Plurinational State of",
        "dial_code": "+591",
        "code": "BO"
        },
        {
        "name": "Bosnia and Herzegovina",
        "dial_code": "+387",
        "code": "BA"
        },
        {
        "name": "Botswana",
        "dial_code": "+267",
        "code": "BW"
        },
        {
        "name": "Brazil",
        "dial_code": "+55",
        "code": "BR"
        },
        {
        "name": "British Indian Ocean Territory",
        "dial_code": "+246",
        "code": "IO"
        },
        {
        "name": "Brunei Darussalam",
        "dial_code": "+673",
        "code": "BN"
        },
        {
        "name": "Bulgaria",
        "dial_code": "+359",
        "code": "BG"
        },
        {
        "name": "Burkina Faso",
        "dial_code": "+226",
        "code": "BF"
        },
        {
        "name": "Burundi",
        "dial_code": "+257",
        "code": "BI"
        },
        {
        "name": "Cambodia",
        "dial_code": "+855",
        "code": "KH"
        },
        {
        "name": "Cameroon",
        "dial_code": "+237",
        "code": "CM"
        },
        {
        "name": "Canada",
        "dial_code": "+1",
        "code": "CA"
        },
        {
        "name": "Cape Verde",
        "dial_code": "+238",
        "code": "CV"
        },
        {
        "name": "Cayman Islands",
        "dial_code": "+ 345",
        "code": "KY"
        },
        {
        "name": "Central African Republic",
        "dial_code": "+236",
        "code": "CF"
        },
        {
        "name": "Chad",
        "dial_code": "+235",
        "code": "TD"
        },
        {
        "name": "Chile",
        "dial_code": "+56",
        "code": "CL"
        },
        {
        "name": "China",
        "dial_code": "+86",
        "code": "CN"
        },
        {
        "name": "Christmas Island",
        "dial_code": "+61",
        "code": "CX"
        },
        {
        "name": "Cocos (Keeling) Islands",
        "dial_code": "+61",
        "code": "CC"
        },
        {
        "name": "Colombia",
        "dial_code": "+57",
        "code": "CO"
        },
        {
        "name": "Comoros",
        "dial_code": "+269",
        "code": "KM"
        },
        {
        "name": "Congo",
        "dial_code": "+242",
        "code": "CG"
        },
        {
        "name": "Congo, The Democratic Republic of the Congo",
        "dial_code": "+243",
        "code": "CD"
        },
        {
        "name": "Cook Islands",
        "dial_code": "+682",
        "code": "CK"
        },
        {
        "name": "Costa Rica",
        "dial_code": "+506",
        "code": "CR"
        },
        {
        "name": "Cote d`Ivoire",
        "dial_code": "+225",
        "code": "CI"
        },
        {
        "name": "Croatia",
        "dial_code": "+385",
        "code": "HR"
        },
        {
        "name": "Cuba",
        "dial_code": "+53",
        "code": "CU"
        },
        {
        "name": "Cyprus",
        "dial_code": "+357",
        "code": "CY"
        },
        {
        "name": "Czech Republic",
        "dial_code": "+420",
        "code": "CZ"
        },
        {
        "name": "Denmark",
        "dial_code": "+45",
        "code": "DK"
        },
        {
        "name": "Djibouti",
        "dial_code": "+253",
        "code": "DJ"
        },
        {
        "name": "Dominica",
        "dial_code": "+1767",
        "code": "DM"
        },
        {
        "name": "Dominican Republic",
        "dial_code": "+1849",
        "code": "DO"
        },
        {
        "name": "Ecuador",
        "dial_code": "+593",
        "code": "EC"
        },
        {
        "name": "Egypt",
        "dial_code": "+20",
        "code": "EG"
        },
        {
        "name": "El Salvador",
        "dial_code": "+503",
        "code": "SV"
        },
        {
        "name": "Equatorial Guinea",
        "dial_code": "+240",
        "code": "GQ"
        },
        {
        "name": "Eritrea",
        "dial_code": "+291",
        "code": "ER"
        },
        {
        "name": "Estonia",
        "dial_code": "+372",
        "code": "EE"
        },
        {
        "name": "Ethiopia",
        "dial_code": "+251",
        "code": "ET"
        },
        {
        "name": "Falkland Islands (Malvinas)",
        "dial_code": "+500",
        "code": "FK"
        },
        {
        "name": "Faroe Islands",
        "dial_code": "+298",
        "code": "FO"
        },
        {
        "name": "Fiji",
        "dial_code": "+679",
        "code": "FJ"
        },
        {
        "name": "Finland",
        "dial_code": "+358",
        "code": "FI"
        },
        {
        "name": "France",
        "dial_code": "+33",
        "code": "FR"
        },
        {
        "name": "French Guiana",
        "dial_code": "+594",
        "code": "GF"
        },
        {
        "name": "French Polynesia",
        "dial_code": "+689",
        "code": "PF"
        },
        {
        "name": "Gabon",
        "dial_code": "+241",
        "code": "GA"
        },
        {
        "name": "Gambia",
        "dial_code": "+220",
        "code": "GM"
        },
        {
        "name": "Georgia",
        "dial_code": "+995",
        "code": "GE"
        },
        {
        "name": "Germany",
        "dial_code": "+49",
        "code": "DE"
        },
        {
        "name": "Ghana",
        "dial_code": "+233",
        "code": "GH"
        },
        {
        "name": "Gibraltar",
        "dial_code": "+350",
        "code": "GI"
        },
        {
        "name": "Greece",
        "dial_code": "+30",
        "code": "GR"
        },
        {
        "name": "Greenland",
        "dial_code": "+299",
        "code": "GL"
        },
        {
        "name": "Grenada",
        "dial_code": "+1473",
        "code": "GD"
        },
        {
        "name": "Guadeloupe",
        "dial_code": "+590",
        "code": "GP"
        },
        {
        "name": "Guam",
        "dial_code": "+1671",
        "code": "GU"
        },
        {
        "name": "Guatemala",
        "dial_code": "+502",
        "code": "GT"
        },
        {
        "name": "Guernsey",
        "dial_code": "+44",
        "code": "GG"
        },
        {
        "name": "Guinea",
        "dial_code": "+224",
        "code": "GN"
        },
        {
        "name": "Guinea-Bissau",
        "dial_code": "+245",
        "code": "GW"
        },
        {
        "name": "Guyana",
        "dial_code": "+595",
        "code": "GY"
        },
        {
        "name": "Haiti",
        "dial_code": "+509",
        "code": "HT"
        },
        {
        "name": "Holy See (Vatican City State)",
        "dial_code": "+379",
        "code": "VA"
        },
        {
        "name": "Honduras",
        "dial_code": "+504",
        "code": "HN"
        },
        {
        "name": "Hong Kong",
        "dial_code": "+852",
        "code": "HK"
        },
        {
        "name": "Hungary",
        "dial_code": "+36",
        "code": "HU"
        },
        {
        "name": "Iceland",
        "dial_code": "+354",
        "code": "IS"
        },
        {
        "name": "India",
        "dial_code": "+91",
        "code": "IN"
        },
        {
        "name": "Indonesia",
        "dial_code": "+62",
        "code": "ID"
        },
        {
        "name": "Iran, Islamic Republic of Persian Gulf",
        "dial_code": "+98",
        "code": "IR"
        },
        {
        "name": "Iraq",
        "dial_code": "+964",
        "code": "IQ"
        },
        {
        "name": "Ireland",
        "dial_code": "+353",
        "code": "IE"
        },
        {
        "name": "Isle of Man",
        "dial_code": "+44",
        "code": "IM"
        },
        {
        "name": "Israel",
        "dial_code": "+972",
        "code": "IL"
        },
        {
        "name": "Italy",
        "dial_code": "+39",
        "code": "IT"
        },
        {
        "name": "Jamaica",
        "dial_code": "+1876",
        "code": "JM"
        },
        {
        "name": "Japan",
        "dial_code": "+81",
        "code": "JP"
        },
        {
        "name": "Jersey",
        "dial_code": "+44",
        "code": "JE"
        },
        {
        "name": "Jordan",
        "dial_code": "+962",
        "code": "JO"
        },
        {
        "name": "Kazakhstan",
        "dial_code": "+77",
        "code": "KZ"
        },
        {
        "name": "Kenya",
        "dial_code": "+254",
        "code": "KE"
        },
        {
        "name": "Kiribati",
        "dial_code": "+686",
        "code": "KI"
        },
        {
        "name": "Korea, Democratic Peoples Republic of Korea",
        "dial_code": "+850",
        "code": "KP"
        },
        {
        "name": "Korea, Republic of South Korea",
        "dial_code": "+82",
        "code": "KR"
        },
        {
        "name": "Kuwait",
        "dial_code": "+965",
        "code": "KW"
        },
        {
        "name": "Kyrgyzstan",
        "dial_code": "+996",
        "code": "KG"
        },
        {
        "name": "Laos",
        "dial_code": "+856",
        "code": "LA"
        },
        {
        "name": "Latvia",
        "dial_code": "+371",
        "code": "LV"
        },
        {
        "name": "Lebanon",
        "dial_code": "+961",
        "code": "LB"
        },
        {
        "name": "Lesotho",
        "dial_code": "+266",
        "code": "LS"
        },
        {
        "name": "Liberia",
        "dial_code": "+231",
        "code": "LR"
        },
        {
        "name": "Libyan Arab Jamahiriya",
        "dial_code": "+218",
        "code": "LY"
        },
        {
        "name": "Liechtenstein",
        "dial_code": "+423",
        "code": "LI"
        },
        {
        "name": "Lithuania",
        "dial_code": "+370",
        "code": "LT"
        },
        {
        "name": "Luxembourg",
        "dial_code": "+352",
        "code": "LU"
        },
        {
        "name": "Macao",
        "dial_code": "+853",
        "code": "MO"
        },
        {
        "name": "Macedonia",
        "dial_code": "+389",
        "code": "MK"
        },
        {
        "name": "Madagascar",
        "dial_code": "+261",
        "code": "MG"
        },
        {
        "name": "Malawi",
        "dial_code": "+265",
        "code": "MW"
        },
        {
        "name": "Malaysia",
        "dial_code": "+60",
        "code": "MY"
        },
        {
        "name": "Maldives",
        "dial_code": "+960",
        "code": "MV"
        },
        {
        "name": "Mali",
        "dial_code": "+223",
        "code": "ML"
        },
        {
        "name": "Malta",
        "dial_code": "+356",
        "code": "MT"
        },
        {
        "name": "Marshall Islands",
        "dial_code": "+692",
        "code": "MH"
        },
        {
        "name": "Martinique",
        "dial_code": "+596",
        "code": "MQ"
        },
        {
        "name": "Mauritania",
        "dial_code": "+222",
        "code": "MR"
        },
        {
        "name": "Mauritius",
        "dial_code": "+230",
        "code": "MU"
        },
        {
        "name": "Mayotte",
        "dial_code": "+262",
        "code": "YT"
        },
        {
        "name": "Mexico",
        "dial_code": "+52",
        "code": "MX"
        },
        {
        "name": "Micronesia, Federated States of Micronesia",
        "dial_code": "+691",
        "code": "FM"
        },
        {
        "name": "Moldova",
        "dial_code": "+373",
        "code": "MD"
        },
        {
        "name": "Monaco",
        "dial_code": "+377",
        "code": "MC"
        },
        {
        "name": "Mongolia",
        "dial_code": "+976",
        "code": "MN"
        },
        {
        "name": "Montenegro",
        "dial_code": "+382",
        "code": "ME"
        },
        {
        "name": "Montserrat",
        "dial_code": "+1664",
        "code": "MS"
        },
        {
        "name": "Morocco",
        "dial_code": "+212",
        "code": "MA"
        },
        {
        "name": "Mozambique",
        "dial_code": "+258",
        "code": "MZ"
        },
        {
        "name": "Myanmar",
        "dial_code": "+95",
        "code": "MM"
        },
        {
        "name": "Namibia",
        "dial_code": "+264",
        "code": "NA"
        },
        {
        "name": "Nauru",
        "dial_code": "+674",
        "code": "NR"
        },
        {
        "name": "Nepal",
        "dial_code": "+977",
        "code": "NP"
        },
        {
        "name": "Netherlands",
        "dial_code": "+31",
        "code": "NL"
        },
        {
        "name": "Netherlands Antilles",
        "dial_code": "+599",
        "code": "AN"
        },
        {
        "name": "New Caledonia",
        "dial_code": "+687",
        "code": "NC"
        },
        {
        "name": "New Zealand",
        "dial_code": "+64",
        "code": "NZ"
        },
        {
        "name": "Nicaragua",
        "dial_code": "+505",
        "code": "NI"
        },
        {
        "name": "Niger",
        "dial_code": "+227",
        "code": "NE"
        },
        {
        "name": "Nigeria",
        "dial_code": "+234",
        "code": "NG"
        },
        {
        "name": "Niue",
        "dial_code": "+683",
        "code": "NU"
        },
        {
        "name": "Norfolk Island",
        "dial_code": "+672",
        "code": "NF"
        },
        {
        "name": "Northern Mariana Islands",
        "dial_code": "+1670",
        "code": "MP"
        },
        {
        "name": "Norway",
        "dial_code": "+47",
        "code": "NO"
        },
        {
        "name": "Oman",
        "dial_code": "+968",
        "code": "OM"
        },
        {
        "name": "Pakistan",
        "dial_code": "+92",
        "code": "PK"
        },
        {
        "name": "Palau",
        "dial_code": "+680",
        "code": "PW"
        },
        {
        "name": "Palestinian Territory, Occupied",
        "dial_code": "+970",
        "code": "PS"
        },
        {
        "name": "Panama",
        "dial_code": "+507",
        "code": "PA"
        },
        {
        "name": "Papua New Guinea",
        "dial_code": "+675",
        "code": "PG"
        },
        {
        "name": "Paraguay",
        "dial_code": "+595",
        "code": "PY"
        },
        {
        "name": "Peru",
        "dial_code": "+51",
        "code": "PE"
        },
        {
        "name": "Philippines",
        "dial_code": "+63",
        "code": "PH"
        },
        {
        "name": "Pitcairn",
        "dial_code": "+872",
        "code": "PN"
        },
        {
        "name": "Poland",
        "dial_code": "+48",
        "code": "PL"
        },
        {
        "name": "Portugal",
        "dial_code": "+351",
        "code": "PT"
        },
        {
        "name": "Puerto Rico",
        "dial_code": "+1939",
        "code": "PR"
        },
        {
        "name": "Qatar",
        "dial_code": "+974",
        "code": "QA"
        },
        {
        "name": "Romania",
        "dial_code": "+40",
        "code": "RO"
        },
        {
        "name": "Russia",
        "dial_code": "+7",
        "code": "RU"
        },
        {
        "name": "Rwanda",
        "dial_code": "+250",
        "code": "RW"
        },
        {
        "name": "Reunion",
        "dial_code": "+262",
        "code": "RE"
        },
        {
        "name": "Saint Barthelemy",
        "dial_code": "+590",
        "code": "BL"
        },
        {
        "name": "Saint Helena, Ascension and Tristan Da Cunha",
        "dial_code": "+290",
        "code": "SH"
        },
        {
        "name": "Saint Kitts and Nevis",
        "dial_code": "+1869",
        "code": "KN"
        },
        {
        "name": "Saint Lucia",
        "dial_code": "+1758",
        "code": "LC"
        },
        {
        "name": "Saint Martin",
        "dial_code": "+590",
        "code": "MF"
        },
        {
        "name": "Saint Pierre and Miquelon",
        "dial_code": "+508",
        "code": "PM"
        },
        {
        "name": "Saint Vincent and the Grenadines",
        "dial_code": "+1784",
        "code": "VC"
        },
        {
        "name": "Samoa",
        "dial_code": "+685",
        "code": "WS"
        },
        {
        "name": "San Marino",
        "dial_code": "+378",
        "code": "SM"
        },
        {
        "name": "Sao Tome and Principe",
        "dial_code": "+239",
        "code": "ST"
        },
        {
        "name": "Saudi Arabia",
        "dial_code": "+966",
        "code": "SA"
        },
        {
        "name": "Senegal",
        "dial_code": "+221",
        "code": "SN"
        },
        {
        "name": "Serbia",
        "dial_code": "+381",
        "code": "RS"
        },
        {
        "name": "Seychelles",
        "dial_code": "+248",
        "code": "SC"
        },
        {
        "name": "Sierra Leone",
        "dial_code": "+232",
        "code": "SL"
        },
        {
        "name": "Singapore",
        "dial_code": "+65",
        "code": "SG"
        },
        {
        "name": "Slovakia",
        "dial_code": "+421",
        "code": "SK"
        },
        {
        "name": "Slovenia",
        "dial_code": "+386",
        "code": "SI"
        },
        {
        "name": "Solomon Islands",
        "dial_code": "+677",
        "code": "SB"
        },
        {
        "name": "Somalia",
        "dial_code": "+252",
        "code": "SO"
        },
        {
        "name": "South Africa",
        "dial_code": "+27",
        "code": "ZA"
        },
        {
        "name": "South Sudan",
        "dial_code": "+211",
        "code": "SS"
        },
        {
        "name": "South Georgia and the South Sandwich Islands",
        "dial_code": "+500",
        "code": "GS"
        },
        {
        "name": "Spain",
        "dial_code": "+34",
        "code": "ES"
        },
        {
        "name": "Sri Lanka",
        "dial_code": "+94",
        "code": "LK"
        },
        {
        "name": "Sudan",
        "dial_code": "+249",
        "code": "SD"
        },
        {
        "name": "Suriname",
        "dial_code": "+597",
        "code": "SR"
        },
        {
        "name": "Svalbard and Jan Mayen",
        "dial_code": "+47",
        "code": "SJ"
        },
        {
        "name": "Swaziland",
        "dial_code": "+268",
        "code": "SZ"
        },
        {
        "name": "Sweden",
        "dial_code": "+46",
        "code": "SE"
        },
        {
        "name": "Switzerland",
        "dial_code": "+41",
        "code": "CH"
        },
        {
        "name": "Syrian Arab Republic",
        "dial_code": "+963",
        "code": "SY"
        },
        {
        "name": "Taiwan",
        "dial_code": "+886",
        "code": "TW"
        },
        {
        "name": "Tajikistan",
        "dial_code": "+992",
        "code": "TJ"
        },
        {
        "name": "Tanzania",
        "dial_code": "+255",
        "code": "TZ"
        },
        {
        "name": "United Republic of Tanzania",
        "dial_code": "+255",
        "code": "TZ"
        },
        {
        "name": "Thailand",
        "dial_code": "+66",
        "code": "TH"
        },
        {
        "name": "Timor-Leste",
        "dial_code": "+670",
        "code": "TL"
        },
        {
        "name": "Togo",
        "dial_code": "+228",
        "code": "TG"
        },
        {
        "name": "Tokelau",
        "dial_code": "+690",
        "code": "TK"
        },
        {
        "name": "Tonga",
        "dial_code": "+676",
        "code": "TO"
        },
        {
        "name": "Trinidad and Tobago",
        "dial_code": "+1868",
        "code": "TT"
        },
        {
        "name": "Tunisia",
        "dial_code": "+216",
        "code": "TN"
        },
        {
        "name": "Turkey",
        "dial_code": "+90",
        "code": "TR"
        },
        {
        "name": "Turkmenistan",
        "dial_code": "+993",
        "code": "TM"
        },
        {
        "name": "Turks and Caicos Islands",
        "dial_code": "+1649",
        "code": "TC"
        },
        {
        "name": "Tuvalu",
        "dial_code": "+688",
        "code": "TV"
        },
        {
        "name": "Uganda",
        "dial_code": "+256",
        "code": "UG"
        },
        {
        "name": "Ukraine",
        "dial_code": "+380",
        "code": "UA"
        },
        {
        "name": "United Arab Emirates",
        "dial_code": "+971",
        "code": "AE"
        },
        {
        "name": "United Kingdom",
        "dial_code": "+44",
        "code": "GB"
        },
        {
        "name": "United States",
        "dial_code": "+1",
        "code": "US"
        },
        {
        "name": "Uruguay",
        "dial_code": "+598",
        "code": "UY"
        },
        {
        "name": "Uzbekistan",
        "dial_code": "+998",
        "code": "UZ"
        },
        {
        "name": "Vanuatu",
        "dial_code": "+678",
        "code": "VU"
        },
        {
        "name": "Venezuela, Bolivarian Republic of Venezuela",
        "dial_code": "+58",
        "code": "VE"
        },
        {
        "name": "Vietnam",
        "dial_code": "+84",
        "code": "VN"
        },
        {
        "name": "Virgin Islands, British",
        "dial_code": "+1284",
        "code": "VG"
        },
        {
        "name": "Virgin Islands, U.S.",
        "dial_code": "+1340",
        "code": "VI"
        },
        {
        "name": "Wallis and Futuna",
        "dial_code": "+681",
        "code": "WF"
        },
        {
        "name": "Yemen",
        "dial_code": "+967",
        "code": "YE"
        },
        {
        "name": "Zambia",
        "dial_code": "+260",
        "code": "ZM"
        },
        {
        "name": "Zimbabwe",
        "dial_code": "+263",
        "code": "ZW"
        }
        ]';


        return $countries;
    }

    public function getWheelData()
    {
        $wheelData = '[
                        {
                            "name": "Aromas",
                            "id": "aromas",
                            "fill": "#cbbba0"
                        },
                        {
                            "name": "Enzymatic",
                            "parent": "aromas",
                            "id": "enzymatic",
                            "fill": "#f38967"
                        },
                        {
                            "name": "Sugar Browning",
                            "parent": "aromas",
                            "id": "sugar-browning",
                            "fill": "#795841"
                        },
                        {
                            "name": "Dry Distillation",
                            "parent": "aromas",
                            "id": "dry-distillation",
                            "fill": "#357ca5"
                        },
                        {
                            "name": "Flowery",
                            "parent": "enzymatic",
                            "id": "flowery",
                            "fill": "#edcf37"
                        },
                        {
                            "name": "Fruity",
                            "parent": "enzymatic",
                            "id": "fruity",
                            "fill": "#da943b"
                        },
                        {
                            "name": "Herby",
                            "parent": "enzymatic",
                            "id": "herby",
                            "fill": "#9ba776"
                        },
                        {
                            "name": "Floral",
                            "parent": "flowery",
                            "id": "floral"
                        },
                        {
                            "name": "Fragrant",
                            "parent": "flowery",
                            "id": "fragrant"
                        },
                        {
                            "name": "Coffee Blossom",
                            "parent": "floral",
                            "id": "coffee-blossom"
                        },
                        {
                            "name": "Tea Rose",
                            "parent": "floral",
                            "id": "tea-rose"
                        },
                        {
                            "name": "Cardamon Caraway",
                            "parent": "fragrant",
                            "id": "cardamon-caraway"
                        },
                        {
                            "name": "Coriander Seeds",
                            "parent": "fragrant",
                            "id": "coriander-seeds"
                        },
                        {
                            "name": "Citrus",
                            "parent": "fruity",
                            "id": "citrus"
                        },
                        {
                            "name": "Berry-like",
                            "parent": "fruity",
                            "id": "berry-like"
                        },
                        {
                            "name": "Lemon",
                            "parent": "citrus",
                            "id": "lemon"
                        },
                        {
                            "name": "Apple",
                            "parent": "citrus",
                            "id": "apple"
                        },
                        {
                            "name": "Apricot",
                            "parent": "berry-like",
                            "id": "apricot"
                        },
                        {
                            "name": "Blackberry",
                            "parent": "berry-like",
                            "id": "blackberry"
                        },
                        {
                            "name": "Alliaceous",
                            "parent": "herby",
                            "id": "alliaceous"
                        },
                        {
                            "name": "Leguminous",
                            "parent": "herby",
                            "id": "leguminous"
                        },
                        {
                            "name": "Onion",
                            "parent": "alliaceous",
                            "id": "onion"
                        },
                        {
                            "name": "Garlic",
                            "parent": "alliaceous",
                            "id": "garlic"
                        },
                        {
                            "name": "Cucumber",
                            "parent": "leguminous",
                            "id": "cucumber"
                        },
                        {
                            "name": "Garden Peas",
                            "parent": "leguminous",
                            "id": "garden-peas"
                        },
                        {
                            "name": "Nutty",
                            "parent": "sugar-browning",
                            "id": "nutty",
                            "fill": "#8b5d2d"
                        },
                        {
                            "name": "Carmelly",
                            "parent": "sugar-browning",
                            "id": "carmelly",
                            "fill": "#d08631"
                        },
                        {
                            "name": "Chocolatey",
                            "parent": "sugar-browning",
                            "id": "chocolatey",
                            "fill": "#7f4636"
                        },
                        {
                            "name": "Nut-like",
                            "parent": "nutty",
                            "id": "nut-like"
                        },
                        {
                            "name": "Malt-like",
                            "parent": "nutty",
                            "id": "malt-like"
                        },
                        {
                            "name": "Roasted Peanuts",
                            "parent": "nut-like",
                            "id": "roasted-peanuts"
                        },
                        {
                            "name": "Walnuts",
                            "parent": "nut-like",
                            "id": "walnuts"
                        },
                        {
                            "name": "Balsamic Rice",
                            "parent": "malt-like",
                            "id": "balsamic-rice"
                        },
                        {
                            "name": "Toast",
                            "parent": "malt-like",
                            "id": "toast"
                        },
                        {
                            "name": "Candy-like",
                            "parent": "carmelly",
                            "id": "candy-like"
                        },
                        {
                            "name": "Syrup-like",
                            "parent": "carmelly",
                            "id": "syrup-like"
                        },
                        {
                            "name": "Roasted Hazelnut",
                            "parent": "candy-like",
                            "id": "roasted-hazelnut"
                        },
                        {
                            "name": "Roasted Almond",
                            "parent": "candy-like",
                            "id": "roasted-almond"
                        },
                        {
                            "name": "Honey",
                            "parent": "syrup-like",
                            "id": "honey"
                        },
                        {
                            "name": "Maple Syrup",
                            "parent": "syrup-like",
                            "id": "maple-syrup"
                        },
                        {
                            "name": "Chocolate-like",
                            "parent": "chocolatey",
                            "id": "chocolate-like"
                        },
                        {
                            "name": "Vanilla-like",
                            "parent": "chocolatey",
                            "id": "vanilla-like"
                        },
                        {
                            "name": "Bakers",
                            "parent": "chocolate-like",
                            "id": "bakers"
                        },
                        {
                            "name": "Dark Chocolate",
                            "parent": "chocolate-like",
                            "id": "dark-chocolate"
                        },
                        {
                            "name": "Swiss",
                            "parent": "vanilla-like",
                            "id": "swiss"
                        },
                        {
                            "name": "Butter",
                            "parent": "vanilla-like",
                            "id": "butter"
                        },
                        {
                            "name": "Resinous",
                            "parent": "dry-distillation",
                            "id": "resinous",
                            "fill": "#5e4e7b"
                        },
                        {
                            "name": "Spicy",
                            "parent": "dry-distillation",
                            "id": "spicy",
                            "fill": "#8d3974"
                        },
                        {
                            "name": "Carbony",
                            "parent": "dry-distillation",
                            "id": "carbony",
                            "fill": "#602268"
                        },
                        {
                            "name": "Turpeny",
                            "parent": "resinous",
                            "id": "turpeny"
                        },
                        {
                            "name": "Medicinal",
                            "parent": "resinous",
                            "id": "medicinal"
                        },
                        {
                            "name": "Piney",
                            "parent": "turpeny",
                            "id": "piney"
                        },
                        {
                            "name": "Blackcurrant-like",
                            "parent": "turpeny",
                            "id": "blackcurrant-like"
                        },
                        {
                            "name": "Camphoric",
                            "parent": "medicinal",
                            "id": "camphoric"
                        },
                        {
                            "name": "Cineolic",
                            "parent": "medicinal",
                            "id": "cineolic"
                        },
                        {
                            "name": "Warming",
                            "parent": "spicy",
                            "id": "warming"
                        },
                        {
                            "name": "Pungent",
                            "parent": "spicy",
                            "id": "aromas-pungent"
                        },
                        {
                            "name": "Cedar",
                            "parent": "warming",
                            "id": "cedar"
                        },
                        {
                            "name": "Pepper",
                            "parent": "warming",
                            "id": "pepper"
                        },
                        {
                            "name": "Clove",
                            "parent": "aromas-pungent",
                            "id": "clove"
                        },
                        {
                            "name": "Thyme",
                            "parent": "aromas-pungent",
                            "id": "thyme"
                        },
                        {
                            "name": "Smokey",
                            "parent": "carbony",
                            "id": "smokey"
                        },
                        {
                            "name": "Ashy",
                            "parent": "carbony",
                            "id": "ashy"
                        },
                        {
                            "name": "Tarry",
                            "parent": "smokey",
                            "id": "tarry"
                        },
                        {
                            "name": "Pipe Tobacco",
                            "parent": "smokey",
                            "id": "pipe-tobacco"
                        },
                        {
                            "name": "Burnt",
                            "parent": "ashy",
                            "id": "burnt"
                        },
                        {
                            "name": "Charred",
                            "parent": "ashy",
                            "id": "charred"
                        },
                        {
                            "name": "Tastes",
                            "id": "tastes",
                            "fill": "#634e42"
                        },
                        {
                            "name": "Bitter",
                            "parent": "tastes",
                            "id": "bitter",
                            "fill": "#575756"
                        },
                        {
                            "name": "Salt",
                            "parent": "tastes",
                            "id": "salt",
                            "fill": "#a30d1c"
                        },
                        {
                            "name": "Sweet",
                            "parent": "tastes",
                            "id": "sweet",
                            "fill": "#6f1547"
                        },
                        {
                            "name": "Sour",
                            "parent": "tastes",
                            "id": "sour",
                            "fill": "#00814e"
                        },
                        {
                            "name": "Pungent",
                            "parent": "bitter",
                            "id": "tastes-pungent",
                            "fill": "#9c81a8"
                        },
                        {
                            "name": "Harsh",
                            "parent": "bitter",
                            "id": "harsh",
                            "fill": "#e85381"
                        },
                        {
                            "name": "Creosol",
                            "parent": "tastes-pungent",
                            "id": "creosol"
                        },
                        {
                            "name": "Phenolic",
                            "parent": "tastes-pungent",
                            "id": "phenolic"
                        },
                        {
                            "name": "Caustic",
                            "parent": "harsh",
                            "id": "caustic"
                        },
                        {
                            "name": "Alkaline",
                            "parent": "harsh",
                            "id": "alkaline"
                        },
                        {
                            "name": "Sharp",
                            "parent": "salt",
                            "id": "sharp",
                            "fill": "#db7773"
                        },
                        {
                            "name": "Bland",
                            "parent": "salt",
                            "id": "bland",
                            "fill": "#f2a569"
                        },
                        {
                            "name": "Astringent",
                            "parent": "sharp",
                            "id": "astringent"
                        },
                        {
                            "name": "Rough",
                            "parent": "sharp",
                            "id": "rough"
                        },
                        {
                            "name": "Neutral",
                            "parent": "bland",
                            "id": "neutral"
                        },
                        {
                            "name": "Soft",
                            "parent": "bland",
                            "id": "soft"
                        },
                        {
                            "name": "Mellow",
                            "parent": "sweet",
                            "id": "mellow",
                            "fill": "#f1bf71"
                        },
                        {
                            "name": "Acidy",
                            "parent": "sweet",
                            "id": "acidy",
                            "fill": "#edd529"
                        },
                        {
                            "name": "Delicate",
                            "parent": "mellow",
                            "id": "delicate"
                        },
                        {
                            "name": "Mild",
                            "parent": "mellow",
                            "id": "mild"
                        },
                        {
                            "name": "Nippy",
                            "parent": "acidy",
                            "id": "nippy"
                        },
                        {
                            "name": "Piquant",
                            "parent": "acidy",
                            "id": "piquant"
                        },
                        {
                            "name": "Winey",
                            "parent": "sour",
                            "id": "winey",
                            "fill": "#c8cd80"
                        },
                        {
                            "name": "Soury",
                            "parent": "sour",
                            "id": "soury",
                            "fill": "#e5dc65"
                        },
                        {
                            "name": "Tangy",
                            "parent": "winey",
                            "id": "tangy"
                        },
                        {
                            "name": "Tart",
                            "parent": "winey",
                            "id": "tart"
                        },
                        {
                            "name": "Hard",
                            "parent": "soury",
                            "id": "hard"
                        },
                        {
                            "name": "Acrid",
                            "parent": "soury",
                            "id": "acrid"
                        }
                        ]';

        return $wheelData;
    }

    public function getRoasters()
    {

        $roasters = '[
                    {
                    "id": 1,
                    "name": "Henry Roaster"
                    },
                    {
                    "id": 2,
                    "name": "Elixr Coffee Roasters"
                    }, 
                    {
                    "id": 3,
                    "name": "La Colombe Coffee Roasters"
                    }, 
                    {
                    "id": 4,
                    "name": "Vibrant Coffee Roasters & Bakery"
                    } 
                  ]';
        return $roasters;
    }


    public function getManualUsersData()
    {

        $payload = array(
            array(
                "email" => "info@12farms.com",
                "password" => "greenstreet@2025?",
                "firstName" => "12 Farms",
                "lastName" => "Restaurant",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Hightstown",
                "billingState" => "NJ",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "12 Farms Restaurant",
                "businessType" => "Buyer",
                "billingZipCode" => "08520",
                "taxIdNumber" => "",
                "billingAddressLine1" => "120 N. Main Street",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "jokowas@yahoo.com",
                "password" => "greenstreet@2025?",
                "firstName" => "3 J's",
                "lastName" => "Cafe",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "3 J's Cafe",
                "businessType" => "Buyer",
                "billingZipCode" => "1112", // Using default as ZIP not provided
                "taxIdNumber" => "",
                "billingAddressLine1" => "801 N. 2nd Street",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "jokowas@yahoo.com",
                "password" => "greenstreet@2025?",
                "firstName" => "3 J's",
                "lastName" => "Food Market Fishtown",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "3 J's Food Market Fishtown",
                "businessType" => "Buyer",
                "billingZipCode" => "19125",
                "taxIdNumber" => "",
                "billingAddressLine1" => "1140 Shackamaxon St",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "Jandkstaffing@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "43 E.",
                "lastName" => "Synder Ave",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "(215) 485-0272",
                "businessName" => "43 E. Synder Ave",
                "businessType" => "Buyer",
                "billingZipCode" => "19148",
                "taxIdNumber" => "",
                "billingAddressLine1" => "43 E. Synder Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "agamble@locals8.com",
                "password" => "greenstreet@2025?",
                "firstName" => "4th Street",
                "lastName" => "Deli",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "4th Street Deli",
                "businessType" => "Buyer",
                "billingZipCode" => "19147",
                "taxIdNumber" => "",
                "billingAddressLine1" => "700 S 4th St, Philadelphia",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "joe@alponte.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Al",
                "lastName" => "Ponte",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Neptune City",
                "billingState" => "NJ",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Al Ponte",
                "businessType" => "Buyer",
                "billingZipCode" => "07753",
                "taxIdNumber" => "",
                "billingAddressLine1" => "1311 NJ Route 35 South",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "Allen.Todd@sig.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Allen",
                "lastName" => "Todd",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Allen Todd",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "andrew@octostudio.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Andrew",
                "lastName" => "J",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Andrew J",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "sonja@bicyclecoalition.org",
                "password" => "greenstreet@2025?",
                "firstName" => "Bicycle Coalition of Greater",
                "lastName" => "Philadelphia",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Bicycle Coalition of Greater Philadelphia",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "c.durkin@breezysdeli.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Breezy's",
                "lastName" => "Deli and Market",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Breezy's Deli and Market",
                "businessType" => "Buyer",
                "billingZipCode" => "19146",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2235 Washington Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "brielle.gerrity@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Brielle",
                "lastName" => "Gerrity",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Brielle Gerrity",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "gclarke@brunchaholicsphilly.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Terrance",
                "lastName" => "Clarke",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "PHILADELPHIA",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "(267) 519-2031",
                "businessName" => "Brunchaholics",
                "businessType" => "Buyer",
                "billingZipCode" => "19125",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2401 Aramingo Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "lorenzoarturo.al@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Cafe Y",
                "lastName" => "Chocolate",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Cafe Y Chocolate",
                "businessType" => "Buyer",
                "billingZipCode" => "19145",
                "taxIdNumber" => "",
                "billingAddressLine1" => "1532 Snyder Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "nick@sojournphilly.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Cafe",
                "lastName" => "Ynez",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Cafe Ynez",
                "businessType" => "Buyer",
                "billingZipCode" => "19146",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2025 Washington Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),

            array(
                "email" => "ni@eliandarts.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Nicole",
                "lastName" => "Eiland",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Merchantville",
                "billingState" => "NJ",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Eilandarts Center",
                "businessType" => "Buyer",
                "billingZipCode" => "08109",
                "taxIdNumber" => "",
                "billingAddressLine1" => "10 E Chestnut Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "jcat@elchingonphilly.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Juan Carlos",
                "lastName" => "Aparicio",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "El Chingon",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "aracelicruz3@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "El Cholo &",
                "lastName" => "El Mariachi",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "(267) 250-1299",
                "businessName" => "El Cholo & El Mariachi",
                "businessType" => "Buyer",
                "billingZipCode" => "19148",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2001 s 9th st",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "elpanzon027@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "El",
                "lastName" => "Panzon",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Pennsauken",
                "billingState" => "NJ",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "El Panzon",
                "businessType" => "Buyer",
                "billingZipCode" => "08110",
                "taxIdNumber" => "",
                "billingAddressLine1" => "3618 marlton pike",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "arenasmaria67@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "El",
                "lastName" => "Pastel",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "El Pastel",
                "businessType" => "Buyer",
                "billingZipCode" => "19148",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2101 S 3rd Street",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),

            array(
                "email" => "jimmy@gaulandco.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Gaul & Co.",
                "lastName" => "Malt House",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "(215) 431-7331",
                "businessName" => "Gaul & Co. Malt House",
                "businessType" => "Buyer",
                "billingZipCode" => "19134",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2619 E. Indiana Ave.",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "maxx.ryan@wholefoods.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Glen Mills",
                "lastName" => "Whole Foods #74",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Glen Mills",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Glen Mills Whole Foods #74",
                "businessType" => "Buyer",
                "billingZipCode" => "19342",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "sawyer90@yahoo.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Gordan",
                "lastName" => "Todorovac",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Exton",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Gordan Todorovac",
                "businessType" => "Buyer",
                "billingZipCode" => "19341",
                "taxIdNumber" => "",
                "billingAddressLine1" => "408 Newcomen Rd.",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "christinedipros@gmail.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Higher",
                "lastName" => "Grounds",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Higher Grounds",
                "businessType" => "Buyer",
                "billingZipCode" => "19123",
                "taxIdNumber" => "",
                "billingAddressLine1" => "631 N. 3rd Street",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "hinge_me@yahoo.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Hinge",
                "lastName" => "Cafe",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Hinge Cafe",
                "businessType" => "Buyer",
                "billingZipCode" => "19134",
                "taxIdNumber" => "",
                "billingAddressLine1" => "2443 Somerset St",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),

            array(
                "email" => "kitchen@partyspace.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Jeffery Miller",
                "lastName" => "Catering",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Lansdowne",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Jeffery Miller Catering",
                "businessType" => "Buyer",
                "billingZipCode" => "19050",
                "taxIdNumber" => "",
                "billingAddressLine1" => "20 S Union Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),
            array(
                "email" => "evelyn.baker@wholefoods.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Jenkintown",
                "lastName" => "Whole Foods #40",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Jenkintown",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "(215) 481-0800",
                "businessName" => "Jenkintown Whole Foods #40",
                "businessType" => "Buyer",
                "billingZipCode" => "19046",
                "taxIdNumber" => "",
                "billingAddressLine1" => "Patrick Cambell Mid Atlantic #40",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),

            array(
                "email" => "jimmy@gaulandco.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Joseph's",
                "lastName" => "Pizza Parlor",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "Philadelphia",
                "billingState" => "PA",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Joseph's Pizza Parlor",
                "businessType" => "Buyer",
                "billingZipCode" => "19111",
                "taxIdNumber" => "",
                "billingAddressLine1" => "7947 Oxford Ave",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            ),

            array(
                "email" => "blueeyedjy@yahoo.com",
                "password" => "greenstreet@2025?",
                "firstName" => "Joy",
                "lastName" => "Citta",
                "receiveEmailNotifications" => true,
                "billingCountry" => "USA",
                "billingCity" => "New Bold",
                "billingState" => "Philadelphia",
                "preferredLanguage" => "english",
                "phoneNumber" => "",
                "businessName" => "Joy Citta",
                "businessType" => "Buyer",
                "billingZipCode" => "1112",
                "taxIdNumber" => "",
                "billingAddressLine1" => "",
                "billingAddressLine2" => "",
                "userRole" => "Buyer",
                "userType" => "Buyer"
            )
        );
        return $payload;
    }


    public function getManualCartHistory($num_of_items)
    {
        $payload = array(
            "stockPostingId" => 1,
            "numBags" => $num_of_items,
            "isRoast" => true,
            "roastType" => 'medium',
            "grindType" => 'medium',
            "bagSize" => null,
            "bagImage" => null
        );
    }

    public function getBagDetails($bag)
    {
        $productData = array(
            '5lb_bag' => array(
                'title' => '5lb Bag',
                'size' => '~8" W x 5" D x 19" H',
                'color' => 'Color: Matte black',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 5.50 in (H) x 4 in (L)',
                'mainImage' => '5lb_1.jpg',
                'previewImages' => array('5lb_1.jpg', '5lb.jpg', '5lb.jpg', '5lb.jpg')
            ),
            '12oz_frac_pack' => array(
                'title' => '12oz Frac Pack',
                'size' => '~4" W x 3" D x 12" H',
                'color' => 'Color: Matte black',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 1.75 in (H) x 3.75 in (L)',
                'mainImage' => '12oz_1.png',
                'previewImages' => array('12oz_1.png', '12oz_2.png', '12oz_3.png', '12oz_4.jpg')
            ),
            '10oz_bag' => array(
                'title' => '10oz Bag',
                'size' => '~3.5" W x 2.5" D x 10" H',
                'color' => 'Color: Matte black',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 1.75 in (H) x 3.75 in (L)',
                'mainImage' => '10oz_1.png',
                'previewImages' => array('10oz_1.png', '10oz_2.jpg', '10oz_3.jpg', '10oz_4.jpg')
            ),
            'frac_pack' => array(
                'title' => 'Frac Packs',
                'size' => '~6.5" W x 2.5" D x 8" H',
                'color' => 'Color: Silver foil',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 3.5 in (H) x 2.75 in (L)',
                'mainImage' => 'frac_pack.jpg',
                'previewImages' => array('frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg')
            ),
            'frac_pack_3oz' => array(
                'title' => 'Frac Packs 3oz',
                'size' => '~6.5" W x 2.5" D x 8" H',
                'color' => 'Color: Silver foil',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 3.5 in (H) x 2.75 in (L)',
                'mainImage' => 'frac_pack.jpg',
                'previewImages' => array('frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg')
            ),
            'frac_pack_4oz' => array(
                'title' => 'Frac Packs 4oz',
                'size' => '~6.5" W x 2.5" D x 8" H',
                'color' => 'Color: Silver foil',
                'origin' => 'Roasted in the USA',
                'note' => 'Label size: 3.5 in (H) x 2.75 in (L)',
                'mainImage' => 'frac_pack.jpg',
                'previewImages' => array('frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg', 'frac_pack.jpg')
            ),
            'k_cup' => array(
                'title' => 'K Cup',
                'size' => '12 Count Box',
                'color' => 'Color: Matte black',
                'origin' => 'Roasted in the USA',
                'note' => '',
                'mainImage' => 'kcup_1.png',
                'previewImages' => array('kcup_1.png', 'kcup_2.jpg', 'kcup_3.jpg', 'kcup_4.jpg')
            )
        );
        // dd($productData[$bag]);

        // Handle special cases for different bag key mappings
        if ($bag === 'oz_bag') {
            return $productData['10oz_bag'];
        }

        if ($bag === 'oz_frac_pack') {
            return $productData['12oz_frac_pack'];
        }

        if ($bag === 'lb') {
            return $productData['5lb_bag'];
        }

        if (array_key_exists($bag, $productData)) {
            return $productData[$bag];
        }

        // Return default array when key is not matched
        return array(
            'title' => $bag,
            'size' => '~3.5" W x 2.5" D x 10" H',
            'color' => 'Color: Matte black',
            'origin' => 'Roasted in the USA',
            'note' => 'Label size: 1.75 in (H) x 3.75 in (L)',
            'mainImage' => '12oz_1.png',
            'previewImages' => array('12oz_1.png', '12oz_1.png', '12oz_1.png', '12oz_1.png')
        );
    }

    public function resetCart()
    {
        session()->forget('roast');
        session()->forget('roast_type');
        session()->forget('grind_type');
        session()->forget('bag_size');
        session()->forget('bag_image');
        session()->forget('product');
        session()->forget('num_of_bags');
    }

    public function getBrands()
    {
        $brands = array(
            array(
                'id' => 1,
                'logoUrl' => 'https://res.cloudinary.com/dfovrekgg/image/upload/v1742504901/k7ra0arugisuybpvbetq.jpg',
                'name' => 'Green Street Coffee',
            )

        );

        return $brands;
    }

    public function getProductTypes()
    {
        return array(
            array(
                'value' => self::GREEN_COFFEE,
                'label' => 'Green Coffee'
            ),
            array(
                'value' => self::ROASTED_SINGLE_ORIGIN_COFFEE,
                'label' => 'Roasted Single Origin Coffee'
            ),
            array(
                'value' => self::ROASTED_BLEND_COFFEE,
                'label' => 'Roasted Blend Coffee'
            ),
            array(
                'value' => self::WHOLE_SALE_BRAND_COFFEE,
                'label' => 'Whole Sale Brand Coffee'
            )
        );
    }
}
