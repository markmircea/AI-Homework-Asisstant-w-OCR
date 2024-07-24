<template>
  <div>

    <Head :title="`${user.first_name} ${user.last_name}`" />
    <div class="flex justify-start mb-8 max-w-3xl">
      <h1 class="text-3xl font-bold">
        <span class="mb-8 text-3xl font-bold">Hi {{ user.first_name }}, let's get started!</span>
      </h1>
    </div>

    <div class="container mt-20">
      <div class="flex flex-col lg:flex-row gap-4">



        <!-- Question Section -->
        <div class="flex-1 bg-white shadow-lg rounded-lg  overflow-hidden">
          <div class="px-8 py-4 bg-white border-b border-gray-200">
            <h2 class="text-xl font-semibold">Question</h2>
          </div>
          <form @submit.prevent="update">
            <div class="flex flex-wrap -mb-8 -mr-6 p-8">

              <!-- Title with Tooltip -->
              <div class="w-full pb-8 pr-6 relative">
                <label for="title" class="block text-sm font-medium text-gray-700 flex items-center">
                  Title
                  <div class="relative inline-block ml-2">
                    <button type="button" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                      class="text-gray-600 transition-colors duration-200 focus:outline-none dark:text-gray-200 dark:hover:text-blue-400 hover:text-blue-500">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                      </svg>
                    </button>
                    <p v-if="showTooltip"
                      class="absolute flex items-center justify-center w-36 p-2 text-gray-600 bg-white rounded-lg shadow-lg left-10 -top-6 dark:shadow-none shadow-gray-200 dark:bg-gray-800 dark:text-white text-xs">
                      <span>Enter the title of your question</span>
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
              <div class="w-full lg:w-1/2 pb-8 pr-6">
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
              <div class="w-full lg:w-1/2 pb-8 pr-6">
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
                <label for="homework_question" class="block text-sm font-medium text-gray-700">Your homework question

                  <div class="relative inline-block ml-2">
                    <button type="button" @mouseover="showTooltip = true" @mouseleave="showTooltip = false"
                      class="text-gray-600 transition-colors duration-200 focus:outline-none dark:text-gray-200 dark:hover:text-blue-400 hover:text-blue-500">
                      <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                        stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                      </svg>
                    </button>
                    <p v-if="showTooltip"
                      class="absolute flex items-center justify-center w-36 p-2 text-gray-600 bg-white rounded-lg shadow-lg left-10 -top-6 dark:shadow-none shadow-gray-200 dark:bg-gray-800 dark:text-white text-xs">
                      <span>Enter the title of your question</span>
                      <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute w-4 h-4 text-white transform rotate-45 -translate-y-1/2 fill-current -left-2 top-1/2 dark:text-gray-800"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M20 3H4a1 1 0 0 0-1 1v16a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1z"></path>
                      </svg>
                    </p>
                  </div>
                </label>

                <textarea v-model="form.question" id="question" rows="4"
                  class="mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                  placeholder="Enter your homework question here..."></textarea>
              </div>

              <!-- Expandable Area for Upload File or Image -->
              <div class="w-full pb-8 pr-6">
                <div @click="toggleUploadSection" class="cursor-pointer">
                  <h3 class="text-lg font-semibold text-indigo-600">
                    {{ showUploadSection ? '- Hide Upload' : '+ Add Upload' }}
                  </h3>
                  <hr class="my-2 border-gray-300" />
                </div>
                <transition name="fade">
                  <div v-if="showUploadSection" class="mt-4 p-4 border border-gray-300 rounded-md bg-gray-50">

                    <file-input v-model="form.photo" :error="form.errors.photo" class="pb-8 pr-6 w-full lg:w-1/2"
                      type="file" accept="image/*" label="Photo" />
                    <!-- Image Upload -->
                    <ImageUpload v-model="form.photo" :error="form.errors.photo" class="w-full lg:w-100%" type="file"
                      accept="image/*" label="Photo" />

                  </div>
                </transition>
              </div>

              <!-- Advanced Options Section -->
              <div class="w-full pb-8 pr-6">
                <div @click="toggleAdvancedOptions" class="cursor-pointer">
                  <h3 class="text-lg font-semibold text-indigo-600">{{ showAdvancedOptions ? '- Hide Advanced Options' :
                    '+ Show Advanced Options' }}</h3>
                  <hr class="my-2 border-gray-300" />
                </div>
                <transition name="fade">
                  <div v-if="showAdvancedOptions" class="mt-4 p-4 border border-gray-300 rounded-md bg-gray-50">
                    <div class="flex items-center mb-4">
                      <input v-model="form.explain" id="explanation" type="checkbox" class="mr-2" />
                      <label for="explain" class="text-sm font-medium text-gray-700">Explain why the answer is
                        correct</label>
                    </div>
                    <div class="flex items-center">
                      <input v-model="form.steps" id="steps" type="checkbox" class="mr-2" />
                      <label for="steps" class="text-sm font-medium text-gray-700">Show the work done to get to the
                        answer</label>
                    </div>
                  </div>
                </transition>
              </div>


            </div>
            <div class="flex items-center px-8 py-4 bg-gray-50 border-t border-gray-100">

              <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update
                User</loading-button>
            </div>
          </form>
        </div>

        <!-- Response Settings Section -->
        <div class="flex-1 bg-white shadow-lg rounded-lg overflow-hidden ">
          <div class="bg-white shadow-lg rounded-lg overflow-hidden h-full">
            <div class="px-8 py-4 bg-white border-b border-gray-200">
              <h2 class="text-xl font-semibold">Response</h2>
            </div>


            <div class="p-4">
              <!-- Loader Section -->
              <div id="answer-loader" v-if="form.processing">
                <div class="flex justify-center items-center">
                  <div>
                    <svg class="w-60 h-60" width="240" height="240" viewBox="0 0 240 240">
                      <circle class="text-gray-400" cx="120" cy="120" r="105" fill="none" stroke="currentColor"
                        stroke-width="20" stroke-dasharray="0 660" stroke-dashoffset="-330" stroke-linecap="round">
                      </circle>
                      <circle class="text-gray-400" cx="120" cy="120" r="35" fill="none" stroke="currentColor"
                        stroke-width="20" stroke-dasharray="0 220" stroke-dashoffset="-110" stroke-linecap="round">
                      </circle>
                      <circle class="text-gray-400" cx="85" cy="120" r="70" fill="none" stroke="currentColor"
                        stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                      <circle class="text-gray-400" cx="155" cy="120" r="70" fill="none" stroke="currentColor"
                        stroke-width="20" stroke-dasharray="0 440" stroke-linecap="round"></circle>
                    </svg>
                  </div>
                </div>
                <div class="text-center mt-4">
                  <h6 class="text-gray-600">One moment while I get the answer...</h6>
                  <div id="answer-loader-text" class="text-gray-500">
                    Did you know that the average human attention span is 8 seconds?
                  </div>
                </div>
              </div>

              <!-- Result Section -->
              <div id="result-card">
                <h5 class="text-lg font-semibold mt-4 mb-2" id="result-scroll-point">Answer</h5>
                <div>
                  <label class="flex justify-between items-end mb-2">
                    <span class="text-gray-600"><i class="fa-solid fa-comments mr-2"></i> The answer to your
                      question</span>

                    <a class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg cursor-not-allowed opacity-50"
                      href="javascript:;" aria-disabled="true">Copy</a>
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
                      <span class="text-gray-600"><i class="fa-solid fa-pen-to-square mr-2"></i> The explanation to
                        your question</span>
                      <a class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg cursor-not-allowed opacity-50"
                        href="javascript:;" aria-disabled="true">Copy</a>
                    </label>
                    <div class="form-textarea mt-1 block w-full bg-gray-50 border border-gray-300 rounded-md shadow-sm"
                      rows="3">
                      {{ explainResponse || placeholderExplain }}
                    </div>
                  </div>
                </div>

                <div class="mt-5">
                  <h5 class="text-lg font-semibold mb-2">Steps</h5>
                  <div>
                    <label class="flex justify-between items-end mb-2">
                      <span class="text-gray-600"><i class="fa-solid fa-list-ol mr-2"></i> The steps to your
                        question</span>
                      <a class="bg-blue-500 text-white text-xs px-3 py-1 rounded-lg cursor-not-allowed opacity-50"
                        href="javascript:;" aria-disabled="true">Copy</a>
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

