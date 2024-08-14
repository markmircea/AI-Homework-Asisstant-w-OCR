<template>
  <div class="bg-gradient-to-br from-gray-900 to-gray-800 min-h-screen text-white font-sans">
    <FullPageLoader />
    <Nav />
    <flash-messages ref="FlashMessages" class="pt-16" />

    <Head title="Ask" />

   <div class="pt-20 pb-12 px-4 sm:px-6 lg:px-8">
      <div class="max-w-7xl mx-auto">
        <div class="text-center mb-16">
          <h1 class="text-5xl font-extrabold sm:text-6xl md:text-7xl bg-clip-text text-transparent bg-gradient-to-r from-white to-white">
              Ask
          </h1>
          <p class="mt-6 text-xl text-gray-300 max-w-2xl mx-auto">
            Get instant answers powered by advanced AI models.
          </p>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
          <!-- Question Section -->
          <div class="flex-1 bg-gray-800 bg-opacity-50 shadow-xl rounded-2xl overflow-hidden backdrop-filter backdrop-blur-lg">
            <div class="px-8 py-4 bg-gradient-to-r from-indigo-400 to-indigo-500">
              <h2 class="text-2xl font-semibold text-white">Question</h2>
            </div>
            <form @submit.prevent="update" class="p-8">
              <div class="space-y-6">
                <!-- Subject and Level Selection -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                  <div>
                    <label for="subject" class="block text-sm font-medium text-gray-300">Subject</label>
                    <select v-model="form.subject" id="subject"
                      class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                      <option value="" selected>Auto-Detect</option>
                      <option v-for="subject in subjects" :key="subject" :value="subject">{{ subject }}</option>
                    </select>
                  </div>
                  <div>
                    <label for="level" class="block text-sm font-medium text-gray-300">Level</label>
                    <select v-model="form.level" id="level"
                      class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
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

                <!-- Text Area for Homework Question -->
                <div>
                  <div class="flex items-center justify-between mb-2">
                    <label for="homework_question" class="block text-sm font-medium text-gray-300">Your homework question</label>
                    <button type="button" @click="toggleUploadSection"
                      class="flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-500 rounded-md hover:bg-indigo-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-5 h-5 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                      </svg>
                      Upload
                    </button>
                  </div>
                  <textarea v-model="form.question" id="question" rows="4"
                    class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white"
                    placeholder="Enter your homework question here..."></textarea>
                </div>

                <!-- Accordion for Upload and Advanced Options -->
                <div class="space-y-4">
                  <!-- Upload Section -->
                  <div class="border border-gray-600 rounded-md">
                    <button type="button" @click.prevent="toggleUploadSection"
                      class="w-full px-4 py-2 text-left font-semibold text-indigo-400 hover:bg-gray-700 focus:outline-none flex justify-between items-center">
                      <span>{{ showUploadSection ? 'Hide Upload' : 'Add Upload' }}</span>
                      <svg class="w-5 h-5 transform transition-transform duration-200"
                        :class="{ 'rotate-180': showUploadSection }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </button>
                    <div v-show="showUploadSection" class="px-4 py-2 bg-gray-200">
                      <FileUpload v-model="form.photo" :error="form.errors.photo" name="photo"
                        label="Upload File or Image" required />
                    </div>
                  </div>

                  <!-- Advanced Options Section -->
                  <div class="border border-gray-600 rounded-md">
                    <button @click.prevent="toggleAdvancedOptions"
                      class="w-full px-4 py-2 text-left font-semibold text-indigo-400 hover:bg-gray-700 focus:outline-none flex justify-between items-center">
                      <span>{{ showAdvancedOptions ? 'Hide Advanced Options' : 'Show Advanced Options' }}</span>
                      <svg class="w-5 h-5 transform transition-transform duration-200"
                        :class="{ 'rotate-180': showAdvancedOptions }" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                          d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                          clip-rule="evenodd" />
                      </svg>
                    </button>
                    <div v-show="showAdvancedOptions" class="px-4 py-2 bg-gray-200 space-y-4">
                      <div class="flex items-center">
                        <input v-model="form.explain" id="explanation" type="checkbox" class="mr-2 text-indigo-500 focus:ring-indigo-500" />
                        <label for="explain" class="text-sm font-medium text-gray-600">Explain why the answer is correct</label>
                      </div>
                      <div class="flex items-center">
                        <input v-model="form.steps" id="steps" type="checkbox" class="mr-2 text-indigo-500 focus:ring-indigo-500" />
                        <label for="steps" class="text-sm font-medium text-gray-600">Show the work done to get to the answer</label>
                      </div>
                      <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-600">Creativity (Higher = More Creative, Lower = Logical)</label>
                        <select v-model="form.temperature" id="temperature"
                          class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                          <option value="0.6" selected>0.6</option>
                          <option value="0.0">0.0</option>
                          <option value="0.2">0.2</option>
                          <option value="0.4">0.4</option>
                          <option value="0.8">0.8</option>
                          <option value="1.0">1.0</option>
                        </select>
                      </div>
                      <div>
                        <label for="model" class="block text-sm font-medium text-gray-600">AI Model
                          <div class="relative inline-block ml-2">
                            <button type="button" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                              class="text-gray-600 transition-colors duration-200 hover:text-indigo-400">
                              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                              </svg>
                            </button>
                            <p v-if="showTooltip"
                              class="absolute z-10 w-48 p-2 text-sm text-gray-700 bg-gray-300 rounded-lg shadow-lg left-10 -top-6">
                              Hyper-advanced models available to Subscribers
                            </p>
                          </div>
                        </label>
                        <select v-model="form.model" id="model"
                          class="mt-1 block w-full bg-gray-700 border border-gray-600 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm text-white">
                          <option value="gpt-4o-mini" selected>GPT-4o Mini</option>
                          <option value="gpt-4-turbo">GPT-4 Turbo</option>
                          <option value="gpt-4o">GPT-4o</option>
                        </select>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="mt-8">
                <loading-button :loading="form.processing"
                  class="w-full btn-indigo transition-colors duration-200 bg-gradient-to-r from-indigo-400 to-indigo-500 hover:from-indigo-500 hover:to-indigo-600 text-white font-bold py-3 px-6 rounded-full flex items-center justify-center space-x-2">
                  <span class="question-mark">?</span>
                  <span>Ask Question</span>
                </loading-button>
              </div>
            </form>
          </div>

          <!-- Response Section -->
          <div id="result-section" class="flex-1 bg-gray-800 bg-opacity-50 shadow-xl rounded-2xl overflow-hidden backdrop-filter backdrop-blur-lg">
            <div class="h-full">
              <div class="px-8 py-4 bg-gradient-to-r from-indigo-400 to-indigo-500">
                <h2 class="text-2xl font-semibold text-white">Response</h2>
              </div>

              <div class="p-8 space-y-6">
                <!-- Loader Section -->
                <div id="answer-loader" v-if="form.processing" class="flex flex-col items-center">
                  <div class="loader mb-10 mt-10"></div>
                  <div class="text-center mt-4">
                    <h6 class="text-gray-300">One moment while I get the answer...</h6>
                    <div class="text-gray-400">
                      Did you know that the average human attention span is 8 seconds?
                    </div>
                  </div>
                </div>

                <!-- Result Section -->
                <div id="result-card" v-else>
                  <h5 class="text-xl font-semibold mb-4 text-indigo-400" id="result-scroll-point">Answer</h5>
                  <div class="space-y-4">
                    <div>
                      <label class="flex justify-between items-end mb-2">
                        <span class="text-gray-300">
                          <i class="fa-solid fa-comments mr-2"></i>
                          The answer to your question
                        </span>
                        <a :class="copyButtonClass('answer')" @click="copyToClipboard('answer')"
                          :aria-disabled="!response || clicked.answer" href="javascript:;">
                          Copy
                        </a>
                      </label>
                      <div class="bg-gray-700 border border-gray-600 rounded-md p-4 text-gray-300">
                        {{ response || placeholderAnswer }}
                      </div>
                    </div>

                    <div>
                      <h5 class="text-xl font-semibold mb-4 text-indigo-400">Explanation</h5>
                      <div>
                        <label class="flex justify-between items-end mb-2">
                          <span class="text-gray-300">
                            <i class="fa-solid fa-comments mr-2"></i>
                            Explanation of the answer
                          </span>
                          <a :class="copyButtonClass('explanation')" @click="copyToClipboard('explanation')"
                            :aria-disabled="!explanation || clicked.explanation" href="javascript:;">
                            Copy
                          </a>
                        </label>
                        <div class="bg-gray-700 border border-gray-600 rounded-md p-4 text-gray-300">
                          {{ explainResponse || placeholderExplain }}
                        </div>
                      </div>
                    </div>

                    <div>
                      <h5 class="text-xl font-semibold mb-4 text-indigo-400">Steps</h5>
                      <div>
                        <label class="flex justify-between items-end mb-2">
                          <span class="text-gray-300">
                            <i class="fa-solid fa-comments mr-2"></i>
                            Steps to solve the problem
                          </span>
                          <a :class="copyButtonClass('steps')" @click="copyToClipboard('steps')"
                            :aria-disabled="!steps || clicked.steps" href="javascript:;">
                            Copy
                          </a>
                        </label>
                        <div class="bg-gray-700 border border-gray-600 rounded-md p-4 text-gray-300">
                          {{ stepsResponse || placeholderSteps }}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <contact-us-vue id="contact-us"></contact-us-vue>
  <Footer />
