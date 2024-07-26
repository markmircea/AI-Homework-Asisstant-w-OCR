<template>
  <div class="container mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
      <Head title="History" />
      <div>
        <h1 class="mb-8 text-3xl font-bold">History</h1>
        <h2 class="p-4 border rounded-lg text-sm sm:text-base">Hi {{ user.first_name }}! Welcome to your dashboard, here are some of your historic.</h2>
        <div class="flex flex-col sm:flex-row justify-between items-center mb-4 p-4">
          <button @click="toggleOCRModal" class="btn-indigo w-full sm:w-auto mb-2 sm:mb-0">Analyze</button>
        </div>

        <draggable :list="paginatedAnnouncements" @update="updateOrder" class="grid gap-4 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3">
          <div v-for="announcement in paginatedAnnouncements" :key="announcement.id"
            :class="['announcement', { 'announcement-expanded': !announcement.collapsed }]"
            class="p-4 border rounded-lg shadow cursor-move" @dblclick="showEditModal(announcement)">
            <div class="flex flex-col h-full">
              <div class="flex-1">
                <p class="announcement-title text-sm sm:text-base">{{ announcement.title }}</p>
                <p class="text-gray-500 text-xs sm:text-sm">Created at: {{ formatDate(announcement.created_at) }}</p>

                <div v-if="!announcement.collapsed" class="mt-4">
                  <img v-if="announcement.photo" class="rounded-lg shadow w-full sm:w-48 h-auto cursor-pointer"
                    :src="expandedImageUrl(announcement)"
                    @click="expandImage(announcement)" :class="{ 'expanded': announcement.expanded }" />

                  <p class="mt-4 text-sm sm:text-base">{{ announcement.title }}</p>
                  <h3 class="font-bold text-lg sm:text-xl mt-2">{{ announcement.content }}</h3>
                  <p class="text-gray-500 text-xs sm:text-sm mt-2">Subject: {{ announcement.subject }}</p>
                  <p class="text-gray-500 text-xs sm:text-sm mt-2">Extracted Text: {{ announcement.extracted_text }}</p>
                </div>
              </div>

              <div class="flex flex-col sm:flex-row justify-center items-center space-y-2 sm:space-y-0 sm:space-x-2 mt-4">
                <button @click="showEditModal(announcement)" class="btn-indigo w-full sm:w-auto">Edit</button>
                <button @click="destroy(announcement.id)" class="btn-red w-full sm:w-auto">Delete</button>
              </div>
              <Icon class="center-icon mt-2" name="drag-drop"/>

              <Icon @click="toggleCollapse(announcement)"
                :class="['btn-arrow small-icon mt-2', { 'icon-collapsed': announcement.collapsed, 'icon-expanded': !announcement.collapsed }]"
                :name="announcement.collapsed ? 'cheveron-down' : 'cheveron-up'" />
            </div>
          </div>
        </draggable>

        <!-- Pagination Controls -->
        <div class="pagination-controls mt-8 flex flex-wrap justify-center items-center space-x-2 space-y-2">
          <button @click="goToPage(currentPage - 1)" :disabled="currentPage <= 1" class="w-full sm:w-auto">Previous</button>
          <div class="page-numbers flex flex-wrap justify-center space-x-1 space-y-1">
            <button v-for="number in pageNumbers" :key="number" @click="goToPage(number)"
              :class="{ 'active': number === currentPage }" class="w-8 h-8 sm:w-10 sm:h-10">
              {{ number }}
            </button>
          </div>
          <button @click="goToPage(currentPage + 1)" :disabled="currentPage >= totalPages" class="w-full sm:w-auto">Next</button>
        </div>

        <p class="mt-4 text-center">You have {{ coins }} coins.</p>
      </div>

      <!-- Modals -->
      <Modal :visible="OCRModalVisible" @close="toggleOCRModal">
        <OCR @submitted="toggleOCRModal" />
      </Modal>
      <Modal :visible="isEditModalVisible" @close="hideEditModal">
        <EditAnnouncement :announcement="selectedAnnouncement" @submitted="hideEditModal" />
      </Modal>
    </div>
  </div>
</template>


<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import Modal from '@/Shared/Modal.vue'
import EditAnnouncement from '@/Pages/History/Edit.vue'
import OCR from '@/Pages/History/OCR.vue'

