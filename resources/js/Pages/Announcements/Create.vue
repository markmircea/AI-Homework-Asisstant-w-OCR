<template>
  <div>
    <Head title="Create Announcement" />
    <h1 class="mb-8 text-3xl font-bold">Create Announcement</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <TextInput id="title" v-model="form.title" label="Title" :error="form.errors.title" />
      <TextareaInput id="content" v-model="form.content" label="Content" :error="form.errors.content" />
      <button type="submit" :disabled="form.processing" class="btn-indigo">
        Create
      </button>
    </form>
  </div>
</template>

<script>
import { Head, useForm } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import TextareaInput from '@/Shared/TextareaInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'

export default {
  components: {
    Head,
    TextInput,
    TextareaInput,
    SelectInput,
  },
  setup(_, { emit }) {
    const form = useForm({
      title: '',
      content: '',
      // Add more fields as needed
    })

    const submit = () => {
      form.post('/announcements', {
        onSuccess: () => emit('submitted')
      })
    }

    return { form, submit }
  },
}
</script>

<style scoped>
/* Your scoped styles here */
</style>
