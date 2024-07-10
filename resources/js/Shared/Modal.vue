<template>
  <transition name="modal">
    <div class="fixed inset-0 flex items-center justify-center z-50" v-if="visible">

      <div class="absolute inset-0 bg-black opacity-50" @click="close"></div>
      <div class="bg-white rounded-lg shadow-lg overflow-hidden z-10 modal-container">
        <div class="p-4">
          <slot></slot>
        </div>
        <div class="p-4 border-t border-gray-200 flex justify-end">
          <button @click="close" class="btn-red">Close</button>
        </div>
      </div>
    </div>
  </transition>
</template>

<script>
export default {
  props: {
    visible: {
      type: Boolean,
      default: false,
    },
  },

  methods: {
    close() {
      this.$emit('close');
    },
    handleEscape(event) {
      if (event.key === 'Escape' && this.visible) {
        // Emit the close event when Escape is pressed
        this.close();
      }
    },

  },

  mounted() {
    // Add event listener for Escape key on mount
    document.addEventListener('keyup', this.handleEscape);
  },

  beforeDestroy() {
    // Remove event listener on component destruction
    document.removeEventListener('keyup', this.handleEscape);
  },
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.5s;
}

.modal-enter,
.modal-leave-to {
  opacity: 0;
}

.modal-container {
  width: 80%;
  /* Adjust this percentage to make the modal wider or narrower */
  max-width: 1000px;
  /* Adjust the max width as needed */
  margin: 0 auto;
}

.btn-red {
  color: #e53e3e;
}
</style>
