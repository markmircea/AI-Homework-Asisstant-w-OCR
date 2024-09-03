<template>
      <FullPageLoader />
      <flash-messages ref="FlashMessages" class="pt-16" />

  <div class="relative overflow-hidden min-h-screen" style="z-index: 1;">
    <div class="absolute inset-0 bg-gradient-animation" style="z-index: -1;"></div>
    <div class="absolute inset-0 bg-grid-white/[0.05] bg-[size:40px_40px]" style="z-index: -1;"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-indigo-900/50 to-transparent" style="z-index: -1;"></div>
     <div class="absolute inset-x-0 bottom-0">
      <svg viewBox="0 0 224 12" fill="white" class="w-full -mb-1 text-white/20" preserveAspectRatio="none">
        <path
          d="M0,0 C48.8902582,6.27314026 86.2235915,9.40971039 112,9.40971039 C137.776408,9.40971039 175.109742,6.27314026 224,0 L224,12.0441132 L0,12.0441132 L0,0 Z">
        </path>
      </svg>
    </div>
    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20 relative z-10">
      <div class="relative max-w-4xl mx-auto sm:text-center">
          <h2 class="mb-6 mt-20 font-sans text-4xl font-bold tracking-tight text-white sm:text-5xl sm:leading-none">
          Unlock Your Academic Potential with
          <span class="relative inline-block px-2 py-1 mt-2">
            <div class="absolute inset-0 transform -skew-x-12 bg-gradient-to-r from-teal-400 to-blue-500 opacity-80"></div>
            <span class="relative text-indigo-900 font-extrabold">AI-Powered Analysis</span>
          </span>
        </h2>
        <p class="mb-6 text-base text-indigo-100 md:text-lg">
          Upload a photo, document, or screenshot and our advanced multi-model AI will analyze your assignments and tests, provide detailed explanations, and guide you
          through step-by-step solutions.
        </p>

         <!-- Question Section -->
        <form @submit.prevent="update" class="bg-indigo-950/70 backdrop-blur-lg p-8 rounded-2xl shadow-2xl">
          <div class="flex flex-col sm:flex-row mb-6 gap-4">
            <div class="w-full sm:w-1/2">
              <label for="subject" class="block text-sm font-medium text-indigo-100 mb-2">Subject</label>
              <select v-model="form.subject" id="subject" class="w-full bg-indigo-700/50 text-white border-0 rounded-lg py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                <option value="" disabled>Auto-Detect</option>
                <option v-for="subject in subjects" :key="subject" :value="subject">{{ subject }}</option>
              </select>
            </div>
            <div class="w-full sm:w-1/2">
              <label for="level" class="block text-sm font-medium text-indigo-100 mb-2">Level</label>
              <select v-model="form.level" id="level" class="w-full bg-indigo-700/50 text-white border-0 rounded-lg py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all duration-300">
                <option value="" selected>Any Level</option>
                <option value="1-5th grade">1-5th grade</option>
                <option value="6-8th grade">6-8th grade</option>
                <option value="9-12th grade">9-12th grade</option>
                <option value="University">University</option>
                <option value="Masters">Masters</option>
                <option value="Expert">Expert</option>
              </select>
            </div>
          </div>

  <div class="relative w-full mb-6">
    <label for="question" class="block text-sm font-medium text-indigo-100 mb-2">Your homework question</label>
    <div class="relative">
      <textarea
        v-model="form.question"
        id="question"
        rows="4"
        ref="questionTextarea"
        class="w-full bg-indigo-700/50 text-white border-0 rounded-lg py-3 px-4 pr-12 focus:ring-2 focus:ring-blue-500 transition-all duration-300"
        :placeholder="currentPlaceholder"
      ></textarea>
      <div class="absolute top-3 right-3">
        <input
          type="file"
          ref="fileInput"
          @change="handleFileUpload"
          class="hidden"
          accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
        />
        <button
          @click.prevent="form.photo ? removeFile() : $refs.fileInput.click()"
          :class="form.photo ? 'text-red-400 hover:text-red-300' : 'text-indigo-300 hover:text-indigo-100'"
          class="transition-colors duration-300"
          :title="form.photo ? 'Remove file' : 'Upload file'"
        >
          <svg v-if="!form.photo" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
          </svg>
          <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </button>
      </div>
    </div>
    <p v-if="form.photo" class="mt-2 text-sm text-indigo-300">
      File selected: {{ form.photo.name }} ({{ formatFileSize(form.photo.size) }})
    </p>
  </div>
          <button type="submit"
            class="w-full py-4 px-6 bg-gradient-to-r from-teal-400 to-blue-500 text-white font-semibold rounded-lg shadow-lg hover:from-teal-500 hover:to-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-indigo-200 transition-all duration-300 transform hover:scale-105">
            <span class="inline-block mr-2 transition-transform group-hover:translate-x-1 motion-safe:animate-bounce">🚀</span>
            Ask Question
          </button>
        </form>

        <p class="mt-6 max-w-md text-xs tracking-wide text-indigo-200 sm:text-sm sm:mx-auto">
          Experience the power of multi-model AI analysis for all your homework needs.
        </p>
      </div>
    </div>
  </div>
