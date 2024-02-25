import App from './App.vue'
import { createApp } from 'vue'
import { router } from './router'

// Vuetify
import 'vuetify/styles'
import { createVuetify } from 'vuetify'
import * as components from 'vuetify/components'
import * as directives from 'vuetify/directives'

import './assets/css/styles.css'

const vuetify = createVuetify({
    components,
    directives,
})

// Create app
const app = createApp(App)

app.use(router)
app.use(vuetify)
app.mount('#app')