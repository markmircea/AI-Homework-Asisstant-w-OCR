<template>
  <div class="bg-gradient-to-b from-indigo-900 to-indigo-700 min-h-screen">
    <Hero :selected-subject="localSelectedSubject" :isAuthenticated="$page.props.auth.user !== null" />

    <Nav :user="user" @subject-selected="handleSubjectSelected" />



    <FeatureSection />


    <Steps />

    <DarkDivider />

    <Pricing />

    <ContactUs />

    <Footer />

    <div class="md:flex-1 md:p-12 md:overflow-y-auto" scroll-region>
            <flash-messages-vue ref="FlashMessages"/>
            <slot />
          </div>
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
import FlashMessagesVue from '../../Shared/FlashMessages.vue'

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
    PricingPage,
    FlashMessagesVue
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
