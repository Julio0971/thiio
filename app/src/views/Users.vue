<script setup lang="ts">
import { ref } from 'vue'
import { User } from '../interfaces'
import MainLayout from '../layouts/MainLayout.vue'
import UserForm from '../components/Users/UserForm.vue'
import UserShow from '../components/Users/UserShow.vue'
import UsersList from '../components/Users/UsersList.vue'
import UserDeletion from '../components/Users/UserDeletion.vue'

const refresh = ref(0)
const user_model = ref({} as User)
const show_users_form = ref(false)
const show_users_info = ref(false)
const show_confirmation_modal = ref(false)

const showUserInfo = (user: User) => {
    user_model.value = user
    show_users_info.value = true
}

const showUserForm = (user: User = {} as User) => {
    user_model.value = user
    show_users_form.value = true
}

const showUserDeletion = (user: User) => {
    user_model.value = user
    show_confirmation_modal.value = true
}
</script>

<template>
    <MainLayout>
        <div class="d-flex justify-end">
            <v-btn
                text="New user"
                color="#1A237E"
                @click="showUserForm"
            />
        </div>

        <UsersList
            :refresh="refresh"
            @show-user-form="showUserForm"
            @show-user-info="showUserInfo"
            @show-user-deletion="showUserDeletion"
        />

        <UserForm
            :user="user_model"
            :show="show_users_form"
            @get-data="refresh++"
            @close="show_users_form = false"
        />

        <UserShow
            :user="user_model"
            :show="show_users_info"
            @close="show_users_info = false"
        ></UserShow>

        <UserDeletion
            :user="user_model"
            :show="show_confirmation_modal"
            @get-data="refresh++"
            @close="show_confirmation_modal = false"
        />
    </MainLayout>
</template>