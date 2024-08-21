<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ContactFormSubmission;
use Illuminate\Support\Facades\RateLimiter;

class DashboardController extends Controller
{
    public function index(Request $request): Response
    {
        $user = Auth::user();
        $coins = $user->coins;

        Inertia::share('coins', $coins);

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
            'selectedSubject' => $request->query('subject', ''),
        ]);
    }

    public function indexNoAuth()
    {
        return Inertia::render('Dashboard/IndexNoAuth');
    }

    public function contact(Request $request)
    {
        $key = 'contact_form_' . $request->ip();
        $maxAttempts = 3; // Maximum 3 attempts
        $decaySeconds = 3600; // Per hour

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many attempts. Please try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key, $decaySeconds);

        Log::info('Received contact form submission. Raw data:', $request->all());

        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Log::info('Validated data:', $validated);

        try {
            Notification::route('mail', 'support@easyace.ai')
                ->notify(new ContactFormSubmission($validated));

            Log::info('Contact form notification sent successfully to support@easyace.ai');
            return back()->with('success', 'Message sent successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to send contact form notification: ' . $e->getMessage());
            return back()->with('error', 'Failed to send message. Please try again later.');
        }
    }
}
