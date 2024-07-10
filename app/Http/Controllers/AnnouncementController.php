<?php
// app/Http/Controllers/AnnouncementController.php
namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AnnouncementController extends Controller
{
    public function create()
    {
        return Inertia::render('Announcements/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Auth::user()->announcements()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Announcement created.');
    }

    public function edit(Announcement $announcement)
    {
        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Announcements/Edit', ['announcement' => $announcement]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Announcement updated.');
    }

    public function destroy(Announcement $announcement)
    {
        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $announcement->delete();

        return redirect()->route('dashboard')->with('success', 'Announcement deleted.');
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

        return redirect()->route('dashboard')->with('success', 'Announcements reordered.');
    }
}
