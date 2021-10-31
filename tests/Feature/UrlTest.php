<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlTest extends TestCase
{
    public function testAddNotValidUrl()
    {
        $response = $this->postJson('/add', ['URL' => 'notValidUrl']);

        $response->assertStatus(422);
        $response->assertJsonPath('URL', ['The u r l must be a valid URL.']);
        $response->dump();
    }

    public function testAddNotActiveUrl()
    {
        $response = $this->postJson('/add', ['URL' => 'http://qweqwe.qw/qwe']);

        $response->assertStatus(422);
        $response->assertJsonPath('URL', 'Not correct URL!');
        $response->dump();
    }
}
