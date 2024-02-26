import { ref } from 'vue'
import { defineStore } from 'pinia'
import { User } from '../interfaces'

export const useStore = defineStore('auth', () => {
    const user = ref({} as User)
    const snackbar_text = ref('')
    const show_snackbar = ref(false)
    const snackbar_type = ref('' as 'success' | 'error')
    const api_token = ref(localStorage.getItem('api_token') ?? '')

    return {
        user,
        api_token,
        show_snackbar,
        snackbar_type,
        snackbar_text,
    }
})