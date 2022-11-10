<?php

namespace App\Http\Controllers;

use App\Http\Requests\LinkShortStoreRequest;
use App\Models\ShortLink;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class LinkShortController extends Controller
{
    public function store(LinkShortStoreRequest $request)
    {
        $validateDate = $request->validated();
        $long_url = $validateDate['long_url'];

        // Duplicate long url check
        $long_url_duplicate = ShortLink::query()->where('long_url', $long_url)->first();
        if ($long_url_duplicate){
            return response()->json(['message' => 'Already short url exits!',  'short_url' => $long_url_duplicate->short_url], 200);
            //throw ValidationException::withMessages(['message' => 'Already short url exits!'], ['short_url' => $long_url_duplicate->short_url]);
        }

        $base = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $path = url('/');
        $short_url = '';

        // Generate short url
        for ($i = 0; $i < 6; $i++) {
            $short_url .= $base[rand(0, 61)];
        }

        $short_url = $path . "/" . $short_url;

        // Duplicate short url check
        while (1) {
            $duplicate = ShortLink::query()->where('short_url', $short_url)->first();
            if ($duplicate) {
                $short_url = '';
                for ($i = 0; $i < 6; $i++) {
                    $short_url .= $base[rand(0, 61)];
                }
            } else {
                break;
            }
        }

        $data['long_url']  = $long_url;
        $data['short_url'] = $short_url;
        $created_short_url = ShortLink::query()->create($data);

        return response()->json(['message' => 'Short link created successfully.', 'short_url' => $created_short_url->short_url], 200);

    }
}
