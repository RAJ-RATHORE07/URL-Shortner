<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Redirect users to login page if not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // If user is not logged in and request is NOT an API request,
        // redirect them to the login page
        if (! $request->expectsJson()) {
            return route('login'); 
        }

        return null;
    }
}
