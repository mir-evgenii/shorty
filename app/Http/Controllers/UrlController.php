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

        $url_service = new UrlService();
        $result = $url_service->add($long_url);

        return "Add $result";
    }

    public function addCustom(Request $request)
    {
        // TODO обьединить с add методом, код почти одинаковый
        $short_url = $request->short_url;
        $long_url = $request->input('URL');

        $url_service = new UrlService();
        $result = $url_service->add($long_url, $short_url);

        return "Add custom $result";
    }

    public function redirect(Request $request)
    {
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return redirect("$long_url");
    }

    public function saveRedirect(Request $request)
    {
        // TODO обьединить с redirect, код почти одинаковый
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return "Save redirect $long_url";
    }
}