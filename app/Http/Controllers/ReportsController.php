<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactEmail;

class ReportsController extends Controller
{
    public function index(): Response
    {
        $filters = Request::all('search', 'trashed', 'strengths', 'hired', 'fired'); // Retrieve all filters including strengths

        // Query builder for contacts
        $contactsQuery = Auth::user()->account->contacts()
            ->with('organization')
            ->orderByName();

        // Apply search filter
        if ($filters['search']) {
            $contactsQuery->where(function ($query) use ($filters) {
                $query->where('first_name', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('description', 'like', '%' . $filters['search'] . '%')
                    ->orWhere('last_name', 'like', '%' . $filters['search'] . '%');
            });
        }

        // Apply hired filter
        if ($filters['hired'] === 'only') {
            $contactsQuery->whereNotNull('hired_on');
        }

        if ($filters['fired'] === 'only') {
            $contactsQuery->whereNotNull('hired_by')->whereNull('hired_on');
        }

        //elseif ($filters['fired'] === 'with') {
        //    $contactsQuery->whereNotNull('hired_by')->whereNull('hired_on');
        //}



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


        // Transform each contact to include the 'photo' attribute
        $contacts->getCollection()->transform(function ($contact) {
            return [
                'id' => $contact->id,
                'first_name' => $contact->first_name,
                'last_name' => $contact->last_name,
                'organization' => $contact->organization ? $contact->organization->only('name') : null,
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
                'hired_by' => $contact->hired_by,
                'hired_on' => $contact->hired_on,
                'photo' => $contact->photo_path ? URL::route('image', ['path' => $contact->photo_path, 'w' => 40, 'h' => 40, 'fit' => 'crop']) : null,
            ];
        });

        // Prepare data for Inertia rendering
        return Inertia::render('Reports/Index', [
            'filters' => $filters,
            'contacts' => $contacts,
        ]);
    }

    public function sendEmail(Contact $contact)
    {
        // Validate input (subject and message)
        $data = request()->validate([
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $sub = $data['subject'];

        // Send email logic
        // Mail::to($contact->email)->send(new ContactEmail($data['subject'], $data['message']));

        return Redirect::back()->with('success', "Contact emailed. Subject: $sub");
    }

    public function hire(Contact $contact)
    {

        $contact->hired_by = Auth::id();
        $contact->hired_on = now();
        $contact->save();
        // Send email logic
        // Mail::to($contact->email)->send(new ContactEmail($data['subject'], $data['message']));

        return Inertia::location(Redirect::back()->with(
            'success',
            "$contact->first_name $contact->last_name hired at $contact->hired_on by $contact->hired_by"
        )->getTargetUrl());
    }

    public function fire(Contact $contact)
    {

        $contact->hired_on = null;
        $contact->save();

        return Inertia::location(Redirect::back()->with('success', "$contact->first_name $contact->last_name fired.")->getTargetUrl());
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

                'photo_path' => Request::file('photo') ? Request::file('photo')->store('contacts') : null,


            ])
        );

        return Redirect::route('contacts')->with('success', 'Contact created.');
    }

    public function edit(Contact $contact): Response
    {
        return Inertia::render('Reports/Edit', [
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

                'hired_by' => $contact->hired_by,
                'hired_on' => $contact->hired_on,

                'photo' => $contact->photo_path ? URL::route('image', ['path' => $contact->photo_path, 'w' => 60, 'h' => 60, 'fit' => 'crop']) : null,

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
        // Validate the request data
        $validatedData = Request::validate([
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
            'soft_skills' => ['nullable', 'max:2000'],
            'photo' => ['nullable', 'image'],
        ]);

        // Handle photo upload if present
        if (Request::file('photo')) {
            $validatedData['photo_path'] = Request::file('photo')->store('contacts');
        }

        // Log the validated data for debugging
        \Log::info('Validated Data:', $validatedData);

        // Remove the 'photo' key to avoid trying to update it in the database
        unset($validatedData['photo']);

        // Update the contact with validated data
        $contact->update($validatedData);

        // Redirect back with success message
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
