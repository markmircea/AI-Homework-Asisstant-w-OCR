<template>
  <div>

    <Head title="Contacts" />
    <h1 class="mb-8 text-3xl font-bold">History List</h1>
    <div class="flex items-center justify-between mb-6">
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">Deleted Included</option>
          <option value="only">Deleted Only</option>
        </select>

      </search-filter>
      <Link class="btn-indigo" href="/ask">
      <span>Ask</span>
      <span class="hidden md:inline">&nbsp;Question</span>
      </Link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-wordwrap ">
        <tr class="text-left font-bold">
          <th class="pb-4 pt-6 px-6">Title</th>
          <th class="pb-4 pt-6 px-6" >Question</th>
          <th class="pb-4 pt-6 px-6" >Answer</th>
          <th class="pb-4 pt-6 px-6" colspan="2" >Details</th>
        </tr>

        <tr v-for="announcement in announcements.data" :key="announcement.id"
          class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <Link class="flex items-center px-6 py-4 focus:text-indigo-500" :href="`/history-list/${announcement.id}/edit`">
            <div class="truncate-lines"> {{ announcement.title }}</div>
            <icon v-if="announcement.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/history-list/${announcement.id}/edit`" tabindex="-1">
           <div class="truncate-lines">{{ announcement.aiquery }}</div>
            </Link>
          </td>
          <td class="border-t">
            <Link class="flex items-center px-6 py-4" :href="`/history-list/${announcement.id}/edit`" tabindex="-1">
            <div class="truncate-lines"> {{ announcement.content }}</div>
            </Link>
          </td>
          <td class="w-px border-t">
            <Link class="flex items-center px-4" :href="`/history-list/${announcement.id}/edit`" tabindex="-1">
            <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
            </Link>
          </td>
        </tr>
        <tr v-if="announcements.length === 0">
          <td class="px-6 py-4 border-t" colspan="4">No contacts found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="announcements.links" />
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
  -webkit-line-clamp: 4;
  /* Limit to 4 lines */

}
</style>
