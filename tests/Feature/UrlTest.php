<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use DOMDocument;
use App\Services\UrlService;

class UrlTest extends TestCase
{
    const VALID_URL = 'http://www.google.com';
    const NOT_VALID_URL = 'http://qweqwe.qw/qwe';
    const ERROR_HTTP_STATUS = 422;
    const SUCCESS_HTTP_STATUS = 200;

    public function testAddNotValidUrl()
    {
        $response = $this->postJson('/add', ['URL' => 'notValidUrl']);

        $response->assertStatus(self::ERROR_HTTP_STATUS);
        $response->assertJsonPath('URL', ['The u r l must be a valid URL.']);
    }

    public function testAddNotActiveUrl()
    {
        $response = $this->postJson('/add', ['URL' => self::NOT_VALID_URL]);

        $response->assertStatus(self::ERROR_HTTP_STATUS);
        $response->assertJsonPath('URL', 'Not correct URL!');
    }

    public function testAddUrlAndRedirect()
    {
        $this->addUrlAndRedidect('add');
    }

    public function testAddCustomUrlAndRedirect()
    {
        $custom = UrlService::genUri();

        $this->addUrlAndRedidect($custom);
    }

    public function testAddCustomUrlTwice()
    {
        $custom = UrlService::genUri();

        $response = $this->postJson('/'.$custom, ['URL' => self::VALID_URL]);

        $response->assertStatus(self::SUCCESS_HTTP_STATUS);

        $response = $this->postJson('/'.$custom, ['URL' => self::VALID_URL]);

        $response->assertStatus(self::ERROR_HTTP_STATUS);
        $response->assertJsonPath('URL', 'Not unique short URL!');
    }

    public function testAddUrlTwice()
    {
        $response = $this->postJson('/add', ['URL' => self::VALID_URL]);

        $response->assertStatus(self::SUCCESS_HTTP_STATUS);
        $res = $response->dump();
        $shortUrl = $res->baseResponse->original['URL'];

        $response = $this->postJson('/add', ['URL' => self::VALID_URL]);
        $response->assertStatus(self::SUCCESS_HTTP_STATUS);
        $res = $response->dump();
        $response->assertJsonPath('URL', $shortUrl);
    }

    private function addUrlAndRedidect($uri)
    {
        $response = $this->postJson('/'.$uri, ['URL' => self::VALID_URL]);

        $response->assertStatus(self::SUCCESS_HTTP_STATUS);
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
