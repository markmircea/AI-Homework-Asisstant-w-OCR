<template>
  <nav :class="[
    'transition-all duration-300 ease-in-out fixed top-0 left-0 right-0 w-full',
    scrolled ? 'bg-gray-900' : 'bg-transparent'
  ]" style="z-index: 1000;">
    <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
      <div class="relative flex h-16 items-center justify-between">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button-->
          <button @click="toggleMobileMenu" type="button"
            class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-indigo-700 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
            aria-controls="mobile-menu" :aria-expanded="mobileMenuOpen">
            <span class="absolute -inset-0.5"></span>
            <span class="sr-only">Open main menu</span>
            <!-- Icon when menu is closed -->
            <svg :class="{'hidden': mobileMenuOpen, 'block': !mobileMenuOpen}" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
            <!-- Icon when menu is open -->
            <svg :class="{'block': mobileMenuOpen, 'hidden': !mobileMenuOpen}" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
          <Link href="/" class="flex flex-shrink-0 items-center group">
            <icon name="logo" class="h-8 w-auto fill-gray-300 group-hover:fill-indigo-300 animate-pulse-slow transition-colors duration-300" />
            <span class="hidden md:block ml-2 text-xl font-bold text-white group-hover:text-indigo-300 transition-colors duration-300">Easy Ace</span>
          </Link>
          <div class="hidden sm:ml-6 sm:block">
            <div class="flex space-x-4">
              <Link href="/public-ask"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-indigo-700 hover:text-white"
              >
                Ask
              </Link>
              <!-- Subjects Dropdown -->
              <div class="relative" @mouseenter="showSubjects = true" @mouseleave="showSubjects = false">
                <button
                  class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-indigo-700 hover:text-white"
                >
                  Subjects
                  <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                  </svg>
                </button>
                <transition enter-active-class="transition ease-out duration-100"
                  enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100"
                  leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100"
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
              <Link href="/pricing"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-indigo-700 hover:text-white"
              >
                Pricing
              </Link>
              <Link href="/pricing#faq"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-indigo-700 hover:text-white"
              >
                FAQ
              </Link>
              <Link href="/public-ask#contact-us"
                class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-indigo-700 hover:text-white"
              >
                Contact Us
              </Link>

            </div>
          </div>
        </div>
        <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
    <Link href="/login" type="button"
      class="rounded-md mr-2 px-2 py-1 text-xs sm:px-3 sm:py-2 sm:text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition-colors duration-300">
      Sign In
    </Link>
    <Link href="/register" type="button"
      class="rounded-md px-2 py-1 text-xs sm:px-3 sm:py-2 sm:text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-300">
      Sign Up
    </Link>
  </div>
      </div>
    </div>

    <!-- Mobile menu overlay -->
    <transition
      enter-active-class="transition-opacity ease-linear duration-300"
      enter-from-class="opacity-0"
      enter-to-class="opacity-100"
      leave-active-class="transition-opacity ease-linear duration-300"
      leave-from-class="opacity-100"
      leave-to-class="opacity-0"
    >
      <div v-show="mobileMenuOpen" class="fixed inset-0 bg-black bg-opacity-25 z-40" @click="closeMobileMenu"></div>
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
      <div v-show="mobileMenuOpen" class="sm:hidden fixed inset-x-0 top-16 z-50 bg-gray-900 shadow-lg" @click.stop>
        <div class="px-2 pt-2 pb-3 space-y-1">

          <Link href="/public-ask" @click="closeMobileMenu" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">Ask</Link>

          <Link href="/pricing" @click="closeMobileMenu" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">Pricing</Link>
          <Link href="/pricing#faq" @click="closeMobileMenu" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">FAQ</Link>
          <Link href="/public-ask#contact-us" @click="closeMobileMenu" class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">Contact Us</Link>
            <!-- Mobile Subjects Dropdown -->
           <div class="relative">
            <button @click="toggleMobileSubjects" class="w-full text-left block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">
              Subjects
              <svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
              </svg>
            </button>
            <div v-show="showMobileSubjects" class="mt-2 space-y-1">
              <a v-for="subject in subjects" :key="subject" @click.prevent="selectSubject(subject); closeMobileMenu();" class="block pl-6 py-2 text-base font-medium text-gray-300 hover:bg-indigo-700 hover:text-white">
                {{ subject }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </transition>
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
      showSubjects: false,
      showMobileSubjects: false
    }
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
      closeMobileMenu
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
    toggleMobileSubjects() {
      this.showMobileSubjects = !this.showMobileSubjects;
    }
  }
}
</script>

<style scoped>
.glow-container {
  position: relative;
}

.glow-container::after {
  content: '';
  position: absolute;
  top: -5px;
  left: -5px;
  right: -5px;
  bottom: -5px;
  border-radius: 50%;
  background-color: rgba(79, 70, 229, 0.4);
  filter: blur(10px);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.group:hover .glow-container::after {
  opacity: 1;
}

.glow-text {
  position: relative;
}

.glow-text::after {
  content: 'Easy Ace';
  position: absolute;
  top: 0;
  left: 0;
  color: #818cf8;
  filter: blur(4px);
  opacity: 0;
  transition: opacity 0.3s ease;
}

.group:hover .glow-text::after {
  opacity: 1;
}

nav {
  z-index: 1000;
}

.absolute {
  z-index: 1001;
}
</style>
