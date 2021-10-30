<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Url;

class UrlController extends Controller
{
    public function add(Request $request)
    {
        $long_url = $request->input('URL');

        $url = new Url();
        $url->add('short', $long_url, 0);

        return "Add $long_url";
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
        $url = Url::findLong($request->short_url);
        $long_url = $url->long;

        return "Redirect $long_url";
    }

    public function saveRedirect(Request $request)
    {
        $url = Url::findLong($request->short_url);
        $long_url = $url->long;

        return "Save redirect $long_url";
    }
}