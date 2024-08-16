<template>
  <Head title="Reset Password" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-gradient-radial from-indigo-800 via-indigo-850 to-indigo-900">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white animate-pulse-slow" height="50" />
       <form class="mt-8 bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl" @submit.prevent="resetPassword">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold text-indigo-800">Reset Password</h1>
          <div class="mt-6 mx-auto w-24 border-b-2 border-indigo-500" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" disabled />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="New Password" type="password" />
          <text-input v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="mt-6" label="Confirm New Password" type="password" />
          <input type="hidden" v-model="form.token" />
        </div>
        <div class="flex items-center justify-end px-10 py-4 bg-gray-50 border-t border-gray-100">
          <loading-button :loading="form.processing" class="btn-indigo hover:bg-indigo-700 transition-colors duration-300" type="submit">Reset Password</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Logo from '@/Shared/Logo.vue'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Logo,
    TextInput,
    LoadingButton,
  },
  props: {
    email: String,
    token: String,
  },
  data() {
    return {
      form: this.$inertia.form({
        token: this.token,
        email: this.email,
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    resetPassword() {
      this.form.post('/reset-password')
    },
  },
}
</script>
