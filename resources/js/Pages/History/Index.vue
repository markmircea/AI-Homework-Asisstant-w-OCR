<template>

  <div>

    <div class="flex justify-start mb-8 max-w-3xl">

      <Head title="History" />
      <div>
        <h1 class="mb-8 text-3xl font-bold">History</h1>
        <h2 class="p-4 border rounded-lg">Hi {{ user.first_name }}! Welcome to your dashboard, here are some of your
          historic.</h2>
        <div class="flex justify-between mb-4 p-4">
          <!-- <button @click="showCreateModal" class="btn-indigo">Create Announcement</button> -->
          <button @click="toggleOCRModal" class="btn-indigo justify-end">Analyze</button>
        </div>

        <draggable :list="paginatedAnnouncements" @update="updateOrder" class="drag-handle announcement-grid">
          <div v-for="announcement in paginatedAnnouncements" :key="announcement.id"
            :class="['announcement', { 'announcement-expanded': !announcement.collapsed }]"
            class="p-4 border rounded-lg shadow cursor-move" @dblclick="showEditModal(announcement)">
            <div class="flex flex-col h-full">
              <div class="flex-1">
                <p class="announcement-title">{{ announcement.title }}</p>
                <p class="text-gray-500 text-sm">Created at: {{ formatDate(announcement.created_at) }}</p><br>

                <div v-if="!announcement.collapsed">
                  <!-- Add click event handler to expand image -->
                  <img v-if="announcement.photo" class="rounded-lg shadow"
                    style="width: 200px; height: auto; cursor: pointer;" :src="expandedImageUrl(announcement)"
                    @click="expandImage(announcement)" :class="{ 'expanded': announcement.expanded }" />
                  <br><br>

                  <p>{{ announcement.title }}</p>
                  <br><br>
                  <h3 class="font-bold text-xl">{{ announcement.content }}</h3>
                  <br><br>
                  <p class="text-gray-500 text-sm">Subject: {{ announcement.subject }}</p><br>
                  <p class="text-gray-500 text-sm">Extracted Text: {{ announcement.extracted_text }}</p><br><br>
                </div>
              </div>

              <!-- Arrow button to collapse/expand announcement -->
              <div class="flex space-x-2 items-center center-icon">
                <button @click="showEditModal(announcement)" class="btn-indigo">Edit</button>
                <button @click="destroy(announcement.id)" class="btn-red">Delete</button>
              </div>
              <Icon class="center-icon"  name="drag-drop"/>

              <Icon @click="toggleCollapse(announcement)" :class="['btn-arrow small-icon', { 'icon-collapsed': announcement.collapsed, 'icon-expanded': !announcement.collapsed }]"
      :name="announcement.collapsed ? 'cheveron-down' : 'cheveron-down'" />
            </div>
          </div>
        </draggable>

        <!-- Pagination Controls -->
        <div class="pagination-controls mt-4 flex justify-center space-x-2 items-center">
          <button @click="goToPage(currentPage - 1)" :disabled="currentPage <= 1">Previous</button>
          <div class="page-numbers flex space-x-1">
            <button v-for="number in pageNumbers" :key="number" @click="goToPage(number)"
              :class="{ 'active': number === currentPage }">
              {{ number }}
            </button>
          </div>
          <button @click="goToPage(currentPage + 1)" :disabled="currentPage >= totalPages">Next</button>
        </div>

        <p>You have {{ coins }} coins.</p>
      </div>
      <!-- Create Announcement Modal -->
      <Modal :visible="OCRModalVisible" @close="toggleOCRModal">
        <OCR @submitted="toggleOCRModal" />
      </Modal>
      <!-- Create Announcement Modal -->
      <Modal :visible="isCreateModalVisible" @close="hideCreateModal">
        <CreateAnnouncement @submitted="hideCreateModal" />
      </Modal>
      <!-- Edit Announcement Modal -->
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
/* Grid layout for announcements */
.announcement-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  /* 3-column layout */
  gap: 1rem;
  /* Space between grid items */
}

.announcement {
  margin-bottom: 1rem;
  padding: 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

/* Styling for expanded announcement */
.announcement-expanded {
  grid-column: span 3;
  /* Span all 3 columns */
}

.announcement-title {
  display: -webkit-box;
  /* Required for ellipsis */
  -webkit-line-clamp: 2;
  /* Limit to 2 lines */
  -webkit-box-orient: vertical;
  /* Vertical orientation of the box */
  overflow: hidden;
  /* Hide overflow */
  text-overflow: ellipsis;
  /* Show ellipsis for overflow text */
  white-space: normal;
  /* Ensure normal white space handling */
  margin: 0;
  /* Optional: Adjust margin as needed */
}

.cursor-move {
  cursor: move;
}

.flex {
  display: flex;
}

.justify-between {
  justify-content: space-between;
}

.items-center {
  align-items: center;
}

.space-x-2> :not(:last-child) {
  margin-right: 0.5rem;
}




/* Styling for expanded image */
.expanded {
  width: 600px;
  /* Three times larger than original */
  height: auto;
  /* Maintain aspect ratio */
  position: fixed;
  /* Position fixed to overlay on top */
  top: 50%;
  /* Center vertically */
  left: 50%;
  /* Center horizontally */
  transform: translate(-50%, -50%) scale(3);
  /* Center the image and scale it */
  z-index: 999;
  /* Ensure expanded image is on top of everything else */
  cursor: zoom-out;
  /* Change cursor to indicate closing */
}

/* Base styles for the icon */
.btn-arrow {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0;
  margin-left: auto; /* Ensures it aligns to the right */
  transition: margin 0.3s; /* Smooth transition for margin change */
}

/* Additional styles for collapsed and expanded states */
.icon-collapsed {
  margin-right: 0; /* Default position when collapsed */
}

.icon-expanded {
  margin-right: 1rem; /* Adjust this value to move the icon to the right */
}

.small-icon {
  width: 20px;
  /* Adjust width as needed */
  height: 20px;
  /* Adjust height as needed */
}

/* Add to your scoped <style> section */
.move-right {
  margin-left: auto; /* Pushes the icon to the right in a flex container */
}




/* Pagination controls styling */
.pagination-controls {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.pagination-controls button {
  @apply bg-indigo-500 text-white border-none py-2 px-4 rounded-lg;
}

.pagination-controls button:disabled {
  @apply bg-gray-300 cursor-not-allowed;
}

.page-numbers button {
  @apply bg-white text-indigo-500 border-indigo-500 border py-2 px-4 rounded-lg;
}

.page-numbers button.active {
  @apply bg-indigo-500 text-white;
}

.display-none {
  display: none;
}

/* Add this to center the icon when expanded */
.center-icon {
  margin: 0 auto; /* Center the icon horizontally */
}

/* Flex container adjustment */
.announcement .flex-col.items-center {
  align-items: center; /* Center all children horizontally */
}

</style>
