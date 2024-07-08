<template>
    <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <div>
      <h2>Hi {{ user.first_name }}! Welcome to your dashboard, here are some announcements. </h2>

      <DIV/>
      <p>You have {{ coins }} coins.</p>
    </div>
  </div>
</template>




<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

export default {
  props: {
    coins: Number,
    user: Object
  },





  components: {
    Head,
  },
  layout: Layout,
}
</script>
