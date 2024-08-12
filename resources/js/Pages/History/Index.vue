<template>
  <div class="bg-white rounded-md shadow overflow-hidden">
    <div class="px-4 sm:px-6 py-4 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white border-gray-200">
      <h1 class="text-xs font-medium text-white uppercase tracking-wider font-semibold">History</h1>
    </div>
    <div class="p-4 sm:p-6">
      <div class="bg-gray-50 border border-gray-200 rounded-md p-4 mb-6">
        <p class="text-sm sm:text-base">Hi {{ user.first_name }}! Welcome to your dashboard, here are some of your historic items.</p>
      </div>



      <draggable :list="paginatedAnnouncements" @update="updateOrder" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
        <div v-for="announcement in paginatedAnnouncements" :key="announcement.id"
          class="bg-white border border-gray-200 rounded-md shadow-sm overflow-hidden"
          :class="{ 'col-span-1 sm:col-span-2 lg:col-span-3': !announcement.collapsed }"
          @dblclick="showEditModal(announcement)">
          <div class="p-4">
            <div class="flex justify-between items-start mb-2">
              <h3 class="text-sm font-medium text-gray-900">{{ announcement.title }}</h3>
              <p class="text-xs text-gray-500">{{ formatDate(announcement.created_at) }}</p>
            </div>

            <p class="text-xs text-gray-600 mb-2">Subject: {{ announcement.subject }}</p>

            <div class="text-sm text-gray-700 mb-2">
              <p class="font-medium">Question:</p>
              <p class="line-clamp-2">{{ announcement.aiquery }}{{ announcement.extracted_text }}</p>
            </div>

            <div class="text-sm text-gray-700 mb-2">
              <p class="font-medium">Answer:</p>
              <p class="line-clamp-2">{{ announcement.content }}</p>
            </div>

            <div v-if="!announcement.collapsed" class="mt-4">
              <template v-if="announcement.file_type === 'image'">
                <img v-if="announcement.photo"
                  class="w-full sm:w-48 h-auto rounded-md cursor-pointer mb-4"
                  :src="announcement.photo"
                  @click="expandImage(announcement)" />
              </template>
              <template v-else-if="announcement.file_type">
                <div class="mb-4">
                  <a :href="announcement.file_url" download :class="'px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition-colors inline-flex items-center'">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download {{ announcement.file_name }} ({{ announcement.file_type }})
                  </a>
                </div>
              </template>

              <p class="text-sm text-gray-700 mb-2 mt-10">{{ announcement.content }}</p>
              <p class="text-sm text-gray-700 mt-10">{{ announcement.aiquery }}{{ announcement.extracted_text }}</p>
            </div>

            <div class="flex justify-end mt-4 space-x-2">
              <button @click="showEditModal(announcement)" class="px-3 py-1 bg-indigo-600 text-white text-xs rounded-md hover:bg-indigo-700 transition-colors">Edit</button>
              <button @click="destroy(announcement.id)" class="px-3 py-1 bg-red-600 text-white text-xs rounded-md hover:bg-red-700 transition-colors">Delete</button>
            </div>
          </div>

          <button @click="toggleCollapse(announcement)" class="w-full px-4 py-2 text-sm text-gray-700 bg-gray-50 hover:bg-gray-100 transition-colors">
            {{ announcement.collapsed ? 'Expand' : 'Collapse' }}
          </button>
        </div>
      </draggable>

      <!-- Pagination Controls -->
      <div class="mt-6 flex flex-wrap justify-center items-center space-x-1 space-y-1">
        <button @click="goToPage(currentPage - 1)" :disabled="currentPage <= 1" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 transition-colors disabled:opacity-50">Previous</button>
        <button v-for="number in pageNumbers" :key="number" @click="goToPage(number)"
          :class="{ 'bg-indigo-600 text-white': number === currentPage, 'bg-gray-200 text-gray-700': number !== currentPage }"
          class="px-3 py-1 rounded-md text-sm hover:bg-indigo-700 transition-colors">
          {{ number }}
        </button>
        <button @click="goToPage(currentPage + 1)" :disabled="currentPage >= totalPages" class="px-3 py-1 bg-gray-200 text-gray-700 rounded-md text-sm hover:bg-gray-300 transition-colors disabled:opacity-50">Next</button>
      </div>

      <p class="mt-4 text-center text-sm text-gray-700">You have {{ coins }} coins.</p>
    </div>

    <!-- Modals -->
    <Modal :visible="OCRModalVisible" @close="toggleOCRModal">
      <OCR @submitted="toggleOCRModal" />
    </Modal>
    <Modal :visible="isEditModalVisible" @close="hideEditModal">
      <EditAnnouncement :announcement="selectedAnnouncement" @submitted="hideEditModal" />
    </Modal>

    <!-- Enlarged Image Modal using Teleport -->
    <teleport to="body">
      <div v-if="enlargedImage"
           class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50"
           @click="closeEnlargedImage">
        <img :src="enlargedImage"
             class="max-w-full max-h-full object-contain"
             @click.stop />
        <button
          @click="closeEnlargedImage"
          class="absolute top-4 right-4 text-white text-4xl"
          aria-label="Close enlarged image"
        >
          &times;
        </button>
      </div>
    </teleport>
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Modal from '@/Shared/Modal.vue'
import EditAnnouncement from '@/Pages/History/Edit.vue'
import OCR from '@/Pages/History/OCR.vue'
import { VueDraggableNext } from 'vue-draggable-next'

