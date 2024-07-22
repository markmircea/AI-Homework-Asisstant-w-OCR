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


        $announcements->transform(function ($announcement) {
            return [
                'title' => $announcement->title,
                'content' => $announcement->content,
                'user_id' => $announcement->user_id,
                'id' => $announcement->id,
                'aiquery' => $announcement->aiquery,
                'subject' => $announcement->subject,
                'extracted_text' => $announcement->extracted_text,
                'instructions' => $announcement->instructions,
                'created_at' => $announcement->created_at,
                'updated_at' => $announcement->updated_at,
                'deleted_at' => $announcement->deleted_at,
                'photo' => $announcement->photo_path ? URL::route('image', ['path' => $announcement->photo_path, 'w' => 400, 'h' => 400, 'fit' => 'crop']) : null,
            ];
        });

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



        return Inertia::render('Dashboard/Index', [
            'coins' => $coins,
            'user' => $userTransformed,
            'announcements' => $announcements,
        ]);
    }

    public function indexNoAuth()
    {
        // Accessible for non-authenticated users
       return Inertia::render('Dashboard/IndexNoAuth');
    }
}
