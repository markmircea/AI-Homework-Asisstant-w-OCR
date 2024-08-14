<template>
  <div v-show="isLoading" class="fixed inset-0 z-50 flex items-center justify-center">
    <!-- Blurred background -->
    <div class="absolute inset-0 bg-gray-900 bg-opacity-50 backdrop-filter backdrop-blur-sm"></div>

    <!-- Loader content -->
    <div class="relative z-10 bg-white p-8 rounded-lg shadow-xl text-center">
      <div class="mb-4">
        <svg class="animate-spin h-12 w-12 text-indigo-600 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
          <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
          <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
      </div>
      <h2 class="text-xl font-semibold text-gray-900 mb-2">Loading...</h2>
      <p class="mt-2 text-gray-600">Please wait</p>
    </div>
  </div>
</template>

<script>
import { ref, onMounted, onUnmounted } from 'vue'

export default {
  setup() {
    const isLoading = ref(false)

    const startLoading = () => {
      isLoading.value = true
    }

    const endLoading = () => {
      isLoading.value = false
    }

    onMounted(() => {
      document.addEventListener('inertia:start', startLoading)
      document.addEventListener('inertia:finish', endLoading)
    })

    onUnmounted(() => {
      document.removeEventListener('inertia:start', startLoading)
      document.removeEventListener('inertia:finish', endLoading)
    })

    return {
      isLoading
    }
  }
}
</script>
