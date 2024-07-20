<template>
  <div>
    <Head title="Analyze" />
    <h1 class="mb-8 text-3xl font-bold">Analyze</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <!-- Title Input -->
      <TextInput
        id="title"
        v-model="form.title"
        label="Title"
        :error="form.errors.title"
        placeholder="Enter a title (optional)"
      />

      <!-- AI Query Input -->
      <TextInput
        id="aiquery"
        v-model="form.aiquery"
        label="Test Question"
        :error="form.errors.aiquery"
        placeholder="Enter your AI query or Upload an Image"
      />

      <!-- Subject Selector -->
      <div class="flex flex-col">
        <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
        <select
          id="subject"
          v-model="form.subject"
          class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring focus:ring-indigo-500 focus:ring-opacity-50"
        >
          <option value="auto-detect">Auto-Detect</option>
          <option v-for="subject in subjects" :key="subject" :value="subject">{{ subject }}</option>
        </select>
        <p v-if="form.errors.subject" class="text-red-600 text-sm mt-2">{{ form.errors.subject }}</p>
      </div>

      <!-- Image Upload -->
      <ImageUpload
        v-model="form.photo"
        :error="form.errors.photo"
        class="w-full lg:w-100%"
        type="file"
        accept="image/*"
        label="Photo"
      />

      <!-- Submit Button -->
      <LoadingButton
        type="submit"
        :loading="form.processing"
        class="btn-indigo"
      >
        Analyze
      </LoadingButton>
    </form>
  </div>
</template>

<script>
import { Head, useForm } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import ImageUpload from '@/Shared/ImageUpload.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    TextInput,
    LoadingButton,
    ImageUpload,
  },
  setup(_, { emit }) {
    const subjects = [
      'Mathematics', 'Science', 'History', 'Geography', 'English',
      'Chemistry', 'Physics', 'Biology', 'Computer Science', 'Economics'
    ]

    const form = useForm({
      title: '',
      aiquery: '',
      subject: 'auto-detect', // Default value
      photo: null,
    })

    const submit = () => {
      // If title is empty, set it to the current date and time
      if (!form.title) {
        form.title = new Date().toISOString()
      }

      form.post('/ocr', {
        onSuccess: () => emit('submitted')
      })
    }

    return { form, submit, subjects }
  },
}
</script>

<style scoped>
/* Add any additional styles here */
</style>
