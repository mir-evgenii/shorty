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
        $long_url = $request->input('URL');
        return "Add custom $long_url";
    }

    public function redirect(Request $request)
    {
        return "Redirect $request->short_url";
    }

    public function saveRedirect(Request $request)
    {
        return "Save redirect $request->short_url";
    }
}