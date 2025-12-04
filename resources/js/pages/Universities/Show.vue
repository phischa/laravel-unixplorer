<template>
    <Head title="UniXplorer" />

    <AppHeader />

    <div class="mx-auto mt-12 max-w-7xl sm:px-6 lg:px-8">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl leading-7 font-bold text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">{{ university.name }}</h2>
        </div>

        <div class="mt-8 rounded-2xl border-4 border-dashed border-gray-200 p-32 text-center text-gray-400">Put your content here</div>
    </div>
</template>

<script setup>
import AppHeader from '@/Components/AppHeader.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    university: Object,
});
</script>
