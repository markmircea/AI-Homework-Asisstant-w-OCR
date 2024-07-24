<template>
  <div class="container mx-auto p-4">
    <Head title="Edit Announcement" />
    <h1 class="mb-6 text-2xl font-bold text-gray-900">Modify Query</h1>
    <form @submit.prevent="submit" class="space-y-4 bg-white p-4 rounded-lg shadow-md max-w-2xl mx-auto">
      <TextInput id="title" v-model="form.title" label="Title" :error="form.errors.title" />

      <div v-if="form.extracted_text">
        <TextareaInput
          id="extracted_text"
          disabled
          v-model="form.extracted_text"
          label="Extracted Text"
          class="bg-gray-100"
        />
      </div>

      <div v-if="!form.extracted_text && form.aiquery">
        <TextareaInput
          id="aiquery"
          disabled
          v-model="form.aiquery"
          label="AI Query"
          class="bg-gray-100"
        />
      </div>

      <TextareaInput id="instructions" disabled v-model="form.instructions" label="Instructions" class="bg-gray-100" />
      <TextareaInput id="content" disabled v-model="form.content" label="Response" class="bg-gray-100" />

      <div>
        <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
        <select
          id="subject"
          v-model="form.subject"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
        >
          <option value="" disabled>Select a subject</option>
          <option v-for="subject in subjects" :key="subject" :value="subject">
            {{ subject }}
          </option>
        </select>
      </div>

      <button
        type="submit"
        :disabled="form.processing"
        class="mt-4 w-full bg-indigo-600 text-white py-2 px-4 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-300"
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
/* Container for the form */
.container {
  max-width: 800px;
  margin: 0 auto;
}

/* Form container */
form {
  background-color: #fff;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Input fields */
input:disabled,
textarea:disabled {
  background-color: #f3f4f6;
  cursor: not-allowed;
}

/* Select input */
select {
  border: 1px solid #d1d5db;
  background-color: #fff;
  padding: 0.5rem;
  border-radius: 0.375rem;
}

/* Button styling */
button {
  background-color: #4f46e5;
  color: #fff;
  padding: 0.5rem;
  border-radius: 0.375rem;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button:disabled {
  background-color: #e5e7eb;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  background-color: #3730a3;
}

button:focus {
  outline: none;
  box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.5);
}
</style>
