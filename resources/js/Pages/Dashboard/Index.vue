<template>
    <div>
    <Head title="Dashboard" />
    <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
    <div>

      <p>You have {{ coins }} coins.</p>
    </div>
  </div>
</template>

<script setup>
import { defineProps, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';


const props = defineProps({
  coins: {
    type: Number,
    required: true,
  },
});

onMounted(() => {
  console.log('Coins in Dashboard:', props.coins); // Debug statement
});
</script>


<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'

export default {
  components: {
    Head,
  },
  layout: Layout,
}
</script>
