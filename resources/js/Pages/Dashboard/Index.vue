<template>
  <div>
    <div class="flex justify-start mb-8 max-w-3xl">
      <Head title="Dashboard" />
      <div>
        <h1 class="mb-8 text-3xl font-bold">Dashboard</h1>
        <h2 class="p-4 border rounded-lg">Hi {{ user.first_name }}! Welcome to your dashboard, here are some announcements.</h2>
        <div class="flex mb-4 p-4">
          <button @click="showCreateModal" class="btn-indigo">Create Announcement</button>
        </div>
        <draggable :list="localAnnouncements" @update="updateOrder" class="drag-handle">
          <div v-for="announcement in localAnnouncements" :key="announcement.id" class="announcement mb-4 p-4 border rounded-lg shadow cursor-move" @dblclick="showEditModal(announcement)">
            <div class="flex justify-between items-center">
              <div class="flex-1">
                <h3 class="font-bold text-xl">{{ announcement.title }}</h3>
                <p>{{ announcement.content }}</p>
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
      selectedAnnouncement: null,
      localAnnouncements: [...this.announcements], // Create a local copy of the announcements array
    }
  },

  components: {
    Head,
    Modal,
    CreateAnnouncement,
    EditAnnouncement,
    draggable: VueDraggableNext,
    Icon,
  },

  layout: Layout,

  methods: {
    showCreateModal() {
      this.isCreateModalVisible = true;
    },
    hideCreateModal() {
      this.isCreateModalVisible = false;
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
    }
  },

  watch: {
    announcements: {
      handler(newAnnouncements) {
        this.localAnnouncements = [...newAnnouncements];
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

.btn-indigo {
  background-color: #5a67d8;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  text-align: center;
  text-decoration: none;
}

.btn-red {
  background-color: #e53e3e;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  text-align: center;
  text-decoration: none;
}
</style>
