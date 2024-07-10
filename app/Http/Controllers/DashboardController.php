<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Announcement;




class DashboardController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        $coins = $user->coins;

        Inertia::share('coins', $coins);

     //   $announcements = Announcement::where('user_id', $user->id)->get();
        $announcements = $user->announcements()->orderBy('order')->get();


        return Inertia::render('Dashboard/Index', [
            'coins' => $coins,
            'user' => $user,
            'announcements' => $announcements,
        ]);
    }
}
