require('./bootstrap');

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import store from './stores'
import globalComponents from "./global-components";
const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';

createInertiaApp({
  title: (title) => `${title} - ${appName}`,
  resolve: (name) => require(`./Pages/${name}.vue`),
  setup({ el, app, props, plugin }) {
    const myapp = createApp({ render: () => h(app, props) })
      .use(plugin)
      .use(store)
      .mixin({ methods: { route } })

    globalComponents(myapp);
    myapp.provide('moment', require('moment') );
    return myapp.mount(el);
  },
});


InertiaProgress.init({ color: '#ffffff' });
