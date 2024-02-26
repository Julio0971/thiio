<script setup lang="ts">

</script>

<template>
    <div>
        <v-toolbar color="white" class="mb-5">
            <v-toolbar-title>
                Thiio
            </v-toolbar-title>

            <RouterLink class="text-black" to="/login">
                <v-btn>
                    Login
                </v-btn>
            </RouterLink>
            
            <RouterLink class="text-black" to="/register">
                <v-btn>
                    Register
                </v-btn>
            </RouterLink>
        </v-toolbar>
        
        <v-container style="height: 50vh;">
            <v-row justify="center" align="center" style="height: 50vh;">
                <v-col xs="12" sm="8" md="6" lg="4">
                    <slot />
                </v-col>
            </v-row>
        </v-container>
    </div>
</template>