import { VueDraggableNext } from 'vue-draggable-next'
import Icon from '@/Shared/Icon.vue' // Import the Icon component



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
        expanded: false // Initialize expanded state for each announcement
      })),
      currentPage: 1, // Track the current page
      itemsPerPage: 12 // Number of items per page
    }
  },

  components: {
    Head,
    Modal,
    EditAnnouncement,
    OCR,
    draggable: VueDraggableNext,
    Icon
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
    showCreateModal() {
      this.isCreateModalVisible = true;
    },
    hideCreateModal() {
      this.isCreateModalVisible = false;
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
      announcement.expanded = !announcement.expanded; // Toggle expanded state
    },
    expandedImageUrl(announcement) {
      // Check if announcement is expanded and modify URL accordingly
      if (announcement.expanded) {
        return announcement.photo.replace(/&?w=400&h=400&fit=crop$/, '');
      } else {
        return announcement.photo;
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleString();
    },
    goToPage(page) {
      if (page >= 1 && page <= this.totalPages) {
        this.currentPage = page;
      }
    }
  },

  watch: {
    announcements: {
      handler(newAnnouncements) {
        this.localAnnouncements = newAnnouncements.map(announcement => ({
          ...announcement,
          collapsed: true,
          expanded: false // Reset expanded state when announcements change
        }));
      },
      deep: true,
    }
  }
}
</script>
<style scoped>
/* Tailwind CSS classes are used inline in the HTML */

/* Custom CSS */
.container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  @apply p-8 rounded-2xl;
}

.announcement, .border {
  background-color: rgba(255, 255, 255, 0.95);
  @apply rounded-2xl shadow-lg transition-all duration-300 ease-in-out;
}

.announcement:hover, .border:hover {
  @apply transform -translate-y-1 shadow-xl;
}

.btn-indigo, .btn-red, .pagination-controls button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  @apply border-none rounded-lg text-white font-semibold py-3 px-6 transition-all duration-300 ease-in-out;
}

.btn-indigo:hover, .btn-red:hover, .pagination-controls button:hover:not(:disabled) {
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
  @apply transform -translate-y-0.5 shadow-md;
}

.btn-red {
  background: linear-gradient(135deg, #f87171 0%, #dc2626 100%);
}

.btn-red:hover {
  background: linear-gradient(135deg, #dc2626 0%, #f87171 100%);
}

.announcement-title {
  @apply font-semibold text-gray-700 line-clamp-2;
}

.pagination-controls button:disabled {
  @apply bg-gray-300 cursor-not-allowed;
}

.page-numbers button {
  @apply bg-white text-indigo-500 border border-indigo-500 py-2 px-4 rounded-lg;
}

.page-numbers button.active {
  @apply bg-indigo-500 text-white;
}

.btn-arrow {
  @apply text-gray-600 transition-all duration-300 ease-in-out;
}

.btn-arrow:hover {
  @apply text-indigo-500;
}

.small-icon {
  @apply w-6 h-6;
}

img {
  @apply rounded-lg transition-all duration-300 ease-in-out;
}

.expanded {
  @apply shadow-2xl;
  width: 90vw;
  max-width: 600px;
  height: auto;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  z-index: 999;
  cursor: zoom-out;
}

.center-icon {
  @apply flex justify-center mt-4;
}

.announcement-grid {
  @apply grid gap-4;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
}

.announcement {
  @apply mb-4 p-4 border border-gray-200 rounded-lg shadow-sm;
}

.cursor-move {
  cursor: move;
}

.icon-collapsed {
  @apply mr-0;
}

.icon-expanded {
  @apply mr-4;
}

.move-right {
  @apply ml-auto;
}

/* Responsive styles */
@screen sm {
  .announcement-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@screen lg {
  .announcement-grid {
    grid-template-columns: repeat(3, 1fr);
  }
}

@media (max-width: 640px) {
  .announcement-expanded {
    grid-column: span 1;
  }
}

@media (min-width: 641px) and (max-width: 1024px) {
  .announcement-expanded {
    grid-column: span 2;
  }
}

@media (min-width: 1025px) {
  .announcement-expanded {
    grid-column: span 3;
  }
}

/* Ensure sharp text */
* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

</style>