</template>


<script>
import { Head } from '@inertiajs/vue3'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import FileUpload from '../../Shared/FileUpload.vue'
import Nav from './PublicNav.vue'
import Footer from './Footer.vue'
import FlashMessages from '@/Shared/FlashMessages.vue'
import ContactUsVue from './ContactUs.vue'
import FullPageLoader from '../../Shared/FullPageLoader.vue'


export default {
  components: {
    Head,
    LoadingButton,
    FlashMessages,
    ContactUsVue,
    SelectInput,
    TextInput,
    FileUpload,
    Nav,
    Footer,
    FullPageLoader,
    FlashMessages
  },

  props: {
    response: String,
    explainResponse: String,
    stepsResponse: String,
    remainingQuestions: Number,
    shouldScrollToResult: Boolean,

    selectedSubject: {
      type: String,
      default: ''
    }
  },
  mounted() {
    this.$nextTick(() => {
      if (this.shouldScrollToResult && this.response) {
        this.handleScroll();
      }
    });
  },
  data() {
    return {
      form: this.$inertia.form({
        _method: 'post',
        title: '',
        subject: this.selectedSubject,
        level: '',
        question: '',
        explain: '',
        steps: '',
        tokensCost: 1000,
        temperature: 0.7,
        model: "gpt-4o-mini",
        photo: null,
      }),
      subjects: ['Biology', 'Chemistry', 'Computer Science', 'Economics', 'English', 'Geography', 'History', 'Mathematics', 'Physics', 'Science'],
      isScrolled: false,

      showTooltip: false,
      showUploadSection: false,
      showAdvancedOptions: false,
      clicked: {
        answer: false,
        explanation: false,
        steps: false,
      },
      placeholderAnswer: 'Ask away!',
      placeholderExplain: 'You can enable explanations in "Advanced Options" under the question box',
      placeholderSteps: 'You can enable steps in "Advanced Options" under the question box',
    }
  },
  watch: {
    shouldScrollToResult(newValue) {
      if (newValue && !this.isScrolled) {
        this.handleScroll();
      }
    },
    response(newValue) {
      if (newValue && !this.isScrolled) {
        this.handleScroll();
      }
    }
  },

  methods: {
    copyToClipboard(type) {
      let textToCopy = '';

      if (type === 'answer') {
        textToCopy = this.response || this.placeholderAnswer;
        this.clicked.answer = true;
      } else if (type === 'explanation') {
        textToCopy = this.explainResponse || this.placeholderExplain;
        this.clicked.explanation = true;
      } else if (type === 'steps') {
        textToCopy = this.stepsResponse || this.placeholderSteps;
        this.clicked.steps = true;
      }

      navigator.clipboard.writeText(textToCopy).then(() => {
        this.copyButtonClass(type);
        this.$forceUpdate();
      });
    },

    handleScroll() {
      if (this.isMobile()) {
        const resultSection = document.getElementById('result-section');
        resultSection.scrollIntoView({ behavior: 'smooth' });
        this.isScrolled = true;
      }
    },

    isMobile() {
      const isMobile = window.innerWidth <= 1000;
      return isMobile;
    },

    copyButtonClass(type) {
      return this.clicked[type] ? 'bg-gray-500 text-white text-xs px-3 py-1 rounded-lg cursor-not-allowed opacity-50' : 'bg-indigo-400 text-white text-xs px-3 py-1 rounded-lg';
    },

    update() {
      this.form.post(`/public-ask`, {
        onSuccess: () => {
          this.form.reset('');
          this.clicked.answer = false;
          this.clicked.explanation = false;
          this.clicked.steps = false;
        }
      })
    },
    toggleUploadSection() {
      this.showUploadSection = !this.showUploadSection
    },
    toggleAdvancedOptions() {
      this.showAdvancedOptions = !this.showAdvancedOptions
    },
  },
}
</script>


