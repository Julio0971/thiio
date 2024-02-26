<script setup lang="ts">
import { useStore } from '../store'

const store = useStore()
</script>

<template>
    <v-snackbar
        multi-line
        v-model="store.show_snackbar"
        :timeout="store.snackbar_type == 'success' ? 3000 : undefined"
        :color="store.snackbar_type == 'success' ? '#00695C' : '#E53935'"
    >
        <div class="text-center">
            {{ store.snackbar_text }}
        </div>

        <template v-slot:actions>
            <v-btn
                color="white"
                v-if="store.snackbar_type == 'error'"
                @click="store.show_snackbar = false"
            >
                Close
            </v-btn>
        </template>
    </v-snackbar>
</template>