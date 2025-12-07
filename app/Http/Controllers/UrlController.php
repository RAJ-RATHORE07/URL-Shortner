<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index()
    {
        // same listing logic as dashboard, reuse
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            $urls = Url::with('company', 'user')->latest()->get();
        } elseif ($user->role === 'admin') {
            $urls = Url::with('company', 'user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->get();
        } else {
            $urls = Url::with('company', 'user')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('urls.index', compact('urls', 'user'));
    }

    public function create()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot create short URLs');
        }

        return view('urls.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            abort(403, 'SuperAdmin cannot create short URLs');
        }

        $request->validate([
            'original_url' => 'required|url',
        ]);

        $code = Str::random(8);

        Url::create([
            'company_id'   => $user->company_id,
            'user_id'      => $user->id,
            'original_url' => $request->original_url,
            'short_code'         => $code,
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'Short URL created: ' . url('/s/' . $code));
    }

    public function redirect($code)
    {
        $url = Url::where('code', $code)->firstOrFail();

        return redirect()->away($url->original_url);
    }
}
