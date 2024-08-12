<template>
  <div :class="$attrs.class">
    <label v-if="label" class="block text-sm font-medium text-gray-700 mb-1" :for="id">
      {{ label }}:
    </label>
    <div class="relative">
      <textarea
        :id="id"
        ref="input"
        v-bind="{ ...$attrs, class: null }"
        class="form-textarea w-full px-3 py-2 text-gray-700 border rounded-lg focus:outline-none transition duration-300 ease-in-out"
        :class="{
          'border-red-500 focus:border-red-500 focus:ring focus:ring-red-200': error,
          'border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200': !error
        }"
        :value="modelValue"
        @input="handleInput"
        @focus="adjustHeight"
        rows="1"
      />
      <div
        v-if="error"
        class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
      >
        <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
        </svg>
      </div>
    </div>
    <p v-if="error" class="mt-2 text-sm text-red-600">{{ error }}</p>
  </div>
</template>

<script>
import { v4 as uuid } from 'uuid'

export default {
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `textarea-input-${uuid()}`
      },
    },
    error: String,
    label: String,
    modelValue: String,
  },
  emits: ['update:modelValue'],
  methods: {
    focus() {
      this.$refs.input.focus()
    },
    select() {
      this.$refs.input.select()
    },
    handleInput(event) {
      this.$emit('update:modelValue', event.target.value)
      this.adjustHeight()
    },
    adjustHeight() {
      const textarea = this.$refs.input
      textarea.style.height = 'auto'
      textarea.style.height = `${textarea.scrollHeight}px`
    }
  },
  mounted() {
    this.adjustHeight()
    window.addEventListener('resize', this.adjustHeight)
  },
  updated() {
    this.adjustHeight()
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.adjustHeight)
  }
}
</script>

<style scoped>
.form-textarea {
  min-height: 38px; /* Matches the height of a single line */
  resize: none; /* Prevents manual resizing */
  overflow-y: hidden; /* Hides the scrollbar */
  transition: all 0.3s ease;
}

.form-textarea:focus {
  box-shadow: 0 0 0 3px rgba(164, 202, 254, 0.45);
}

.form-textarea:hover:not(:focus) {
  border-color: #a0aec0;
}
</style>
