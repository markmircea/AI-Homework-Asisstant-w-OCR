<template>
  <div class="container bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto py-6 sm:px-6 lg:px-8">
      <h6 class="block text-sm font-medium text-gray-700 mb-6">
        This is for rapid fire question response using the most intelligent AI on the market today. Due to the very high
        cost of using this model you are limited to 50 questions a day.</h6>

      <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <form @submit.prevent="uploadImage" class="p-6">
          <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2" for="image">
              Upload Image
            </label>
            <div class="mt-1 flex items-center justify-between">
              <div class="flex items-center">
                <input id="image" ref="imageInput" type="file" class="hidden" @change="handleFileChange"
                  accept="image/*" />
                <label for="image"
                  class="cursor-pointer bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                  Choose file
                </label>
                <span class="ml-3 text-sm text-gray-500" v-if="form.image">
                  {{ form.image.name }}
                </span>
              </div>
              <div class="flex items-center">
                <button
                  v-if="form.image"
                  @click.prevent="removeImage"
                  type="button"
                  class="mr-2 px-3 py-2 text-sm font-medium rounded-md bg-red-500 hover:bg-red-600 text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out flex items-center"
                >
                  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                  </svg>
                  Remove
                </button>
                <button
                  @click.prevent="captureScreenshot"
                  type="button"
                  :class="[
                    'px-3 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out flex items-center',
                    screenshotCaptured ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-indigo-400 hover:bg-indigo-500 text-white'
                  ]"
                >
                  <svg v-if="!screenshotCaptured" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                      d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                  </svg>
                  {{ screenshotCaptured ? 'Captured' : 'Screenshot' }}
                </button>
              </div>
            </div>
          </div>
          <div v-if="imagePreview" class="mt-4 mb-4">
            <p class="text-sm text-gray-600 mb-1 text-center">
              {{ screenshotCaptured ? 'Screenshot captured:' : 'File uploaded:' }}
            </p>
            <div class="flex justify-center">
              <img :src="imagePreview" alt="Image preview" class="max-w-xs h-20 object-cover rounded-md shadow-sm mr-2" />
            </div>
          </div>
          <div>
            <button type="submit"
              class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
              :disabled="form.processing">
              {{ form.processing ? 'Uploading...' : 'Upload and Analyze' }}
            </button>
          </div>
        </form>
      </div>

      <div v-if="analysis" class="mt-8 bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
          <h2 class="text-2xl font-bold text-gray-900 mb-4">Analysis Result</h2>
          <div class="prose max-w-none">
            <p class="text-gray-700 whitespace-pre-wrap">{{ analysis }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { useForm, Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

export default {
  layout: Layout,
  props: {
    analysis: {
      type: String,
      default: null,
    },
  },
  setup(props) {
    const imageInput = ref(null)
    const form = useForm({
      image: null,
    })
    const screenshotCaptured = ref(false)
    const imagePreview = ref(null)

    const handleFileChange = (e) => {
      const file = e.target.files[0]
      if (file) {
        form.image = file
        screenshotCaptured.value = false
        imagePreview.value = URL.createObjectURL(file)
      }
    }

    const removeImage = () => {
      form.image = null
      screenshotCaptured.value = false
      imagePreview.value = null
      if (imageInput.value) {
        imageInput.value.value = ''
      }
    }

    const captureScreenshot = async () => {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
        alert("Your browser doesn't support screenshot capture. Please use the file upload option.");
        return;
      }

      const activeElement = document.activeElement;

      try {
        const stream = await navigator.mediaDevices.getDisplayMedia({
          video: {
            displaySurface: "window",
          },
          audio: false,
          selfBrowserSurface: "include",
        });

        const video = document.createElement('video');
        video.srcObject = stream;
        video.autoplay = true;

        await new Promise((resolve) => {
          video.onloadeddata = resolve;
        });

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        stream.getTracks().forEach(track => track.stop());

        const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
        const file = new File([blob], "screenshot.png", { type: "image/png" });

        form.image = file;
        screenshotCaptured.value = true;
        imagePreview.value = URL.createObjectURL(blob);

      } catch (error) {
        if (error.name === 'AbortError') {
          console.log('User cancelled the screenshot capture');
        } else {
          console.error("Error capturing screenshot:", error);
          alert("Failed to capture screenshot. Please try again or use the file upload option.");
        }
      } finally {
        if (activeElement && typeof activeElement.focus === 'function') {
          activeElement.focus();
        }
        window.focus();
      }
    }

    const uploadImage = () => {
      form.post('/test-hacked/upload', {
        preserveState: true,
        preserveScroll: true,
      })
    }

    return {
      imageInput,
      form,
      handleFileChange,
      uploadImage,
      captureScreenshot,
      screenshotCaptured,
      imagePreview,
      removeImage,
    }
  },
}
</script>
