<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;




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
