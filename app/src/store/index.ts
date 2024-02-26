import { ref } from 'vue'
import { defineStore } from 'pinia'
import { User } from '../interfaces'

export const useStore = defineStore('auth', () => {
    const user = ref({} as User)
    const snackbar_text = ref('')
    const show_snackbar = ref(false)
    const snackbar_type = ref('' as 'success' | 'error')
    const access_token = ref(localStorage.getItem('access_token') ?? '')

    return {
        user,
        access_token,
        show_snackbar,
        snackbar_type,
        snackbar_text,
    }
})