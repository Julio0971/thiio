<script setup lang="ts">
import SnakbarAlert from './components/SnakbarAlert.vue'
</script>

<template>
    <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>

    <SnakbarAlert />
</template>