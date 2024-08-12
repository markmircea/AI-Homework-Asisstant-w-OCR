<template>
  <div class="w-full max-w-4xl mx-auto">
    <div class="flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-4">
      <div class="w-full flex-grow relative">
        <input
          class="w-full px-6 py-3 bg-white rounded-lg shadow-md focus:ring-2 focus:ring-indigo-500 focus:outline-none transition duration-150 ease-in-out"
          autocomplete="off"
          type="text"
          name="search"
          placeholder="Search..."
          :value="modelValue"
          @input="$emit('update:modelValue', $event.target.value)"
        />
        <button
          v-if="modelValue"
          class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
          @click="$emit('update:modelValue', '')"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
          </svg>
        </button>
      </div>
      <div class="flex items-center space-x-4">
        <dropdown
          :auto-close="false"
          class="relative"
          placement="bottom-end"
        >
          <template #default>
            <button
              class="px-4 py-2 bg-white rounded-lg shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 transition duration-150 ease-in-out"
            >
              <div class="flex items-center">
                <span class="text-gray-700 mr-2">Filter</span>
                <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                </svg>
              </div>
            </button>
          </template>
          <template #dropdown>
            <div class="mt-2 px-4 py-6 w-screen bg-white rounded-lg shadow-xl" :style="{ maxWidth: `${maxWidth}px` }">
              <slot />
            </div>
          </template>
        </dropdown>
        <button
          class="px-4 py-2  text-gray hover:text-indigo-500"
          type="button"
          @click="$emit('reset')"
        >
          Reset
        </button>
      </div>
    </div>
  </div>
</template>

<script>
import Dropdown from '@/Shared/Dropdown.vue'

export default {
  components: {
    Dropdown,
  },
  props: {
    modelValue: String,
    maxWidth: {
      type: Number,
      default: 300,
    },
  },
  emits: ['update:modelValue', 'reset'],
}
</script>
