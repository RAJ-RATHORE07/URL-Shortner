<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        if ($user->role === 'superadmin') {
            // SuperAdmin -> sab companies ke sab URLs
            $urls = Url::with('company', 'user')
                ->latest()
                ->get();

        } elseif ($user->role === 'admin') {
            // Admin -> sirf apni company ke sab URLs
            $urls = Url::with('company', 'user')
                ->where('company_id', $user->company_id)
                ->latest()
                ->get();

        } else { // member
            // Member -> sirf khud ke URLs
            $urls = Url::with('company', 'user')
                ->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('dashboard', compact('user', 'urls'));
    }
}
