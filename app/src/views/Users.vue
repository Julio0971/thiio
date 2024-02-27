<script setup lang="ts">
import _ from 'lodash'
import { ref } from 'vue'
import { User } from '../interfaces'
import MainLayout from '../layouts/MainLayout.vue'
import UserForm from '../components/Users/UserForm.vue'
import UserShow from '../components/Users/UserShow.vue'
import UsersList from '../components/Users/UsersList.vue'
import FormInputText from '../components/FormInputText.vue'
import UserDeletion from '../components/Users/UserDeletion.vue'

const search = ref('')
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

const searchUsers = _.debounce(() => {
    refresh.value++
}, 300)
</script>

<template>
    <MainLayout>
        <v-container>
            <v-row>
                <v-col cols="4">
                    <v-btn
                        text="New user"
                        color="#1A237E"
                        @click="showUserForm"
                    />
                </v-col>

                <v-col cols="4" offset="4">
                    <FormInputText
                        :rules="[]"
                        type="text"
                        icon="search"
                        label="Search"
                        v-model="search"
                        :required="false"
                        @input="searchUsers"
                    />
                </v-col>
            </v-row>
        </v-container>

        <UsersList
            :search="search"
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