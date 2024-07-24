<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Models\Announcement;
use Illuminate\Support\Facades\Log;

class HistoryController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized access.');
        }
        $coins = $user->coins;

        Inertia::share('coins', $coins);

        // For reorder $announcements = $user->announcements()->orderBy('order')->get();

        // Fetch announcements ordered by creation date, newest first
        $announcements = $user->announcements()->orderBy('created_at', 'desc')->get();


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


        return Inertia::render('History/Index', [
            'coins' => $coins,
            'user' => $user,
            'announcements' => $announcements,
        ]);
    }





    public function edit(Announcement $announcement)
    {

        Log::info('Current User ID: ' . Auth::id());
        Log::info('Announcement User ID: ' . $announcement->user_id);

        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('History/Edit', ['announcement' => $announcement]);
    }



    public function update(Request $request, Announcement $announcement)
    {
        Log::info('Update request data:', $request->all());
        Log::info('Current User ID: ' . Auth::id());


        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update($request->all());

        return redirect()->route('history')->with('success', 'Announcement updated.');
    }


    public function destroy(Announcement $announcement)
    {
        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $announcement->delete();

        return redirect()->route('history')->with('success', 'Announcement deleted.');
    }


    public function updateOrder(Request $request)
    {
        $user = Auth::user();
        $announcements = $request->input('announcements', []);

        foreach ($announcements as $announcementData) {
            $announcement = Announcement::where('user_id', $user->id)
                ->where('id', $announcementData['id'])
                ->first();

            if ($announcement) {
                $announcement->order = $announcementData['order'];
                $announcement->updated_at = now(); // Update the updated_at column
                $announcement->save();
            }
        }

        return redirect()->route('history')->with('success', 'Announcements reordered.');
    }
}
