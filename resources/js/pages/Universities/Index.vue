<template>
    <Head title="UniXplorer" />

    <AppHeader />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-12">
        <div class="min-w-0 flex-1">
            <h2
                class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight"
            >
                Universities in Germany
            </h2>
        </div>

        <div
            class="p-32 border-4 border-gray-200 rounded-2xl border-dashed mt-8 text-gray-400 text-center"
        >
            Put your content here
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppHeader from "@/Components/AppHeader.vue";
</script>
