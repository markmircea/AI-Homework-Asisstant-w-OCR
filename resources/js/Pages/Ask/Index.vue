<template>
  <div>
    <full-page-loader />

    <Head :title="`${user.first_name} ${user.last_name}`" />

    <div class="container bg-gray-100 min-h-screen py-12 px-4 sm:px-6 lg:px-8">
      <div class="hidden lg:block text-center mb-12">
        <h1 class="text-xl font-extrabold text-gray-900 sm:text-2xl md:text-3xl">
          <span class="hidden lg:block">Hi {{ user.first_name }}, let's get started!</span>
        </h1>
      </div>
      <div class="flex flex-col lg:flex-row gap-4">

        <!-- Question Section -->
        <div class="flex-1 bg-white shadow-lg rounded-lg overflow-hidden">
          <div class="px-8 py-4 bg-gradient-to-r from-indigo-400 to-indigo-600 text-white border-gray-200">
            <h2 class="text-s font-medium text-white uppercase tracking-wider font-semibold">Question</h2>
          </div>
          <form @submit.prevent="update">
            <div class="flex flex-wrap -mb-8 -mr-6 p-8">
              <!-- Title with Tooltip -->
              <div class="w-full pb-8 pr-6 relative">
                <label for="title" class="block text-sm font-medium text-gray-700 flex items-center">
                  Title
                  <div class="relative inline-block ml-2">
                    <button type="button" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                      class="text-gray-600 transition-colors duration-200 hover:text-indigo-500">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                      </svg>
                    </button>
                    <p v-if="showTooltip"
                      class="absolute flex items-center justify-center w-36 p-2 text-gray-600 bg-white rounded-lg shadow-lg left-10 -top-6 dark:shadow-none shadow-gray-200 dark:bg-gray-800 dark:text-white text-xs">
                      <span>The title is only used to make searching your query history easier. You can use the title to
                        organize your searches better.</span>
                      <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute w-4 h-4 text-white transform rotate-45 -translate-y-1/2 fill-current -left-2 top-1/2 dark:text-gray-800"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20 3H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z"></path>
                      </svg>
                    </p>
                  </div>
                </label>
                <input v-model="form.title" id="title" type="text"
                  class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  placeholder="Enter the title here...(Optional)" />
              </div>

              <!-- Subject and Level Selection -->
              <div class="w-full pb-8 pr-6">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <select v-model="form.subject" id="subject"
                  class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="" disabled selected>Auto-Detect</option>
                  <option value="Biology">Biology</option>
                  <option value="Chemistry">Chemistry</option>
                  <option value="Computer-Science">Computer Science</option>
                  <option value="Economics">Economics</option>
                  <option value="English">English</option>
                  <option value="Geography">Geography</option>
                  <option value="History">History</option>
                  <option value="Mathematics">Mathematics</option>
                  <option value="Physics">Physics</option>
                  <option value="Science">Science</option>
                </select>
              </div>
              <div class="w-full pb-8 pr-6">
                <label for="level" class="block text-sm font-medium text-gray-700">Level</label>
                <select v-model="form.level" id="level"
                  class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                  <option value="" selected>Any Level</option>
                  <option value="1-5th grade">1-5th grade</option>
                  <option value="6-8th grade">6-8th grade</option>
                  <option value="9-12th grade">9-12th grade</option>
                  <option value="University">University</option>
                  <option value="Masters">Masters</option>
                  <option value="Expert">Expert</option>
                </select>
              </div>

              <!-- Text Area for Homework Question -->
              <div class="w-full pb-8 pr-6">
                <div class="flex items-center justify-between mb-2">
                  <label for="homework_question" class="block text-sm font-medium text-gray-700">Your homework
                    question</label>
                  <button type="button" @click="toggleUploadSection"
                    class="flex items-center px-3 py-2 text-sm font-medium text-white bg-indigo-400 rounded-md hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                      stroke="currentColor" class="upload-button w-5 h-5 ">
                      <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                  </button>
                </div>
                <textarea v-model="form.question" id="question" rows="4"
                  class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  placeholder="Enter your homework question here..."></textarea>
              </div>

              <!-- Accordion for Upload and Advanced Options -->
              <div class="w-full pb-8 pr-6">
                <!-- Upload Section -->
                <div class="border border-gray-200 rounded-md mb-4">
                  <button type="button" @click.prevent="toggleUploadSection"
                    class="w-full px-4 py-2 text-left font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none flex justify-between items-center">
                    <span>{{ showUploadSection ? 'Hide Upload' : 'Add Upload' }}</span>
                    <svg class="w-5 h-5 transform transition-transform duration-200"
                      :class="{ 'rotate-180': showUploadSection }" xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                  <div v-show="showUploadSection" class="px-4 py-2 bg-white">
                    <div class="flex flex-col items-center space-y-4">
                      <div class="w-full">
                        <FileUpload v-model="form.photo" :error="form.errors.photo" name="photo"
                          label="Upload File or Image" required @input="handleFileUpload" />
                      </div>
                      <div class="w-full flex justify-center">
                        <button @click="captureScreenshot" type="button"
                          :class="[
                            'px-3 py-2 text-sm font-medium rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150 ease-in-out flex items-center',
                            screenshotCaptured ? 'bg-green-500 hover:bg-green-600 text-white' : 'bg-indigo-400 hover:bg-indigo-500 text-white'
                          ]">
                          <svg v-if="!screenshotCaptured" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                              d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                          </svg>
                          <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5 mr-2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                          </svg>
                          {{ screenshotCaptured ? 'Captured' : 'Screenshot' }}
                        </button>
                      </div>
                    </div>
                    <div v-if="form.photo" class="mt-4">
                      <p class="text-sm text-gray-600 mb-1">
                        {{ screenshotCaptured ? 'Screenshot captured:' : 'File uploaded:' }}
                      </p>
                      <div class="flex items-center">
                        <img v-if="imagePreview" :src="imagePreview" alt="Image preview" class="max-w-xs h-20 object-cover rounded-md shadow-sm mr-2" />
                        <span class="text-sm text-gray-500">{{ form.photo.name }}</span>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Advanced Options Section -->
                <div class="border border-gray-200 rounded-md">
                  <button @click.prevent="toggleAdvancedOptions"
                    class="w-full px-4 py-2 text-left font-semibold text-indigo-600 hover:bg-indigo-50 focus:outline-none flex justify-between items-center">
                    <span>{{ showAdvancedOptions ? 'Hide Advanced Options' : 'Show Advanced Options' }}</span>
                    <svg class="w-5 h-5 transform transition-transform duration-200"
                      :class="{ 'rotate-180': showAdvancedOptions }" xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20" fill="currentColor">
                      <path fill-rule="evenodd"
                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                        clip-rule="evenodd" />
                    </svg>
                  </button>
                  <div v-show="showAdvancedOptions" class="px-4 py-2 bg-white">
                    <div class="flex items-center mb-4">
                      <input v-model="form.explain" id="explanation" type="checkbox" class="mr-2" />
                      <label for="explain" class="text-sm font-medium text-gray-700">Explain why the answer is
                        correct</label>
                    </div>

                    <div class="flex items-center mb-8">
                      <input v-model="form.steps" id="steps" type="checkbox" class="mr-2" />
                      <label for="steps" class="text-sm font-medium text-gray-700">Show the work done to get to the
                        answer</label>
                    </div>
                    <div class="w-full pb-8 pr-6">
                      <label for="tokensCost" class="block text-sm font-medium text-gray-700">Response Length</label>
                      <select v-model="form.tokensCost" id="tokensCost"
                        class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="200" selected>Default 200 Tokens</option>
                        <option value="100">100 Tokens</option>
                        <option value="400">400 Tokens</option>
                        <option value="600">600 Tokens</option>
                        <option value="800">800 Tokens</option>
                        <option value="1000">1000 Tokens</option>
                        <option value="1500">1500 Tokens</option>
                      </select>
                    </div>
                    <div class="w-full pb-8 pr-6">
                      <label for="temperature" class="block text-sm font-medium text-gray-700">Creativity (Higher = More
                        Creative, Lower = Logical)</label>
                      <select v-model="form.temperature" id="temperature"
                        class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="0.6" selected>0.6</option>
                        <option value="0.0">0.0</option>
                        <option value="0.2">0.2</option>
                        <option value="0.4">0.4</option>
                        <option value="0.8">0.8</option>
                        <option value="1.0">1.0</option>
                      </select>
                    </div>
                    <div class="w-full pb-8 pr-6">
                      <label for="model" class="block text-sm font-medium text-gray-700">AI Model</label>
                      <select v-model="form.model" id="model"
                        class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                        <option value="gpt-4o-mini" selected>GPT-4o Mini</option>
                        <option value="gpt-4-turbo">GPT-4 Turbo</option>
                        <option value="gpt-4o">GPT-4o</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">
              <loading-button :loading="form.processing"
                class="w-full btn-indigo1 transition-colors duration-200 hover:text-indigo-500 flex items-center justify-center space-x-2"
                type="submit">
                <span
                  class="inline-block mr-2 transition-transform group-hover:translate-x-1 motion-safe:animate-bounce">🚀</span>
                Ask
                <span class="hidden md:inline">Question</span>
              </loading-button>
            </div>
          </form>
        </div>
        <!-- Response Settings Section -->
        <div class="flex-1 bg-white shadow-lg rounded-lg overflow-hidden ">
          <div class=" h-full">
            <div class="px-8 py-4 bg-gradient-to-r from-indigo-500 to-indigo-700 text-white border-gray-200">
              <h2 class="text-s font-medium text-white uppercase tracking-wider font-semibold">Response</h2>
            </div>
            <div class="p-4">
              <!-- Loader Section -->
              <div id="answer-loader" v-if="form.processing" class="flex flex-col items-center  ">
                <div class="loader mb-10 mt-10"></div>
                <div class="text-center mt-4">
                  <h6 class="text-gray-600">One moment while I get the answer...</h6>
                  <div class="text-gray-500">
                    Did you know that the average human attention span is 8 seconds?
                  </div>
                </div>
              </div>
              <!-- Result Section -->
              <div id="result-card" ref="responseSection">
                <h5 class="text-lg font-semibold mt-4 mb-2" id="result-scroll-point">Answer</h5>
                <div>
                  <label class="flex justify-between items-end mb-2">
                    <span class="text-gray-600">
                      <i class="fa-solid fa-comments mr-2"></i>
                      The answer to your question
                    </span>
                    <a :class="copyButtonClass('answer')" @click="copyToClipboard('answer')"
                      :aria-disabled="!response || clicked.answer" href="javascript:;">
                      Copy
                    </a>
                  </label>
                  <div class="form-textarea mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm"
                    rows="3">
                    {{ response || placeholderAnswer }}
                  </div>
                </div>
                <div class="mt-5">
                  <h5 class="text-lg font-semibold mb-2">Explanation</h5>
                  <div>
                    <label class="flex justify-between items-end mb-2">
                      <span class="text-gray-600">
                        <i class="fa-solid fa-comments mr-2"></i>
                        Explanation of the answer
                      </span>
                      <a :class="copyButtonClass('explanation')" @click="copyToClipboard('explanation')"
                        :aria-disabled="!explanation || clicked.explanation" href="javascript:;">
                        Copy
                      </a>
                    </label>
                    <div class="form-textarea mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm"
                      rows="3">
                      {{ explainResponse || placeholderExplain }}
                    </div>
                  </div>
                </div>
                <div class="mt-5 pb-5">
                  <h5 class="text-lg font-semibold mb-2">Steps</h5>
                  <div>
                    <label class="flex justify-between items-end mb-2">
                      <span class="text-gray-600">
                        <i class="fa-solid fa-comments mr-2"></i>
                        Steps to solve the problem
                      </span>
                      <a :class="copyButtonClass('steps')" @click="copyToClipboard('steps')"
                        :aria-disabled="!steps || clicked.steps" href="javascript:;">
                        Copy
                      </a>
                    </label>
                    <div class="form-textarea mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm"
                      rows="3">
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
</template>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import FileUpload from '../../Shared/FileUpload.vue'
import FullPageLoader from '../../Shared/FullPageLoader.vue'

