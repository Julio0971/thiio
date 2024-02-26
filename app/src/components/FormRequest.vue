<script setup lang="ts">
import { ref } from 'vue'
import { useStore } from '../store'
import { useFetch } from '../composables'

const store = useStore()

const loading = ref(false)
const validation_errors = ref({} as any)

const props = defineProps<{
    url: string
    data?: Object
    isValid: boolean
    buttonText: string
    method: 'post' | 'put' | 'delete'
}>()

const emit = defineEmits<{
    (e: 'setData', data: any): void
    (e: 'setValidationErrors', validation_errors: any): void
}>()

const save = async () => {
    if (!props.isValid) {
        return
    }

    loading.value = true

    try {
        const { response, res } = await useFetch(props.method, props.url, props.data)

        if (response.ok) {
            if (res.message) {
                store.show_snackbar = true
                store.snackbar_type = 'success'
                store.snackbar_text = res.message
            }

            emit('setData', res)
            emit('setValidationErrors', {})
        } else if (response.status == 422) {
            validation_errors.value = {}

            Object.entries(res.errors).map((item: any) => {
                validation_errors.value[item[0]] = item[1][0]
            })

            emit('setValidationErrors', validation_errors.value)
        } else {
            throw new Error(res.message)
        }
    } catch (error) {
        store.show_snackbar = true
        store.snackbar_type = 'error'
        store.snackbar_text = error as string
    } finally {
        loading.value = false
    }
}
</script>

<template>
    <v-form @submit.prevent="save">
        <slot />
    
        <v-btn
            block
            class="mt-3"
            type="submit"
            color="#1A237E"
            :loading="loading"
            :disabled="loading"
            :text="props.buttonText"
        />
    </v-form>
</template>