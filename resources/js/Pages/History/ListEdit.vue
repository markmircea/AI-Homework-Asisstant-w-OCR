<template>
  <div class="container mx-auto px-4 py-8">
    <Head :title="`${form.title}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600 transition duration-300" href="/history-list">History List</Link>
      <span class="text-indigo-400 font-medium"> / </span>
      {{ form.title }}
    </h1>
    <trashed-message v-if="announcement.deleted_at" class="mb-6" @restore="restore">
      This search has been deleted.
    </trashed-message>
    <div class="bg-white rounded-lg shadow-lg overflow-hidden transition-all duration-300 hover:shadow-xl">
      <form @submit.prevent="update" class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div class="col-span-1 md:col-span-2">
            <text-input v-model="form.title" :error="form.errors.title" class="w-full" label="Title" />
          </div>
          <TextareaInput v-if="form.aiquery" v-model="form.aiquery" :error="form.errors.aiquery" class="w-full" label="Question" disabled/>
          <TextareaInput v-if="form.extracted_text" v-model="form.extracted_text" :error="form.errors.extracted_text" class="w-full" label="Question - Extracted Text" disabled/>

          <TextareaInput v-model="form.content" :error="form.errors.content" class="w-full" label="Answer" rows="4" disabled/>
          <text-input v-model="form.subject" :error="form.errors.subject" class="w-full" label="Subject" disabled/>
          <text-input v-model="form.created_at" :error="form.errors.created_at" class="w-full" label="Created At" disabled />
          <text-input v-if="form.deleted_at" v-model="form.deleted_at" :error="form.errors.deleted_at" class="w-full" label="Deleted At" disabled />
        </div>
        <div class="flex items-center justify-between mt-6 pt-6 border-t border-gray-200">
          <button
            v-if="!announcement.deleted_at"
            class="text-red-600 hover:text-red-800 transition duration-300"
            tabindex="-1"
            type="button"
            @click="destroy"
          >
            Delete Announcement
          </button>
          <loading-button
            :loading="form.processing"
            class="btn-indigo"
            type="submit"
          >
            Update Announcement
          </loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import TextareaInput from '@/Shared/TextareaInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    TextInput,
    TextareaInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    announcement: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        title: this.announcement.title || '',
        content: this.announcement.content || '',
        user_id: this.announcement.user_id || null,
        id: this.announcement.id || null,
        aiquery: this.announcement.aiquery || '',
        subject: this.announcement.subject || '',
        extracted_text: this.announcement.extracted_text || '',
        instructions: this.announcement.instructions || '',
        created_at: this.announcement.created_at || '',
        updated_at: this.announcement.updated_at || '',
        deleted_at: this.announcement.deleted_at || '',
      }),
    }
  },
  methods: {
    update() {
      this.form.put(`/history-list/${this.announcement.id}`);
    },
    destroy() {
      if (confirm('Are you sure you want to delete this announcement?')) {
        this.$inertia.delete(`/history-list/${this.announcement.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this announcement?')) {
        this.$inertia.put(`/history-list/${this.announcement.id}/restore`)
      }
    },
  },
}
</script>

<style scoped>
.container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
}

.btn-indigo {
  @apply bg-indigo-500 text-white px-6 py-3 rounded-lg font-semibold
         transition duration-300 ease-in-out transform hover:bg-indigo-600
         hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-indigo-500
         focus:ring-opacity-50 active:bg-indigo-700;
}

.btn-indigo:hover {
  @apply -translate-y-0.5;
}

/* Add any additional custom styles here */
</style>
