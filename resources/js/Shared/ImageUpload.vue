<template>
  <div>
    <label v-if="label" class="form-label">{{ label }}:</label>
    <div class="form-input p-0" :class="{ error: errors.length }">
      <input
        ref="file"
        type="file"
        :accept="accept"
        class="hidden"
        @change="change"
        @drop.prevent="handleDrop"
        @dragover.prevent
        @paste.prevent="handlePaste"
      />
      <!-- Drop area for drag and drop -->
      <div
        class="drop-area"
        v-if="!modelValue"
        @drop.prevent="handleDrop"
        @dragover.prevent
      >
        <p>Drag & Drop</p>
        <button
          type="button"
          class="browse-btn"
          @click="browse"
        >
          Or Browse for Image
        </button>
      </div>
      <!-- Display selected file details -->
      <div v-else class="file-details">
        <div class="flex items-center justify-between p-2">
          <div class="flex-1 pr-1">
            {{ modelValue.name }} <span class="text-gray-500 text-xs">({{ filesize(modelValue.size) }})</span>
          </div>
          <button
            type="button"
            class="remove-btn"
            @click="remove"
          >
            Remove
          </button>
        </div>
      </div>
    </div>
    <div v-if="errors.length" class="form-error">{{ errors[0] }}</div>
  </div>
</template>

<script>
export default {
  props: {
    modelValue: File,
    label: String,
    accept: String,
    errors: {
      type: Array,
      default: () => [],
    },
  },
  emits: ['update:modelValue'],
  methods: {
    filesize(size) {
      var i = Math.floor(Math.log(size) / Math.log(1024))
      return (size / Math.pow(1024, i)).toFixed(2) * 1 + ' ' + ['B', 'kB', 'MB', 'GB', 'TB'][i]
    },
    browse() {
      this.$refs.file.click()
    },
    change(e) {
      this.$emit('update:modelValue', e.target.files[0])
    },
    remove() {
      this.$emit('update:modelValue', null)
    },
    handleDrop(e) {
      e.preventDefault()
      const file = e.dataTransfer.files[0]
      this.$emit('update:modelValue', file)
    },
    handlePaste(e) {
      e.preventDefault()
      const items = e.clipboardData.items
      for (let i = 0; i < items.length; i++) {
        if (items[i].type.indexOf('image') !== -1) {
          const blob = items[i].getAsFile()
          this.$emit('update:modelValue', blob)
          break
        }
      }
    },
  },
}
</script>

<style scoped>
.form-label {
  margin-bottom: 0.5rem;
  display: block;
}

.form-input {
  position: relative;
}

.drop-area {
  border: 2px dashed #ccc;
  padding: 2rem;
  text-align: center;
  cursor: pointer;
}

.drop-area p {
  margin-bottom: 0.5rem;
}

.browse-btn {
  background-color: #5a67d8;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.file-details {
  border: 1px solid #ccc;
  border-radius: 0.375rem;
}

.remove-btn {
  background-color: #e53e3e;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.375rem;
  cursor: pointer;
}

.form-error {
  color: #e53e3e;
  margin-top: 0.5rem;
}
</style>