<style scoped>
/* Update styles to match the new indigo theme */
.bg-gradient-to-br {
  background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
}

.from-gray-900 {
  --tw-gradient-from: #111827;
  --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(17, 24, 39, 0));
}

.to-gray-800 {
  --tw-gradient-to: #1f2937;
}

.text-transparent {
  color: transparent;
}

.bg-clip-text {
  -webkit-background-clip: text;
  background-clip: text;
}

.from-indigo-400 {
  --tw-gradient-from: #818cf8;
  --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(129, 140, 248, 0));
}

.to-indigo-500 {
  --tw-gradient-to: #6366f1;
}

.btn-indigo {
  background-image: linear-gradient(to right, var(--tw-gradient-stops));
}

.btn-indigo:hover {
  --tw-gradient-from: #6366f1;
  --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(99, 102, 241, 0));
  --tw-gradient-to: #4f46e5;
}

.question-mark {
  display: inline-block;
  font-size: 1.5rem;
  margin-right: 0.5rem;
  animation: flip-spin 5s ease-in-out infinite;
}

@keyframes flip-spin {
  0% { transform: rotate(0deg) scaleY(1); }
  25% { transform: rotate(90deg) scaleY(-1); }
  50% { transform: rotate(180deg) scaleY(1); }
  75% { transform: rotate(270deg) scaleY(-1); }
  100% { transform: rotate(360deg) scaleY(1); }
}

/* Loader styles */
.loader {
  height: 60px;
  aspect-ratio: 1;
  position: relative;
}

.loader::before,
.loader::after {
  content: "";
  position: absolute;
  inset: 0;
  border-radius: 50%;
  transform-origin: bottom;
}

.loader::after {
  background:
    radial-gradient(at 75% 15%, #fffb, #0000 35%),
    radial-gradient(at 80% 40%, #0000, #0008),
    radial-gradient(circle 5px, #fff 94%, #0000),
    radial-gradient(circle 10px, #000 94%, #0000),
    linear-gradient(#818cf8 0 0) top /100% calc(50% - 5px),
    linear-gradient(#fff 0 0) bottom/100% calc(50% - 5px) #000;
  background-repeat: no-repeat;
  animation: l20 1s infinite cubic-bezier(0.5, 120, 0.5, -120);
}

.loader::before {
  background: #1f2937;
  filter: blur(8px);
  transform: scaleY(0.4) translate(-13px, 0px);
}

@keyframes l20 {
  30%, 70% { transform: rotate(0deg) }
  49.99% { transform: rotate(0.2deg) }
  50% { transform: rotate(-0.2deg) }
}
</style>

Version 2 of 2
