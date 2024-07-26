<template>
  <div class="edit-container h-full flex flex-col">
    <h1 class="mb-8 text-3xl font-bold">Modify Query</h1>
    <form @submit.prevent="submit" class="flex flex-col flex-grow">
      <div class="space-y-4 flex-grow flex flex-col">
        <div class="flex-shrink-0">
          <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
          <input
            id="title"
            v-model="form.title"
            type="text"
            class="w-full bg-gray-100 dark:bg-gray-700 rounded-md p-2 text-sm custom-scrollbar"
          />
          <div v-if="form.errors.title" class="text-red-500 text-xs mt-1">{{ form.errors.title }}</div>
        </div>

        <div v-if="form.extracted_text" class="flex-shrink-0">
          <label for="extracted_text" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Extracted Text</label>
          <div class=" h-16">
            <textarea
              id="extracted_text"
              disabled
              v-model="form.extracted_text"
              class="custom-scrollbar w-full h-full bg-gray-100 dark:bg-gray-700 rounded-md p-2 text-sm"
            ></textarea>
          </div>
        </div>

        <div v-if="!form.extracted_text && form.aiquery" class="flex-shrink-0">
          <label for="aiquery" class="block text-sm font-medium text-gray-700 dark:text-gray-300">AI Query</label>
          <div class=" h-16">
            <textarea
              id="aiquery"
              disabled
              v-model="form.aiquery"
              class="custom-scrollbar w-full h-full bg-gray-100 dark:bg-gray-700 rounded-md p-2 text-sm"
            ></textarea>
          </div>
        </div>

        <div class="flex-shrink-0">
          <label for="instructions" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Instructions</label>
          <div class=" h-16">
            <textarea
              id="instructions"
              disabled
              v-model="form.instructions"
              class="custom-scrollbar w-full h-full bg-gray-100 dark:bg-gray-700 rounded-md p-2 text-sm"
            ></textarea>
          </div>
        </div>

        <div class="flex-grow flex flex-col min-h-0">
          <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Response</label>
          <div class="flex-grow " style="min-height: 210px;">
            <textarea
              id="content"
              disabled
              v-model="form.content"
              class="w-full h-full custom-scrollbar bg-gray-100 dark:bg-gray-700 rounded-md p-2 text-sm"
            ></textarea>
          </div>
        </div>

        <div class="flex-shrink-0">
          <label for="subject" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Subject</label>
          <select
            id="subject"
            v-model="form.subject"
            class="mt-1 block w-full bg-white dark:bg-gray-700 border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
          >
            <option value="" disabled>Select a subject</option>
            <option v-for="subject in subjects" :key="subject" :value="subject">
              {{ subject }}
            </option>
          </select>
        </div>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="mt-4 w-full btn-indigo text-white py-3 px-4 rounded-md hover:btn-indigo-hover focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-300 text-lg font-semibold"
      >
        Update
      </button>
    </form>
  </div>
</template>

<script>
import { Head, useForm } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import TextareaInput from '@/Shared/TextareaInput.vue'

export default {
  components: {
    Head,
    TextInput,
    TextareaInput,
  },
  props: {
    announcement: Object,
  },
  setup(props, { emit }) {
    const subjects = [
      'Mathematics', 'Science', 'History', 'Geography', 'English',
      'Chemistry', 'Physics', 'Biology', 'Computer Science', 'Economics'
    ];

    const form = useForm({
      title: props.announcement.title,
      content: props.announcement.content,
      extracted_text: props.announcement.extracted_text,
      aiquery: props.announcement.aiquery,
      instructions: props.announcement.instructions,
      subject: props.announcement.subject,
    });

    const submit = () => {
      form.put(`/history/${props.announcement.id}`, {
        onSuccess: () => emit('submitted')
      });
    };

    return { form, subjects, submit };
  },
}
</script>




<style scoped>

/* Button styling */
.btn-indigo, .btn-red, .pagination-controls button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 0.5rem;
  color: white;
  font-weight: 600;
  padding: 0.75rem 1.5rem;
  transition: all 0.3s ease;
}

.btn-indigo:hover, .btn-red:hover, .pagination-controls button:hover:not(:disabled) {
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}
.edit-container {
  width: 100%;
}

textarea, input[type="text"] {
  resize: none;
  border: 1px solid #d1d5db;
}

.custom-scrollbar {
  overflow-y: auto;
  scrollbar-width: thin;
  scrollbar-color: rgba(156, 163, 175, 0.5) transparent;
}

.custom-scrollbar::-webkit-scrollbar {
  width: 6px;
}

.custom-scrollbar::-webkit-scrollbar-track {
  background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
  background-color: rgba(156, 163, 175, 0.5);
  border-radius: 3px;
  border: 2px solid transparent;
  background-clip: content-box;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
  background-color: rgba(156, 163, 175, 0.8);
}

select {
  border: 1px solid #d1d5db;
  background-color: #fff;
  padding: 0.5rem;
  border-radius: 0.375rem;
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236B7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3E%3C/svg%3E");
  background-position: right 0.5rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}

button {
  background-color: #4f46e5;
  color: #fff;
  padding: 0.75rem;
  border-radius: 0.375rem;
  cursor: pointer;
  transition: all 0.3s ease;
  font-weight: 600;
}

button:disabled {
  background-color: #e5e7eb;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  background-color: #4338ca;
  transform: translateY(-1px);
}

button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.5);
}

</style>
