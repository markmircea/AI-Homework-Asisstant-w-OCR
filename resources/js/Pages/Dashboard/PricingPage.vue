<template>



  <div class="bg-gradient-to-r from-indigo-900 to-indigo-600 min-h-screen text-white">
    <Nav :user="user" />
    <section class="pt-20 pb-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center">
          <h1 class="text-4xl font-extrabold sm:text-5xl md:text-6xl">
            Plans That Fit Your
            <span class="relative">
              Needs
              <span
                class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-[-1] hidden sm:block">
                <svg width="204" height="54" viewBox="0 0 204 54" class="text-indigo-400 opacity-50">
                  <path
                    d="M126.49,49.51c19.28,0.32,33.97,0.06,48.55-2.07c5.25-0.77,10.43-2.14,15.54-3.6c2.26-0.64,4.43-1.95,6.35-3.36 c3.16-2.32,3.37-4.88,0.61-7.62c-1.84-1.82-3.96-3.42-6.16-4.8c-5.74-3.6-12.04-6.02-18.4-8.28c-15.69-5.58-31.86-9.17-48.29-11.7 c-18.65-2.87-37.4-4.07-56.26-3.51C54.54,5,40.71,6.16,26.99,8.39C19.25,9.65,11.5,10.9,3.76,12.15c-0.1,0.02-0.2,0.04-0.3,0.05 c-2.03,0.27-3.23-0.26-3.44-1.51c-0.2-1.22,0.72-2.05,2.84-2.45c13.24-2.51,26.48-5.11,39.9-6.43c14.43-1.42,28.9-2.13,43.42-1.67 c24.63,0.78,48.89,4.14,72.7,10.58c9.42,2.55,18.73,5.54,27.54,9.77c4.06,1.95,7.9,4.39,11.66,6.88c1.63,1.08,3.02,2.69,4.15,4.32 c2.53,3.63,2.27,7.63-0.89,10.71c-1.84,1.79-4.08,3.29-6.38,4.45c-5.44,2.75-11.4,3.91-17.38,4.77c-19.2,2.75-38.5,2.96-57.84,1.98 c-7.84-0.4-15.68-0.74-23.5-1.34c-10.13-0.77-20.26-1.58-30.36-2.72c-9.49-1.07-18.96-2.38-28.37-4.01 C32.2,44.6,26.97,43,21.81,41.34c-2.44-0.78-4.81-2.13-6.86-3.69c-4.56-3.49-4.8-8.3-0.9-12.54c2.3-2.5,5.23-4.07,8.3-5.36 c6.9-2.91,14.13-4.64,21.46-5.97c10.14-1.84,20.37-2.47,30.66-1.92c2.57,0.14,3.72,0.84,3.6,2.22c-0.11,1.26-1.19,1.84-3.6,1.92 c-6.13,0.21-12.28,0.2-18.4,0.67c-10.47,0.82-20.72,2.87-30.56,6.62c-2.23,0.85-4.45,1.95-6.4,3.31c-4.53,3.16-4.36,6.27,0.46,8.87 c2.28,1.23,4.75,2.19,7.24,2.97c7.8,2.44,15.84,3.88,23.93,4.79c15.4,1.73,30.8,3.38,46.24,4.67 C108.32,48.84,119.7,49.15,126.49,49.51z"
                    fill="currentColor" />
                </svg>
              </span>
            </span>
          </h1>
          <p class="mt-3 text-xl text-indigo-100">Simple, transparent pricing for AI-powered homework assistance.</p>
          <div class="mt-4">
            <span
              class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
              Save $24 with an annual plan!
            </span>
          </div>
        </div>

        <div class="mt-8 flex justify-center">
          <div class="relative">
            <label for="pricing-toggle" class="flex items-center cursor-pointer">
              <span class="mr-3 text-sm font-medium">Monthly</span>
              <div class="relative">
                <input type="checkbox" id="pricing-toggle" class="sr-only" v-model="isAnnual">
                <div class="w-14 h-6 bg-gray-200 rounded-full shadow-inner"></div>
                <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 -top-1 transition"></div>
              </div>
              <span class="ml-3 text-sm font-medium">Yearly</span>
            </label>
          </div>
        </div>

        <div
          class="mt-12 space-y-4 sm:mt-16 sm:space-y-0 sm:grid sm:grid-cols-2 sm:gap-6 lg:max-w-4xl lg:mx-auto xl:max-w-none xl:grid-cols-3">
          <!-- Basic Plan -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
              <h3 class="text-2xl font-semibold text-gray-900">Basic Plan</h3>
              <p class="mt-4 text-gray-500">Get started with AI homework assistance</p>
              <p class="mt-8">
                <span class="text-4xl font-extrabold text-gray-900">Free</span>
                <span class="text-base font-medium text-gray-500">/ forever</span>
              </p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>3</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>5</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600">Standard AI model</span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-50">
              <a href="#"
                class="block w-full bg-indigo-600 text-center rounded-md py-3 font-medium text-white hover:bg-indigo-700">Get
                Started</a>
            </div>
          </div>

          <!-- Homework Helper + Essay -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
              <h3 class="text-2xl font-semibold text-gray-900">Homework Helper + Test Helper</h3>
              <p class="mt-4 text-gray-500">Complete homework and "practice" for any test!</p>
              <p class="mt-8">
                <span class="text-4xl font-extrabold text-gray-900">${{ isAnnual ? '8' : '10' }}</span>
                <span class="text-base font-medium text-gray-500">/ {{ isAnnual ? 'month' : 'month' }}</span>
              </p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>Unlimited</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>Unlimited</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600">Advanced AI model</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600">Essay writing assistance</span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-50">
              <a href="#"
                class="block w-full bg-indigo-600 text-center rounded-md py-3 font-medium text-white hover:bg-indigo-700">Try
                free for 14 days</a>
            </div>
          </div>


          <!-- Homework Helper + Essay -->
          <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="px-6 py-8">
              <h3 class="text-2xl font-semibold text-gray-900">Homework Helper + Essay</h3>
              <p class="mt-4 text-gray-500">Complete homework and essay writing solution</p>
              <p class="mt-8">
                <span class="text-4xl font-extrabold text-gray-900">${{ isAnnual ? '8' : '10' }}</span>
                <span class="text-base font-medium text-gray-500">/ {{ isAnnual ? 'month' : 'month' }}</span>
              </p>
              <ul class="mt-8 space-y-4">
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>Unlimited</strong> questions daily</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600"><strong>Unlimited</strong> subjects</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600">Advanced AI model</span>
                </li>
                <li class="flex items-center">
                  <svg class="w-5 h-5 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                      d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                      clip-rule="evenodd" />
                  </svg>
                  <span class="ml-2 text-gray-600">Essay writing assistance</span>
                </li>
              </ul>
            </div>
            <div class="px-6 py-8 bg-gray-50">
              <a href="#"
                class="block w-full bg-indigo-600 text-center rounded-md py-3 font-medium text-white hover:bg-indigo-700">Try
                free for 14 days</a>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Feature Comparison Table -->

    <!-- Feature Comparison Table -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-8">
          <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Compare Plans</h2>
          <p class="mt-3 max-w-2xl mx-auto text-xl text-indigo-200 sm:mt-4">
            Find the perfect plan for your study needs
          </p>
        </div>
        <div class="col-12">
          <div class="table-responsive-xl">
            <table class="w-full bg-white rounded-lg overflow-hidden">
              <thead class="bg-gray-100">
                <tr>
                  <th scope="col" class="px-6 py-3 text-left w-1/4">
                    <p class="text-lg font-semibold text-gray-900">Compare Plans</p>
                  </th>
                  <th scope="col" class="px-6 py-3 text-center w-1/4">
                    <div class="bg-transparent">
                      <h3 class="text-base font-medium text-gray-900">Free Plan</h3>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-center w-1/4">
                    <div class="bg-transparent">
                      <h3 class="text-base font-medium text-gray-900">Homework Helper</h3>
                    </div>
                  </th>
                  <th scope="col" class="px-6 py-3 text-center w-1/4">
                    <div class="bg-transparent">
                      <h3 class="text-base font-medium text-gray-900">Homework Helper + Essay</h3>
                    </div>
                  </th>
                </tr>
              </thead>
              <tbody class="divide-y divide-gray-200">
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Included Questions</span>
                  </th>
                  <td class="px-6 py-4 text-sm text-gray-500 text-center">3 / day</td>
                  <td class="px-6 py-4 text-sm text-gray-500 text-center">50 / day</td>
                  <td class="px-6 py-4 text-center">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                  </td>
                </tr>
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Included Subjects</span>
                  </th>
                  <td class="px-6 py-4 text-sm text-gray-500 text-center">5</td>
                  <td class="px-6 py-4 text-center">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <span
                      class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Unlimited</span>
                  </td>
                </tr>
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Remove Ads</span>
                  </th>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                </tr>
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Online Support</span>
                  </th>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                </tr>
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Essay Writer</span>
                  </th>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                </tr>
                <tr>
                  <th scope="row" class="px-6 py-4 text-sm font-medium text-gray-900 text-left">
                    <span class="text-base">Advanced AI Model</span>
                  </th>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-red-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                      </path>
                    </svg>
                  </td>
                  <td class="px-6 py-4 text-center">
                    <svg class="w-6 h-6 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                      xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </section>



    <!-- FAQ Section -->
    <!-- FAQ Section -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-3xl font-extrabold text-white sm:text-4xl">Frequently Asked Questions</h2>
          <p class="mt-3 max-w-2xl mx-auto text-xl text-indigo-200 sm:mt-4">
            Got questions? We've got answers.
          </p>
        </div>
        <div class="mt-12 max-w-3xl mx-auto">
          <dl class="space-y-6">
            <div v-for="(faq, index) in faqs" :key="index" class="bg-white rounded-xl shadow-md overflow-hidden">
              <dt>
                <button @click="faq.isOpen = !faq.isOpen"
                  class="flex justify-between w-full px-6 py-4 text-left focus:outline-none">
                  <span class="text-lg font-semibold text-gray-900">{{ faq.question }}</span>
                  <span class="ml-6 flex-shrink-0">
                    <svg class="h-6 w-6 text-indigo-500 transition-transform duration-200"
                      :class="{ 'transform rotate-180': faq.isOpen }" fill="none" viewBox="0 0 24 24"
                      stroke="currentColor">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                  </span>
                </button>
              </dt>
              <dd v-show="faq.isOpen" class="px-6 pb-4">
                <p class="text-base text-gray-600">{{ faq.answer }}</p>
              </dd>
            </div>
          </dl>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-indigo-800 rounded-lg shadow-xl overflow-hidden">
          <div class="px-6 py-12 sm:px-12 lg:py-16 lg:pr-0 xl:py-20 xl:px-20">
            <div class="lg:self-center">
              <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
                <span class="block">Ready to boost your grades?</span>
                <span class="block">Start your free trial today.</span>
              </h2>
              <p class="mt-4 text-lg leading-6 text-indigo-200">Sign up for our 14-day free trial and experience the
                power of AI-assisted learning.</p>
              <a href="#"
                class="mt-8 bg-white border border-transparent rounded-md shadow px-6 py-3 inline-flex items-center text-base font-medium text-indigo-600 hover:bg-indigo-50">
                Start free trial
              </a>
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

export default {
  components: {
    ContactUs,
    Footer,
    Nav,
    Head
  },
  props: {
    user: Object,
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
