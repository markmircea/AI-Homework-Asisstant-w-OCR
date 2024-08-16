<template>
  <div>
    <div id="dropdown" />
    <div class="md:flex md:flex-col">
      <div class="md:flex md:flex-col md:h-screen">
        <div class="md:flex md:flex-shrink-0">
          <div class="flex items-center justify-between px-6 py-4 bg-indigo-900 md:flex-shrink-0 md:justify-center md:w-56">
            <Link class="mt-1" href="/">
              <logo class="fill-white animate-pulse-slow" width="120" height="28" />
            </Link>
            <button @click="toggleMobileMenu" class="md:hidden focus:outline-none">
              <svg :class="{'rotate-90': mobileMenuOpen}" class="w-6 h-6 fill-white transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" />
              </svg>
            </button>
          </div>
          <div class="md:text-md flex items-center justify-between p-4 w-full text-sm  border-b md:px-12 md:py-0">
            <div class="mr-4 mt-1">Easy Ace AI</div>
            <dropdown class="mt-1" placement="bottom-end">
              <template #default>
                <div class="group flex items-center cursor-pointer select-none">
                  <div class="mr-1 text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 whitespace-nowrap">
                    <span class="hidden md:inline">{{ auth.user.first_name }} {{ auth.user.last_name }}</span>
                    <div v-if="auth.user.photo" class="inline-block ml-4 w-8 h-8">
                      <img class="w-full h-full rounded-full" :src="auth.user.photo" :alt="auth.user.first_name + ' ' + auth.user.last_name" />
                    </div>
                    <div v-else class="inline-flex ml-4 w-8 h-8 items-center justify-center rounded-full bg-indigo-500 text-white font-semibold text-sm">
                      {{ getInitials(auth.user.first_name, auth.user.last_name) }}
                    </div>
                  </div>
                  <icon class="w-5 h-5 fill-gray-700 group-hover:fill-indigo-600 focus:fill-indigo-600" name="cheveron-down" />
                </div>
              </template>
              <template #dropdown>
                <div class="mt-2 py-2 text-sm bg-white rounded shadow-xl">
                  <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" :href="`/profile/${auth.user.id}`">My Profile</Link>
                  <Link v-if="auth.user.owner" class="block px-6 py-2 hover:text-white hover:bg-indigo-500" href="/users">Manage Users</Link>
                  <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500" href="/logout" method="delete" as="button">Logout</Link>
                </div>
              </template>
            </dropdown>
          </div>
        </div>
        <div class="md:flex md:flex-grow md:overflow-hidden">
          <!-- Desktop menu -->
          <main-menu :auth="auth" class="hidden flex-shrink-0 p-12 w-56 bg-indigo-800 overflow-y-auto md:block" />

          <!-- Mobile menu overlay -->
          <transition
            enter-active-class="transition-opacity ease-linear duration-300"
            enter-from-class="opacity-0"
            enter-to-class="opacity-100"
            leave-active-class="transition-opacity ease-linear duration-300"
            leave-from-class="opacity-100"
            leave-to-class="opacity-0"
          >
            <div v-show="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-25 z-30" @click="closeMobileMenu"></div>
          </transition>

          <!-- Mobile menu -->
          <transition
            enter-active-class="transition ease-out duration-200"
            enter-from-class="opacity-0 transform -translate-y-full"
            enter-to-class="opacity-100 transform translate-y-0"
            leave-active-class="transition ease-in duration-150"
            leave-from-class="opacity-100 transform translate-y-0"
            leave-to-class="opacity-0 transform -translate-y-full"
          >
            <div v-show="mobileMenuOpen" class="fixed inset-x-0 top-0 z-40 bg-indigo-800 shadow-lg md:hidden" @click.stop>
              <div class="flex items-center justify-between px-4 py-3">
                <Link @click="closeMobileMenu" href="/">
                  <logo class="fill-white" width="120" height="28" />
                </Link>
                <button @click="closeMobileMenu" class="text-white focus:outline-none">
                  <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                  </svg>
                </button>
              </div>
              <div class="px-4 py-6 overflow-y-auto max-h-[calc(100vh-80px)]">
                <main-menu :auth="auth" @linkClicked="closeMobileMenu" />
              </div>
            </div>
          </transition>

          <div class="md:flex-1 md:p-12 md:overflow-y-auto" scroll-region>
            <flash-messages ref="FlashMessages"/>
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue'
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import Logo from '@/Shared/Logo.vue'
import Dropdown from '@/Shared/Dropdown.vue'
import MainMenu from '@/Shared/MainMenu.vue'
import FlashMessages from '@/Shared/FlashMessages.vue'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
    Link,
    Logo,
    MainMenu,
  },
  props: {
    auth: Object,
  },
  setup() {
    const mobileMenuOpen = ref(false)

    const toggleMobileMenu = () => {
      mobileMenuOpen.value = !mobileMenuOpen.value
    }

    const closeMobileMenu = () => {
      mobileMenuOpen.value = false
    }

    return {
      mobileMenuOpen,
      toggleMobileMenu,
      closeMobileMenu,
    }
  },
  methods: {
    getInitials(firstName, lastName) {
      return (firstName.charAt(0) + lastName.charAt(0)).toUpperCase();
    },
  },
}
</script>

<style scoped>
.rotate-90 {
  transform: rotate(90deg);
}
</style>
