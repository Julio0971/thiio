<script setup lang="ts">
import { ref } from 'vue'
import { User } from '../../interfaces'
import TableList from '../TableList.vue'

const props = defineProps<{
    refresh: number
}>()

const emit = defineEmits<{
    (e: 'showUserInfo', user: User): void
    (e: 'showUserForm', user: User): void
    (e: 'showUserDeletion', user: User): void
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
        <tr v-if="users.length == 0">
            <td class="text-center" :colspan="headers.length">
                No users to show
            </td>
        </tr>

        <tr v-for="user in users">
            <td class="text-center" v-text="user.name" />
            <td class="text-center" v-text="user.username" />
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#0D47A1"
                    icon="fas fa-eye"
                    @click="emit('showUserInfo', user)"
                />
            </td>
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#00695C"
                    icon="fas fa-edit"
                    @click="emit('showUserForm', user)"
                />
            </td>
            <td class="text-center">
                <v-btn
                    class="pb-1"
                    variant="text"
                    color="#E53935"
                    icon="fas fa-trash"
                    @click="emit('showUserDeletion', user)"
                />
            </td>
        </tr>
    </TableList>
</template>