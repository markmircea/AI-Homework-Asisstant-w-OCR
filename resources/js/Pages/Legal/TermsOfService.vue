<template>
  <div class="flex flex-col min-h-screen">
    <PublicNav v-if="!$page.props.auth.user" />

    <main class="flex-grow bg-indigo-100">
      <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Terms of Service</h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Last updated: {{ new Date().toLocaleDateString() }}</p>
          </div>
          <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">1. Acceptance of Terms</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  By accessing or using our service, you agree to be bound by these Terms of Service and all applicable laws and regulations.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">2. Description of Service</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  Our service is a homework helper application that provides assistance with academic questions and problems. We offer both free and paid subscription tiers.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">3. User Accounts</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  You must create an account to use certain features of our service. You are responsible for maintaining the confidentiality of your account information and for all activities that occur under your account.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">4. Subscription and Payments</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  We offer paid subscription tiers processed through PayPal. By subscribing, you agree to pay the fees associated with your chosen tier. Subscriptions will automatically renew unless cancelled.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">5. Acceptable Use</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  You agree not to use our service for any unlawful purpose or in any way that interrupts, damages, or impairs the service. This includes not submitting any content that infringes on intellectual property rights or violates academic integrity policies.
                </dd>
              </div>
            </dl>
          </div>
        </div>
      </div>
    </main>

    <Footer />
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3';
import PublicNav from '@/Pages/Dashboard/PublicNav.vue';
import Nav from '@/Pages/Dashboard/Nav.vue';
import Footer from '@/Pages/Dashboard/Footer.vue';

export default {
  components: {
    Head,
    PublicNav,
    Nav,
    Footer,
  },
};
</script>
