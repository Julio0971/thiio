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
            <td v-text="user.name" />
            <td v-text="user.username" />
            <td>
                <v-btn icon color="#0D47A1">

                </v-btn>
            </td>
            <td>
                <v-btn icon color="#00695C">

                </v-btn>
            </td>
            <td>
                <v-btn icon color="#E53935">

                </v-btn>
            </td>
        </tr>
    </TableList>
</template>