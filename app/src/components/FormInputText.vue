<script setup lang="ts">
const model = defineModel()

const props = defineProps<{
    icon: string
    label: string
    error?: string
    required: boolean
    type: 'text' | 'password'
    rules: ((value: string) => boolean | string)[]
}>()
</script>

<template>
    <v-text-field
        persistent-hint
        v-model="model"
        :type="props.type"
        :hint="props.error"
        variant="underlined"
        :label="props.label"
        :rules="props.rules"
        :required="props.required"
        :prepend-icon="`fas fa-${props.icon}`"
    />
</template>