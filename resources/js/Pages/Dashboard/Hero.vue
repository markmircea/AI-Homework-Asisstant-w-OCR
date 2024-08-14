<template>
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
      <div class="relative max-w-2xl sm:mx-auto sm:max-w-xl md:max-w-2xl sm:text-center">
        <h2 class="mb-6 font-sans text-4xl font-bold tracking-tight text-white sm:text-5xl sm:leading-none">
          Unlock Your Academic Potential with
          <span class="relative inline-block px-2 py-1 mt-2">
            <div class="absolute inset-0 transform -skew-x-12 bg-gradient-to-r from-teal-400 to-blue-500 opacity-80"></div>
            <span class="relative text-indigo-900 font-extrabold">AI-Powered Assistance</span>
          </span>
        </h2>
        <p class="mb-6 text-base text-indigo-100 md:text-lg">
          Our cutting-edge AI technology analyzes your assignments, provides detailed explanations, and guides you
          through step-by-step solutions. Instantly boost your understanding and grades!
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
            <textarea v-model="form.question" id="question" rows="4"
              class="w-full bg-indigo-700/50 text-white border-0 rounded-lg py-3 px-4 focus:ring-2 focus:ring-blue-500 transition-all duration-300"
              placeholder="Enter your homework question here..."></textarea>
            <div class="absolute top-0 right-0 mt-8 mr-4 text-indigo-300 animate-bounce">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
              </svg>
            </div>
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
export default {
  name: 'Hero',
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
      form: this.$inertia.form({
        _method: 'post',
        title: '',
        subject: this.selectedSubject,
        level: '',
        question: '',
        tokensCost: 1000,
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
  },
  methods: {
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
@keyframes gradient {
  0% {
    background-position: 0% 50%;
  }
  25% {
    background-position: 100% 50%;
  }
  50% {
    background-position: 50% 100%;
  }
  75% {
    background-position: 0% 50%;
  }
  100% {
    background-position: 0% 0%;
  }
}

.bg-gradient-animation {
  background: linear-gradient(
    -45deg,
    #4338ca,
    #3730a3,
    #312e81,
    #1e3a8a
  );
  background-size: 400% 400%;
  animation: gradient 15s ease infinite;
}

.bg-grid-white {
  background-image: linear-gradient(to right, rgba(255, 255, 255, 0.1) 1px, transparent 1px),
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.1) 1px, transparent 1px);
}

/* Rest of the styles remain unchanged */
</style>

Version 2 of 2
