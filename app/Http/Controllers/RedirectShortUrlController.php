<?php

namespace App\Http\Controllers;

use App\Models\Url;

class RedirectShortUrlController extends Controller
{
    public function __invoke(string $code)
    {
        $url = Url::where('short_code', $code)->firstOrFail();

        return redirect()->away($url->original_url);
    }
}
