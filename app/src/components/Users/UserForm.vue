<script setup lang="ts">
import { User } from '../../interfaces'
import { computed, ref, watch } from 'vue'
import FormRequest from '../FormRequest.vue'
import ModalDialog from '../ModalDialog.vue'
import FormInputText from '../FormInputText.vue'

const props = defineProps<{
    user: User
    show: boolean
}>()

const emit = defineEmits<{
    (e: 'close'): void
    (e: 'getData'): void
}>()

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
            if (value || props.user.id != undefined) {
                return true
            }

            return 'The password field is required'
        },
        (value: string) => {
            if (value.length > 7 || props.user.id != undefined) {
                return true
            }

            return 'The password must be at least 8 characters'
        },
    ],
    password_confirmation: [
        (value: string) => {
            if (value || props.user.id != undefined) {
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

const setData = () => {
    emit('close')
    emit('getData')
}

const setValidationErrors = (validation_errors: any) => form.value.errors = {
    name: validation_errors.name ?? '',
    username: validation_errors.username ?? '',
    password: validation_errors.password ?? '',
}

watch(() => props.user, user => form.value.data = {
    name: user.name ?? '',
    username: user.username ?? '',
    password: '',
    password_confirmation: ''
})
</script>

<template>
    <ModalDialog
        :show="props.show"
        :title="`${props.user.id ? 'Edit' : 'New'} user`"
        @close="emit('close')"
    >
        <FormRequest
            :data="form.data"
            :is-valid="isValid"
            :url="`/users/${props.user.id ?? ''}`"
            :method="props.user.id ? 'put' : 'post'"
            :button-text="`${props.user.id ? 'Update' :  'Save'}`"
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
    </ModalDialog>
</template>