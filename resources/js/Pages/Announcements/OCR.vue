<template>
  <div>
    <Head title="Analyze" />
    <h1 class="mb-8 text-3xl font-bold">Analyze</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <TextInput id="title" v-model="form.title" label="Title" :error="form.errors.title" />
      <TextareaInput id="content" v-model="form.content" label="Content" :error="form.errors.content" />

      <file-input v-model="form.photo" :error="form.errors.photo" class="w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />

      <loading-button type="submit" :loading="form.processing" class="btn-indigo">
        Analyze
      </loading-button>

    </form>
  </div>
</template>

<script>
import { Head, useForm } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import TextareaInput from '@/Shared/TextareaInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'


export default {
  components: {
    Head,
    TextInput,
    TextareaInput,
    LoadingButton,
    FileInput,
  },
  setup(_, { emit }) {
    const form = useForm({
      title: '',
      content: '',
      photo: null,
      // Add more fields as needed
    })

    const submit = () => {
      form.post('/ocr', {
        onSuccess: () => emit('submitted')
      })
    }

    return { form, submit }
  },
}
</script>

<style scoped>
.btn-indigo {
  background-color: #5a67d8;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  text-align: center;
  text-decoration: none;
}</style>
