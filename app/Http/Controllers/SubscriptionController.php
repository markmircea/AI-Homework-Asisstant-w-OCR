<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\CancelSubscription;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;


class SubscriptionController extends Controller
{
    public function updateSubscription(Request $request)
    {
        if (!Auth::check()) {
            // User is not authenticated
            return redirect()->route('public.ask')->with('error', 'You subscribed without first registering an account. Please register and then contact support: support@easyace.ai ');
        }
        try {
            $request->validate([
                'subscriptionId' => 'required|string',
                'planId' => 'required|string',
            ]);

            $user = Auth::user();
            $subscriptionType = $this->getSubscriptionTypeFromPlanId($request->planId);


            if ($subscriptionType) {
                $user->subscription_type = $subscriptionType;
                $user->paypal_subscription_id = $request->subscriptionId;
                $user->save();

                return redirect()->route('ask')->with('success', "Upgrade Completed Successfully!");

            }

            return redirect()->route('ask')->with('error', "Invalid Plan ID");


        } catch (\Exception $e) {

            return redirect()->route('ask')->with('error', $e);

        }
    }

    public function cancelSubscription(Request $request)
    {
        $user = Auth::user();
        $key = 'cancel_subscription_' . $request->ip();
        $maxAttempts = 2; // Maximum 3 attempts
        $decaySeconds = 86400; // Per hour

        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', "You have already submitted a request to cancel today... Too many attempts. Please try again in {$seconds} seconds.");
        }

        RateLimiter::hit($key, $decaySeconds);

        // Send email to support
        Notification::route('mail', 'support@easyace.ai')
            ->notify(new CancelSubscription([
                'firstName' => $user->first_name,
                'lastName' => $user->last_name,
                'email' => $user->email,
                'message' => 'User has requested to cancel their subscription.',
            ]));

        // Update user's subscription type to Free at the end of the billing period
        // Note: You may need to implement a job or event to handle this if you want to delay the change

       // $user->subscription_type = User::SUBSCRIPTION_FREE;
      //  $user->save();

        return redirect()->back()->with('success', 'Your subscription type will revert to Free at the end of your current billing period. Thank you!');
    }

    private function getSubscriptionTypeFromPlanId($planId)
    {
        switch ($planId) {
            case 'P-27C40840MP185570GM25ATXY':
            case 'P-49H18172SJ932691BM25CJPY':
                return User::SUBSCRIPTION_PRO;
            case 'P-7PP87202865174126M25AWTA':
            case 'P-90V19407PM991921WM25CKIY':
                return User::SUBSCRIPTION_PREMIUM;
            default:
                return null;
        }
    }
}
