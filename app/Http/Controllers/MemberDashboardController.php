<?php

namespace App\Http\Controllers;

class MemberDashboardController extends Controller
{
    public function __invoke()
    {
        return view('dashboards.member');
    }
}
