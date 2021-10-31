<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Url;
use App\Services\UrlService;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'URL' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        $long_url = $request->input('URL');

        $url_service = new UrlService();
        $result = $url_service->add($long_url);

        if ($result[0]) {
            return response(['URL' => $result[1]], 422);
        }

        $result = url($result[1]);
        $result = ['URL' => $result];

        return $result;
    }

    public function addCustom(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'URL' => 'required|url'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->messages(), 422);
        }

        // TODO обьединить с add методом, код почти одинаковый
        $short_url = $request->short_url;
        $long_url = $request->input('URL');

        $url_service = new UrlService();
        $result = $url_service->add($long_url, $short_url);

        if ($result[0]) {
            return response(['URL' => $result[1]], 422);
        }

        $result = url($result[1]);
        $result = ['URL' => $result];

        return $result;
    }

    public function redirect(Request $request)
    {
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return redirect("$long_url");
    }

    public function saveRedirect(Request $request)
    {
        $url = Url::findShort($request->short_url);
        $long_url = $url->long;

        return "Save redirect $long_url";
    }
}