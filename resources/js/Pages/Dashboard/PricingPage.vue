<template>
  <div class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen text-white font-sans">
    <Nav v-if="user" :user="user" />
    <PublicNav v-else />

    <Head title="Pricing" />

    <section class="pt-20 pb-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h1
            class="text-5xl font-extrabold sm:text-6xl md:text-7xl bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-blue-500">
            Choose Your Plan
          </h1>
          <p class="mt-6 text-xl text-gray-300 max-w-2xl mx-auto">
            Unlock the power of Multi-model AI-assisted learning with our flexible pricing options.
          </p>
        </div>

        <!-- Pricing Toggle -->
        <div class="flex justify-center items-center space-x-4 mb-8">
          <span class="text-gray-300 font-medium">Monthly</span>
          <label class="relative inline-flex items-center cursor-pointer">
            <input type="checkbox" v-model="isAnnual" class="sr-only peer">
            <div
              class="w-14 h-7 bg-gray-600 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:left-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-blue-600">
            </div>
          </label>
          <span class="text-gray-300 font-medium">Yearly <span class="text-green-400 text-sm">(Save 25%)</span></span>
        </div>

        <div
          class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-3 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none">
          <!-- Free Plan -->
          <div
            class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden flex flex-col transform transition-all duration-300 hover:scale-105">
            <div class="px-6 py-8 flex-grow">
              <h3 class="text-2xl font-semibold text-teal-400">Free Plan</h3>
              <p class="mt-4 text-gray-400">Get started with AI homework assistance</p>
              <p class="mt-8">
                <span class="text-5xl font-extrabold text-white">Free</span>
                <span class="text-base font-medium text-gray-400">/ forever</span>
              </p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>3</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>5</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-teal-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300">Standard AI models ( GPT-4o / Gemeni )</span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-700 mt-auto">
              <a href="#"
                class="block w-full bg-gradient-to-r from-teal-400 to-blue-500 text-center rounded-md py-3 font-medium text-white hover:from-teal-500 hover:to-blue-600 transition-all duration-300 transform hover:-translate-y-1">Get
                Started</a>
            </div>
          </div>

          <!-- Pro Plan -->
          <div
            class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden flex flex-col transform transition-all duration-300 hover:scale-105">
            <div class="px-6 py-8 flex-grow">
              <h3 class="text-2xl font-semibold text-blue-400">Pro</h3>
              <p class="mt-4 text-gray-400">Complete homework solution</p>
              <p class="mt-8">
                <span class="text-5xl font-extrabold text-white">${{ isAnnual ? '5.99' : '7.99' }}</span>
                <span class="text-base font-medium text-gray-400">/ {{ isAnnual ? 'month' : 'month' }}</span>
              </p>
              <p v-if="isAnnual" class="mt-2 text-sm text-green-400">Billed annually at $71.88/year</p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>50</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>Unlimited</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300">Advanced AI models ( GPT-4 / Claude 3.5 / Llama 3.1 )</span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-700 mt-auto">
              <div v-if="isAnnual" id="paypal-button-container-P-49H18172SJ932691BM25CJPY"></div>
              <div v-else id="paypal-button-container-P-27C40840MP185570GM25ATXY"></div>
            </div>
          </div>

          <!-- Premium Plan -->
          <div
            class="bg-gray-800 rounded-2xl shadow-xl overflow-hidden flex flex-col transform transition-all duration-300 hover:scale-105">
            <div class="px-6 py-8 flex-grow relative">
              <span
                class="absolute top-0 right-0 bg-gradient-to-r from-pink-500 to-purple-500 text-white text-xs font-bold py-1 px-3 rounded-bl-lg">BEST
                VALUE</span>
              <h3 class="text-2xl font-semibold text-purple-400">Premium</h3>
              <p class="mt-4 text-gray-400">Complete homework and test hacking solution</p>
              <p class="mt-8">
                <span class="text-5xl font-extrabold text-white">${{ isAnnual ? '7.99' : '9.99' }}</span>
                <span class="text-base font-medium text-gray-400">/ {{ isAnnual ? 'month' : 'month' }}</span>
              </p>
              <p v-if="isAnnual" class="mt-2 text-sm text-green-400">Billed annually at $95.88/year</p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>Unlimited</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>Unlimited</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300">Advanced AI models ( GPT-4 / Claude 3.5 / Llama 3.1 )</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300">Test Hacking</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-purple-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-300"><strong>+ EXTRAS</strong></span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-700 mt-auto">
              <div v-if="isAnnual" id="paypal-button-container-P-90V19407PM991921WM25CKIY"></div>
              <div v-else id="paypal-button-container-P-7PP87202865174126M25AWTA"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Feature Comparison Table -->
    <!-- Compare Plans Section -->
    <!-- Compare Plans Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-4xl font-extrabold sm:text-5xl bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-blue-500">
            Compare Plans
          </h2>
          <p class="mt-4 text-xl text-gray-300 max-w-2xl mx-auto">
            Find the perfect plan for your study needs
          </p>
        </div>
        <div class="overflow-x-auto">
          <table class="w-full bg-gray-800 rounded-lg overflow-hidden shadow-xl">
            <thead class="bg-gray-700">
              <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Compare Plans
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Free Plan
                </th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Homework
                  Helper</th>
                <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Homework
                  Helper + Test Hacker</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-700">
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Included Questions</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">3 / day</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">50 / day</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                </td>

              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Included Subjects</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">5</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <span
                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                </td>
              </tr>

              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">24/7 access</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>

              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Remove Ads</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>

              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Online Support</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>

              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Searchable History</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>

              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Advanced AI Models<br> <br>
                  MythoMax 13B | Anthropic: Claude 3.5 Sonnet | OpenAI: GPT-4 | Meta: Llama 3.1 70B Instruct |
                  WizardLM-2 8x22B <br> Mistral: Mistral 7B Instruct | Google: Gemma 2 9B</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Detailed step-by-step
                  explanations</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Priority processing</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>
              <tr>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-300">Test Hacker</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                  </svg>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-400">
                  <svg class="w-5 h-5 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                  </svg>
                </td>
              </tr>

            </tbody>
          </table>
        </div>
      </div>
    </section>


    <!-- FAQ Section -->
    <!-- FAQ Section -->
    <!-- FAQ Section -->
    <section class="py-20 px-4 sm:px-6 lg:px-8 bg-gray-900">
      <div class="max-w-3xl mx-auto">
        <div class="text-center mb-16">
          <h2
            class="text-4xl font-extrabold sm:text-5xl bg-clip-text text-transparent bg-gradient-to-r from-teal-400 to-blue-500">
            Frequently Asked Questions
          </h2>
          <p class="mt-4 text-xl text-gray-300">
            Got questions? We've got answers.
          </p>
        </div>
        <div class="space-y-8">
          <div v-for="(faq, index) in faqs" :key="index" class="bg-gray-800 rounded-lg shadow-md overflow-hidden">
            <button @click="faq.isOpen = !faq.isOpen"
              class="flex justify-between items-center w-full px-6 py-4 text-left focus:outline-none">
              <span class="text-lg font-semibold text-gray-100">{{ faq.question }}</span>
              <svg class="w-5 h-5 text-gray-400 transform transition-transform duration-200"
                :class="{ 'rotate-180': faq.isOpen }" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div v-show="faq.isOpen" class="px-6 pb-4 text-gray-300">
              <p class="text-base">{{ faq.answer }}</p>
            </div>
          </div>
        </div>
      </div>
    </section>



    <div id="contact-us"><contact-us /></div>

    <Footer />


  </div>
