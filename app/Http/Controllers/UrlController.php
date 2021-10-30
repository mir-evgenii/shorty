<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Services\UrlService;

class UrlController extends Controller
{
    public function add(Request $request)
    {
        $long_url = $request->input('URL');

        // $url = new Url();
        // $url->add('short', $long_url, 0);

        $url_service = new UrlService();
        $q = $url_service->add($long_url);

        return "Add $long_url $q";
    }

    public function addCustom(Request $request)
    {
        $short_url = $request->short_url;
        $long_url = $request->input('URL');

        $url = new Url();
        $url->add($short_url, $long_url, 1);

        return "Add custom $long_url";
    }

    public function redirect(Request $request)
    {
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return "Redirect $long_url";
    }

    public function saveRedirect(Request $request)
    {
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return "Save redirect $long_url";
    }
}