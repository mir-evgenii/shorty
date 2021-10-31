<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DOMDocument;

class UrlTest extends TestCase
{
    public function testAddNotValidUrl()
    {
        $response = $this->postJson('/add', ['URL' => 'notValidUrl']);

        $response->assertStatus(422);
        $response->assertJsonPath('URL', ['The u r l must be a valid URL.']);
    }

    public function testAddNotActiveUrl()
    {
        $response = $this->postJson('/add', ['URL' => 'http://qweqwe.qw/qwe']);

        $response->assertStatus(422);
        $response->assertJsonPath('URL', 'Not correct URL!');
    }

    public function testAddUrlAndRedirect()
    {
        $response = $this->postJson('/add', ['URL' => 'http://www.google.com']);

        $response->assertStatus(200);
        $res = $response->dump();
        $shortUrl = $res->baseResponse->original['URL'];

        $httpCode = $this->getHttpCode($shortUrl);
        echo "\nHttp код страницы переадресации: ".$httpCode."\n";

        $title = $this->getHtmlPageTitle($shortUrl);
        echo "\nПереадресован на страницу: ".$title."\n";
    }

    private function getHttpCode($url)
    {
        $curl = curl_init($url);
        curl_exec($curl);
        $http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        return $http_code;
    }

    private function getHtmlPageTitle($url)
    {
        libxml_use_internal_errors(true);
        $dom = new DOMDocument();
        $dom->loadHTMLFile($url);
        $anchors = $dom->getElementsByTagName('title');
        foreach ($anchors as $a) {
            $title = $a->nodeValue;
        }

        return $title;
    }
}
