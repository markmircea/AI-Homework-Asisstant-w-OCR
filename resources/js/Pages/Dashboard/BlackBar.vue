<template>
  <!-- CTA Section -->
  <section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-gradient-to-r from-gray-900 to-gray-800 rounded-2xl shadow-2xl overflow-hidden transform hover:scale-105 transition-all duration-300">
        <div class="px-6 py-12 sm:px-12 lg:py-16 lg:flex lg:items-center lg:justify-between">
          <div class="lg:w-0 lg:flex-1">
            <h2 class="text-3xl font-extrabold text-white sm:text-4xl">
              <span class="block">Ready to boost your grades?</span>
              <span class="block mt-1 text-indigo-400">Get hired for that new job?</span>
            </h2>
            <p class="mt-4 max-w-3xl text-lg text-gray-300">
              Sign up for our 7-day free trial and experience the power of multi-model AI-assisted learning. <br><br> We provide comprehensive solutions to popular hiring exams and psychometric tests. We can easily help you beat Crossovers timed aptitude test! Simply upload a picture of each of the question and answers and instantly receive the correct response. Our solution also works on visual logic questions!
            </p>
          </div>
          <div class="mt-8 lg:mt-0 lg:ml-8">
            <Link :href="trialLink" class="inline-flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-indigo-700 bg-white hover:bg-indigo-50 hover:text-indigo-600 transition-colors duration-300 shadow-md hover:shadow-lg">
              Start free trial
            </Link>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import { Link } from '@inertiajs/vue3'

export default {
  name: 'BlackBar',
  components: {
    Link
  },
  props: {
    isAuthenticated: {
      type: Boolean,
      required: true
    }
  },
  computed: {
    trialLink() {
      return this.isAuthenticated ? '/pricing' : '/register'
    }
  }
};
</script>