</template>
<script>
import { Head } from '@inertiajs/vue3'

import ContactUs from './ContactUs.vue';
import Footer from './Footer.vue';
import Nav from './Nav.vue';
import PublicNav from './PublicNav.vue';


export default {
  components: {
    ContactUs,
    Footer,
    Nav,
    PublicNav,
    Head
  },
  props: {
    user: {
      type: Object,
      required: false,
      default: null
    },
  },
  mounted() {
    if (window.location.hash === '#contact-us') {
      this.$nextTick(() => {
        const contactUsElement = document.getElementById('contact-us');
        if (contactUsElement) {
          contactUsElement.scrollIntoView({ behavior: 'smooth' });
        }
      });
    }
    this.loadPayPalScript();
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
          shape: 'pill',
          color: 'blue',
          layout: 'vertical',
          label: 'paypal'
        },
        createSubscription: function (data, actions) {
          return actions.subscription.create({
            plan_id: planId
          });
        },
        onApprove: function (data, actions) {
          return this.updateSubscription(data.subscriptionID, planId)
            .then(() => {
              alert(`You have successfully subscribed to the ${planName}! Subscription ID: ${data.subscriptionID}`);
            })
            .catch((error) => {
              console.error('Error updating subscription:', error);
              alert('There was an error processing your subscription. Please contact support.');
            });
        }
      }).render(`#paypal-button-container-${planId}`);
    },
    updateSubscription(subscriptionId, planId) {
      // Make an API call to your backend
      return fetch('/api/update-subscription', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ subscriptionId, planId })
      }).then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      });
    }

  },
  watch: {
    isAnnual() {
      this.$nextTick(() => {
        this.renderPayPalButtons();
      });
    }
  },


  data() {
    return {
      isAnnual: false,
      faqs: [
        {
          question: "Do you provide customer support?",
          answer: "Yes, we provide customer support for users on any of our two paid plans. You can contact us through our contact form.",
          isOpen: false
        },
        {
          question: "Do you offer a free trial?",
          answer: "Yes, we offer a 14-day free trial of our premium plans. You can cancel anytime during your trial for a full refund.",
          isOpen: false
        },
        {
          question: "Is there a money-back guarantee?",
          answer: "Yes, you can cancel anytime during your trial for a full refund. After the trial period, all sales are final.",
          isOpen: false
        }
      ]
    }
  }
}
</script>
<style scoped>
.dot {
  transition: all 0.3s ease-in-out;
}

input:checked~.dot {
  transform: translateX(100%);
  background-color: #4f46e5;
}

/* Add these styles for the table */
.table-responsive-xl {
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

@media (max-width: 1199.98px) {
  .table-responsive-xl {
    display: block;
    width: 100%;
  }
}
</style>
