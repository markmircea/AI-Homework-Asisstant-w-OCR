<template>
  <Head title="Forgot Password" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-gradient-radial from-indigo-800 via-indigo-850 to-indigo-900">
    <div class="w-full max-w-md">
      <Link href="/" class="flex flex-shrink-0 items-center group">

      <logo class="block mx-auto w-full max-w-xs fill-white animate-pulse-slow" height="50" />
      </Link>
      <form class="mt-8 bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl" @submit.prevent="sendResetLink">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold text-indigo-800">Forgot Password</h1>
          <div class="mt-6 mx-auto w-24 border-b-2 border-indigo-500" />
          <div class="mt-6">
            <p class="text-gray-600 text-center">We'll send a password reset link to your email address.</p>
          </div>
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
        </div>
        <div class="flex items-center justify-between px-10 py-4 bg-gray-50 border-t border-gray-100">
          <Link href="/login" class="text-indigo-600 hover:text-indigo-800 transition-colors duration-300">Back to Login</Link>
          <loading-button :loading="form.processing" class="btn-indigo hover:bg-indigo-700 transition-colors duration-300" type="submit">Send Reset Link</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Logo from '@/Shared/Logo.vue'
import TextInput from '@/Shared/TextInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    Logo,
    TextInput,
  },
  data() {
    return {
      form: this.$inertia.form({
        email: '',
      }),
    }
  },
  methods: {
    sendResetLink() {
      this.form.post('/forgot-password')
    },
  },
}
</script>
