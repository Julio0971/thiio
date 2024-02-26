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
        console.log(error);
    }
}
</script>

<template>
    <div>
        <v-toolbar color="#263238">
            <v-toolbar-title>
                Thiio
            </v-toolbar-title>

            <v-menu>
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

        <v-container>
            <v-row>
                <v-col>
                    <slot />
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>