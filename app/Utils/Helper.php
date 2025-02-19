<?php

namespace App\Utils;

class Helper
{
    /**
     * generate guid
     *
     * @param bool $format
     * @return string
     */
    public static function guid(bool $format = false): string
    {
        if (function_exists('com_create_guid') === true) {
            return md5(trim(com_create_guid(), '{}'));
        }
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40); // set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80); // set bits 6-7 to 10
        if ($format) {
            return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }
        return md5(vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4)) . '-' . time());
    }

    /**
     * get rates from exchange
     *
     * @param $from
     * @param $to
     * @return mixed
     */
    public static function exchange($from, $to)
    {
        $result = file_get_contents('https://api.exchangerate.host/latest?symbols=' . $to . '&base=' . $from);
        $result = json_decode($result, true);
        return $result['rates'][$to];
    }


    /**
     * generate random string
     *
     * @param int $len
     * @param bool $special
     * @return string
     */
    public static function randomChar(int $len, bool $special = false): string
    {
        $chars = array(
            "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
            "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
            "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
            "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
            "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
            "3", "4", "5", "6", "7", "8", "9"
        );

        if ($special) {
            $chars = array_merge($chars, array(
                "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
                "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
                "}", "<", ">", "~", "+", "=", ",", "."
            ));
        }

        $charsLen = count($chars) - 1;
        shuffle($chars);
        $str = '';
        for ($i = 0; $i < $len; $i++) {
            $str .= $chars[mt_rand(0, $charsLen)];
        }
        return $str;
    }

    /**
     * generate order number
     *
     * @return string
     */
    public static function generateOrderNo(): string
    {
        $randomChar = rand(10000, 99999);
        return date('YmdHms') . $randomChar;
    }


    /**
     * multi password verify
     *
     * @param string|null $algo
     * @param string|null $salt
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public static function multiPasswordVerify(?string $algo, ?string $salt, string $password, string $hash): bool
    {
        switch ($algo) {
            case 'md5':
                return md5($password) === $hash;
            case 'sha256':
                return hash('sha256', $password) === $hash;
            case 'md5salt':
                return md5($password . $salt) === $hash;
            default:
                return password_verify($password, $hash);
        }
    }

    /**
     * email suffix verify
     *
     * @param string $email
     * @param mixed $suffixes
     * @return bool
     */
    public static function emailSuffixVerify(string $email, $suffixes): bool
    {
        $suffix = preg_split('/@/', $email)[1];
        if (!$suffix) {
            return false;
        }

        if (!is_array($suffixes)) {
            $suffixes = preg_split('/,/', $suffixes);
        }

        if (!in_array($suffix, $suffixes)) {
            return false;
        }
        return true;
    }

    /**
     * traffic convert
     *
     * @param int $byte
     * @return int|string
     */
    public static function trafficConvert(int $byte)
    {
        $kb = 1024;
        $mb = 1048576;
        $gb = 1073741824;
        if ($byte > $gb) {
            return round($byte / $gb, 2) . ' GB';
        } else if ($byte > $mb) {
            return round($byte / $mb, 2) . ' MB';
        } else if ($byte > $kb) {
            return round($byte / $kb, 2) . ' KB';
        } else if ($byte < 0) {
            return 0;
        } else {
            return round($byte, 2) . ' B';
        }
    }

    /**
     * get subscribe host
     *
     * @return  string
     */
    public static function getSubscribeHost(): string
    {
        $subscribeUrl = config('v2board.app_url');
        $subscribeUrls = explode(',', config('v2board.subscribe_url'));
        if ($subscribeUrls && $subscribeUrls[0]) {
            $subscribeUrl = $subscribeUrls[rand(0, count($subscribeUrls) - 1)];
        }
        return $subscribeUrl;
    }
}
