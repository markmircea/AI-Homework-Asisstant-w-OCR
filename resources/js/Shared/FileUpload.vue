<template>
  <div class="file-input-container">
    <label :for="inputId" class="file-input-label">
      {{ label }}
      <span v-if="required" class="text-red-500">*</span>
    </label>
    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md">
      <div class="space-y-1 text-center">
        <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
          <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <div class="flex text-sm text-gray-600">
          <label :for="inputId" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
            <span>Upload a file</span>
            <input :id="inputId" :name="name" type="file" class="sr-only" :accept="acceptedFileTypes" @change="handleFileChange">
          </label>
          <p class="pl-1">or drag and drop</p>
        </div>
        <p class="text-xs text-gray-500">
          PNG, JPG, GIF, PDF, DOC, DOCX up to 10MB
        </p>
      </div>
    </div>
    <div v-if="selectedFile" class="mt-2 flex items-center justify-between">
      <span class="text-sm text-gray-600">
        Selected file: {{ selectedFile.name }} ({{ formattedFileSize }})
      </span>
      <button
        @click="removeFile"
        class="ml-2 inline-flex items-center px-2.5 py-1.5 border border-transparent text-xs font-medium rounded text-indigo-700 bg-red-100 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
      >
        Remove
      </button>
    </div>
    <div v-if="error" class="mt-2 text-sm text-red-600">
      {{ error }}
    </div>
  </div>
</template>

<script>
import { ref, computed } from 'vue';

export default {
  name: 'CustomFileInput',
  props: {
    label: {
      type: String,
      default: 'File'
    },
    name: {
      type: String,
      required: true
    },
    required: {
      type: Boolean,
      default: false
    },
    error: {
      type: String,
      default: ''
    },
    modelValue: {
      type: [File, null],
      default: null
    }
  },
  emits: ['update:modelValue'],
  setup(props, { emit }) {
    const selectedFile = ref(null);
    const inputId = computed(() => `file-input-${props.name}`);
    const acceptedFileTypes = '.png,.jpg,.jpeg,.gif,.pdf,.doc,.docx';

    const formattedFileSize = computed(() => {
      if (!selectedFile.value) return '';
      const bytes = selectedFile.value.size;
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    });

    const handleFileChange = (event) => {
      const file = event.target.files[0];
      if (file) {
        if (file.size > 10 * 1024 * 1024) { // 10MB limit
          emit('update:modelValue', null);
          selectedFile.value = null;
          alert('File size exceeds 10MB limit. Please choose a smaller file.');
        } else {
          selectedFile.value = file;
          emit('update:modelValue', file);
        }
      }
    };

    const removeFile = () => {
      selectedFile.value = null;
      emit('update:modelValue', null);
      // Reset the file input
      const fileInput = document.getElementById(inputId.value);
      if (fileInput) fileInput.value = '';
    };

    return {
      selectedFile,
      inputId,
      acceptedFileTypes,
      handleFileChange,
      formattedFileSize,
      removeFile
    };
  }
};
</script>

<style scoped>
.file-input-container {
  @apply mb-4;
}

.file-input-label {
  @apply block text-sm font-medium text-gray-700 mb-1;
}
</style>
