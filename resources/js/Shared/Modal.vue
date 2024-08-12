<template>
  <teleport to="body">
    <transition name="modal" appear>
      <div class="fixed inset-0 z-[9999] overflow-y-auto" v-if="visible">
        <!-- Overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click.self="close"></div>
        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen p-4">
          <div class="modal-container bg-white dark:bg-gray-800 w-full max-w-md sm:max-w-lg md:max-w-xl lg:max-w-2xl xl:max-w-4xl rounded-lg shadow-xl z-[10000] transform transition-all duration-300 ease-out flex flex-col relative">
            <!-- Modal Content -->
            <div class="p-6 flex-grow overflow-y-auto">
              <slot></slot>
            </div>
            <!-- Modal Footer -->
            <div class="p-4 bg-gray-50 dark:bg-gray-700 flex justify-end rounded-b-lg">
              <button @click.stop="close" class="bg-red-500 text-white font-semibold py-2 px-4 rounded-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition duration-150 ease-in-out">
                Close
              </button>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </teleport>
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
        this.close();
      }
    },
  },

  watch: {
    visible(newValue) {
      if (newValue) {
        document.body.style.overflow = 'hidden';
      } else {
        document.body.style.overflow = '';
      }
    }
  },

  mounted() {
    document.addEventListener('keyup', this.handleEscape);
  },

  beforeUnmount() {
    document.removeEventListener('keyup', this.handleEscape);
    document.body.style.overflow = '';
  },
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
  transition: opacity 0.3s ease;
}

.modal-enter-from,
.modal-leave-to {
  opacity: 0;
}

.modal-enter-to,
.modal-leave-from {
  opacity: 1;
}

.modal-container {
  transition: all 0.3s ease-out;
}

.modal-enter-from .modal-container,
.modal-leave-to .modal-container {
  opacity: 0;
  transform: scale(0.9);
}
</style>