<script setup>


const placeholderAnswer = 'Ask away!';
const placeholderExplain = 'You can enable explanations in "Advanced Options" under the question box'
const placeholderSteps = 'You can enable steps in "Advanced Options" under the question box'
</script>

<script>
import { Head, Link } from '@inertiajs/vue3'
import Layout from '@/Shared/Layout.vue'
import TextInput from '@/Shared/TextInput.vue'
import FileInput from '@/Shared/FileInput.vue'
import SelectInput from '@/Shared/SelectInput.vue'
import LoadingButton from '@/Shared/LoadingButton.vue'
import ImageUpload from '../../Shared/ImageUpload.vue'

export default {
  components: {
    FileInput,
    Head,
    Link,
    LoadingButton,
    SelectInput,
    TextInput,
    ImageUpload,
  },
  layout: Layout,

  props: {
    user: Object,
    response: String,
    explainResponse: String,
    stepsResponse: String,


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
        photo: null,
      }),
      showTooltip: false,
      showUploadSection: false,
      showAdvancedOptions: false,
    }
  },

  methods: {
    update() {
      console.log('Form data:', this.form)

      this.form.post(`/ask`, {
        onSuccess: () => this.form.reset(''),
      })
    },

    toggleUploadSection() {
      console.log('Toggle Advanced Options clicked');

      this.showUploadSection = !this.showUploadSection
    },
    toggleAdvancedOptions() {
      this.showAdvancedOptions = !this.showAdvancedOptions

    },
  },
}
</script>

<style>
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
  /* Smaller padding */
  border-radius: 4px;
  white-space: nowrap;
  font-size: 0.625rem;
  /* Smaller font size */
  z-index: 10;
}


/* Fade transition for the expandable section */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.5s;
}

.fade-enter,
.fade-leave-to

/* .fade-leave-active in <2.1.8 */
  {
  opacity: 0;
}





.form-textarea {
  white-space: pre-wrap;
  /* Ensures whitespace and line breaks are preserved */
  overflow: auto;
  resize: none;
  min-height: 4em;
  /* Adjust the height as needed */
  padding: 0.5em;
}
</style>
