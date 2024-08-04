<template>

  <nav :user="user" :class="[
    'transition-all duration-300 ease-in-out',
    scrolled ? 'bg-gray-800 sticky top-0' : 'bg-transparent'
  ]" style="z-index: 1000;">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button type="button"
            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            aria-controls="mobile-menu" aria-expanded="false">
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
              <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
              <Link href="/"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Dashboard</Link>
              <!-- Subjects Dropdown -->
              <div class="relative group">
                <button
                  class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                  Subjects
                  <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
                <div
                  class="absolute left-0 w-48 mt-2 origin-top-left bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 opacity-0 scale-95 transition-all duration-200 ease-out group-hover:opacity-100 group-hover:scale-100"
                  style="z-index: 1001;">
                  <div class="py-1" role="menu" aria-orientation="vertical" aria-labelledby="options-menu">
                    <a v-for="subject in subjects" :key="subject" @click.prevent="selectSubject(subject)"
                      class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900 cursor-pointer"
                      role="menuitem">
                      {{ subject }}
                    </a>
                  </div>
                </div>
              </div>



              <Link href="/pricing"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Pricing</Link>
              <Link href="/pricing#contact-us"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
              Contact Us</Link>
            </div>
          </div>

        </div>
        <div class="inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
          <!-- Notification Button -->
          <button type="button"
            class="relative rounded-full  p-1 text-gray-400 hover:outline-none hover:ring-2 hover:ring-white ">
            <span class="absolute -inset-1.5"></span>
            <span class="sr-only">View notifications</span>
            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
              aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round"
                d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
            </svg>
          </button>





          <!-- Profile dropdown -->
          <div class="relative ml-3 group">
            <div>
              <button type="button"
                class="relative flex rounded-full bg-indigo-800 text-sm focus:outline-none hover:ring-2 hover:ring-white hover:ring-offset-2 hover:ring-offset-gray-800">
                <span class="absolute -inset-1.5"></span>
                <span class="sr-only">Open user menu</span>
                <img v-if="user.photo" class="h-8 w-8 rounded-full" :src="user.photo" alt="User photo" />
                <div v-else class="h-8 w-8 rounded-full bg-gray-500 flex items-center justify-center text-white">
                  {{ user.name ? user.name.charAt(0).toUpperCase() : 'U' }}
                </div>
              </button>
            </div>

            <!-- Dropdown menu -->
            <div
              class="absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md bg-white py-1 shadow-lg ring-1 ring-black ring-opacity-5 opacity-0 scale-95 transition-all duration-200 ease-out group-hover:opacity-100 group-hover:scale-100">
              <a @click="goToProfile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                role="menuitem" tabindex="-1" id="user-menu-item-0">Your Profile</a>
              <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem" tabindex="-1"
                id="user-menu-item-1">Settings</a>
              <a @click="logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer"
                role="menuitem" tabindex="-1" id="user-menu-item-2">Sign out</a>
            </div>
          </div>



        </div>
      </div>
    </div>

    <!-- Mobile menu -->
    <div class="sm:hidden" id="mobile-menu">
      <div class="space-y-1 px-2 pb-3 pt-2">
        <Link href="/"
          class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
        Dashboard</Link>
        <Link href="/subjects"
          class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
        Subjects</Link>
        <Link href="/pricing"
          class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
        Pricing</Link>
        <Link href="/pricing#contact-us"
          class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
        Contact Us</Link>
      </div>
    </div>
  </nav>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '../../Shared/Icon.vue';



export default {
  name: 'Nav',
  components: {
    Link,
    Icon
  },

  data() {
    return {
      scrolled: false,
      subjects: ['Biology', 'Chemistry', 'Computer Science', 'Economics', 'English', 'Geography', 'History', 'Mathematics', 'Physics', 'Science']

    }
  },

  props: {
    user: {
      type: Object,
      required: true,
    },
  },
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
  },

  beforeUnmount() {
    window.removeEventListener('scroll', this.handleScroll);
  },

  methods: {

    selectSubject(subject) {
      this.$inertia.get('/index', { subject: subject }, {
        preserveState: true,
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
      this.$inertia.visit(`/users/${userId}/edit`);
    },

    logout() {
      Inertia.delete('/logout', {
        onFinish: () => {
          window.location.href = '/'; // Redirect to home or login page
        }
      })
    }
  }
};
</script>
<style scoped>
nav {
  z-index: 1000;
}

.group:hover .absolute {
  display: block;
}

.absolute {
  display: none;
}

.group:hover::after {
  content: '';
  position: absolute;
  left: 0;
  right: 0;
  top: 100%;
  height: 20px;
}

/* Styles for different background states */
nav.bg-transparent .text-gray-300 {
  color: rgba(255, 255, 255, 0.8);
}

nav.bg-transparent .text-gray-400 {
  color: rgba(255, 255, 255, 0.6);
}

nav.bg-transparent .text-white {
  color: white;
}

nav.bg-gray-800 .text-gray-300 {
  color: #d1d5db;
}

nav.bg-gray-800 .text-gray-400 {
  color: #9ca3af;
}

nav.bg-gray-800 .text-white {
  color: white;
}
</style>
