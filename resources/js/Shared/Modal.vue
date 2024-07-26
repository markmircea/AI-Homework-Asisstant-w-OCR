<template>
  <transition name="modal" appear>
    <div class="fixed inset-0 flex items-center justify-center z-50" v-if="visible">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click.self="close"></div>
      <!-- Modal Container -->
      <div class="modal-container bg-white dark:bg-gray-800 rounded-lg shadow-xl z-10 mx-4 sm:mx-6 lg:mx-8 transform transition-all duration-300 ease-out flex flex-col">
        <!-- Modal Content -->
        <div class="p-6 flex-grow flex flex-col">
          <slot></slot>
        </div>
        <!-- Modal Footer -->
        <div class="p-4 bg-gray-50 dark:bg-gray-700 flex justify-end">
          <button @click.stop="close" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
            Close
          </button>
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

  beforeUnmount() {
    // Remove event listener on component destruction
    document.removeEventListener('keyup', this.handleEscape);
  },
}
</script>

<style scoped>
.modal-container {
  max-width: 90%;
  width: 800px;
  height: 90vh;
  max-height: 900px;
  margin: auto;
  display: flex;
  flex-direction: column;
}

.modal-enter-active,
.modal-leave-active {
  transition: all 0.3s ease-out;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
  transform: scale(0.95);
}

.modal-enter-to,
.modal-leave-from {
  opacity: 1;
  transform: scale(1);
}
</style>
