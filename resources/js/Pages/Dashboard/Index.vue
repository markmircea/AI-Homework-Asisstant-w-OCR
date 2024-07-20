<template>
  <div>
    <div class="flex justify-start mb-8 max-w-3xl">
      <Head title="Dashboard" />
      <div>
        <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
        <h2 class="p-4 border rounded-lg">Hi {{ user.first_name }}! Welcome to your dashboard, here are some of your historic.</h2>
        <div class="flex justify-between mb-4 p-4">
          <button @click="showCreateModal" class="btn-indigo">Create Announcement</button>
          <button @click="toggleOCRModal" class="btn-indigo justify-end">Analyze</button>

        </div>
        <draggable :list="localAnnouncements" @update="updateOrder" class="drag-handle">
          <div v-for="announcement in localAnnouncements" :key="announcement.id" class="announcement mb-4 p-4 border rounded-lg shadow cursor-move" @dblclick="showEditModal(announcement)">
            <div class="flex justify-between items-center">
              <div class="flex-1">
               <!-- Add click event handler to expand image -->
               <img v-if="announcement.photo" class="rounded-lg shadow" style="width: 200px; height: auto; cursor: pointer;" :src="expandedImageUrl(announcement)" @click="expandImage(announcement)" :class="{ 'expanded': announcement.expanded }" />
              <br><br>
               <p>{{ announcement.title }}</p>
                <br><br>
                <h3 class="font-bold text-xl">{{ announcement.content }}</h3>
                <br><br>
                <p class="text-gray-500 text-sm"> Subject: {{ announcement.subject }}</p><br>
                <p class="text-gray-500 text-sm"> Extracted Text: {{ announcement.extracted_text }}</p><br><br>
                <p class="text-gray-500 text-sm">Created at: {{ formatDate(announcement.created_at) }} </p><br>



              </div>
              <div class="flex space-x-2 items-center">
                <button @click="showEditModal(announcement)" class="btn-indigo">Edit</button>
                <button @click="destroy(announcement.id)" class="btn-red">Delete</button>

                <!-- SVG drag handle -->
                <div class="drag-handle ml-2">
                  <Icon name="drag-drop" />
                </div>

              </div>
            </div>
          </div>
        </draggable>
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
import CreateAnnouncement from '@/Pages/Announcements/Create.vue'
import EditAnnouncement from '@/Pages/Announcements/Edit.vue'
import OCR from '@/Pages/Announcements/OCR.vue'

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
      isCreateModalVisible: false,
      isEditModalVisible: false,
      OCRModalVisible: false,
      selectedAnnouncement: null,
      localAnnouncements: [...this.announcements].map(announcement => ({
        ...announcement,
        expanded: false // Initialize expanded state for each announcement
      }))
    }
  },

  components: {
    Head,
    Modal,
    CreateAnnouncement,
    EditAnnouncement,
    OCR,
    draggable: VueDraggableNext,
    Icon
  },

  layout: Layout,

  methods: {
    showCreateModal() {
      this.isCreateModalVisible = true;
    },
    hideCreateModal() {
      this.isCreateModalVisible = false;
    },
    toggleOCRModal(){
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
        this.$inertia.delete(`/announcements/${id}`)
      }
    },
    updateOrder() {
      this.$inertia.post('/announcements/update-order', {
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
    }
  },

  watch: {
    announcements: {
      handler(newAnnouncements) {
        this.localAnnouncements = newAnnouncements.map(announcement => ({
          ...announcement,
          expanded: false // Reset expanded state when announcements change
        }));
      },
      deep: true,
    }
  }
}
</script>

<style scoped>
.announcement {
  margin-bottom: 1rem;
  padding: 1rem;
  border: 1px solid #e5e7eb;
  border-radius: 0.375rem;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
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
  width: 600px; /* Three times larger than original */
  height: auto; /* Maintain aspect ratio */
  position: fixed; /* Position fixed to overlay on top */
  top: 50%; /* Center vertically */
  left: 50%; /* Center horizontally */
  transform: translate(-50%, -50%) scale(3); /* Center the image and scale it */
  z-index: 999; /* Ensure expanded image is on top of everything else */
  cursor: zoom-out; /* Change cursor to indicate closing */
}
</style>
