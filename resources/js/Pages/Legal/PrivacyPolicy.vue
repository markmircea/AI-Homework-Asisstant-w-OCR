<template>
  <div class="flex flex-col min-h-screen">
    <PublicNav />

    <main class="flex-grow bg-indigo-100">
      <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
          <div class="px-4 py-5 sm:px-6">
            <h1 class="text-3xl font-extrabold text-gray-900">Privacy Policy</h1>
            <p class="mt-1 max-w-2xl text-sm text-gray-500">Last updated: {{ new Date().toLocaleDateString() }}</p>
          </div>
          <div class="border-t border-gray-200 px-4 py-5 sm:p-0">
            <dl class="sm:divide-y sm:divide-gray-200">
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">1. Information We Collect</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  We collect information you provide directly to us, such as when you create an account, submit questions, or make a payment. This may include name, contact information, account credentials, payment information, and homework submissions.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">2. How We Use Your Information</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  We use your information to provide and improve our services, process payments, manage subscriptions, communicate with you about your account, and analyze usage patterns to enhance user experience.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">3. Data Security</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  We implement appropriate technical and organizational measures to protect your personal information against unauthorized or unlawful processing, accidental loss, destruction, or damage.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">4. Third-Party Services</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  We use PayPal for payment processing. Please review PayPal's privacy policy for information on how they handle your payment data.
                </dd>
              </div>
              <div class="py-4 sm:py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                <dt class="text-sm font-medium text-gray-500">5. Your Rights</dt>
                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                  You have the right to access, correct, or delete your personal information. Please contact us if you wish to exercise these rights.
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
