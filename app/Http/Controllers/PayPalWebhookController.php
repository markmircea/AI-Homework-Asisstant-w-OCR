<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class PayPalWebhookController extends Controller
{
    public function handleWebhook(Request $request)
    {
        Log::info('PayPal Webhook received', ['headers' => $request->headers->all(), 'body' => $request->all()]);

        if (!$this->verifyWebhookSignature($request)) {
            Log::error('Invalid PayPal webhook signature');
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $payload = $request->all();
        $eventType = $payload['event_type'];

        Log::info('Processing PayPal Webhook', ['event_type' => $eventType]);

        switch ($eventType) {
            case 'BILLING.SUBSCRIPTION.CREATED':
                $this->handleSubscriptionCreated($payload);
                break;
            case 'BILLING.SUBSCRIPTION.CANCELLED':
                $this->handleSubscriptionCancelled($payload);
                break;
            case 'BILLING.SUBSCRIPTION.EXPIRED':
                $this->handleSubscriptionExpired($payload);
                break;
            case 'PAYMENT.SALE.COMPLETED':
                $this->handlePaymentCompleted($payload);
                break;
            default:
                Log::info('Unhandled PayPal webhook event', ['event_type' => $eventType]);
                break;
        }

        return response()->json(['message' => 'Webhook handled successfully']);
    }

    private function verifyWebhookSignature(Request $request)
    {
        $webhookId = env('PAYPAL_WEBHOOK_ID');
        $apiSecret = env('PAYPAL_API_SECRET');

        $signatureVerification = openssl_verify(
            $request->header('PAYPAL-TRANSMISSION-ID') . '|' .
            $request->header('PAYPAL-TRANSMISSION-TIME') . '|' .
            $webhookId . '|' .
            crc32($request->getContent()),
            base64_decode($request->header('PAYPAL-TRANSMISSION-SIG')),
            openssl_get_publickey(file_get_contents(env('PAYPAL_CERT_URL'))),
            'sha256WithRSAEncryption'
        );

        return $signatureVerification === 1;
    }

    private function handleSubscriptionCreated($payload)
    {
        $subscriptionId = $payload['resource']['id'];
        $planId = $payload['resource']['plan_id'];
        $user = User::where('paypal_subscription_id', $subscriptionId)->first();

        if ($user) {
            $subscriptionType = $this->getSubscriptionTypeFromPlanId($planId);
            $user->subscription_type = $subscriptionType;
            $user->save();

            Log::info('User subscription created', ['user_id' => $user->id, 'subscription_type' => $subscriptionType]);
        } else {
            Log::warning('Subscription created for unknown user', ['subscription_id' => $subscriptionId]);
        }
    }

    private function handleSubscriptionCancelled($payload)
    {
        $subscriptionId = $payload['resource']['id'];
        $user = User::where('paypal_subscription_id', $subscriptionId)->first();

        if ($user) {
            $user->subscription_type = User::SUBSCRIPTION_FREE;
            $user->paypal_subscription_id = null;
            $user->save();

            Log::info('User subscription cancelled', ['user_id' => $user->id]);
        } else {
            Log::warning('Subscription cancelled for unknown user', ['subscription_id' => $subscriptionId]);
        }
    }

    private function handleSubscriptionExpired($payload)
    {
        $this->handleSubscriptionCancelled($payload);
    }

    private function handlePaymentCompleted($payload)
    {
        $subscriptionId = $payload['resource']['billing_agreement_id'];
        $user = User::where('paypal_subscription_id', $subscriptionId)->first();

        if ($user) {
            Log::info('Payment completed for user', ['user_id' => $user->id, 'amount' => $payload['resource']['amount']['total']]);
            // You might want to update a payments table or user's paid_through date here
        } else {
            Log::warning('Payment completed for unknown user', ['subscription_id' => $subscriptionId]);
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
                Log::warning('Unknown plan ID', ['plan_id' => $planId]);
                return User::SUBSCRIPTION_FREE;
        }
    }
}
