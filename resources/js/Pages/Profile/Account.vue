<template>
  <div class="container bg-gray-100 min-h-screen py-12 px-0 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto ">

      <Head :title="`${form.first_name} ${form.last_name}`" />

      <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
          <img v-if="user.photo" class="inline-block mr-4 w-12 h-12 rounded-full" :src="user.photo" />
          {{ form.first_name }} {{ form.last_name }}
        </h1>
      </div>

      <trashed-message v-if="user.deleted_at" class="mb-6" @restore="restore">
        This account has been deleted.
      </trashed-message>
      <div id="profile-information" class="bg-white rounded-md shadow overflow-hidden">
        <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white border-gray-200">
          <h2 class="text-s font-medium text-white uppercase tracking-wider font-semibold">Profile Information</h2>
        </div>
        <form @submit.prevent="validateAndSubmit">
          <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-2 ">
              <text-input  v-model="form.first_name" :error="form.errors.first_name" label="First name" />
              <text-input v-model="form.last_name" :error="form.errors.last_name" label="Last name" />
              <text-input v-model="form.email" :error="form.errors.email" label="Email" />
              <text-input v-model="form.password" :error="passwordError" type="password" autocomplete="new-password"
                label="Password" />
              <text-input v-model="form.password_confirmation" :error="passwordConfirmationError" type="password"
                autocomplete="new-password" label="Confirm Password" />
              <file-input v-model="form.photo" :error="form.errors.photo" type="file" accept="image/*" label="Photo" />
            </div>
          </div>
          <div class="px-4 py-3 bg-gray-50 text-right sm:px-6 flex justify-between items-center">
            <button v-if="!user.deleted_at" class="text-red-600 hover:underline" tabindex="-1" type="button"
              @click="destroy">Delete Account</button>
            <loading-button :loading="form.processing"
              class="w-full sm:w-auto px-6 py-3 bg-indigo-400 text-white text-sm font-bold rounded-lg shadow hover:bg-indigo-200 focus:outline-none focus:shadow-outline transition duration-300 ease-in-out"
              type="submit">Update Profile</loading-button>
          </div>
        </form>
      </div>

      <!-- Daily Questions Section -->
      <div id="billing" class="mt-20">
        <div class="bg-white rounded-none shadow-lg overflow-hidden sm:rounded-lg">
          <div class="px-6 py-8 bg-gradient-to-r from-indigo-400 to-indigo-600">
            <h2 class="text-xl font-medium text-white uppercase tracking-wider font-semibold mb-2">Daily Questions</h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                <p class="text-5xl font-bold text-white">{{ user.questions_left }}</p>
                <p class="text-sm text-indigo-100">Questions left today</p>
              </div>
              <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                <p class="text-3xl font-semibold text-white">{{ user.daily_question_limit }}</p>
                <p class="text-sm text-indigo-100">Daily limit</p>
              </div>
              <div class="bg-white bg-opacity-20 p-4 rounded-lg">
                <p class="text-xl font-semibold text-white">Current Plan</p>
                <p class="text-2xl text-indigo-100">{{ subscriptionTypeText }}</p>
              </div>
              <div
                class="bg-white bg-opacity-20 p-4 rounded-lg flex items-center justify-center hover:bg-indigo-200 transition duration-300">
                <button @click="goToPricingPage" class="px-4 py-2  text-white rounded-full font-semibold ">
                  Upgrade Plan
                </button>
              </div>
            </div>
          </div>

          <div class="px-6 py-6">
            <div class="bg-indigo-50 border-l-4 border-indigo-400 p-4 mb-6">
              <p class="text-sm text-indigo-700">
                <span class="font-bold">Upgrade to Pro or Premium</span> to remove ads and get more daily questions!
              </p>
            </div>

            <h3 class="text-xl font-semibold text-gray-800 mb-4">Subscription Management</h3>
            <form @submit.prevent="goToPricingPage" class="space-y-4">
              <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between">
                <select-input v-model="form.subscription_type" :error="form.errors.subscription_type"
                  class="w-full sm:w-2/3 mb-4 sm:mb-0" label="Select Subscription Type">
                  <option :value="1">Free</option>
                  <option :value="2">Pro</option>
                  <option :value="3">Premium</option>
                </select-input>

                <div class="flex space-x-2">
                  <loading-button :loading="form.processing" :disabled="!canUpgrade"
                    class="w-full sm:w-auto px-6 py-3 bg-indigo-400 text-white text-sm font-bold rounded-lg shadow hover:bg-indigo-200 focus:outline-none focus:shadow-outline transition duration-300 ease-in-out"
                    type="submit">
                    Upgrade Subscription
                  </loading-button>
                  <loading-button v-if="user.subscription_type != 1" :loading="cancellingSubscription" @click="cancelSubscription"
                    class="w-full sm:w-auto px-6 py-3 bg-red-400 text-white text-sm font-bold rounded-lg shadow hover:bg-red-200 focus:outline-none focus:shadow-outline transition duration-300 ease-in-out"
                    type="button">
                    Cancel Subscription
                  </loading-button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Advanced Settings Section -->
      <div class="mt-20">
        <div class="bg-white rounded-none shadow-lg overflow-hidden sm:rounded-lg">
          <div class="px-8 py-4 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white">
            <h2 class="text-xl font-medium text-white uppercase tracking-wider font-semibold">Advanced Settings</h2>
          </div>
          <!-- Add your advanced settings content here -->
        </div>
      </div>

      <!-- Active Sessions Section -->
      <div id="active-sessions" class="mt-20">
        <ActiveSessions />
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
        password_confirmation: '',
        photo: null,
        id: this.user.id,
      }),
      passwordError: '',
      passwordConfirmationError: '',
      cancellingSubscription: false,
    }
  },
  computed: {
    subscriptionTypeText() {
      switch (this.user.subscription_type) {
        case '1': return 'Free'
        case '2': return 'Pro'
        case '3': return 'Premium'
        case 1: return 'Free'
        case 2: return 'Pro'
        case 3: return 'Premium'
        default: return 'Unknown'
      }
    },
    canUpgrade() {
      return this.form.subscription_type !== this.user.subscription_type;
    }
  },
  methods: {
    validateAndSubmit() {
      this.passwordError = '';
      this.passwordConfirmationError = '';

      let isValid = true;

      if (this.form.password || this.form.password_confirmation) {
        if (this.form.password.length < 8) {
          this.passwordError = 'Password must be at least 8 characters long.';
          isValid = false;
        }
        if (this.form.password !== this.form.password_confirmation) {
          this.passwordConfirmationError = 'Passwords do not match.';
          isValid = false;
        }
      }

      if (isValid) {
        this.update();
      }
    },
    update() {
      this.form.post(`/profile/${this.user.id}`, {
        preserveScroll: true,
        onSuccess: () => {
          this.form.reset('password', 'password_confirmation', 'photo');
          this.passwordError = '';
          this.passwordConfirmationError = '';
        },
      })
    },
    destroy() {
      if (confirm('Are you sure you want to delete your account? You will only be able to recover your account by contacting support.')) {
        this.$inertia.delete(`/profile/${this.user.id}`)
      }
    },
    goToPricingPage() {
      this.$inertia.visit('/pricing', {
        data: { selectedType: this.form.subscription_type }
      });
    },
    cancelSubscription() {
      if (confirm('Are you sure you want to cancel your subscription? Your subscription type will revert to Free at the end of your current billing period.')) {
        this.cancellingSubscription = true;
        this.$inertia.post('/cancel-subscription', {}, {
          preserveState: true,
          preserveScroll: true,
          onSuccess: () => {
            this.cancellingSubscription = false;
          },
          onError: () => {
            this.cancellingSubscription = false;
          }
        });
      }
    },
  },
}
</script>

<style scoped>
.btn-indigo {
  @apply px-6 py-3 bg-indigo-600 text-white text-sm font-bold rounded shadow hover:bg-indigo-500 focus:outline-none focus:shadow-outline;
}
</style>
