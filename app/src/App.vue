<script setup lang="ts">
import ToolBar from './components/ToolBar.vue'
import SnakbarAlert from './components/SnakbarAlert.vue'

</script>

<template>
    <transition name="fade" appear>
        <ToolBar />
    </transition>

    <router-view v-slot="{ Component }">
        <transition name="fade" mode="out-in">
            <component :is="Component" />
        </transition>
    </router-view>

    <SnakbarAlert />
</template>