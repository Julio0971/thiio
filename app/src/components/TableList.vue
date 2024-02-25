<script setup lang="ts">
import { onMounted, ref, watch } from 'vue'
import { useFetch } from '../composables'

const loading = ref(true)

const props = defineProps<{
    url: string
    refresh: number
    headers: string[]
}>()

const emit = defineEmits<{
    (e: 'setRecords', records: Object[]): void
}>()

const getData = async (url: string) => {
    loading.value = true

    try {
        const { response, res } = await useFetch('get', url)

        if (response.ok) {
            emit('setRecords', res.data as Object[])
        } else {
            throw new Error(res.message)
        }
    } catch (error) {
        console.log(error)
    } finally {
        loading.value = false
    }
}

watch(() => props.refresh, () => getData(props.url))

onMounted(() => getData(props.url))
</script>

<template>
    <transition name="fade" mode="out-in">
        <span aria-busy="true" v-if="loading">
            Loading...
        </span>

        <v-table v-else>
            <thead>
                <tr>
                    <th
                        v-text="header"
                        v-for="header in props.headers"
                    />
                </tr>
            </thead>
            <tbody>
                <slot />
            </tbody>
        </v-table>
    </transition>
</template>