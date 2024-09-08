<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Notifications\RegistrationConfirmation;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;




class AuthenticatedSessionController extends Controller
{

    public function createRegistration(): \Inertia\Response
    {
        return Inertia::render('Auth/Register');
    }

    public function storeRegistration(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
    /**
     * Display the login view.
     */
    public function create(): \Inertia\Response
    {
        return Inertia::render('Auth/Login');
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended('/'); // Redirect to home after regular login
    }

    /**
     * Redirect the user to the Google authentication page.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            Log::info('Google user data:', ['user' => $googleUser]);

            $user = User::where('email', $googleUser->email)->first();

            if ($user) {
                // User exists, update google_id and photo if not set
                if (!$user->google_id) {
                    $user->google_id = $googleUser->id;
                }
                if(!$user->email_verified_at){
                    $user->email_verified_at = now();
                }
                if(!$user->photo_path){
                    $user->photo_path = $googleUser->avatar;
                }

                $user->save();

            } else {
                // Create new user
                $name_parts = explode(' ', $googleUser->name, 2);
                $user = User::create([
                    'first_name' => $name_parts[0],
                    'last_name' => isset($name_parts[1]) ? $name_parts[1] : '',
                    'email' => $googleUser->email,
                    'google_id' => $googleUser->id,
                    'password' => Hash::make(Str::random(24)),
                    'subscription_type' => User::SUBSCRIPTION_FREE,
                    'email_verified_at' => now(),
                    'photo_path' => $googleUser->avatar,

                ]);



                event(new Registered($user));
            }



            Auth::login($user);
            return redirect()->route('dashboard')->with('success', 'Logged In.');

        } catch (\Exception $e) {
            Log::error('Google authentication failed:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect('login')->with('error', 'Google authentication failed. Please try again.');
        }

    }



    public function showForgotPasswordForm(): \Inertia\Response
    {
        return Inertia::render('Auth/ForgotPassword');
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
