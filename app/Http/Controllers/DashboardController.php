<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;



class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $coins = $user->coins;

        Inertia::share('coins', $coins);

        return Inertia::render('Dashboard/Index', [
            'coins' => $coins,
            'user' => Auth::user(),
        ]);
    }
}
