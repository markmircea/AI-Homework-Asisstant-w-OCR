<template>
  <div class="bg-white mt-20 mb-20 px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
    <div class="grid gap-6 row-gap-10 lg:grid-cols-2">
      <div class="lg:py-6 lg:pr-16">
        <div class="flex">
          <div class="flex flex-col items-center mr-4">
            <div>
              <div class="flex items-center justify-center w-10 h-10 border rounded-full">
                <svg class="w-4 text-gray-600" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <line fill="none" stroke-miterlimit="10" x1="12" y1="2" x2="12" y2="22"></line>
                  <polyline fill="none" stroke-miterlimit="10" points="19,15 12,22 5,15"></polyline>
                </svg>
              </div>
            </div>
            <div class="w-px h-full bg-gray-300"></div>
          </div>
          <div class="pt-1 pb-8">
            <p class="mb-2 text-lg font-bold">Step 1: Submit Your Assignment or Test</p>
            <p class="text-gray-700">
              Upload your homework question or take a photo of your assignment, quiz or test. Our system accepts various image and document formats to make submission easy.
            </p>
          </div>
        </div>
        <div class="flex">
          <div class="flex flex-col items-center mr-4">
            <div>
              <div class="flex items-center justify-center w-10 h-10 border rounded-full">
                <svg class="w-4 text-gray-600" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <line fill="none" stroke-miterlimit="10" x1="12" y1="2" x2="12" y2="22"></line>
                  <polyline fill="none" stroke-miterlimit="10" points="19,15 12,22 5,15"></polyline>
                </svg>
              </div>
            </div>
            <div class="w-px h-full bg-gray-300"></div>
          </div>
          <div class="pt-1 pb-8">
            <p class="mb-2 text-lg font-bold">Step 2: AI Analysis</p>
            <p class="text-gray-700">
              Our advanced AI models analyze your assignment, processing it through multiple specialized systems to ensure comprehensive understanding. First the image gets processed through a specialized OCR AI model to extract the text even from blurry, fuzzy, poor quality photos. Then it gets sent to our analysis model to give you the best possible response.
            </p>
          </div>
        </div>
        <div class="flex">
          <div class="flex flex-col items-center mr-4">
            <div>
              <div class="flex items-center justify-center w-10 h-10 border rounded-full">
                <svg class="w-4 text-gray-600" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                  <line fill="none" stroke-miterlimit="10" x1="12" y1="2" x2="12" y2="22"></line>
                  <polyline fill="none" stroke-miterlimit="10" points="19,15 12,22 5,15"></polyline>
                </svg>
              </div>
            </div>
            <div class="w-px h-full bg-gray-300"></div>
          </div>
          <div class="pt-1 pb-8">
            <p class="mb-2 text-lg font-bold">Step 3: Receive Detailed Solution</p>
            <p class="text-gray-700">
              Get a comprehensive answer, including step-by-step explanations, relevant examples, and additional resources to deepen your understanding.
            </p>
          </div>
        </div>
        <div class="flex">
          <div class="flex flex-col items-center mr-4">
            <div>
              <div class="flex items-center justify-center w-10 h-10 border rounded-full">
                <svg class="w-6 text-gray-600" stroke="currentColor" viewBox="0 0 24 24">
                  <polyline fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" points="6,12 10,16 18,8"></polyline>
                </svg>
              </div>
            </div>
          </div>
          <div class="pt-1">
            <p class="mb-2 text-lg font-bold">Success: Learn and Improve</p>
            <p class="text-gray-700">Use the provided solution to enhance your understanding and improve your academic performance.</p>
          </div>
        </div>
      </div>
      <div class="relative">
        <div class="h-64 rounded-2xl bg-cover bg-center lg:h-full"
             style="background-image: url('/img/studentest.jpeg'); background-size: cover; background-position: center;">
        </div>      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Steps',
};
</script>

<style scoped>
/* Add any specific styles for this component here */
</style>
