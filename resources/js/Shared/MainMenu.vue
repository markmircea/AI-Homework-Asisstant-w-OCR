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

    <!-- History Link with Collapsible Submenu -->
     <!-- History Link with Collapsible Submenu -->
     <div class="mb-4">
      <button @click="toggleHistorySubmenu" class="group flex items-center py-3 w-full text-left focus:outline-none">
        <icon name="history" class="mr-2 w-4 h-4" :class="isHistoryActive ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isHistoryActive ? 'text-white' : 'text-indigo-300 group-hover:text-white'">History</div>
        <icon name="cheveron-down" class="ml-auto w-4 h-4 transition-transform duration-200" :class="historySubmenuOpen ? 'transform rotate-180' : 'transform rotate-0'"/>
      </button>
      <transition
        name="fade-slide"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <div v-show="historySubmenuOpen" class="pl-4 mt-2">
          <Link class="group flex items-center text-sm py-2" :class="isExactUrl('history-list') ? 'text-white' : 'text-indigo-300 hover:text-white'" href="/history-list">
            <icon name="list" class="mr-2 w-4 h-4" :class="isExactUrl('history-list') ? 'fill-white' : 'fill-indigo-400'" />
            <div>List</div>
          </Link>
          <Link class="group flex items-center text-sm py-2" :class="isExactUrl('history') ? 'text-white' : 'text-indigo-300 hover:text-white'" href="/history">
            <icon name="card" class="mr-2 w-4 h-4" :class="isExactUrl('history') ? 'fill-white' : 'fill-indigo-400'" />
            <div>Cards</div>
          </Link>
        </div>
      </transition>
    </div>
    <!-- Account Link with Collapsible Submenu -->
    <div class="mb-4">
      <button @click="toggleAccountSubmenu" class="group flex items-center py-3 w-full text-left focus:outline-none">
        <icon name="users" class="mr-2 w-4 h-4" :class="isUrl('profile') ? 'fill-white' : 'fill-indigo-400'" />
        <div :class="isUrl(`profile`) ? 'text-white' : 'text-indigo-300 group-hover:text-white'">Account</div>
        <icon name="cheveron-down" class="ml-auto w-4 h-4 transition-transform duration-200" :class="accountSubmenuOpen ? 'transform rotate-180' : 'transform rotate-0'"/>
      </button>
      <transition
        name="fade-slide"
        @before-enter="beforeEnter"
        @enter="enter"
        @leave="leave"
      >
        <div v-show="accountSubmenuOpen" class="pl-4 mt-2">
          <Link class="group flex items-center text-sm py-2" :class="isUrl(`profile`) ? 'text-white' : 'text-indigo-300 hover:text-white'" :href="`/profile/${auth.user.id}`">
            <icon name="profile" class="mr-2 w-4 h-4" :class="isUrl(`profile`) ? 'text-white' : 'text-white'" />
            <div>Profile</div>
          </Link>
          <Link class="group flex items-center text-sm py-2 text-indigo-300 hover:text-white" href="/billing">
            <icon name="billing" class="mr-2 w-4 h-4 text-white" />
            <div>Billing</div>
          </Link>
          <Link class="group flex items-center text-sm py-2 text-indigo-300 hover:text-white" href="/active-sessions">
            <icon name="active" class="mr-2 w-4 h-4 text-white" />
            <div>Active Sessions</div>
          </Link>
          <Link class="group flex items-center text-sm py-2 text-indigo-300 hover:text-red-500" href="/log-out">
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
      historySubmenuOpen: false,
      accountSubmenuOpen: false,
    }
  },
  computed: {
    isHistoryActive() {
      return this.isUrl('history') || this.isUrl('history-list');
    }
  },
  methods: {
    isUrl(url) {
      const currentUrl = this.$page.url.split('?')[0]; // Remove query parameters
      if (url === '') return currentUrl === '/';
      return currentUrl.startsWith('/' + url);
    },
    isExactUrl(url) {
      const currentUrl = this.$page.url.split('?')[0]; // Remove query parameters
      return currentUrl === '/' + url;
    },
    toggleHistorySubmenu() {
      this.historySubmenuOpen = !this.historySubmenuOpen;
    },
    toggleAccountSubmenu() {
      this.accountSubmenuOpen = !this.accountSubmenuOpen;
    },
    beforeEnter(el) {
      el.style.opacity = 0;
      el.style.transform = 'translateY(-10px)';
    },
    enter(el, done) {
      el.offsetHeight;
      el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      el.style.opacity = 1;
      el.style.transform = 'translateY(0)';
      done();
    },
    leave(el, done) {
      el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
      el.style.opacity = 0;
      el.style.transform = 'translateY(-10px)';
      done();
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
