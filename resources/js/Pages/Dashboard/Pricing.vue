<template>
  <div class="bg-gray-100 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="lg:text-center">
        <h2 class="text-base text-indigo-600 font-semibold tracking-wide uppercase">Pricing</h2>
        <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
          Choose the perfect plan for you
        </p>
        <p class="mt-4 max-w-2xl text-xl text-gray-500 lg:mx-auto">
          Get access to our AI-powered homework assistance at a price that fits your needs.
        </p>
      </div>

      <!-- Pricing Toggle -->
      <div class="flex justify-center items-center space-x-4 mt-8">
        <span class="text-gray-700 font-medium">Monthly</span>
        <label class="relative inline-flex items-center cursor-pointer">
          <input type="checkbox" v-model="isAnnual" class="sr-only peer">
          <div class="w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-indigo-600"></div>
        </label>
        <span class="text-gray-700 font-medium">Yearly <span class="text-green-600 text-sm">(Save 25%)</span></span>
      </div>

      <div class="mt-10">
        <div class="space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
          <!-- Free Plan -->
          <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Free</h3>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-extrabold tracking-tight">$0</span>
                <span class="ml-1 text-xl font-semibold">/month</span>
              </p>
              <p class="mt-6 text-gray-500">Get started with AI homework assistance</p>

              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>3</strong> questions daily</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>5</strong> subjects</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500">Standard AI models ( GPT-4o / Gemeni )</span>
                </li>
              </ul>
            </div>

            <a href="#"
              class="bg-indigo-50 text-indigo-700 hover:bg-indigo-100 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">Get
              Started</a>
          </div>

          <!-- Pro Plan -->
          <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Pro</h3>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-extrabold tracking-tight">${{ isAnnual ? '5.99' : '7.99' }}</span>
                <span class="ml-1 text-xl font-semibold">/month</span>
              </p>
              <p v-if="isAnnual" class="mt-2 text-sm text-green-600">Billed annually at $71.88/year</p>
              <p class="mt-6 text-gray-500">Complete homework solution</p>

              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>50</strong> questions daily</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>UNLIMITED</strong> subjects</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500">Advanced AI models ( GPT-4 / Claude 3.5 / Llama 3.1 )</span>
                </li>
              </ul>
            </div>

            <div class="mt-8">
              <div v-if="isAnnual" id="paypal-button-container-P-49H18172SJ932691BM25CJPY"></div>
              <div v-else id="paypal-button-container-P-27C40840MP185570GM25ATXY"></div>
            </div>
          </div>

          <!-- Premium Plan -->
          <div class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
            <div class="absolute top-0 right-0 p-2 bg-indigo-500 text-white text-xs font-bold rounded-bl-lg rounded-tr-xl">
              BEST VALUE
            </div>
            <div class="flex-1">
              <h3 class="text-xl font-semibold text-gray-900">Premium</h3>
              <p class="mt-4 flex items-baseline text-gray-900">
                <span class="text-5xl font-extrabold tracking-tight">${{ isAnnual ? '7.99' : '9.99' }}</span>
                <span class="ml-1 text-xl font-semibold">/month</span>
              </p>
              <p v-if="isAnnual" class="mt-2 text-sm text-green-600">Billed annually at $95.88/year</p>
              <p class="mt-6 text-gray-500">Complete homework and test hacking solution</p>

              <ul role="list" class="mt-6 space-y-6">
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>UNLIMITED</strong> questions daily</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>UNLIMITED</strong> subjects</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500">Advanced AI models ( GPT-4 / Claude 3.5 / Llama 3.1 )</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500">Test Hacking</span>
                </li>
                <li class="flex">
                  <svg class="flex-shrink-0 w-6 h-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                  </svg>
                  <span class="ml-3 text-gray-500"><strong>+ EXTRAS</strong></span>
                </li>
              </ul>
            </div>

            <div class="mt-8">
              <div v-if="isAnnual" id="paypal-button-container-P-90V19407PM991921WM25CKIY"></div>
              <div v-else id="paypal-button-container-P-7PP87202865174126M25AWTA"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import { router } from '@inertiajs/vue3'

export default {
  name: 'Pricing',
  data() {
    return {
      isAnnual: false,
      loading: false,
      error: null
    }
  },
  mounted() {
    this.loadPayPalScript();
    this.setupInertiaEvents();

  },
  methods: {
    loadPayPalScript() {
      const script = document.createElement('script');
      script.src = "https://www.paypal.com/sdk/js?client-id=AT1AN3A-SZTy0CoeQzjZO-LMKVYZju4ABAIXr62BrXZ99Xt3bqkbuhXlTA5gj_sM1vskMxjKngLpqcyK&vault=true&intent=subscription";
      script.setAttribute('data-sdk-integration-source', 'button-factory');

      script.onload = () => {
        this.renderPayPalButtons();
      };

      document.body.appendChild(script);
    },
    setupInertiaEvents() {
      router.on('success', (event) => {
        this.loading = false;
        if (event.detail.page.props.flash && event.detail.page.props.flash.success) {
          alert(event.detail.page.props.flash.success);
        }
      });
      router.on('error', (event) => {
        this.loading = false;
        this.error = 'There was an error processing your subscription. Please contact support.';
        console.error('Error updating subscription:', event);
      });
    },
    renderPayPalButtons() {
      // Clear existing buttons
      ['P-27C40840MP185570GM25ATXY', 'P-49H18172SJ932691BM25CJPY', 'P-7PP87202865174126M25AWTA', 'P-90V19407PM991921WM25CKIY'].forEach(id => {
        const container = document.getElementById(`paypal-button-container-${id}`);
        if (container) container.innerHTML = '';
      });

      // Render appropriate buttons based on isAnnual
      if (this.isAnnual) {
        this.renderButton('P-49H18172SJ932691BM25CJPY', 'Yearly Pro Plan');
        this.renderButton('P-90V19407PM991921WM25CKIY', 'Yearly Premium Plan');
      } else {
        this.renderButton('P-27C40840MP185570GM25ATXY', 'Monthly Pro Plan');
        this.renderButton('P-7PP87202865174126M25AWTA', 'Monthly Premium Plan');
      }
    },
    renderButton(planId, planName) {
      paypal.Buttons({
        style: {
          shape: 'rect',
          color: 'blue',
          layout: 'vertical',
          label: 'subscribe'
        },
        createSubscription: function(data, actions) {
          return actions.subscription.create({
            plan_id: planId
          });
        },
        onApprove: (data, actions) => {
          this.loading = true;
          this.error = null;
          console.log('PayPal subscription approved:', data);

          router.post('/api/update-subscription', {
            subscriptionId: data.subscriptionID,
            planId: planId
          }, {
            preserveState: true,
            preserveScroll: true,
          });
        },
        onError: (err) => {
          this.error = 'There was an error with PayPal. Please try again or contact support.';
          console.error('PayPal error:', err);
        }
      }).render(`#paypal-button-container-${planId}`);
    }
  },
  watch: {
    isAnnual() {
      this.$nextTick(() => {
        this.renderPayPalButtons();
      });
    }
  }
}
</script>
