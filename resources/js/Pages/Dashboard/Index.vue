<template>

  <div>

<Nav :user="user"/>



<Hero/>


<feature-section/>
<black-bar/>
   <steps></steps>

<dark-divider/>

   <pricing/>



 <Footer/>




  </div>
</template>


<script>
import { Head } from '@inertiajs/vue3'
import Modal from '@/Shared/Modal.vue'
import CreateAnnouncement from '@/Pages/Announcements/Create.vue'
import EditAnnouncement from '@/Pages/Announcements/Edit.vue'
import OCR from '@/Pages/Announcements/OCR.vue'

import { VueDraggableNext } from 'vue-draggable-next'
import Icon from '@/Shared/Icon.vue' // Import the Icon component

import FeatureSection from './FeatureSection.vue'; // Adjust the path as necessary
import BlackBar from './BlackBar.vue'
import Nav from './Nav.vue'
import Hero from './Hero.vue'
import Steps from './Steps.vue'
import DarkDivider from './DarkDivider.vue'
import Pricing from './Pricing.vue'
import Footer from './Footer.vue'




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
        collapsed: true,
        expanded: false // Initialize expanded state for each announcement
      })),
      currentPage: 1, // Track the current page
      itemsPerPage: 12, // Number of items per page
      user: this.$page.props.user
    }
  },

  mounted () {
    console.log(this.user.id)       // gets undefined
  },

  components: {
    Head,
    Modal,
    CreateAnnouncement,
    EditAnnouncement,
    OCR,
    draggable: VueDraggableNext,
    Icon,
    FeatureSection,
    BlackBar,
    Nav,
    Hero,
    Steps,
    DarkDivider,
    Pricing,
    Footer
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
</style>
