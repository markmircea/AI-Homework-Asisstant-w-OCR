<template>
  <div class="min-h-screen overflow-x-hidden">
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <Head title="History List" />
    <div class="flex flex-col sm:flex-row items-center justify-between mb-6 space-y-4 sm:space-y-0">
      <search-filter v-model="form.search" class="w-full sm:w-64 lg:w-96" @reset="reset">
        <label class="block text-sm font-medium text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
          <option :value="null">All</option>
          <option value="with">Deleted Included</option>
          <option value="only">Deleted Only</option>
        </select>
      </search-filter>
    </div>
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
  <thead class="bg-gradient-to-r from-indigo-400 to-indigo-600 text-white">
    <tr>
      <th scope="col" class="w-1/8 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Title</th>
      <th scope="col" class="w-1/4 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Question</th>
      <th scope="col" class="w-7/12 px-6 py-3 text-left text-xs font-medium text-white uppercase tracking-wider">Answer</th>
      <th scope="col" class="w-1/12 relative px-6 py-3">
        <span class="sr-only">Edit</span>
      </th>
    </tr>
  </thead>
  <tbody class="bg-white divide-y divide-gray-200">
    <tr v-for="announcement in announcements.data" :key="announcement.id" class="hover:bg-gray-50">
      <td class="w-1/8 px-6 py-4 whitespace-nowrap">
        <Link class="flex items-center text-sm font-medium text-gray-900 hover:text-indigo-600" :href="`/history-list/${announcement.id}/edit`">
          <div class="truncate-lines truncate-lines-1">{{ announcement.title }}</div>
          <icon v-if="announcement.deleted_at" name="trash" class="ml-2 h-4 w-4 text-gray-400" />
        </Link>
      </td>
      <td class="w-1/4 px-6 py-4">
        <div class="text-sm text-gray-900 truncate-lines truncate-lines-2">{{ announcement.aiquery }} {{ announcement.extracted_text }}</div>
      </td>
      <td class="w-7/12 px-6 py-4">
        <div class="text-sm text-gray-900 truncate-lines truncate-lines-3">{{ announcement.content }}</div>
      </td>
      <td class="w-1/12 px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <Link :href="`/history-list/${announcement.id}/edit`" class="text-indigo-600 hover:text-indigo-900">
          Edit<span class="sr-only">, {{ announcement.title }}</span>
        </Link>
      </td>
    </tr>
    <tr v-if="announcements.length === 0">
      <td class="px-6 py-4 text-center text-sm text-gray-500" colspan="4">No contacts found.</td>
    </tr>
  </tbody>
</table>
      </div>
    </div>
    <pagination class="mt-6" :links="announcements.links" />
  </div>

</div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Icon from '@/Shared/Icon.vue'
import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout.vue'
import throttle from 'lodash/throttle'
import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination.vue'
import SearchFilter from '@/Shared/SearchFilter.vue'

export default {
  components: {
    Head,
    Icon,
    Link,
    Pagination,
    SearchFilter,
  },
  layout: Layout,
  props: {
    filters: Object,
    announcements: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
      },
    }
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        this.$inertia.get('/history-list', pickBy(this.form), { preserveState: true })
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null)
    },
  },
}
</script>
<style scoped>
/* Add this style to handle the truncation with a maximum of 4 lines */
.truncate-lines {
  display: -webkit-box;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  -webkit-line-clamp: 3; /* Reduced to 2 lines for a more compact look */
  line-clamp: 3;
}


</style>
