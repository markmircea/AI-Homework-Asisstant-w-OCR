<template>
  <div class="bg-gradient-to-b from-indigo-900 to-indigo-700 min-h-screen">
    <Nav :user="user" @subject-selected="handleSubjectSelected" />

    <Hero :selected-subject="localSelectedSubject" />


    <FeatureSection />

    <BlackBar />

    <Steps />

    <DarkDivider />

    <Pricing />

    <ContactUs />


    <Footer />
  </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Nav from './Nav.vue'
import Hero from './Hero.vue'
import FeatureSection from './FeatureSection.vue'
import BlackBar from './BlackBar.vue'
import Steps from './Steps.vue'
import DarkDivider from './DarkDivider.vue'
import Pricing from './Pricing.vue'
import Footer from './Footer.vue'
import ContactUs from './ContactUs.vue'
import PricingPage from './PricingPage.vue'

export default {
  props: {
    user: Object,
    selectedSubject: String,

  },
  components: {
    Head,
    Nav,
    Hero,
    FeatureSection,
    BlackBar,
    Steps,
    DarkDivider,
    Pricing,
    Footer,
    ContactUs,
    PricingPage
  },
  data() {
    return {
      localSelectedSubject: this.selectedSubject || '',
    }
  },
  watch: {
    selectedSubject(newSubject) {
      this.localSelectedSubject = newSubject;
    }
  },
  methods: {
    handleSubjectSelected(subject) {
      this.localSelectedSubject = subject;
    }
  }
}
</script>

<style>
@import 'tailwindcss/base';
@import 'tailwindcss/components';
@import 'tailwindcss/utilities';

/* Custom styles */
.transition-all {
  transition-property: all;
  transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
  transition-duration: 300ms;
}
</style>
