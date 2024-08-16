<template>
  <Head title="Login" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-gradient-radial from-indigo-800 via-indigo-850 to-indigo-900">
    <div class="w-full max-w-md">
      <logo class="block mx-auto w-full max-w-xs fill-white animate-pulse-slow" height="50" />
      <form class="mt-8 bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl" @submit.prevent="login">
       <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold text-indigo-800">Welcome Back!</h1>
          <div class="mt-6 mx-auto w-24 border-b-2 border-indigo-500" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-10" label="Email" type="email" autofocus autocapitalize="off" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <div class="flex items-center justify-between mt-6">
            <label class="flex items-center select-none" for="remember">
              <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
              <span class="text-sm text-gray-600">Remember Me</span>
            </label>
            <Link href="/forgot-password" class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-300">Forgot Password?</Link>
          </div>
        </div>
        <div class="flex items-center justify-between px-10 py-4 bg-gray-50 border-t border-gray-100">
          <Link href="/register" class="text-sm text-indigo-600 hover:text-indigo-850 transition-colors duration-300">Don't have an account?</Link>
          <loading-button
            :loading="form.processing"
            class="btn-indigo hover:bg-indigo-850 active:bg-indigo-900 disabled:opacity-50 disabled:cursor-not-allowed transition-colors transition-spacing duration-300"
            type="submit"
          >
            Login
          </loading-button>
        </div>
      </form>
      <div class="mt-6 flex justify-center">
        <a href="login/google" class="transform hover:scale-105 transition-transform duration-300">
          <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" alt="Sign in with Google">
        </a>
      </div>
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
        password: '',
        remember: false,
      }),
    }
  },
  methods: {
    login() {
      this.form.post('/login')
    },
    loginWithGoogle() {
      window.location.href = '/login/google'; // Redirect to Google OAuth flow
    },
  },
}
</script>
