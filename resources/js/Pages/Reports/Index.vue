<template>
  <div>
    <Head title="Reports" />
    <h1 class="mb-8 text-3xl font-bold">Reports</h1>

    <div class="flex items-center justify-between mb-6">
      <!-- Search and trashed filter -->
      <search-filter v-model="form.search" class="mr-4 w-full max-w-md" @reset="reset">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="form.trashed" class="form-select mt-1 w-full">
          <option :value="null" />
          <option value="with">Deleted Included</option>
          <option value="only">Deleted Only</option>
        </select>
        <select v-model="form.hired" class="form-select mt-1 w-full">
          <option :value="null" />
           <option value="with">Hired Included</option>
           <option value="only">Hired Only</option>
        </select>
      </search-filter>

      <!-- Strengths filter -->
      <div class="mr-4 w-full max-w-md">
        <label for="strengths" class="block text-gray-700">Strengths:</label>
        <select id="strengths" v-model="form.strengths" multiple class="form-multiselect mt-1 block w-full">
          <option v-for="strength in strengths" :key="strength" :value="strength">{{ strength }}</option>

        </select>
      </div>

      <!-- Create contact button -->
      <Link class="btn-indigo" href="/contacts/create">
        <span>Create</span>
        <span class="hidden md:inline">&nbsp;Contact</span>
      </Link>
    </div>

    <!-- Table for displaying contacts -->
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="min-w-full whitespace-nowrap">
        <thead>
          <tr class="text-left font-bold">
            <th class="pb-4 pt-6 px-6" v-resizable>Name</th>
            <th class="pb-4 pt-6 px-6" v-resizable>Organization</th>
            <th class="pb-4 pt-6 px-6" v-resizable>Description</th>
            <th class="pb-4 pt-6 px-6" v-resizable>Soft Skills</th>
            <th class="pb-4 pt-6 px-6" v-resizable>Strengths</th>
            <th class="pb-4 pt-6 px-6" v-resizable>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="contact in contacts.data" :key="contact.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
            <td class="border-t">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center px-6 py-4 focus:text-indigo-500">
                {{ contact.first_name }}  {{  contact.last_name }}
                <icon v-if="contact.deleted_at" name="trash" class="shrink-0 ml-2 w-3 h-3 fill-gray-400" />
                <icon v-if="contact.hired_on" name="checkmark" class="shrink-0 ml-2 w-3 h-3 fill-green-500" />

              </Link>
            </td>
            <td class="border-t">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center px-6 py-4" tabindex="-1">
                <div v-if="contact.organization">
                  {{ contact.organization.name }}
                </div>
              </Link>
            </td>
            <td class="border-t max-w-xs whitespace-nowrap overflow-hidden overflow-ellipsis px-6 py-4">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center" tabindex="-1">
                {{ contact.description }}
              </Link>
            </td>
            <td class="border-t">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center px-6 py-4" tabindex="-1">
                <template v-if="contact.soft_skills">
                  <ul>
                    <li v-for="skill in JSON.parse(contact.soft_skills)" :key="skill">{{ skill }}</li>
                  </ul>
                </template>
              </Link>
            </td>
            <td class="border-t">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center px-6 py-4" tabindex="-1">
                <template v-if="contact.strengths">
                  <ul>
                    <li v-for="strength in JSON.parse(contact.strengths)" :key="strength">{{ strength }}</li>
                  </ul>
                </template>
              </Link>
            </td>
            <td class="w-px border-t">
              <Link :href="`/reports/${contact.id}/edit`" class="flex items-center px-4" tabindex="-1">
                <icon name="cheveron-right" class="block w-6 h-6 fill-gray-400" />
              </Link>
            </td>
          </tr>
          <tr v-if="contacts.data.length === 0">
            <td class="px-6 py-4 border-t" colspan="6">No contacts found.</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Pagination component -->
    <pagination class="mt-6" :links="contacts.links" />
  </div>
</template>

<script>
import { Head, Link } from '@inertiajs/vue3';
import Icon from '@/Shared/Icon.vue';
import pickBy from 'lodash/pickBy';
import Layout from '@/Shared/Layout.vue';
import throttle from 'lodash/throttle';
import mapValues from 'lodash/mapValues';
import Pagination from '@/Shared/Pagination.vue';
import SearchFilter from '@/Shared/SearchFilter.vue';

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
    contacts: Object,
  },
  data() {
    return {
      form: {
        search: this.filters.search,
        trashed: this.filters.trashed,
        strengths: [], // Array to hold selected strengths
      },
      strengths: ['PHP', 'Laravel', 'Angular', 'React', 'Python', 'Vue.js', 'TailwindCSS', 'Wordpress'], // List of available strengths
    };
  },
  watch: {
    form: {
      deep: true,
      handler: throttle(function () {
        // Make API call to update contacts based on form data
        this.$inertia.get('/reports', pickBy(this.form), { preserveState: true });
      }, 150),
    },
  },
  methods: {
    reset() {
      this.form = mapValues(this.form, () => null);
    },
  },
};
</script>

<style scoped>
/* Add scoped styles here */
</style>
