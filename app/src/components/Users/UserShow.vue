<script setup lang="ts">
import { User } from '../../interfaces'
import ModalDialog from '../ModalDialog.vue'

const props = defineProps<{
    user: User
    show: boolean
}>()

const emit = defineEmits<{
    (e: 'close'): void
}>()
</script>

<template>
    <ModalDialog
        :show="props.show"
        title="User info"
        @close="emit('close')"
    >
        <v-text-field
            disabled
            label="Name"
            variant="underlined"
            :model-value="user.name"
        ></v-text-field>
        
        <v-text-field
            disabled
            label="Username"
            variant="underlined"
            :model-value="user.username"
        ></v-text-field>
    </ModalDialog>
</template>