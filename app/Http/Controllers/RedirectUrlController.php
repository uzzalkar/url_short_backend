<?php

namespace App\Http\Controllers;

use App\Models\ShortLink;
use Illuminate\Http\Request;

class RedirectUrlController extends Controller
{
    public function index($url_id)
    {
        $uri_path = $_SERVER['REQUEST_URI'];
        $uri_parts = explode('/', $uri_path);
        $request_url = end($uri_parts);

        $short_url = url('/') . "/" . $request_url;
        $result = ShortLink::query()->where('short_url', $short_url)->first();

        if (is_null($result)) {
            abort(404);
        }
        return redirect($result->long_url);
    }
}
