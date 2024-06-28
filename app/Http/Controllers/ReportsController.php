<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class ReportsController extends Controller
{
    public function index(): Response
    {
        $filters = Request::all('search', 'trashed', 'strengths'); // Retrieve all filters including strengths

        // Query builder for contacts
        $contactsQuery = Auth::user()->account->contacts()
            ->with('organization')
            ->orderByName();

        // Apply search filter
        if ($filters['search']) {
            $contactsQuery->where(function ($query) use ($filters) {
                $query->where('first_name', 'like', '%'.$filters['search'].'%')
                      ->orWhere('description', 'like', '%'.$filters['search'].'%')
                      ->orWhere('last_name', 'like', '%'.$filters['search'].'%');
            });
        }

        // Apply trashed filter
        if ($filters['trashed'] === 'only') {
            $contactsQuery->onlyTrashed();
        } elseif ($filters['trashed'] === 'with') {
            $contactsQuery->withTrashed();
        }

        // Apply strengths filter
        if (!empty($filters['strengths'])) {
            // Filter contacts that have ALL selected strengths
            $contactsQuery->where(function ($query) use ($filters) {
                foreach ($filters['strengths'] as $strength) {
                    $query->whereJsonContains('strengths', $strength);
                }
            });
        }

        // Paginate the results
        $contacts = $contactsQuery->paginate(10)->withQueryString();

        // Prepare data for Inertia rendering
        return Inertia::render('Reports/Index', [
            'filters' => $filters,
            'contacts' => $contacts,
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

    public function store(): RedirectResponse
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

            ])
        );

        return Redirect::route('contacts')->with('success', 'Contact created.');
    }

    public function edit(Contact $contact): Response
    {
        return Inertia::render('Contacts/Edit', [
            'contact' => [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization_id' => $contact->organization_id,
                'email' => $contact->email,
                'phone' => $contact->phone,
                'address' => $contact->address,
                'city' => $contact->city,
                'region' => $contact->region,
                'country' => $contact->country,
                'postal_code' => $contact->postal_code,
                'deleted_at' => $contact->deleted_at,

                'description' => $contact->description,
                'strengths' => $contact->strengths,
                'soft_skills' => $contact->soft_skills,
            ],
            'organizations' => Auth::user()->account->organizations()
                ->orderBy('name')
                ->get()
                ->map
                ->only('id', 'name'),
        ]);
    }

    public function update(Contact $contact): RedirectResponse
    {
        $contact->update(
            Request::validate([
                'first_name' => ['required', 'max:50'],
                'last_name' => ['required', 'max:50'],
                'organization_id' => [
                    'nullable',
                    Rule::exists('organizations', 'id')->where(fn ($query) => $query->where('account_id', Auth::user()->account_id)),
                ],
                'email' => ['nullable', 'max:50', 'email'],
                'phone' => ['nullable', 'max:50'],
                'address' => ['nullable', 'max:150'],
                'city' => ['nullable', 'max:50'],
                'region' => ['nullable', 'max:50'],
                'country' => ['nullable', 'max:2'],
                'postal_code' => ['nullable', 'max:25'],
                'description' => ['nullable', 'max:2000'],
                'strengths' => ['nullable', 'max:2000'],
                'soft_skills' => ['nullable' , 'max:2000'],

            ])
        );

        return Redirect::back()->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return Redirect::back()->with('success', 'Contact deleted.');
    }

    public function restore(Contact $contact): RedirectResponse
    {
        $contact->restore();

        return Redirect::back()->with('success', 'Contact restored.');
    }
}
