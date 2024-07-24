<template>
  <div>
    <Head :title="`${form.title}`" />
    <h1 class="mb-8 text-3xl font-bold">
      <Link class="text-indigo-400 hover:text-indigo-600" href="/history-list">History List</Link>
      <span class="text-indigo-400 font-medium"> / </span>
      {{ form.title }}
    </h1>
    <trashed-message v-if="announcement.deleted_at" class="mb-6" @restore="restore"> This contact has been deleted. </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden">
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.title" :error="form.errors.title" class="pb-8 pr-6 w-full lg:w-1/2" label="Title" />
          <text-input v-model="form.aiquery" :error="form.errors.aiquery" class="pb-8 pr-6 w-full lg:w-1/2" label="Question" />
          <text-input v-model="form.content" :error="form.errors.content" class="pb-8 pr-6 w-full lg:w-1/2" label="Answer"/>

          <text-input v-model="form.extracted_text" :error="form.errors.extracted_text" class="pb-8 pr-6 w-full lg:w-1/2" label="Extracted Text" />
          <text-input v-model="form.instructions" :error="form.errors.instructions" class="pb-8 pr-6 w-full lg:w-1/2" label="Explanation + Steps" />
          <text-input v-model="form.subject" :error="form.errors.subject" class="pb-8 pr-6 w-full lg:w-1/2" label="Subject" />
          <text-input v-model="form.created_at" :error="form.errors.created_at" class="pb-8 pr-6 w-full lg:w-1/2" label="Created At" />
          <text-input v-if="form.deleted_at" v-model="form.deleted_at" :error="form.errors.deleted_at" class="pb-8 pr-6 w-full lg:w-1/2" label="Deleted At" />

        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!announcement.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Contact</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Contact</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
  },
  layout: Layout,
  props: {
    announcement: Object,

  },
  mounted() {
    this.initializeFormFields();
  },
  watch: {
    'form.strengths': function (newVal) {
      this.form.strengthsText = newVal ? JSON.parse(newVal).join(", ") : "";
    },
    'form.soft_skills': function (newVal) {
      this.form.soft_skillsText = newVal ? JSON.parse(newVal).join(", ") : "";
    }
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
        photo: this.announcement.photo || null,
       }),
    }
  },
  methods: {
    initializeFormFields() {
      this.form.strengthsText = this.form.strengths ? JSON.parse(this.form.strengths).join(", ") : "";
      this.form.soft_skillsText = this.form.soft_skills ? JSON.parse(this.form.soft_skills).join(", ") : "";
    },
    update() {


      this.form.put(`/history-list/${this.announcement.id}`).then(() => {
        this.initializeFormFields(); // Re-initialize form fields to display correctly
      });
    },
    destroy() {
      if (confirm('Are you sure you want to delete this query?')) {
        this.$inertia.delete(`/history-list/${this.announcement.id}`)
      }
    },
    restore() {
      if (confirm('Are you sure you want to restore this contact?')) {
        this.$inertia.put(`/history-list/${this.announcement.id}/restore`)
      }
    },
  },
}
</script>
