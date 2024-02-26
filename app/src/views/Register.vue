<script setup lang="ts">
import { computed, ref } from 'vue'
import { useStore } from '../store'
import { useRouter } from 'vue-router'
import AuthLayout from '../layouts/AuthLayout.vue'
import FormRequest from '../components/FormRequest.vue'
import FormInputText from '../components/FormInputText.vue'

const store = useStore()
const router = useRouter()

const form = ref({
    data: {
        name: '',
        username: '',
        password: '',
        password_confirmation: '',
    },
    errors: {
        name: '',
        username: '',
        password: ''
    }
})

const rules = ref({
    name: [
        (value: string) => {
            if (value) {
                return true
            }

            return 'The name field is required'
        }
    ],
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
    password_confirmation: [
        (value: string) => {
            if (value) {
                return true
            }

            return 'The password field is required'
        },
        (value: string) => {
            if (value == form.value.data.password) {
                return true
            }

            return 'The password confirmation does not match'
        },
    ],
})

const isValid = computed(() => {
    let valid = true

    rules.value.name.map(n => {
        const x = n(form.value.data.name)

        if (typeof x == 'string') {
            valid = false
        }
    })
    
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
    
    rules.value.password_confirmation.map(n => {
        const x = n(form.value.data.password_confirmation)

        if (typeof x == 'string') {
            valid = false
        }
    })

    return valid
})

const setData = (data: { access_token: string }) => {
    form.value.errors = {
        name: '',
        username: '',
        password: ''
    }

    store.access_token = data.access_token
    localStorage.setItem('access_token', data.access_token)
    router.replace('/users')
}

const setValidationErrors = (validation_errors: any) => form.value.errors = {
    name: validation_errors.name ?? '',
    username: validation_errors.username ?? '',
    password: validation_errors.password ?? '',
}
</script>

<template>
    <AuthLayout>
        <v-card title="Register">
            <v-card-text>
                <FormRequest
                    url="/register"
                    method="post"
                    :data="form.data"
                    :is-valid="isValid"
                    button-text="Register"
                    @set-data="setData"
                    @set-validation-errors="setValidationErrors"
                >
                    <FormInputText
                        required
                        icon="user"
                        type="text"
                        label="Name"
                        :rules="rules.name"
                        v-model="form.data.name"
                        :error="form.errors.name"
                    />
                    
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
                    
                    <FormInputText
                        required
                        icon="lock"
                        type="password"
                        label="Password confirmation"
                        :rules="rules.password_confirmation"
                        v-model="form.data.password_confirmation"
                    />
                </FormRequest>
            </v-card-text>
        </v-card>
    </AuthLayout>
</template>