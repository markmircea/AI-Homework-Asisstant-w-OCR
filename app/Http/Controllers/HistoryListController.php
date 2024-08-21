<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use App\Models\Announcement;
use Illuminate\Support\Facades\URL;



class HistoryListController extends Controller
{
    public function index(Request $request): Response
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized access.');
        }
        $coins = $user->coins;
        $announcementsQuery = $user->announcements()->orderBy('created_at', 'desc');

        // Apply filters
        $announcementsQuery->filter($request->only('search', 'trashed'));

        $announcements = $announcementsQuery->paginate(10)->withQueryString();

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

        return Inertia::render('History/List', [
            'filters' => $request->all('search', 'trashed'),
            'coins' => $coins,
            'user' => $user,
            'announcements' => $announcements,
        ]);
    }
    public function create(): Response
    {
        return Inertia::render('Contacts/Create', [
            'organizations' => Auth::user()->account
                ->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function store()
    {
        Auth::user()->account->contacts()->create(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => ['nullable', Rule::exists('organizations', 'id')->where(function ($query) {
                    $query->where('account_id', Auth::user()->account_id);
                })],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
                'description' => ['nullable', 'max:2000'],
                'strengths' => ['nullable', 'max:2000', 'json'],
                'soft_skills' => ['nullable', 'max:2000', 'json'],

            ])
        );

        return Redirect::route('contacts')->with('success', 'Contact created.');
    }

    public function edit(Announcement $announcement): Response
    {


        return Inertia::render('History/ListEdit', [
            'announcement' => [
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
        ]]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        if ($announcement->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        $announcement->update($validated);

        return redirect()->route('history-list')->with('success', 'Title updated.');
    }

    public function destroy(Announcement $announcement)
    {


        $announcement->delete();

        return redirect()->back()->with('success', 'Search deleted.');
    }



    public function restore(Announcement $announcement): RedirectResponse
    {
        $announcement->restore();

        return Redirect::back()->with('success', 'Search restored.');
    }
}
