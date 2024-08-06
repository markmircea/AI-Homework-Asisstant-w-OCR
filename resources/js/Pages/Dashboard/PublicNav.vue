<template>
  <nav :class="[
    'transition-all duration-300 ease-in-out',
    scrolled ? 'bg-gray-800 sticky top-0' : 'bg-transparent'
  ]" style="z-index: 1000;">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button @click="toggleMobileMenu" type="button"
            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Icon when menu is closed -->
            <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Icon when menu is open -->
            <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <div class="flex flex-shrink-0 items-center">
            <icon name="logo" class="h-8 w-auto fill-gray-300" />

          </div>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <a href="index-no-auth"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white"
                aria-current="page">Dashboard</a>
              <a href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
              <!-- Subjects Dropdown -->
              <div class="relative"
     @mouseenter="showSubjects = true"
     @mouseleave="showSubjects = false">
  <button
    class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
    Subjects
    <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
      xmlns="http://www.w3.org/2000/svg">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
    </svg>
  </button>
  <transition
    enter-active-class="transition ease-out duration-100"
    enter-from-class="transform opacity-0 scale-95"
    enter-to-class="transform opacity-100 scale-100"
    leave-active-class="transition ease-in duration-75"
    leave-from-class="transform opacity-100 scale-100"
    leave-to-class="transform opacity-0 scale-95">
    <div v-if="showSubjects"
      class="absolute left-0 w-48 mt-2 origin-top-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5"
      style="z-index: 1001;">
      <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
        <a v-for="subject in subjects" :key="subject" @click.prevent="selectSubject(subject)"
          class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
          role="menuitem">
          {{ subject }}
        </a>
      </div>
    </div>
  </transition>
</div>
              <a href="#"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>

              <Link href="/public-ask"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Public Ask
              </Link>
            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <!-- Conditional rendering based on authentication -->
          <a href="/login" type="button"
            class="rounded-md mr-1 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Sign In
          </a>
          <!-- Conditional rendering based on authentication -->
          <a href="/register" type="button"
            class="rounded-md bg-blue-600 px-3 py-2 text-sm font-medium text-white hover:bg-blue-700">
            Sign Up
          </a>



        </div>
      </div>

      <!-- Mobile menu -->
      <div class="sm:hidden" id="mobile-menu" v-show="mobileMenuOpen">
        <div class="space-y-1 px-2 pb-3 pt-2">
          <a href="/index-no-auth" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
            aria-current="page">Dashboard</a>
          <a href="#"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Team</a>
          <a href="#"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Projects</a>
          <a href="#"
            class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">Calendar</a>
        </div>
      </div>
    </div>
  </nav>
</template>

<script>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    Link,
    Icon
  },

  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },

  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },
  data() {
    return {
      scrolled: false,
      subjects: ['Biology', 'Chemistry', 'Computer Science', 'Economics', 'English', 'Geography', 'History', 'Mathematics', 'Physics', 'Science'],
      showSubjects: false


    }
  },
  setup() {
    const mobileMenuOpen = ref(false)
    const toggleMobileMenu = () => {
      mobileMenuOpen.value = !mobileMenuOpen.value
    }

    return {
      mobileMenuOpen,
      toggleMobileMenu
    }
  },
  methods: {

    selectSubject(subject) {
      this.$inertia.get('/public-ask', { subject: subject }, {
        preserveState: false,
        preserveScroll: false,
        only: ['selectedSubject']
      });
    },


    handleScroll() {
      this.scrolled = window.scrollY > 0;
    },
    goToProfile() {
      // Construct the URL using the user ID
      const userId = this.user.id;
      // Use Inertia to navigate
      this.$inertia.visit(`/profile/${userId}`);
    },

    logout() {
      this.$inertia.get('/log-out', {
        onFinish: () => {
          window.location.href = '/'; // Redirect to home or login page
        }
      })
    }
  }
}
</script>
