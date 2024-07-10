<template>
  <div>

    <Head title="Edit Announcement" />
    <h1 class="mb-8 text-3xl font-bold">Edit Announcement</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <TextInput id="title" v-model="form.title" label="Title" :error="form.errors.title" />
      <TextareaInput id="content" v-model="form.content" label="Content" :error="form.errors.content" />
      <button type="submit" :disabled="form.processing" class="btn-indigo">
        Update
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
  props: {
    announcement: Object,
  },
  setup(props, { emit }) {
    const form = useForm({
      title: props.announcement.title,
      content: props.announcement.content,
      // Add more fields as needed
    })

    const submit = () => {
      form.put(`/announcements/${props.announcement.id}`, {
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
