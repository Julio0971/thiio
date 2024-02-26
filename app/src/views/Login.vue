<script setup lang="ts">
import { computed, ref } from 'vue'
import { useStore } from '../store'
import { useRouter } from 'vue-router'
import FormRequest from '../components/FormRequest.vue'
import FormInputText from '../components/FormInputText.vue'

const store = useStore()
const router = useRouter()

const form = ref({
    data: {
        username: '',
        password: '',
    },
    errors: {
        username: '',
        password: ''
    }
})

const rules = ref({
    username: [
        (value: string) => {
            if (value) {
                return true
            }

            return 'The username field is required'
        }
    ],
    password: [
        (value: string) => {
            if (value) {
                return true
            }

            return 'The password field is required'
        },
        (value: string) => {
            if (value.length > 7) {
                return true
            }

            return 'The password must be at least 8 characters'
        },
    ],
})

const isValid = computed(() => {
    let valid = true
    
    rules.value.username.map(n => {
        const x = n(form.value.data.username)

        if (typeof x == 'string') {
            valid = false
        }
    })
    
    rules.value.password.map(n => {
        const x = n(form.value.data.password)

        if (typeof x == 'string') {
            valid = false
        }
    })

    return valid
})

const setData = (data: { access_token: string }) => {
    form.value.errors = {
        username: '',
        password: ''
    }

    store.access_token = data.access_token
    localStorage.setItem('access_token', data.access_token)
    router.replace('/users')
}

const setValidationErrors = (validation_errors: any) => form.value.errors = {
    username: validation_errors.username ?? '',
    password: validation_errors.password ?? '',
}
</script>

<template>
    <v-container style="height: 100vh;">
        <v-row justify="center" align="center" style="height: 100vh;">
            <v-col xs="12" sm="8" md="6" lg="4">
                <v-card title="Login">
                    <v-card-text>
                        <FormRequest
                            url="/login"
                            method="post"
                            :data="form.data"
                            :is-valid="isValid"
                            button-text="Login"
                            @set-data="setData"
                            @set-validation-errors="setValidationErrors"
                        >
                            <FormInputText
                                required
                                icon="user"
                                type="text"
                                label="Username"
                                :rules="rules.username"
                                v-model="form.data.username"
                                :error="form.errors.username"
                            />
                            
                            <FormInputText
                                required
                                icon="lock"
                                type="password"
                                label="Password"
                                :rules="rules.password"
                                v-model="form.data.password"
                                :error="form.errors.password"
                            />
                        </FormRequest>
                    </v-card-text>
                </v-card>
            </v-col>
        </v-row>
    </v-container>
</template>