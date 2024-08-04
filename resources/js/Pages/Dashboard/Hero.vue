<template>
  <div class="relative bg-gradient-to-r from-indigo-900 to-indigo-600">
    <div class="absolute inset-x-0 bottom-0">
      <svg viewBox="0 0 224 12" fill="currentColor" class="w-full -mb-1 text-white" preserveAspectRatio="none">
        <path
          d="M0,0 C48.8902582,6.27314026 86.2235915,9.40971039 112,9.40971039 C137.776408,9.40971039 175.109742,6.27314026 224,0 L224,12.0441132 L0,12.0441132 L0,0 Z">
        </path>
      </svg>
    </div>
    <div class="px-4 py-16 mx-auto sm:max-w-xl md:max-w-full lg:max-w-screen-xl md:px-24 lg:px-8 lg:py-20">
      <div class="relative max-w-2xl sm:mx-auto sm:max-w-xl md:max-w-2xl sm:text-center">
        <h2 class="mb-6 font-sans text-3xl font-bold tracking-tight text-white sm:text-4xl sm:leading-none">
          Unlock Your Academic Potential with<br class="hidden md:block" />
          AI-Powered
          <span class="relative inline-block px-2">
            <div class="absolute inset-0 transform -skew-x-12 bg-teal-accent-400"></div>
            <span class="relative text-teal-900">Homework Assistance</span>
          </span>
        </h2>
        <p class="mb-6 text-base text-indigo-100 md:text-lg">
          Our cutting-edge AI technology analyzes your assignments, provides detailed explanations, and guides you
          through step-by-step solutions. Instantly boost your understanding and grades!
        </p>

        <!-- Question Section -->
        <form @submit.prevent="update" class="bg-white p-6 rounded-lg shadow-lg">
      <div class="flex mb-4">
        <div class="w-1/2 pr-2">
          <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
          <select v-model="form.subject" id="subject" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            <option value="" disabled>Auto-Detect</option>
            <option v-for="subject in subjects" :key="subject" :value="subject">{{ subject }}</option>
          </select>
        </div>
            <div class="w-1/2 pl-2">
              <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
              <select v-model="form.level" id="level"
                class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
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

          <div class="relative w-full pb-8 pr-6">
                        <label for="question" class="block text-sm font-medium text-gray-700">Your homework question

                          <div class="hidden sm:block">
                           <!-- SVG and Badge -->
                  <figure class="absolute top-0 right-0 text-nowrap">
                    <svg class="absolute ms-4 mt-4" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"
                      viewBox="0 0 99.3 57" width="48">
                      <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10"
                        d="M2,39.5l7.7,14.8c0.4,0.7,1.3,0.9,2,0.4L27.9,42"></path>
                      <path fill="none" stroke="#bdc5d1" stroke-width="4" stroke-linecap="round" stroke-miterlimit="10"
                        d="M11,54.3c0,0,10.3-65.2,86.3-50"></path>
                    </svg>
                    <span class="badge text-gray-600 badge-pill ms-7 fa-beat-fade"
                      style="--fa-beat-fade-opacity: 0.90; --fa-beat-fade-scale: 1.075; --fa-animation-duration: 2s;">Type
                      your question here!</span>
                  </figure>
                </div>
                        </label>
            <textarea v-model="form.question" id="question" rows="4"
              class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              placeholder="Enter your homework question here..."></textarea>
          </div>

          <button type="submit"
            class="w-full btn-indigo1 transition-colors duration-200 hover:text-indigo-500 flex items-center justify-center space-x-2">
            <span class="question-mark">?</span>
            <span>Ask Question</span>
          </button>
        </form>

        <p class="mt-4 max-w-md text-xs tracking-wide text-indigo-100 sm:text-sm sm:mx-auto">
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
    }
  },
  data() {
    return {
      form: {
        title: '',
        subject: this.selectedSubject,
        level: '',
        question: '',
      },
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
      // Handle form submission
      console.log('Form submitted:', this.form);
      // Add your logic here to process the form data
    },
  },
};
</script>

<style scoped>
/* Add any specific styles for this component here */
.btn-indigo1 {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  border: none;
  border-radius: 0.5rem;
  color: white;
  font-weight: 600;
  padding: 0.75rem 1.5rem;
  transition: all 0.3s ease;
}

.btn-indigo1:hover {
  background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
  transform: translateY(-2px);
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.question-mark {
  display: inline-block;
  font-size: 1.5rem;
  margin-right: 0.5rem;
  animation: flip-spin 5s ease-in-out infinite;
}

@keyframes flip-spin {
  0% {
    transform: rotate(0deg) scaleY(1);
  }

  25% {
    transform: rotate(90deg) scaleY(-1);
  }

  50% {
    transform: rotate(180deg) scaleY(1);
  }

  75% {
    transform: rotate(270deg) scaleY(-1);
  }

  100% {
    transform: rotate(360deg) scaleY(1);
  }
}
</style>
