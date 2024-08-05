<template>
  <div>

    <Head :title="`${form.first_name} ${form.last_name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <!--  <Link class="text-indigo-400 hover:text-indigo-600" href="/users">Users</Link>  -->
        <span class="mb-8 text-3xl font-bold">
          <img v-if="user.photo" class="inline-block ml-4 w-8 h-8 rounded-full" :src="user.photo" />

          {{ form.first_name }} {{ form.last_name }}</span>
      </h1>
    </div>
    <trashed-message v-if="user.deleted_at" class="mb-6" @restore="restore"> This account has been deleted.
    </trashed-message>
    <div class="max-w-3xl bg-white rounded-md shadow overflow-hidden ">
      <!-- Profile Heading and Horizontal Line -->
      <div class="px-8 py-4 bg-white border-b border-gray-200">
        <h2 class="text-xl font-semibold">Profile</h2>

      </div>
      <form @submit.prevent="update">
        <div class="flex flex-wrap -mb-8 -mr-6 p-8">
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2"
            label="First name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2"
            label="Last name" />

          <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2" label="Email" />
          <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2"
            type="password" autocomplete="new-password" label="Password" />

          <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file"
            accept="image/*" label="Photo" />
        </div>
        <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
          <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
            @click="destroy">Delete Account</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
            User</loading-button>
        </div>
      </form>
    </div>





      <div class="mt-20 flex-1">
            <ActiveSessions />
          </div>

    <div class="container  mt-20">
      <div class="flex flex-col lg:flex-row gap-4">

        <!-- Billing Section -->
        <div class="flex-1 bg-white rounded-md shadow overflow-hidden">
          <!-- Billing Heading and Horizontal Line -->
          <div class="px-8 py-4 bg-white border-b border-gray-200">
            <h2 class="text-xl font-semibold">Billing</h2>
          </div>
          <form @submit.prevent="update">
            <div class="flex flex-wrap -mb-8 -mr-6 p-8">
              <text-input v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2"
                label="First name" />
              <text-input v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Last name" />
              <text-input v-model="form.id" :error="form.errors.id" class="pb-8 pr-6 w-full lg:w-1/2" label="ID #"
                disabled />
              <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Email" />
              <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2"
                type="password" autocomplete="new-password" label="Password" />
                           <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file"
                accept="image/*" label="Photo" />
            </div>
            <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
              <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
                @click="destroy">Delete Account</button>
              <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
                User</loading-button>
            </div>
          </form>
        </div>

        <!-- Advanced Settings Section -->
        <div class="flex-1 bg-white rounded-md shadow overflow-hidden">
          <!-- Advanced Settings Heading and Horizontal Line -->
          <div class="px-8 py-4 bg-white border-b border-gray-200">
            <h2 class="text-xl font-semibold">Advanced Settings</h2>
          </div>
          <form @submit.prevent="update">
            <div class="flex flex-wrap -mb-8 -mr-6 p-8">
              <text-input v-model="form.first_name" :error="form.errors.first_name" class="pb-8 pr-6 w-full lg:w-1/2"
                label="First name" />
              <text-input v-model="form.last_name" :error="form.errors.last_name" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Last name" />
              <text-input v-model="form.id" :error="form.errors.id" class="pb-8 pr-6 w-full lg:w-1/2" label="ID #"
                disabled />
              <text-input v-model="form.email" :error="form.errors.email" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Email" />
              <text-input v-model="form.password" :error="form.errors.password" class="pb-8 pr-6 w-full lg:w-1/2"
                type="password" autocomplete="new-password" label="Password" />
              <select-input v-model="form.owner" :error="form.errors.owner" class="pb-8 pr-6 w-full lg:w-1/2"
                label="Owner">
                <option :value="true">Yes</option>
                <option :value="false">No</option>
              </select-input>
              <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2" type="file"
                accept="image/*" label="Photo" />
            </div>
            <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
              <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
                @click="destroy">Delete User</button>
              <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
                User</loading-button>
            </div>
          </form>
        </div>
      </div>
    </div>




  </div>


</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import TrashedMessage from '@/Shared/TrashedMessage.vue'
import ActiveSessions from './ActiveSessions.vue'



export default {
  components: {
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    TrashedMessage,
    ActiveSessions
  },
  layout: Layout,
  props: {
    user: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        _method: 'put',
        first_name: this.user.first_name,
        last_name: this.user.last_name,
        email: this.user.email,
        password: '',
       photo: null,
        id: this.user.id,
      }),
    }
  },
  methods: {
    update() {
      this.form.post(`/profile/${this.user.id}`, {
        onSuccess: () => this.form.reset('password', 'photo'),
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete your account? You will only be able to recover your account by contacting support.')) {
        this.$inertia.delete(`/profile/${this.user.id}`)
      }
    },

  },
}
</script>
