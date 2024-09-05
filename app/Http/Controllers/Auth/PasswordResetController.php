<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Log;


use Illuminate\Support\Str;
use Inertia\Inertia;

class PasswordResetController extends Controller
{
    /**
     * Display the password request form.
     */
    public function showLinkRequestForm()
    {
        return Inertia::render('Auth/ForgotPassword');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return redirect()->route('indexNoAuth')->with('success', 'A password reset link has been sent to your email address.');
        }

        return back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the password reset view.
     */
    public function showResetForm(Request $request)
    {
        return Inertia::render('Auth/ResetPasswordPage', [
            'email' => $request->email,
            'token' => $request->route('token'),
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __($status));
        }

        return back()->withErrors(['email' => [__($status)]]);
    }


     public function sendVerificationNotification(Request $request)
    {
        $user = $request->user();
        $key = 'verification-notification:' . $user->id;


        if (RateLimiter::tooManyAttempts($key, 3)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "Too many verification attempts. Please try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key);

        $user->sendEmailVerificationNotification();

        $attemptsLeft = 3 - RateLimiter::attempts($key);

        $message = 'Verification link sent!';
        if ($attemptsLeft > 0) {
            $message .= " You have {$attemptsLeft} attempt(s) remaining today.";
        } else {
            $message .= " This was your last attempt for today.";
        }

        return back()->with('message', $message);
    }
}
