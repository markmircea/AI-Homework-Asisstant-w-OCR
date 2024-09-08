<template>
  <Head title="Register" />
  <div class="flex items-center justify-center p-6 min-h-screen bg-gradient-radial from-indigo-800 via-indigo-850 to-indigo-900">
    <div class="w-full max-w-md">
      <Link href="/" class="flex flex-shrink-0 items-center group">
        <logo class="block mx-auto w-full max-w-xs fill-white animate-pulse-slow" height="50" />
      </Link>
      <form class="mt-8 bg-white rounded-2xl shadow-2xl overflow-hidden transition-all duration-300 hover:shadow-3xl" @submit.prevent="register">
        <div class="px-10 py-12">
          <h1 class="text-center text-3xl font-bold text-indigo-800">Create an Account</h1>
          <div class="mt-6 mx-auto w-24 border-b-2 border-indigo-500" />
          <text-input v-model="form.first_name" :error="form.errors.first_name" class="mt-10" label="First Name" />
          <text-input v-model="form.last_name" :error="form.errors.last_name" class="mt-6" label="Last Name" />
          <text-input v-model="form.email" :error="form.errors.email" class="mt-6" label="Email" type="email" />
          <text-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
          <text-input v-model="form.password_confirmation" :error="form.errors.password_confirmation" class="mt-6" label="Confirm Password" type="password" />
        </div>
        <div class="flex items-center justify-between px-10 py-4 bg-gray-50 border-t border-gray-100">
          <Link href="/login" class="text-sm text-indigo-600 hover:text-indigo-800 transition-colors duration-300">Already have an account?</Link>
          <loading-button :loading="form.processing" class="btn-indigo hover:bg-indigo-700 transition-colors duration-300" type="submit">Register</loading-button>
        </div>
      </form>
      <div class="mt-6 flex justify-center">
        <a href="/login/google" class="flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
          <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
            <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
            <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
            <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
          </svg>
          Sign up with Google
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
        first_name: '',
        last_name: '',
        email: '',
        password: '',
        password_confirmation: '',
      }),
    }
  },
  methods: {
    register() {
      this.form.post('/register')
    },
  },
}
</script>
