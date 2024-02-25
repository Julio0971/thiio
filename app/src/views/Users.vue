<script setup lang="ts">
import { ref } from 'vue'
import MainLayout from '../layouts/MainLayout.vue'
import UsersList from '../components/UsersList.vue'
import UsersForm from '../components/UsersForm.vue'

const refresh = ref(0)
const show_users_form = ref(false)
</script>

<template>
    <MainLayout>
        <div class="d-flex justify-end">
            <v-btn
                text="New user"
                color="#1A237E"
                @click="show_users_form = true"
            />
        </div>

        <UsersList
            :refresh="refresh"
        />

        <UsersForm
            :show="show_users_form"
            @get-data="refresh++"
            @close="show_users_form = false"
        />
    </MainLayout>
</template>