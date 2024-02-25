<script setup lang="ts">
import { ref, watch } from 'vue'
import { Pagination } from '../interfaces'

const props = defineProps<{
    pagination: Pagination
}>()

const emit = defineEmits<{
    (e: 'getData', link: string): void
}>()

const current_page = ref(props.pagination.current_page)

watch(() => current_page.value, p => {
    const link = props.pagination.links.find(l => l.label == p.toString())

    if (link) {
        emit('getData', (link.url ?? '').replace(import.meta.env.VITE_API_URL, ''))
    }
})
</script>

<template>
    <v-pagination
        class="my-4"
        v-model="current_page"
        :length="props.pagination.total"
    ></v-pagination>
</template>