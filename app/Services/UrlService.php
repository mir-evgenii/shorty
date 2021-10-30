<?php

namespace App\Services;

use App\Models\Url;

class UrlService
{
    public function add($long_url, $short_url=null)
    {
        // if ($this->isCorrectUrl($long_url)) {
        //     return 'isCorrectUrl';
        // }

        // $url = $this->findLongUrl($long_url);
        // if ($url) {
        //     return $url->short;
        // }

        return $this->genUrl();
    }

    private function isCorrectUrl($long_url)
    {
        $curl = curl_init($long_url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
 
        if ($http_code == '200') {
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

    private function isBadUrl()
    {
        //провека длинного URL по справочнику запрешенных URL
    }

    private function isUniqueShortUrl($short_url)
    {
        $url = Url::findShort($short_url);

        if ($url == null) {
            return true;
        } 

        return false;
    }

    private function isBadCustomUrl($short_url)
    {
        //проверка нового URL если он кастомный (проверка по справочнику запрешенных слов)
    }

    private function genUrl()
    {
        $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $strength = 6;

        $input_length = strlen($input);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }
}