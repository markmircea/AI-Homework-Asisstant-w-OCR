<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

class PricingController extends Controller
{

    public function index()
    {
        if (Auth::user()) {
        $user = Auth::user();
        // Transform the user object directly
        $userTransformed = [
            'id' => $user->id,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'owner' => $user->owner,
            'photo' => $user->photo_path ? URL::route('image', ['path' => $user->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,
            'deleted_at' => $user->deleted_at,
        ];
        return Inertia::render('Dashboard/PricingPage', [
            'user' => $userTransformed
        ]);

    } else {
        return Inertia::render('Dashboard/PricingPage', [
        ]);
    }
}

}