</template>


<script>
import FullPageLoader from '../../Shared/FullPageLoader.vue'
import FlashMessages from '@/Shared/FlashMessages.vue'

export default {
  name: 'Hero',
  components: {
    FullPageLoader,
    FlashMessages
  },
  props: {
    selectedSubject: {
      type: String,
      default: ''
    },
    isAuthenticated: {
      type: Boolean,
      default: false
    }
  },
  data() {
    return {
      currentPlaceholder: '',
      fullPlaceholder: 'Enter your homework question here...',
      form: this.$inertia.form({
        _method: 'post',
        title: '',
        subject: this.selectedSubject,
        level: '',
        question: '',
        tokensCost: 1500,
        temperature: 0.7,
        model: "gpt-4o-mini",
        photo: null,

      }),
      subjects: ['Biology', 'Chemistry', 'Computer Science', 'Economics', 'English', 'Geography', 'History', 'Mathematics', 'Physics', 'Science']
    };
  },
  watch: {
    selectedSubject: {
      immediate: true,
      handler(newSubject) {
        if (newSubject) {
          this.form.subject = newSubject;
        }
      }
    }
  },
  mounted() {
    if (this.selectedSubject) {
      this.form.subject = this.selectedSubject;
    }
    this.$nextTick(() => {
      this.$refs.questionTextarea.focus();
      this.animatePlaceholder();
    });
  },
  methods: {
    animatePlaceholder() {
      let i = 0;
      const interval = setInterval(() => {
        this.currentPlaceholder = this.fullPlaceholder.slice(0, i);
        i++;
        if (i > this.fullPlaceholder.length) {
          clearInterval(interval);
        }
      }, 100);
    },
    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.form.photo = file;
      }
    },
    removeFile() {
      this.form.photo = null;
      this.$refs.fileInput.value = '';
    },
    formatFileSize(bytes) {
      if (bytes === 0) return '0 Bytes';
      const k = 1024;
      const sizes = ['Bytes', 'KB', 'MB', 'GB'];
      const i = Math.floor(Math.log(bytes) / Math.log(k));
      return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    },
    update() {
      const endpoint = this.isAuthenticated ? '/ask' : '/public-ask';
      this.form.post(endpoint, {
        onSuccess: () => {
          if (this.isAuthenticated) {
            // Handle authenticated user response
          } else {
            // Handle public user response
          }
        },
        onError: () => {
          // Handle errors
        }
      });
    },
  },
};
</script>

<style>


@keyframes blink {
  0% { opacity: 0; }
  50% { opacity: 1; }
  100% { opacity: 0; }
}

textarea::placeholder {
  opacity: 0.7;
}

textarea:focus::placeholder {
  animation: blink 0.7s infinite;
}

@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  50% {
    background-position: 100% 50%;
  }
  100% {
    background-position: 0% 50%;
  }
}

.bg-gradient-animation {
  background: linear-gradient(
    -45deg,
    #4338ca,
    #3730a3,
    #312e81,
    #1e3a8a,
    #5b21b6,
    #6d28d9,
    #4c1d95,
    #2563eb,
    #1d4ed8
  );
  background-size: 400% 400%;
  animation: gradient 20s ease infinite;
}

.bg-grid-white {
  background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
}

</style>

Version 2 of 2