export default {
  props: {
    coins: Number,
    user: Object,
    announcements: Array,
  },

  data() {
    return {
      isEditModalVisible: false,
      OCRModalVisible: false,
      selectedAnnouncement: null,
      localAnnouncements: [...this.announcements].map(announcement => ({
        ...announcement,
        collapsed: true,
        file_type: this.getFileType(announcement),
        file_name: this.getFileName(announcement),
        file_url: announcement.photo, // Assuming the file URL is stored in the 'photo' field
      })),
      currentPage: 1,
      itemsPerPage: 12,
      enlargedImage: null
    }
  },

  components: {
    Head,
    Modal,
    EditAnnouncement,
    OCR,
    draggable: VueDraggableNext,
  },

  computed: {
    paginatedAnnouncements() {
      const start = (this.currentPage - 1) * this.itemsPerPage;
      const end = start + this.itemsPerPage;
      return this.localAnnouncements.slice(start, end);
    },
    totalPages() {
      return Math.ceil(this.localAnnouncements.length / this.itemsPerPage);
    },
    pageNumbers() {
      const total = this.totalPages;
      const numbers = [];
      let start = Math.max(1, this.currentPage - 4);
      let end = Math.min(total, this.currentPage + 4);

      if (start > 1) {
        numbers.push(1);
        if (start > 2) numbers.push('...');
      }

      for (let i = start; i <= end; i++) {
        numbers.push(i);
      }

      if (end < total) {
        if (end < total - 1) numbers.push('...');
        numbers.push(total);
      }

      return numbers;
    }
  },

  layout: Layout,

  methods: {
    toggleCollapse(announcement) {
      announcement.collapsed = !announcement.collapsed;
    },
    toggleOCRModal() {
      this.OCRModalVisible = !this.OCRModalVisible;
    },
    showEditModal(announcement) {
      this.selectedAnnouncement = announcement;
      this.isEditModalVisible = true;
    },
    hideEditModal() {
      this.isEditModalVisible = false;
      this.selectedAnnouncement = null;
    },
    destroy(id) {
      if (confirm('Are you sure you want to delete this announcement?')) {
        this.$inertia.delete(`/history/${id}`)
      }
    },
    updateOrder() {
      this.$inertia.post('/history/update-order', {
        announcements: this.localAnnouncements.map((announcement, index) => ({
          id: announcement.id,
          order: index
        }))
      });
    },
    expandImage(announcement) {
      this.enlargedImage = announcement.photo;
      document.body.style.overflow = 'hidden'; // Prevent scrolling when image is enlarged
    },
    closeEnlargedImage() {
      this.enlargedImage = null;
      document.body.style.overflow = ''; // Restore scrolling
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    },
    getFileType(announcement) {
      if (announcement.photo) {
        const extension = announcement.photo.split('.').pop().toLowerCase();
        if (['jpg', 'jpeg', 'png', 'gif', 'bmp'].includes(extension)) {
          return 'image';
        }
        return extension;
      }
      return null;
    },
    getFileName(announcement) {
      if (announcement.photo) {
        return announcement.photo.split('/').pop();
      }
      return 'file';
    },
  },

  watch: {
    announcements: {
      handler(newAnnouncements) {
        this.localAnnouncements = newAnnouncements.map(announcement => ({
          ...announcement,
          collapsed: true,
          file_type: this.getFileType(announcement),
          file_name: this.getFileName(announcement),
          file_url: announcement.photo,
        }));
      },
      deep: true,
    }
  }
}
</script>

<style scoped>
/* No additional styles needed */
</style>
