<template>
  <div>
    <!-- Dashboard Link -->
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/">
        <icon name="dashboard" class="mr-2 w-4 h-4" :class="isUrl('') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl('') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Dashboard</div>
      </Link>
    </div>

    <!-- Organizations Link -->
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/ask">
        <icon name="question" class="mr-2 w-4 h-4" :class="isUrl('ask') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl('ask') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Ask</div>
      </Link>
    </div>

    <!-- History List Link -->
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/history-list">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('history-list') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl('history-list') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">History List</div>
      </Link>
    </div>



    <!-- History Link -->
    <div class="mb-4">
      <Link class="group flex items-center py-3" href="/history">
        <icon name="history" class="mr-2 w-4 h-4" :class="isUrl('history') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl('history') ? 'text-white' : 'text-indigo-300 group-hover:text-white'">History</div>
      </Link>
    </div>


  <!-- Reports Link with Collapsible Submenu -->
  <div class="mb-4">
      <button @click="toggleSubmenu" class="group flex items-center py-3 w-full text-left focus:outline-none">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('users') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl(`users/${auth.user.id}/edit`) ? 'text-white' : 'text-indigo-300  group-hover:text-white'">Account</div>
        <icon name="cheveron-down" class="ml-auto w-4 h-4 transition-transform duration-200" :class="submenuOpen ? 'transform rotate-180' : 'transform rotate-0'"/>
      </button>
      <transition
        name="fade-slide"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <div v-show="submenuOpen" class="pl-4 mt-2">
          <Link class="group flex items-center text-sm py-2" :class="isUrl(`users/${auth.user.id}/edit`) ? 'text-white' : 'text-indigo-300  hover:text-white'" :href="`/users/${auth.user.id}/edit`">
            <icon name="profile" class="mr-2 w-4 h-4" :class="isUrl(`users/${auth.user.id}/edit`) ? 'text-white' : 'text-white'" />
            <div>Profile</div>
          </Link>          <Link class="group flex items-center text-sm py-2 text-indigo-300  hover:text-white" href="/logout">
        <icon name="billing" class="mr-2 w-4 h-4 text-red-500" />
        <div>Billing</div>
      </Link>
             <Link class="group flex items-center text-sm py-2 text-indigo-300  hover:text-white" href="/logout">
        <icon name="active" class="mr-2 w-4 h-4 text-red-500" />
        <div>Active Sessions</div>
      </Link>
          <Link class="group flex items-center text-sm py-2 text-indigo-300  hover:text-red-500" href="/log-out">
        <icon name="signout" class="mr-2 w-4 h-4 text-red-500" />
        <div>Sign Out</div>
      </Link>

        </div>
      </transition>
    </div>




  </div>



</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'

export default {
  components: {
    Icon,
    Link,
  },
  props: {
    coins: Number,
    auth: Object,
  },
  data() {
    return {
      submenuOpen: false,
    }
  },
  methods: {
    isUrl(url) {
    // Get the current path from the URL
    const currentUrl = this.$page.url.replace(/^\/|\/$/g, ''); // Normalize URL by removing leading/trailing slashes
    // Check if the current URL matches exactly or starts with the given URL
    return currentUrl === url || currentUrl.startsWith(`${url}/`);
  },
    toggleSubmenu() {
      this.submenuOpen = !this.submenuOpen
    },
    beforeEnter(el) {
      el.style.opacity = 0
      el.style.transform = 'translateY(-10px)'
    },
    enter(el, done) {
      el.offsetHeight // trigger reflow
      el.style.transition = 'opacity 0.5s ease, transform 0.5s ease'
      el.style.opacity = 1
      el.style.transform = 'translateY(0)'
      done()
    },
    leave(el, done) {
      el.style.transition = 'opacity 0.5s ease, transform 0.5s ease'
      el.style.opacity = 0
      el.style.transform = 'translateY(-10px)'
      done()
    }
  }
}
</script>

<style scoped>
/* Transition styles */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: opacity 0.7s ease, transform 0.7s ease, max-height 0.7s ease;
}
.fade-slide-enter,
.fade-slide-leave-to /* .fade-slide-leave-active in <2.1.8 */ {
  opacity: 0;
  transform: translateY(-10px);
  max-height: 0;
}
</style>
