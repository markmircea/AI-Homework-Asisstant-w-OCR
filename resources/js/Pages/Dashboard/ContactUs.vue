<template>
  <section id="contact" class="bg-gray-100 py-16 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <div class="text-center">
        <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
          Contact Us
        </h2>
        <p class="mt-4 text-xl text-gray-600">
          Have questions? We're here to help!
        </p>
      </div>

      <!-- Flex container for image and contact form -->
      <div class="mt-16 flex flex-col sm:flex-row gap-10">
        <!-- SVG Image -->
        <div class="flex-1">
          <img src="../../../images/compare.svg" alt="My Icon" class="w-full h-auto" />
        </div>

        <!-- Contact Form -->
        <div class="flex-1">
          <form action="#" method="POST" class="grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-8">
            <div>
              <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
              <div class="mt-1">
                <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
              </div>
            </div>
            <div>
              <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
              <div class="mt-1">
                <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
              <div class="mt-1">
                <input id="email" name="email" type="email" autocomplete="email" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md">
              </div>
            </div>
            <div class="sm:col-span-2">
              <label for="message" class="block text-sm font-medium text-gray-700">Message</label>
              <div class="mt-1">
                <textarea id="message" name="message" rows="4" class="py-3 px-4 block w-full shadow-sm focus:ring-indigo-500 focus:border-indigo-500 border-gray-300 rounded-md"></textarea>
              </div>
            </div>
            <div class="sm:col-span-2">
              <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Send Message
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Centered Contact Cards -->
      <div class="mt-16 flex justify-center">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-10 max-w-2xl">
          <!-- Email Us Card -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-8">
              <div class="flex items-center">
                <svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Email Us</h3>
              </div>
              <p class="mt-4 text-base text-gray-500">
                support@aihomeworkassistant.com
              </p>
            </div>
          </div>

          <!-- Call Us Card -->
          <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="px-6 py-8">
              <div class="flex items-center">
                <svg class="h-8 w-8 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.5-4.5L20 8l-4.5 4.5L15 10zM4 6l2-2 2 2-2 2L4 6zm8 8l4.5-4.5L20 14l-4.5 4.5L12 14zM2 4l2-2 2 2-2 2L2 4z" />
                </svg>
                <h3 class="ml-3 text-lg font-medium text-gray-900">Call Us</h3>
              </div>
              <p class="mt-4 text-base text-gray-500">
                +1 (555) 123-4567
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'ContactUs',
}
</script>
