<template>
  <div class="min-h-screen bg-gray-100 flex flex-col justify-center py-12 sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
      <logo @click="logout" class="mx-auto h-12 w-auto" />
      <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
        Verify Your Email Address
      </h2>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
      <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">
        <div class="text-sm text-gray-600 mb-6">
          <p>Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>
          <p class="mt-2">If you didn't receive the email, we will gladly send you another.</p>
        </div>

        <form @submit.prevent="sendVerification" class="space-y-6">
          <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
          </div>

          <div v-if="error" class="mb-4 font-medium text-sm text-red-600">
            {{ error }}
          </div>

          <div>
            <button type="submit" :disabled="form.processing" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
              {{ form.processing ? 'Sending...' : 'Resend Verification Email' }}
            </button>
          </div>
        </form>

        <div class="mt-6">
          <button @click="logout" class="w-full flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Logout
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { defineComponent } from 'vue'
import { Head, useForm } from '@inertiajs/vue3'
import Logo from '@/Shared/Logo.vue'

export default defineComponent({
  components: {
    Head,
    Logo
  },
  props: {
    status: String,
  },
  data() {
    return {
      error: '',
      form: useForm({}),
    }
  },
  methods: {
    sendVerification() {
      this.form.post('/email/verification-notification', {
        preserveState: true,
        preserveScroll: true,
        onSuccess: () => {
          this.error = ''
        },
        onError: (errors) => {
          this.error = errors.error || 'An error occurred. Please try again.'
        },
      })
    },
    logout() {
      this.$inertia.delete('/logout')
    },
  }
})
</script>
