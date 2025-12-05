<template>

    <Head title="UniXplorer" />

    <AppHeader />

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-8 mb-4">
        <div class="min-w-0 flex-1">
            <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:truncate sm:text-3xl sm:tracking-tight">
                Universities in Germany
            </h2>
        </div>

        <!-- University Table -->
        <div class="mt-8 overflow-hidden rounded-lg border border-gray-200">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Name
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Website
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Courses
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">
                            Avg. Rating
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="university in universities.data" :key="university.id">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">
                            {{ university.name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-blue-600">
                            <a :href="university.homepage" target="_blank" class="hover:underline">
                                {{ university.homepage }}
                            </a>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ university.courses_count }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ university.courses_avg_rating?.toFixed(1) ?? 'N/A' }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4 flex items-center justify-between">
            <p class="text-sm text-gray-6   00">
                Showing {{ universities.from }} to {{ universities.to }} of {{ universities.total }} universities
            </p>
            <nav class="flex gap-1">
                <Link v-for="link in universities.links" :key="link.label" :href="link.url ?? ''"
                    class="px-3 py-2 text-sm rounded-md" :class="{
                        'bg-blue-600 text-white': link.active,
                        'bg-gray-100 text-gray-700 hover:bg-gray-200': !link.active && link.url,
                        'bg-gray-50 text-gray-400 cursor-not-allowed': !link.url
                    }" v-html="link.label" :preserve-scroll="true" />
            </nav>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from "@inertiajs/vue3";
import AppHeader from "@/Components/AppHeader.vue";

// Define the prop to receive data from Laravel
defineProps({
    universities: Object,
});
</script>