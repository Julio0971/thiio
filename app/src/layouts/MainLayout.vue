<template>
    <div>
        <v-toolbar color="#263238">
            <v-toolbar-title>
                Thiio
            </v-toolbar-title>

            <v-btn>
                Logout
            </v-btn>
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