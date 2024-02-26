<script setup lang="ts">
const props = defineProps<{
    show: boolean
    title: string
}>()

const emit = defineEmits<{
    (e: 'close'): void
}>()
</script>

<template>
    <v-dialog
        persistent
        width="500"
        v-model="props.show"
        transition="dialog-top-transition"
    >
        <v-card :title="props.title">
            <v-card-text>
                <slot />

                <v-btn
                    block
                    class="mt-4"
                    text="Close"
                    variant="flat"
                    color="#E53935"
                    @click="emit('close')"
                />
            </v-card-text>
        </v-card>
    </v-dialog>
</template>