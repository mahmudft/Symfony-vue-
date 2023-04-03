import { createApp } from 'vue'
import App from './App.vue'
import Favourite from './components/Favourite.vue'
// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'
import { createRouter, createMemoryHistory } from 'vue-router'
import VueSweetalert2 from 'vue-sweetalert2';

const vuetify = createVuetify({
    components,
    directives,
})


// 2. Define some routes
// Each route should map to a component.
// We'll talk about nested routes later.
const routes = [
    { path: '/favs', component: Favourite, name: 'fav' },
    { path: '/', component: App, name: 'home' },
]

// 3. Create the router instance and pass the `routes` option
// You can pass in additional options here, but let's
// keep it simple for now.
const router = createRouter({
    mode: 'history',
    // 4. Provide the history implementation to use. We are using the hash history for simplicity here.
    history: createMemoryHistory(),
    routes, // short for `routes: routes`
})
createApp(App).use(vuetify).use(router).use(VueSweetalert2).mount('#app')
