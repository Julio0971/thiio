<script setup lang="ts">
import { ref, watch } from 'vue'
import { User } from '../../interfaces'
import FormRequest from '../FormRequest.vue'
import ModalDialog from '../ModalDialog.vue'

const url = ref('')
const message = ref('')

const props = defineProps<{
    user: User
    show: boolean
}>()

const emit = defineEmits<{
    (e: 'close'): void
    (e: 'getData'): void
}>()

const getData = () => {
    emit('close')
    emit('getData')
}

watch(() => props.user, user => {
    url.value = `/users/${user.id}`
    message.value = `Are you sure you want to delete user ${user.name}?`
})
</script>

<template>
    <ModalDialog
        :show="props.show"
        title="User delete confirmation"
        @close="emit('close')"
    >
        <FormRequest
            :url="url"
            method="delete"
            :is-valid="true"
            button-text="Confirm"
            @set-data="getData"
        >
            <h3 class="text-center" v-text="message" />
        </FormRequest>
    </ModalDialog>
</template>