export default {
  components: {
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    FileUpload,
    FullPageLoader
  },
  layout: Layout,

  props: {
    user: Object,
    response: String,
    explainResponse: String,
    stepsResponse: String,
    remainingQuestions: Number,
  },
  remember: 'form',

  data() {
    return {
      form: this.$inertia.form({
        _method: 'post',
        id: this.user.id,
        title: '',
        subject: '',
        level: '',
        question: '',
        explain: '',
        steps: '',
        tokensCost: 200,
        temperature: 0.6,
        model: "gpt-4o-mini",
        photo: null,
      }),
      showTooltip: false,
      showUploadSection: false,
      showAdvancedOptions: false,
      screenshotCaptured: false,
      imagePreview: null,
      clicked: {
        answer: false,
        explanation: false,
        steps: false
      },
    }
  },

  methods: {
    copyToClipboard(type) {
      let textToCopy = '';

      if (type === 'answer') {
        textToCopy = this.response || this.placeholderAnswer;
        this.clicked.answer = true;
      } else if (type === 'explanation') {
        textToCopy = this.explainResponse || this.placeholderExplanation;
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

    copyButtonClass(type) {
      return this.clicked[type] ? 'bg-gray-500 text-white text-xs px-3 py-1 rounded-lg cursor-not-allowed opacity-50' : 'bg-indigo-400 text-white text-xs px-3 py-1 rounded-lg';
    },

    async captureScreenshot() {
      if (!navigator.mediaDevices || !navigator.mediaDevices.getDisplayMedia) {
        alert("Your browser doesn't support screenshot capture. Please use the file upload option.");
        return;
      }

      const activeElement = document.activeElement;

      try {
        const stream = await navigator.mediaDevices.getDisplayMedia({
          video: {
            displaySurface: "window",
          },
          audio: false,
          selfBrowserSurface: "include",
        });

        const video = document.createElement('video');
        video.srcObject = stream;
        video.autoplay = true;

        await new Promise((resolve) => {
          video.onloadeddata = resolve;
        });

        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);

        stream.getTracks().forEach(track => track.stop());

        const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/png'));
        const file = new File([blob], "screenshot.png", { type: "image/png" });

        this.form.photo = file;
        this.screenshotCaptured = true;
        this.imagePreview = URL.createObjectURL(blob);

      } catch (error) {
        if (error.name === 'AbortError') {
          console.log('User cancelled the screenshot capture');
        } else {
          console.error("Error capturing screenshot:", error);
          alert("Failed to capture screenshot. Please try again or use the file upload option.");
        }
      } finally {
        if (activeElement && typeof activeElement.focus === 'function') {
          activeElement.focus();
        }
        window.focus();
      }
    },

    handleFileUpload(event) {
      const file = event.target.files[0];
      if (file) {
        this.screenshotCaptured = false;
        this.imagePreview = URL.createObjectURL(file);
      }
    },

    update() {
      this.form.post(`/ask`, {
        onSuccess: () => {
          this.form.reset('');
          this.clicked.answer = false;
          this.clicked.explanation = false;
          this.clicked.steps = false;
        }
      });
    },

    toggleUploadSection() {
      this.showUploadSection = !this.showUploadSection;
    },

    toggleAdvancedOptions() {
      this.showAdvancedOptions = !this.showAdvancedOptions;
    },

    scrollToResponse() {
      const responseSection = this.$refs.responseSection;
      if (responseSection) {
        responseSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    },
  },

  watch: {
    'form.photo': function (newVal) {
      if (newVal && !this.screenshotCaptured) {
        this.screenshotCaptured = false;
        this.screenshotPreview = null;
      }
    },
    response(newVal, oldVal) {
      if (newVal && newVal !== oldVal) {
        this.$nextTick(() => {
          this.scrollToResponse();
        });
      }
    },
    explainResponse(newVal, oldVal) {
      if (newVal && newVal !== oldVal) {
        this.$nextTick(() => {
          this.scrollToResponse();
        });
      }
    },
    stepsResponse(newVal, oldVal) {
      if (newVal && newVal !== oldVal) {
        this.$nextTick(() => {
          this.scrollToResponse();
        });
      }
    },
  },
}
</script>

<style>
/* General form styling */
.container {
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
  padding: 2rem;
  border-radius: 1rem;
}

/* Card styling */
.bg-white {
  background-color: rgba(255, 255, 255, 0.95);
  border-radius: 1rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
}

.bg-white:hover {
  transform: translateY(-5px);
  box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Input styling */
input[type="text"],
textarea,
select {
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  padding: 0.75rem 1rem;
  transition: all 0.3s ease;
}


input[type="text"]:focus,
textarea:focus,
select:focus {
  border-color: #4f46e5;
  box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
  outline: none;
}

/* Button styling */
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

/* Accordion styling */
.border {
  border-radius: 0.5rem;
  overflow: hidden;
  transition: all 0.3s ease;
}

.border:hover {
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

/* Checkbox styling */
input[type="checkbox"] {
  appearance: none;
  width: 1.5rem;
  height: 1.5rem;
  border: 2px solid #4f46e5;
  border-radius: 0.25rem;
  transition: all 0.3s ease;
}

input[type="checkbox"]:checked {
  background-color: #4f46e5;
  background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E");
  background-size: 100% 100%;
  background-position: center;
  background-repeat: no-repeat;
}

/* Tooltip styling */
.tooltip {
  background-color: #1f2937;
  color: white;
  padding: 0.5rem 1rem;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
}

* {
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Animated Question Mark */
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

/* Tooltip styles */
.relative .tooltip {
  display: none;
}

.relative:hover .tooltip {
  display: block;
}

.tooltip {
  position: absolute;
  top: 100%;
  left: 100%;
  transform: translateX(10px);
  background-color: #333;
  color: #fff;
  padding: 2px 4px;
  border-radius: 4px;
  white-space: nowrap;
  font-size: 0.625rem;
  z-index: 10;
}

/* Fade transition for the expandable section */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.form-textarea {
  white-space: pre-wrap;
  overflow: auto;
  resize: none;
  min-height: 4em;
  padding: 0.5em;
}

/* Loader */
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
    linear-gradient(#F93318 0 0) top /100% calc(50% - 5px),
    linear-gradient(#fff 0 0) bottom/100% calc(50% - 5px) #000;
  background-repeat: no-repeat;
  animation: l20 1s infinite cubic-bezier(0.5, 120, 0.5, -120);
}

.loader::before {
  background: #ddd;
  filter: blur(8px);
  transform: scaleY(0.4) translate(-13px, 0px);
}

@keyframes l20 {
  30%, 70% { transform: rotate(0deg) }
  49.99% { transform: rotate(0.2deg) }
  50% { transform: rotate(-0.2deg) }
}

/* Smooth transition for accordion content */
.accordion-content-enter-active,
.accordion-content-leave-active {
  transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
  max-height: 1000px;
  opacity: 1;
}

.accordion-content-enter-from,
.accordion-content-leave-to {
  max-height: 0;
  opacity: 0;
}

/* Add these new styles for responsiveness */
@media (max-width: 640px) {
  .container {
    padding-left: 1rem;
    padding-right: 1rem;
  }

  .flex-1 {
    width: 100%;
  }

  select,
  textarea,
  .form-textarea {
    width: 100% !important;
  }
}
</style>

