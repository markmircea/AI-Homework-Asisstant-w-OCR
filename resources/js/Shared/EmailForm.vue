<!-- js/Shared/EmailForm.vue -->

<template>
  <div class="fixed inset-0 flex items-center justify-center z-50">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-50"></div> <!-- Semi-transparent grey background -->
    <div class="bg-white rounded-md shadow-lg p-8 w-2/5 max-w-3xl mx-auto relative z-50">
      <h2 class="text-2xl font-bold mb-6">Send Email</h2>

      <form @submit.prevent="sendEmail">
        <div class="mb-6">
          <label for="subject" class="block text-gray-700">Subject:</label>
          <input id="subject" v-model="subject" type="text" class="form-input mt-1 block w-full" required>
        </div>

        <div class="mb-6">
          <label for="message" class="block text-gray-700">Message:</label>
          <textarea id="message" v-model="message" rows="8" class="form-textarea mt-1 block w-full" required></textarea>
        </div>

        <div class="flex justify-end">
          <button type="submit" class="btn-indigo">Send</button>
          <button type="button" class="btn-gray ml-4" @click="closeForm">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>

import axios from 'axios';

export default {
  props: {
    contacte: Object, // Define the contact prop
  },
  data() {
    return {
      subject: '',
      message: '',
    };
  },
  methods: {
    sendEmail() {
      // Prepare data to send
      const postData = {
        subject: this.subject,
        message: this.message,
      };
      this.$emit('emailSent', postData);
      this.closeForm();
/**
      // Make Axios POST request to Laravel backend
      axios.post(`/reports/${this.contacte.id}/send-email`, postData)
        .then(response => {
          console.log('Email sent successfully!', response.data);
          // Emit an event to notify parent component (optional)
          this.$emit('emailSent', { subject: this.subject, message: this.message });
          this.closeForm();
        })
        .catch(error => {
          console.error('Error sending email:', error.response ? error.response.data : error.message);
          // Handle error scenario as needed
        });**/
    },
    closeForm() {
      // Emit an event to notify parent component to close this form
      this.$emit('close');
    },
  },
};
</script>

<style scoped>
/* Scoped styles for EmailForm.vue */
.bg-gray-500 {
  background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent grey color */
}
</style>
