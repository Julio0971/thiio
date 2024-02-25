<script setup lang="ts">
import { ref } from 'vue'
import { User } from '../interfaces'
import TableList from '../components/TableList.vue'

const props = defineProps<{
    refresh: number
}>()

const users = ref([] as User[])
const headers = ref([
    'Name',
    'Username',
    'Show',
    'Edit',
    'Delete',
])

const setRecords = (records: Object[]) => {
    users.value = records as User[]
}
</script>

<template>
    <TableList
        url="/users"
        :headers="headers"
        :refresh="props.refresh"
        @set-records="setRecords"
    >
        <tr v-for="user in users">
            <td class="text-center" v-text="user.name" />
            <td class="text-center" v-text="user.username" />
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#0D47A1"
                    icon="fas fa-eye"
                />
            </td>
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#00695C"
                    icon="fas fa-edit"
                />
            </td>
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#E53935"
                    icon="fas fa-trash"
                />
            </td>
        </tr>
    </TableList>
</template>