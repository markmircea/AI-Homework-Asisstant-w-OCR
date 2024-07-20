<template>
  <transition name="modal">
    <div class="fixed inset-0 flex items-center justify-center z-50" v-if="visible">
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black opacity-50" @click="close"></div>
      <!-- Modal Container -->
      <div class="bg-white rounded-lg shadow-lg overflow-hidden z-10 max-w-lg mx-auto w-full">
        <!-- Modal Content -->
        <div class="p-6">
          <slot></slot>
        </div>
        <!-- Modal Footer -->
        <div class="p-4 border-t border-gray-200 flex justify-end">
          <button @click="close" class="bg-red-500 text-white font-semibold py-2 px-4 rounded hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
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
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.5s ease;
}

.modal-enter,
.modal-leave-to {
  opacity: 0;
}
</style>
