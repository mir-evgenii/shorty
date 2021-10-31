<?php

namespace App\Services;

use App\Models\Url;

class UrlService
{
    const SUCCESS_HTTP_STATUS = 200;
    const SYMBOLS_FOR_URI = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const LENGTH_URI = 6;

    public function add($long_url, $short_url=null)
    {
        if (!$this->isCorrectUrl($long_url)) {
            return [1, 'Not correct URL!'];
        }

        if (($short_url != null) && (!$this->isUniqueShortUrl($short_url) == true)) {
            return [1, 'Not unique short URL!'];
        }

        if ($short_url == null) {
            $custom = 1;
            $find_long_url = $this->findLongUrl($long_url);
            if ($find_long_url) {
                return [0, $find_long_url->short];
            }

            do {
                $short_url = UrlService::genUri();
            } while (!$this->isUniqueShortUrl($short_url));
        } else {
            $custom = 0;
        }

        $url = new Url();
        $url->add($short_url, $long_url, $custom);

        return [0, $short_url];
    }

    private function isCorrectUrl($long_url)
    {
        $curl = curl_init($long_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
 
        if ($http_code == self::SUCCESS_HTTP_STATUS) {
            return true;
        }

        return false;
    }

    private function findLongUrl($long_url)
    {
        $url = Url::findLong($long_url);

        if ($url == null) {
            return false;
        }

        return $url;
    }

    private function isUniqueShortUrl($short_url)
    {
        $url = Url::findShort($short_url);

        if ($url == null) {
            return true;
        } 

        return false;
    }

    public static function genUri()
    {
        $input_length = strlen(self::SYMBOLS_FOR_URI);
        $random_string = '';
        for ($i = 0; $i < self::LENGTH_URI; $i++) {
            $random_character = self::SYMBOLS_FOR_URI[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}
