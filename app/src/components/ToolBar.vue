<script setup lang="ts">
import { useStore } from '../store'
import { useRouter } from 'vue-router'
import { useFetch } from '../composables'

const store = useStore()
const router = useRouter()

const logout = async () => {
    try {
        const { response, res } = await useFetch('post', '/logout')

        if (response.ok) {
            router.replace('/login')
        } else {
            throw new Error(res.message)
        }
    } catch (error) {
        store.show_snackbar = true
        store.snackbar_type = 'error'
        store.snackbar_text = error as string
    }
}
</script>

<template>
    <v-toolbar color="#263238">
        <v-toolbar-title>
            Thiio
        </v-toolbar-title>

        <RouterLink class="text-white" to="/login" v-if="store.user.id == undefined">
            <v-btn>
                Login
            </v-btn>
        </RouterLink>
        
        <RouterLink class="text-white" to="/register" v-if="store.user.id == undefined">
            <v-btn>
                Register
            </v-btn>
        </RouterLink>
        
        <RouterLink class="text-white" to="/users" v-if="store.user.id">
            <v-btn>
                Users
            </v-btn>
        </RouterLink>

        <v-menu v-if="store.user.id">
            <template v-slot:activator="{ props }">
                <v-btn color="white" v-bind="props" v-text="store.user.name" />
            </template>

            <v-list>
                <v-list-item value="1" @click="logout">
                    Logout
                </v-list-item>
            </v-list>
        </v-menu>
    </v-toolbar>
</template>
