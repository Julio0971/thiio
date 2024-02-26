<script setup lang="ts">
import { useFetch } from '../composables'
import { Pagination } from '../interfaces'
import { onMounted, ref, watch } from 'vue'
import TablePagination from './TablePagination.vue'

const loading = ref(true)
const pagination = ref({} as Pagination)

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
            pagination.value = res as Pagination

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
        <div class="d-flex justify-center" v-if="loading" key="loading">
            <v-progress-circular indeterminate />
        </div>

        <div v-else key="data">
            <v-table >
                <thead>
                    <tr>
                        <th
                            v-text="header"
                            class="text-center"
                            v-for="header in props.headers"
                        />
                    </tr>
                </thead>
                <tbody>
                    <slot />
                </tbody>
            </v-table>

            <TablePagination
                :pagination="pagination"
                @get-data="getData"
            />
        </div>
    </transition>
</template>