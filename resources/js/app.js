import '../css/app.css'
import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import resizable from './directives/resizable'; // Import the directive




createInertiaApp({
  resolve: name => {
    const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
    return pages[`./Pages/${name}.vue`]
  },
  title: title => title ? `${title} - Easy Ace AI` : 'Easy Ace AI',
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) });

    app.directive('resizable', resizable); // Register the directive

    app.use(plugin).mount(el);
  },

})
